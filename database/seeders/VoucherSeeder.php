<?php

namespace Database\Seeders;

use App\Models\MaGiamGia;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'ma_code' => 'FREESHIP',
                'loai_giam_gia' => 'shipping',
                'gia_tri_giam' => 32000,
                'don_hang_toi_thieu' => 0,
                'giam_toi_da' => 32000,
                'so_luong_dung' => 1,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => null,
                'trang_thai' => 'active',
                'trang_thai_kich_hoat' => true,
            ],
            [
                'ma_code' => 'DISCOUNT10',
                'loai_giam_gia' => 'percent',
                'gia_tri_giam' => 10,
                'don_hang_toi_thieu' => 0,
                'giam_toi_da' => 0,
                'so_luong_dung' => 2,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => null,
                'trang_thai' => 'active',
                'trang_thai_kich_hoat' => true,
            ],
            [
                'ma_code' => 'DISCOUNT20',
                'loai_giam_gia' => 'percent',
                'gia_tri_giam' => 20,
                'don_hang_toi_thieu' => 0,
                'giam_toi_da' => 0,
                'so_luong_dung' => 2,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => null,
                'trang_thai' => 'active',
                'trang_thai_kich_hoat' => true,
            ],
            [
                'ma_code' => 'DISCOUNT50',
                'loai_giam_gia' => 'percent',
                'gia_tri_giam' => 50,
                'don_hang_toi_thieu' => 0,
                'giam_toi_da' => 0,
                'so_luong_dung' => 1,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => now()->addDay(),
                'trang_thai' => 'active',
                'trang_thai_kich_hoat' => true,
            ],
        ];

        foreach ($vouchers as $voucher) {
            MaGiamGia::updateOrCreate(
                ['ma_code' => $voucher['ma_code']],
                $voucher
            );
        }
    }
}
