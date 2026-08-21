<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanPham;
use Illuminate\Support\Str;

class QuanAoSeeder extends Seeder
{
    public function run(): void
    {
        $danhSachQuanAo = [
            // --- YONEX ---
            [
                'ten_san_pham' => 'Áo Cầu Lông Yonex R3239 White',
                'gia_co_ban' => 149000,
                'anh_dai_dien' => 'ao-yonex-R3239-white.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Yonex RM3239 Jet Black',
                'gia_co_ban' => 149000,
                'anh_dai_dien' => 'ao-yonex-RM3239-jetblack.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Yonex RM3232 White',
                'gia_co_ban' => 149000,
                'anh_dai_dien' => 'ao-yonex-RM3232-white.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Yonex RM3232 Dark Eclipse',
                'gia_co_ban' => 149000,
                'anh_dai_dien' => 'ao-yonex_RM3232-DarkEclipse.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Yonex RM3226 White',
                'gia_co_ban' => 149000,
                'anh_dai_dien' => 'ao-yonex-RM3226-white.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Yonex RM3216 Poinciana',
                'gia_co_ban' => 139000,
                'anh_dai_dien' => 'ao-yonex-RM3216-poinciana.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Yonex TSM3257-RW3ZZ Black',
                'gia_co_ban' => 159000,
                'anh_dai_dien' => 'quan-yonex-TSM3257-RW3ZZ-black.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Yonex SM3387-ESST4 White',
                'gia_co_ban' => 309000,
                'anh_dai_dien' => 'quan-yonex-SM3387-ESST4-white.jpg'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Yonex TSM3085 White',
                'gia_co_ban' => 139000,
                'anh_dai_dien' => 'quan-yonex-TSM3085-white.webp'
            ],

            // --- VICTOR ---
            [
                'ten_san_pham' => 'Áo Cầu Lông Victor 2117 Nữ',
                'gia_co_ban' => 160000,
                'anh_dai_dien' => 'ao-victor-2117-nu.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Victor 2118 Nữ',
                'gia_co_ban' => 160000,
                'anh_dai_dien' => 'ao-victor-2118-nu.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Victor T-40009D',
                'gia_co_ban' => 250000,
                'anh_dai_dien' => 'ao-victor-T-40009D.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Victor 225',
                'gia_co_ban' => 130000,
                'anh_dai_dien' => 'quan-victor-225.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Victor 901',
                'gia_co_ban' => 130000,
                'anh_dai_dien' => 'quan-victor-901.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Victor 960',
                'gia_co_ban' => 130000,
                'anh_dai_dien' => 'quan-victor-960.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Victor 001 Xám',
                'gia_co_ban' => 110000,
                'anh_dai_dien' => 'quan-victor-001-xam.webp'
            ],

            // --- LINING ---
            [
                'ten_san_pham' => 'Áo Cầu Lông Li-Ning P ATSU493-3',
                'gia_co_ban' => 295000,
                'anh_dai_dien' => 'ao-lining-p_ATSU493-3.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Li-Ning P ATSU493-2',
                'gia_co_ban' => 295000,
                'anh_dai_dien' => 'ao-lining-P-ATSU493-2.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Li-Ning P ATSUB07-1',
                'gia_co_ban' => 470000,
                'anh_dai_dien' => 'ao-lining-P-ATSUB07-1.webp'
            ],
            [
                'ten_san_pham' => 'Áo Cầu Lông Li-Ning P APLUA47-1',
                'gia_co_ban' => 599000,
                'anh_dai_dien' => 'ao-lining-P-APLUA47-1.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Li-Ning 967 Xanh Navy',
                'gia_co_ban' => 130000,
                'anh_dai_dien' => 'quan-lining-967-xanhnavy.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Li-Ning Q23',
                'gia_co_ban' => 110000,
                'anh_dai_dien' => 'quan-lining-Q23.webp'
            ],
            [
                'ten_san_pham' => 'Quần Cầu Lông Li-Ning 9682',
                'gia_co_ban' => 133000,
                'anh_dai_dien' => 'quan-lining-9682.webp'
            ]
        ];

        foreach ($danhSachQuanAo as $item) {
            SanPham::updateOrCreate(
                ['slug' => Str::slug($item['ten_san_pham'])],
                [
                    'ten_san_pham' => $item['ten_san_pham'],
                    'gia_co_ban'   => $item['gia_co_ban'],
                    'anh_dai_dien' => $item['anh_dai_dien']
                ]
            );
        }
    }
}