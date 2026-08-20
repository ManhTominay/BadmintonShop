<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PhuKienSeeder extends Seeder
{
    public function run()
    {
        // 1. Đảm bảo danh mục Phụ Kiện Cầu Lông có id = 5
        DB::table('danh_muc')->updateOrInsert(
            ['id' => 5],
            [
                'ten_danh_muc' => 'Phụ Kiện Cầu Lông',
                'slug' => 'phu-kien',
                'danh_muc_cha_id' => null
            ]
        );

        // 2. Danh sách 20 sản phẩm phụ kiện gán danh_muc_id = 5
        $danhSachPhuKien = [
            // Tất / Vớ
            [
                'ten_san_pham' => 'Tất Cầu Lông Yonex Trơn Dài',
                'slug' => Str::slug('Tat Cau Long Yonex Tron Dai'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 80000,
                'anh_dai_dien' => 'tat_yonex_trondai.webp',
            ],
            [
                'ten_san_pham' => 'Tất Cầu Lông Yonex 3D Ergo Socks',
                'slug' => Str::slug('Tat Cau Long Yonex 3D Ergo Socks'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 100000,
                'anh_dai_dien' => 'tat_yonex_3d_ergo_socks.webp',
            ],
            [
                'ten_san_pham' => 'Tất Cầu Lông Yonex Lin Dan',
                'slug' => Str::slug('Tat Cau Long Yonex Lin Dan'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 100000,
                'anh_dai_dien' => 'tat_yonex_Lindan.webp',
            ],
            [
                'ten_san_pham' => 'Tất Cầu Lông Li-Ning P AWSV155-3C',
                'slug' => Str::slug('Tat Cau Long Li Ning P AWSV155-3C'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 174764,
                'anh_dai_dien' => 'tat_lining_P_AWSV155-3C.webp',
            ],
            [
                'ten_san_pham' => 'Tất Cầu Lông Li-Ning P AWTV009-3V',
                'slug' => Str::slug('Tat Cau Long Li Ning P AWTV009-3V'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 196364,
                'anh_dai_dien' => 'tat_lining_P_AWTV009-3V.webp',
            ],
            [
                'ten_san_pham' => 'Tất Cầu Lông Taro Pattern TTR06-2061',
                'slug' => Str::slug('Tat Cau Long Taro Pattern TTR06-2061'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 55000,
                'anh_dai_dien' => 'tat_taro_pattern_TTR06-2061.webp',
            ],

            // Băng Trán & Băng Chặn Mồ Hôi
            [
                'ten_san_pham' => 'Băng Trán Yonex PHB002ZHB1ZZ Navy',
                'slug' => Str::slug('Bang Tran Yonex PHB002ZHB1ZZ Navy'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 55000,
                'anh_dai_dien' => 'bang_tran_yonex_PHB002ZHB1ZZ-navy.webp',
            ],
            [
                'ten_san_pham' => 'Băng Tay Yonex 08522-2',
                'slug' => Str::slug('Bang Tay Yonex 08522-2'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 95000,
                'anh_dai_dien' => 'bang_tay_yonex_08522-2.webp',
            ],
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi VS VH071',
                'slug' => Str::slug('Bang Chan Mo Hoi VS VH071'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 50000,
                'anh_dai_dien' => 'bang_chan_vs-VH071.webp',
            ],
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Li-Ning AHWS029-8',
                'slug' => Str::slug('Bang Chan Mo Hoi Li Ning AHWS029-8'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 55000,
                'anh_dai_dien' => 'bang_chan_lining-AHWS029-8.webp',
            ],
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Li-Ning AHWR014-8',
                'slug' => Str::slug('Bang Chan Mo Hoi Li Ning AHWR014-8'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 65000,
                'anh_dai_dien' => 'bang_chan_lining-AHWR014-8.webp',
            ],
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Kumpoo K31',
                'slug' => Str::slug('Bang Chan Mo Hoi Kumpoo K31'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 75000,
                'anh_dai_dien' => 'bang_chan_kumpoo-k31.webp',
            ],

            // Cước Vợt Cầu Lông
            [
                'ten_san_pham' => 'Cước Cầu Lông Hundred JP66',
                'slug' => Str::slug('Cuoc Cau Long Hundred JP66'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 149000,
                'anh_dai_dien' => 'cuoc_hundred-JP66.webp',
            ],
            [
                'ten_san_pham' => 'Cước Cầu Lông Kizuna Z65X',
                'slug' => Str::slug('Cuoc Cau Long Kizuna Z65X'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 150000,
                'anh_dai_dien' => 'cuoc_kizuna-Z65X.webp',
            ],
            [
                'ten_san_pham' => 'Cước Cầu Lông GOSEN Ryzonic 65 Pochaneco',
                'slug' => Str::slug('Cuoc Cau Long GOSEN Ryzonic 65 Pochaneco'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 155000,
                'anh_dai_dien' => 'cuoc_GOSEN-ryzonic65-pochaneco.webp',
            ],
            [
                'ten_san_pham' => 'Cước Cầu Lông Yonex BG EXBOLT 65',
                'slug' => Str::slug('Cuoc Cau Long Yonex BG EXBOLT 65'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 200000,
                'anh_dai_dien' => 'cuoc-BGEXBOLT65.webp',
            ],

            // Bao Vợt / Túi
            [
                'ten_san_pham' => 'Bao Vợt Cầu Lông Victor AG-150',
                'slug' => Str::slug('Bao Vot Cau Long Victor AG-150'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 894000,
                'anh_dai_dien' => 'bao_victor-AG-150.webp',
            ],
            [
                'ten_san_pham' => 'Bao Vợt Cầu Lông Taro TR024-BAG01',
                'slug' => Str::slug('Bao Vot Cau Long Taro TR024-BAG01'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 599000,
                'anh_dai_dien' => 'bao_taro-TR024-BAG01.webp',
            ],
            [
                'ten_san_pham' => 'Bao Vợt Cầu Lông Li-Ning P ABLV029-3',
                'slug' => Str::slug('Bao Vot Cau Long Li Ning P ABLV029-3'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 1150000,
                'anh_dai_dien' => 'bao_lining-P-ABLV029-3.webp',
            ],
            [
                'ten_san_pham' => 'Bao Vợt Cầu Lông Yonex BAG324B0629',
                'slug' => Str::slug('Bao Vot Cau Long Yonex BAG324B0629'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 889000,
                'anh_dai_dien' => 'bao_yonex_BAG324B0629.webp',
            ],
        ];

        DB::table('san_pham')->insert($danhSachPhuKien);
    }
}