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

        // 2. Danh sách sản phẩm
        $danhSachPhuKien = [
            // Tất / Vớ
            ['ten_san_pham' => 'Tất Cầu Lông Yonex Trơn Dài', 'gia_co_ban' => 80000, 'anh_dai_dien' => 'tat_yonex_trondai.webp'],
            ['ten_san_pham' => 'Tất Cầu Lông Yonex 3D Ergo Socks', 'gia_co_ban' => 100000, 'anh_dai_dien' => 'tat_yonex_3d_ergo_socks.webp'],
            ['ten_san_pham' => 'Tất Cầu Lông Yonex Lin Dan', 'gia_co_ban' => 100000, 'anh_dai_dien' => 'tat_yonex_Lindan.webp'],
            ['ten_san_pham' => 'Tất Cầu Lông Li-Ning P AWSV155-3C', 'gia_co_ban' => 174764, 'anh_dai_dien' => 'tat_lining_P_AWSV155-3C.webp'],
            ['ten_san_pham' => 'Tất Cầu Lông Li-Ning P AWTV009-3V', 'gia_co_ban' => 196364, 'anh_dai_dien' => 'tat_lining_P_AWTV009-3V.webp'],
            ['ten_san_pham' => 'Tất Cầu Lông Taro Pattern TTR06-2061', 'gia_co_ban' => 55000, 'anh_dai_dien' => 'tat_taro_pattern_TTR06-2061.webp'],

            // Băng Trán & Băng Chặn Mồ Hôi
            ['ten_san_pham' => 'Băng Trán Yonex PHB002ZHB1ZZ Navy', 'gia_co_ban' => 55000, 'anh_dai_dien' => 'bang_tran_yonex_PHB002ZHB1ZZ-navy.webp'],
            ['ten_san_pham' => 'Băng Tay Yonex 08522-2', 'gia_co_ban' => 95000, 'anh_dai_dien' => 'bang_tay_yonex_08522-2.webp'],
            ['ten_san_pham' => 'Băng Chặn Mồ Hôi VS VH071', 'gia_co_ban' => 50000, 'anh_dai_dien' => 'bang_chan_vs-VH071.webp'],
            ['ten_san_pham' => 'Băng Chặn Mồ Hôi Li-Ning AHWS029-8', 'gia_co_ban' => 55000, 'anh_dai_dien' => 'bang_chan_lining-AHWS029-8.webp'],
            ['ten_san_pham' => 'Băng Chặn Mồ Hôi Li-Ning AHWR014-8', 'gia_co_ban' => 65000, 'anh_dai_dien' => 'bang_chan_lining-AHWR014-8.webp'],
            ['ten_san_pham' => 'Băng Chặn Mồ Hôi Kumpoo K31', 'gia_co_ban' => 75000, 'anh_dai_dien' => 'bang_chan_kumpoo-k31.webp'],

            // Cước Vợt Cầu Lông
            ['ten_san_pham' => 'Cước Cầu Lông Hundred JP66', 'gia_co_ban' => 149000, 'anh_dai_dien' => 'cuoc_hundred-JP66.webp'],
            ['ten_san_pham' => 'Cước Cầu Lông Kizuna Z65X', 'gia_co_ban' => 150000, 'anh_dai_dien' => 'cuoc_kizuna-Z65X.webp'],
            ['ten_san_pham' => 'Cước Cầu Lông GOSEN Ryzonic 65 Pochaneco', 'gia_co_ban' => 155000, 'anh_dai_dien' => 'cuoc_GOSEN-ryzonic65-pochaneco.webp'],
            ['ten_san_pham' => 'Cước Cầu Lông Yonex BG EXBOLT 65', 'gia_co_ban' => 200000, 'anh_dai_dien' => 'cuoc-BGEXBOLT65.webp'],

            // Bao Vợt / Túi
            ['ten_san_pham' => 'Bao Vợt Cầu Lông Victor AG-150', 'gia_co_ban' => 894000, 'anh_dai_dien' => 'bao_victor-AG-150.webp'],
            ['ten_san_pham' => 'Bao Vợt Cầu Lông Taro TR024-BAG01', 'gia_co_ban' => 599000, 'anh_dai_dien' => 'bao_taro-TR024-BAG01.webp'],
            ['ten_san_pham' => 'Bao Vợt Cầu Lông Li-Ning P ABLV029-3', 'gia_co_ban' => 1150000, 'anh_dai_dien' => 'bao_lining-P-ABLV029-3.webp'],
            ['ten_san_pham' => 'Bao Vợt Cầu Lông Yonex BAG324B0629', 'gia_co_ban' => 889000, 'anh_dai_dien' => 'bao_yonex_BAG324B0629.webp'],

            // Cuốn Cán & Cốt Vợt
            ['ten_san_pham' => 'Cuốn Cán VS OnePiece VG121', 'gia_co_ban' => 50000, 'anh_dai_dien' => 'cuon_can_VS-OnePiece-VG121.webp'],
            ['ten_san_pham' => 'Cuốn Cán Kumpoo KG-30', 'gia_co_ban' => 40000, 'anh_dai_dien' => 'cuon_can_Kumpoo-KG-30.webp'],
            ['ten_san_pham' => 'Cuốn Cán Yonex ET903E', 'gia_co_ban' => 25000, 'anh_dai_dien' => 'cuon_can_yonex-ET903E.webp'],
            ['ten_san_pham' => 'Cuốn Cán Vải Taro TR025-TG02', 'gia_co_ban' => 350000, 'anh_dai_dien' => 'cuon_can_vai_Taro-TR025-TG02.webp'],
            ['ten_san_pham' => 'Cốt Yonex AC381', 'gia_co_ban' => 187000, 'anh_dai_dien' => 'cot-yonexAC381.webp'],
            ['ten_san_pham' => 'Cốt Yonex AC013CR', 'gia_co_ban' => 130000, 'anh_dai_dien' => 'cot_yonex-AC013CR.webp'],
        ];

        // 3. Sử dụng updateOrInsert dựa vào slug để cập nhật hoặc thêm mới không bị lỗi trùng lặp
        foreach ($danhSachPhuKien as $item) {
            $slug = Str::slug($item['ten_san_pham']);
            
            DB::table('san_pham')->updateOrInsert(
                ['slug' => $slug], // Kiểm tra nếu slug đã tồn tại thì cập nhật
                [
                    'ten_san_pham' => $item['ten_san_pham'],
                    'danh_muc_id' => 5,
                    'gia_co_ban' => $item['gia_co_ban'],
                    'anh_dai_dien' => $item['anh_dai_dien'],
                ]
            );
        }
    }
}