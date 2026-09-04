<?php

namespace App\Services;

use App\Models\MaGiamGia;
use Carbon\Carbon;

class VoucherService
{
    public const FREE_SHIP = 'FREESHIP';
    public const DISCOUNT10 = 'DISCOUNT10';
    public const DISCOUNT20 = 'DISCOUNT20';
    public const DISCOUNT50 = 'DISCOUNT50';

    public static function definitions(): array
    {
        $records = MaGiamGia::query()
            ->whereIn('ma_code', [self::FREE_SHIP, self::DISCOUNT10, self::DISCOUNT20, self::DISCOUNT50])
            ->get()
            ->keyBy('ma_code');

        $defaults = [
            self::FREE_SHIP => [
                'label' => 'Miễn phí ship',
                'type' => 'shipping',
                'value' => 32000,
                'max_uses' => 1,
                'duration_hours' => null,
            ],
            self::DISCOUNT10 => [
                'label' => 'Giảm 10%',
                'type' => 'percent',
                'value' => 10,
                'max_uses' => 2,
                'duration_hours' => null,
            ],
            self::DISCOUNT20 => [
                'label' => 'Giảm 20%',
                'type' => 'percent',
                'value' => 20,
                'max_uses' => 2,
                'duration_hours' => null,
            ],
            self::DISCOUNT50 => [
                'label' => 'Voucher 50% lần đầu',
                'type' => 'percent',
                'value' => 50,
                'max_uses' => 1,
                'duration_hours' => 24,
            ],
        ];

        foreach ($defaults as $code => $definition) {
            if (!$records->has($code)) {
                continue;
            }

            $row = $records->get($code);
            $defaults[$code]['label'] = $definition['label'];
            $defaults[$code]['type'] = $row->loai_giam_gia ?? $definition['type'];
            $defaults[$code]['value'] = (float) ($row->gia_tri_giam ?? $definition['value']);
            $defaults[$code]['max_uses'] = (int) ($row->so_luong_dung ?? $definition['max_uses']);
            $defaults[$code]['duration_hours'] = $definition['duration_hours'];
        }

        return $defaults;
    }

    public static function defaultState(): array
    {
        return [
            self::FREE_SHIP => ['remaining_uses' => 1, 'expires_at' => null],
            self::DISCOUNT10 => ['remaining_uses' => 2, 'expires_at' => null],
            self::DISCOUNT20 => ['remaining_uses' => 2, 'expires_at' => null],
            self::DISCOUNT50 => ['remaining_uses' => 0, 'expires_at' => null],
        ];
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

        foreach ($normalized as $code => $default) {
            if (!isset($state[$code])) {
                continue;
            }

            $remainingUses = (int) ($state[$code]['remaining_uses'] ?? $default['remaining_uses']);
            $expiresAt = $state[$code]['expires_at'] ?? $default['expires_at'];

            $normalized[$code] = [
                'remaining_uses' => max(0, min($remainingUses, (int) self::definitions()[$code]['max_uses'])),
                'expires_at' => $expiresAt,
            ];
        }

        return $normalized;
    }

    public static function isVoucherUsable(string $code): bool
    {
        $state = self::getState();
        $definition = self::definitions()[$code] ?? null;

        if (!$definition || !isset($state[$code])) {
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
        $expired = $expiresAt && Carbon::now()->greaterThan(Carbon::parse($expiresAt));

        return [
            'enabled' => !$expired && $remainingUses > 0,
            'remaining_uses' => $remainingUses,
            'label' => $definition['label'],
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

        $discount = 0;
        $finalShippingFee = $shippingFee;

        if ($definition['type'] === 'shipping') {
            $finalShippingFee = 0;
            $discount = 0;
        } elseif ($definition['type'] === 'percent') {
            $discount = round($subtotal * $definition['value'] / 100);
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
