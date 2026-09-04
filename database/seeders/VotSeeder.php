<?php

namespace Database\Seeders;

use App\Models\SanPham;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VotSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('danh_muc')->updateOrInsert(
            ['id' => 1],
            [
                'ten_danh_muc' => 'Vợt Cầu Lông',
                'slug' => 'vot-cau-long',
                'danh_muc_cha_id' => null,
            ]
        );

        $danhSachVot = [
            ['ten_san_pham' => 'Vợt Cầu Lông Li-Ning Aeronaut 6000C', 'gia_co_ban' => 1950000, 'anh_dai_dien' => 'lining_aeronaut6000C.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Li-Ning Axforce 100', 'gia_co_ban' => 5650000, 'anh_dai_dien' => 'lining_axforce100.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Li-Ning Axforce Cannon', 'gia_co_ban' => 980000, 'anh_dai_dien' => 'lining_axforceCannon.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Li-Ning Halbertec 7000', 'gia_co_ban' => 3990000, 'anh_dai_dien' => 'lining_halbertec7000.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Li-Ning Bladex 900', 'gia_co_ban' => 4539000, 'anh_dai_dien' => 'lining_bladex900.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Victor Auraspeed 99J', 'gia_co_ban' => 2350000, 'anh_dai_dien' => 'victor_auraspeed_99J.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Victor Auraspeed 100X', 'gia_co_ban' => 4190000, 'anh_dai_dien' => 'victor_auraspeed_100X.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Victor Jetspeed S 12II R', 'gia_co_ban' => 3400000, 'anh_dai_dien' => 'victor_jetspeed_S12IIR.jpg'],
            ['ten_san_pham' => 'Vợt Cầu Lông Victor Thruster Ryuga TDC', 'gia_co_ban' => 3900000, 'anh_dai_dien' => 'victor_ryuga_TDC.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Victor Thruster K Falcon Ultra', 'gia_co_ban' => 3400000, 'anh_dai_dien' => 'victor_TKF_ultra.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Yonex Astrox 100ZZ', 'gia_co_ban' => 5599000, 'anh_dai_dien' => 'yonex_100ZZ.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Yonex Arcsaber 7 Play', 'gia_co_ban' => 1189000, 'anh_dai_dien' => 'yonex_arcsaber_7play.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Yonex Astrox 77 Play', 'gia_co_ban' => 1189000, 'anh_dai_dien' => 'yonex_astrox_77play.webp'],
            ['ten_san_pham' => 'Vợt Cầu Lông Yonex Astrox 100 Game', 'gia_co_ban' => 2849000, 'anh_dai_dien' => 'yonex_astrox_100game.webp'],
        ];

        foreach ($danhSachVot as $vot) {
            SanPham::updateOrCreate(
                ['slug' => Str::slug($vot['ten_san_pham'])],
                [
                    'ten_san_pham' => $vot['ten_san_pham'],
                    'danh_muc_id' => 1,
                    'gia_co_ban' => $vot['gia_co_ban'],
                    'anh_dai_dien' => $vot['anh_dai_dien'],
                    'trang_thai_kinh_doanh' => true,
                ]
            );
        }
    }
}
