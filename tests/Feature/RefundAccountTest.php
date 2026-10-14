<?php

namespace Tests\Feature;

use App\Http\Middleware\UpdateUserLastActivity;
use App\Models\DonHang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RefundAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_submit_bank_details_for_a_paid_cancelled_order(): void
    {
        $this->withoutMiddleware(UpdateUserLastActivity::class);

        $user = User::create([
            'ho_ten' => 'Khách hàng',
            'email' => 'refund-customer@example.com',
            'mat_khau_hash' => 'password',
        ]);
        $order = DonHang::create([
            'ma_don_hang' => 'DH-REFUND-1',
            'nguoi_dung_id' => $user->id,
            'phuong_thuc_thanh_toan' => 'VietQR',
            'trang_thai_thanh_toan' => 'da_thanh_toan',
            'trang_thai_don_hang' => 'tra_hang',
        ]);

        $this->actingAs($user)
            ->post(route('account.orders.refund-account', $order->id), [
                'ngan_hang_hoan_tien' => 'Ngân hàng A',
                'ten_chu_tai_khoan_hoan_tien' => 'NGUYEN VAN A',
                'so_tai_khoan_hoan_tien' => '0123456789',
            ])
            ->assertRedirect(route('account.orders', ['status' => 'tra_hang']));

        $this->assertDatabaseHas('don_hang', [
            'id' => $order->id,
            'ngan_hang_hoan_tien' => 'Ngân hàng A',
            'ten_chu_tai_khoan_hoan_tien' => 'NGUYEN VAN A',
            'so_tai_khoan_hoan_tien' => '0123456789',
        ]);

        $admin = new User([
            'ho_ten' => 'Quản trị viên',
            'email' => 'refund-admin@example.com',
            'mat_khau_hash' => 'password',
            'vai_tro' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.orders.index', ['status' => 'tra_hang_hoan_tien']))
            ->assertOk()
            ->assertSee('Trả hàng/Hoàn tiền')
            ->assertSee('0123456789')
            ->assertSee('NGUYEN VAN A');
    }

    public function test_customer_cannot_submit_refund_details_for_an_unpaid_order(): void
    {
        $this->withoutMiddleware(UpdateUserLastActivity::class);

        $user = User::create([
            'ho_ten' => 'Khách hàng',
            'email' => 'unpaid-customer@example.com',
            'mat_khau_hash' => 'password',
        ]);
        $order = DonHang::create([
            'ma_don_hang' => 'DH-REFUND-2',
            'nguoi_dung_id' => $user->id,
            'phuong_thuc_thanh_toan' => 'VietQR',
            'trang_thai_thanh_toan' => 'cho_thanh_toan',
            'trang_thai_don_hang' => 'tra_hang',
        ]);

        $this->actingAs($user)
            ->from(route('account.orders', ['status' => 'tra_hang']))
            ->post(route('account.orders.refund-account', $order->id), [
                'ngan_hang_hoan_tien' => 'Ngân hàng A',
                'ten_chu_tai_khoan_hoan_tien' => 'NGUYEN VAN A',
                'so_tai_khoan_hoan_tien' => '0123456789',
            ])
            ->assertSessionHasErrors('order');

        $this->assertDatabaseMissing('don_hang', [
            'id' => $order->id,
            'so_tai_khoan_hoan_tien' => '0123456789',
        ]);
    }
}
