<?php

namespace Tests\Feature;

use App\Models\SanPham;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAddTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_cart(): void
    {
        $user = User::create([
            'ho_ten' => 'Nguyễn Văn A',
            'email' => 'a@example.com',
            'so_dien_thoai' => '0900000001',
            'mat_khau_hash' => bcrypt('password123'),
            'vai_tro' => 'khach_hang',
        ]);

        $product = SanPham::create([
            'ten_san_pham' => 'Vợt cầu lông test',
            'slug' => 'vot-cau-long-test',
            'danh_muc_id' => 1,
            'gia_co_ban' => 1500000,
            'anh_dai_dien' => 'test.webp',
        ]);

        $this->actingAs($user)
            ->post(route('cart.add', $product->id), [
                'so_luong' => 2,
                'size' => '3U',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('gio_hang', [
            'nguoi_dung_id' => $user->id,
            'so_luong' => 2,
            'size' => '3U',
        ]);
    }
}
