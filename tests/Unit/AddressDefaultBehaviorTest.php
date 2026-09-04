<?php

namespace Tests\Unit;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressDefaultBehaviorTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_one_address_as_default_keeps_old_addresses_and_clears_previous_default(): void
    {
        Address::create([
            'nguoi_dung_id' => 1,
            'ten_nguoi_nhan' => 'Nguyễn Văn A',
            'so_dien_thoai' => '0900000001',
            'tinh_thanh' => 'Hà Nội',
            'phuong_xa' => 'Cầu Giấy',
            'dia_chi_chi_tiet' => '123 Lê Duẩn',
            'is_default' => true,
        ]);

        $newAddress = Address::create([
            'nguoi_dung_id' => 1,
            'ten_nguoi_nhan' => 'Nguyễn Văn B',
            'so_dien_thoai' => '0900000002',
            'tinh_thanh' => 'Hà Nội',
            'phuong_xa' => 'Đống Đa',
            'dia_chi_chi_tiet' => '456 Trần Duy Hưng',
            'is_default' => false,
        ]);

        $newAddress->setAsDefault();

        $this->assertTrue($newAddress->fresh()->is_default);
        $this->assertFalse(
            Address::where('nguoi_dung_id', 1)
                ->where('id', '!=', $newAddress->id)
                ->first()->is_default
        );
    }
}
