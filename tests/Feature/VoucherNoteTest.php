<?php

namespace Tests\Feature;

use App\Http\Middleware\UpdateUserLastActivity;
use App\Models\MaGiamGia;
use App\Models\User;
use App\Services\VoucherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoucherNoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_and_update_a_voucher_note(): void
    {
        $this->withoutMiddleware(UpdateUserLastActivity::class);
        $this->actingAs(new User(['vai_tro' => 'admin']));

        $voucherData = [
            'ma_code' => 'NOTE10',
            'ghi_chu' => 'Dành cho khách hàng thân thiết',
            'loai_giam_gia' => 'percent',
            'gia_tri_giam' => 10,
            'don_hang_toi_thieu' => 0,
            'giam_toi_da' => 0,
            'so_luong_dung' => 0,
            'ngay_bat_dau' => null,
            'ngay_ket_thuc' => null,
            'trang_thai' => 'active',
            'trang_thai_kich_hoat' => 1,
        ];

        $this->post(route('admin.vouchers.store'), $voucherData)
            ->assertRedirect(route('admin.vouchers.index'));

        $voucher = MaGiamGia::where('ma_code', 'NOTE10')->firstOrFail();
        $this->assertSame('Dành cho khách hàng thân thiết', $voucher->ghi_chu);

        $voucherData['ghi_chu'] = 'Gia hạn cho khách VIP';
        $this->put(route('admin.vouchers.update', $voucher->id), $voucherData)
            ->assertRedirect(route('admin.vouchers.index'));

        $this->assertDatabaseHas('ma_giam_gia', [
            'id' => $voucher->id,
            'ghi_chu' => 'Gia hạn cho khách VIP',
        ]);
        $this->assertSame('Gia hạn cho khách VIP', VoucherService::definitions()['NOTE10']['note']);
    }
}