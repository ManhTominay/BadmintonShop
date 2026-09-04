<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutAddressKeepsSelectedItemsTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_cart_items_are_kept_when_updating_address(): void
    {
        $user = User::create([
            'ho_ten' => 'Nguyễn Văn B',
            'email' => 'b@example.com',
            'so_dien_thoai' => '0900000002',
            'mat_khau_hash' => bcrypt('password123'),
            'vai_tro' => 'khach_hang',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('checkout.address.update', ['items' => '12,15']), [
            'ten_nguoi_nhan' => 'Nguyễn Văn B',
            'so_dien_thoai' => '0900000002',
            'tinh_thanh' => 'Hồ Chí Minh',
            'phuong_xa' => 'Phường 1',
            'dia_chi_chi_tiet' => '123 Lê Lợi',
            'lat' => 10.762622,
            'lng' => 106.660172,
            'is_default' => true,
        ]);

        $response->assertRedirect(route('checkout.payment', ['items' => '12,15']));
        $this->assertDatabaseHas('dia_chi_nguoi_dung', [
            'nguoi_dung_id' => $user->id,
            'tinh_thanh' => 'Hồ Chí Minh',
        ]);
    }
}
