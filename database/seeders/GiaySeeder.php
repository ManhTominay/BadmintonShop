<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanPham;
use Illuminate\Support\Str;

class GiaySeeder extends Seeder
{
    public function run(): void
    {
        $danhSachGiay = [
            [
                'ten_san_pham' => 'Giày Yonex Power Cushion88 Dial',
                'gia_co_ban'   => 3059000,
                'anh_dai_dien' => 'yonex_power_cushion88Dial.webp',
            ],
            [
                'ten_san_pham' => 'Giày Yonex cascade accel gen2 wide',
                'gia_co_ban'   => 2149000,
                'anh_dai_dien' => 'yonex_cascade_accel_gen2wide.webp',
            ],
            [
                'ten_san_pham' => 'Giày yonex SubaxiaGT Women',
                'gia_co_ban'   => 3479000,
                'anh_dai_dien' => 'yonex_subaxiaGT_Women.webp',
            ],
            [
                'ten_san_pham' => 'Giày yonex strratas',
                'gia_co_ban'   => 1449000,
                'anh_dai_dien' => 'yonex_stratas.webp',
            ],
            [
                'ten_san_pham' => 'Giày yonex hyperboom',
                'gia_co_ban'   => 1639000,
                'anh_dai_dien' => 'yonex_hyperboom.webp',
            ],
            [
                'ten_san_pham' => 'Giày yonex cumulo',
                'gia_co_ban'   => 1225000,
                'anh_dai_dien' => 'yonex_cumulo.webp',
            ],
            [
                'ten_san_pham' => 'Giày yonex rapio',
                'gia_co_ban'   => 989000,
                'anh_dai_dien' => 'yonex_rapio.webp',
            ],
            [
                'ten_san_pham' => 'Giày yonex eclipsionZ3',
                'gia_co_ban'   => 2519000,
                'anh_dai_dien' => 'yonex_eclipsionZ3.webp',
            ],
            [
                'ten_san_pham' => 'Giày lining AYAW001-5',
                'gia_co_ban'   => 2550000,
                'anh_dai_dien' => 'lining_ayaw001-5.webp',
            ],
            [
                'ten_san_pham' => 'Giày lining AYZV001-4',
                'gia_co_ban'   => 1900000,
                'anh_dai_dien' => 'lining_ayzv001-4.webp',
            ],
            [
                'ten_san_pham' => 'Giày lining AYTW191-4',
                'gia_co_ban'   => 1300000,
                'anh_dai_dien' => 'lining_aytw019-4.webp',
            ],
            [
                'ten_san_pham' => 'Giày lining AYZW007-2',
                'gia_co_ban'   => 2299000,
                'anh_dai_dien' => 'lining_ayzw007-2.webp',
            ],
            [
                'ten_san_pham' => 'Giày lining AYTV15-3',
                'gia_co_ban'   => 2299000,
                'anh_dai_dien' => 'lining_aytv015-3.webp',
            ],
            [
                'ten_san_pham' => 'Giày victor P9200CXLTD',
                'gia_co_ban'   => 3650000,
                'anh_dai_dien' => 'victor_p9200cXLTD.webp',
            ],
            [
                'ten_san_pham' => 'Giày victor A513-WCX',
                'gia_co_ban'   => 1589000,
                'anh_dai_dien' => 'victor_a513_WCX.webp',
            ],
            [
                'ten_san_pham' => 'Giày victor A690C',
                'gia_co_ban'   => 1739000,
                'anh_dai_dien' => 'victor_a690C.webp',
            ],
            [
                'ten_san_pham' => 'Giày victor P8500 nitrolite ZSWDX',
                'gia_co_ban'   => 1739000,
                'anh_dai_dien' => 'victor_p8500_nitrolite_zswdx.webp',
            ],
            [
                'ten_san_pham' => 'Giày mizuno_wave_claw_neo3',
                'gia_co_ban'   => 2240000,
                'anh_dai_dien' => 'mizuno_wave_claw_neo3.jpg',
            ],
             [
                'ten_san_pham' => 'Giày mizuno_wave_claw471GA264305',
                'gia_co_ban'   => 2240000,
                'anh_dai_dien' => 'mizuno_wave_claw471GA264305.jpg',
            ],
             [
                'ten_san_pham' => 'Giày mizuno_wave_fang_271GA231347',
                'gia_co_ban'   => 2320000,
                'anh_dai_dien' => 'mizuno_wave_fang_271GA231347.jpg',
            ],
        ];
        foreach ($danhSachGiay as $giay) {
            $slug = Str::slug($giay['ten_san_pham']);

            SanPham::updateOrCreate(
                ['slug' => $slug],
                [
                    'ten_san_pham' => $giay['ten_san_pham'],
                    'danh_muc_id' => 2,
                    'gia_co_ban'   => $giay['gia_co_ban'],
                    'anh_dai_dien' => $giay['anh_dai_dien'],
                    'trang_thai_kinh_doanh' => true,
                ]
            );
        }
    }
}