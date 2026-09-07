<?php

namespace Tests\Unit;

use App\Services\VoucherService;
use App\Models\MaGiamGia;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoucherServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_shipping_voucher_waives_shipping_fee_without_discounting_subtotal(): void
    {
        session()->put('voucher_state', [
            VoucherService::FREE_SHIP => ['remaining_uses' => 1, 'expires_at' => null],
            VoucherService::DISCOUNT10 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT20 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT50 => ['remaining_uses' => 0, 'expires_at' => null],
        ]);

        $result = VoucherService::computeDiscount(VoucherService::FREE_SHIP, 250000, 32000);

        $this->assertSame(0, $result['discount']);
        $this->assertSame(0, $result['shipping_fee']);
    }

    public function test_welcome_voucher_expires_after_24_hours(): void
    {
        session()->put('voucher_state', [
            VoucherService::FREE_SHIP => ['remaining_uses' => 1, 'expires_at' => null],
            VoucherService::DISCOUNT10 => ['remaining_uses' => 0, 'expires_at' => null],
            VoucherService::DISCOUNT20 => ['remaining_uses' => 0, 'expires_at' => null],
            VoucherService::DISCOUNT50 => ['remaining_uses' => 1, 'expires_at' => Carbon::now()->subHours(1)->toDateTimeString()],
        ]);

        $this->assertFalse(VoucherService::isVoucherUsable(VoucherService::DISCOUNT50));
    }

    public function test_voucher_with_end_date_in_the_past_is_not_usable(): void
    {
        MaGiamGia::create([
            'ma_code' => VoucherService::DISCOUNT10,
            'loai_giam_gia' => 'percent',
            'gia_tri_giam' => 10,
            'don_hang_toi_thieu' => 0,
            'giam_toi_da' => 0,
            'so_luong_dung' => 2,
            'ngay_bat_dau' => Carbon::now()->subDay(),
            'ngay_ket_thuc' => Carbon::now()->subHour(),
            'trang_thai' => 'active',
            'trang_thai_kich_hoat' => true,
        ]);

        session()->put('voucher_state', [
            VoucherService::FREE_SHIP => ['remaining_uses' => 1, 'expires_at' => null],
            VoucherService::DISCOUNT10 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT20 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT50 => ['remaining_uses' => 0, 'expires_at' => null],
        ]);

        $this->assertFalse(VoucherService::isVoucherUsable(VoucherService::DISCOUNT10));
        $this->assertTrue(VoucherService::getVoucherStatus(VoucherService::DISCOUNT10)['expired']);
    }

    public function test_percent_vouchers_discount_the_total_payable_amount(): void
    {
        session()->put('voucher_state', [
            VoucherService::FREE_SHIP => ['remaining_uses' => 1, 'expires_at' => null],
            VoucherService::DISCOUNT10 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT20 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT50 => ['remaining_uses' => 0, 'expires_at' => null],
        ]);

        $result = VoucherService::computeDiscount(VoucherService::DISCOUNT10, 250000, 32000);

        $this->assertSame(25000.0, $result['discount']);
        $this->assertSame(32000.0, $result['shipping_fee']);
    }

    public function test_percent_vouchers_are_limited_to_two_uses(): void
    {
        session()->put('voucher_state', [
            VoucherService::FREE_SHIP => ['remaining_uses' => 1, 'expires_at' => null],
            VoucherService::DISCOUNT10 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT20 => ['remaining_uses' => 2, 'expires_at' => null],
            VoucherService::DISCOUNT50 => ['remaining_uses' => 0, 'expires_at' => null],
        ]);

        VoucherService::consumeVoucher(VoucherService::DISCOUNT10);
        VoucherService::consumeVoucher(VoucherService::DISCOUNT10);

        $status = VoucherService::getVoucherStatus(VoucherService::DISCOUNT10);

        $this->assertSame(0, $status['remaining_uses']);
        $this->assertFalse($status['enabled']);
    }
}
