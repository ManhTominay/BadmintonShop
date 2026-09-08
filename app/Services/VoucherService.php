<?php

namespace App\Services;

use App\Models\MaGiamGia;
use Carbon\Carbon;

class VoucherService
{
    public const DISCOUNT50 = 'DISCOUNT50';

    public static function definitions(): array
    {
        return MaGiamGia::query()->get()->mapWithKeys(function (MaGiamGia $voucher) {
            return [$voucher->ma_code => [
                'label' => $voucher->ma_code,
                'type' => $voucher->loai_giam_gia,
                'value' => (float) $voucher->gia_tri_giam,
                'min_amount' => (float) $voucher->don_hang_toi_thieu,
                'max_discount' => (float) $voucher->giam_toi_da,
                'max_uses' => (int) $voucher->so_luong_dung,
            ]];
        })->all();
    }

    public static function defaultState(): array
    {
        return collect(self::definitions())->mapWithKeys(function (array $definition, string $code) {
            return [$code => [
                'remaining_uses' => $code === self::DISCOUNT50 ? 0 : $definition['max_uses'],
                'expires_at' => null,
            ]];
        })->all();
    }

    public static function getState(): array
    {
        $state = session('voucher_state', self::defaultState());

        return self::normalizeState($state);
    }

    public static function setState(array $state): void
    {
        session()->put('voucher_state', self::normalizeState($state));
    }

    public static function grantWelcomeVoucher(): void
    {
        $state = self::getState();
        $state[self::DISCOUNT50] = [
            'remaining_uses' => 1,
            'expires_at' => Carbon::now()->addHours(24)->toDateTimeString(),
        ];

        MaGiamGia::updateOrCreate(
            ['ma_code' => self::DISCOUNT50],
            [
                'loai_giam_gia' => 'percent',
                'gia_tri_giam' => 50,
                'don_hang_toi_thieu' => 0,
                'giam_toi_da' => 0,
                'so_luong_dung' => 1,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => now()->addDay(),
                'trang_thai' => 'active',
                'trang_thai_kich_hoat' => true,
            ]
        );

        self::setState($state);
    }

    public static function normalizeState(array $state): array
    {
        $normalized = self::defaultState();

        foreach (self::definitions() as $code => $definition) {
            $default = $normalized[$code] ?? [
                'remaining_uses' => $definition['max_uses'],
                'expires_at' => null,
            ];
            $remainingUses = (int) ($state[$code]['remaining_uses'] ?? $default['remaining_uses']);
            $expiresAt = $state[$code]['expires_at'] ?? $default['expires_at'];

            $normalized[$code] = [
                'remaining_uses' => max(0, min($remainingUses, (int) $definition['max_uses'])),
                'expires_at' => $expiresAt,
            ];
        }

        return $normalized;
    }

    public static function isVoucherUsable(string $code): bool
    {
        $state = self::getState();
        $definition = self::definitions()[$code] ?? null;
        $voucher = MaGiamGia::where('ma_code', $code)->first();

        if (!$definition || !isset($state[$code]) || ($voucher && !$voucher->isCurrentlyActive())) {
            return false;
        }

        $remainingUses = (int) ($state[$code]['remaining_uses'] ?? 0);
        $expiresAt = $state[$code]['expires_at'] ?? null;

        if ($remainingUses <= 0) {
            return false;
        }

        if ($expiresAt && Carbon::now()->greaterThan(Carbon::parse($expiresAt))) {
            $state[$code]['remaining_uses'] = 0;
            $state[$code]['expires_at'] = null;
            self::setState($state);
            return false;
        }

        return true;
    }

    public static function getVoucherStatus(string $code): array
    {
        $definition = self::definitions()[$code] ?? null;
        $state = self::getState();
        $voucher = MaGiamGia::where('ma_code', $code)->first();

        if (!$definition || !isset($state[$code])) {
            return [
                'enabled' => false,
                'remaining_uses' => 0,
                'label' => 'Không khả dụng',
                'expired' => true,
            ];
        }

        $remainingUses = (int) ($state[$code]['remaining_uses'] ?? 0);
        $expiresAt = $state[$code]['expires_at'] ?? null;
        $expired = ($voucher && $voucher->isExpired())
            || ($expiresAt && Carbon::now()->greaterThan(Carbon::parse($expiresAt)));
        $scheduled = !$voucher || $voucher->isCurrentlyActive();

        return [
            'enabled' => $scheduled && !$expired && $remainingUses > 0,
            'remaining_uses' => $remainingUses,
            'label' => $definition['label'],
            'type' => $definition['type'],
            'value' => $definition['value'],
            'min_amount' => $definition['min_amount'],
            'max_discount' => $definition['max_discount'],
            'expired' => $expired,
            'code' => $code,
        ];
    }

    public static function consumeVoucher(string $code): void
    {
        if (!self::isVoucherUsable($code)) {
            return;
        }

        $state = self::getState();
        $state[$code]['remaining_uses'] = max(0, (int) ($state[$code]['remaining_uses'] ?? 0) - 1);

        if ($state[$code]['remaining_uses'] <= 0 && $code === self::DISCOUNT50) {
            $state[$code]['expires_at'] = null;
        }

        self::setState($state);
    }

    public static function computeDiscount(string $code, float $subtotal, float $shippingFee): array
    {
        $state = self::getState();
        $definition = self::definitions()[$code] ?? null;

        if (!$definition || !self::isVoucherUsable($code)) {
            return [
                'discount' => 0,
                'shipping_fee' => $shippingFee,
                'selected' => false,
                'state' => $state,
            ];
        }

        if ($subtotal < $definition['min_amount']) {
            return [
                'discount' => 0,
                'shipping_fee' => $shippingFee,
                'selected' => false,
                'state' => $state,
            ];
        }

        $discount = 0;
        $finalShippingFee = $shippingFee;

        if ($definition['type'] === 'shipping') {
            $finalShippingFee = 0;
            $discount = 0;
        } elseif ($definition['type'] === 'percent') {
            $discount = round($subtotal * $definition['value'] / 100);
            if ($definition['max_discount'] > 0) {
                $discount = min($discount, $definition['max_discount']);
            }
        }

        if ($definition['type'] !== 'shipping' && $discount > 0) {
            self::consumeVoucher($code);
        }

        if ($definition['type'] === 'shipping') {
            self::consumeVoucher($code);
        }

        return [
            'discount' => $discount,
            'shipping_fee' => $finalShippingFee,
            'selected' => true,
            'state' => self::getState(),
        ];
    }
}
