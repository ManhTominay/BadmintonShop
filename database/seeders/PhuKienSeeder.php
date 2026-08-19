<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PhuKienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Tạo hoặc cập nhật danh mục Phụ Kiện Cầu Lông với id = 5
        DB::table('danh_muc')->updateOrInsert(
            ['id' => 5],
            [
                'ten_danh_muc' => 'Phụ Kiện Cầu Lông',
                'slug' => 'phu-kien',
                'danh_muc_cha_id' => null
            ]
        );

        // 2. Danh sách đầy đủ các sản phẩm phụ kiện
        $danhSachPhuKien = [
            // Bao Vợt
            [
                'ten_san_pham' => 'Bao Vợt Cầu Lông Yonex Pro Bag 6 chiếc',
                'slug' => Str::slug('Bao Vot Cau Long Yonex Pro Bag 6 chiec'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 850000,
                'anh_dai_dien' => 'bao-vot-yonex-pro.webp',
            ],
            [
                'ten_san_pham' => 'Bao Vợt Cầu Lông Victor Rectangle Bag',
                'slug' => Str::slug('Bao Vot Cau Long Victor Rectangle Bag'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 790000,
                'anh_dai_dien' => 'bao-vot-victor-rect.webp',
            ],

            // Cước Vợt
            [
                'ten_san_pham' => 'Cước Cầu Lông Yonex BG 65 Ti',
                'slug' => Str::slug('Cuoc Cau Long Yonex BG 65 Ti'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 130000,
                'anh_dai_dien' => 'cuoc-yonex-bg65ti.webp',
            ],
            [
                'ten_san_pham' => 'Cước Cầu Lông Yonex BG 66 Ultimax',
                'slug' => Str::slug('Cuoc Cau Long Yonex BG 66 Ultimax'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 180000,
                'anh_dai_dien' => 'cuoc-yonex-bg66ultimax.webp',
            ],
            [
                'ten_san_pham' => 'Cước Cầu Lông Li-Ning No.1',
                'slug' => Str::slug('Cuoc Cau Long Li Ning No 1'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 150000,
                'anh_dai_dien' => 'cuoc-lining-no1.webp',
            ],

            // Băng Chặn Mồ Hôi Tay
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Tay Yonex AC488',
                'slug' => Str::slug('Bang Chan Mo Hoi Tay Yonex AC488'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 65000,
                'anh_dai_dien' => 'bang-tay-yonex.webp',
            ],
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Tay Victor Wristband',
                'slug' => Str::slug('Bang Chan Mo Hoi Tay Victor Wristband'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 55000,
                'anh_dai_dien' => 'bang-tay-victor.webp',
            ],

            // Băng Chặn Mồ Hôi Đầu / Trán
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Trán Yonex Headband',
                'slug' => Str::slug('Bang Chan Mo Hoi Tran Yonex Headband'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 80000,
                'anh_dai_dien' => 'bang-dau-yonex.webp',
            ],
            [
                'ten_san_pham' => 'Băng Chặn Mồ Hôi Trán Li-Ning Headband',
                'slug' => Str::slug('Bang Chan Mo Hoi Tran Li Ning Headband'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 75000,
                'anh_dai_dien' => 'bang-dau-lining.webp',
            ],

            // Cuốn Cán Vợt
            [
                'ten_san_pham' => 'Cuốn Cán Vợt Cầu Lông Yonex AC102EX',
                'slug' => Str::slug('Cuon Can Vot Cau Long Yonex AC102EX'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 25000,
                'anh_dai_dien' => 'cuon-can-yonex.webp',
            ],
            [
                'ten_san_pham' => 'Cuốn Cán Vợt Cầu Lông Victor V-GR01',
                'slug' => Str::slug('Cuon Can Vot Cau Long Victor V-GR01'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 20000,
                'anh_dai_dien' => 'cuon-can-victor.webp',
            ],

            // Tất / Vớ Cầu Lông
            [
                'ten_san_pham' => 'Tất Cầu Lông Yonex Cổ Ngắn',
                'slug' => Str::slug('Tat Cau Long Yonex Co Ngan'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 50000,
                'anh_dai_dien' => 'tat-yonex.webp',
            ],
            [
                'ten_san_pham' => 'Tất Cầu Lông Li-Ning Thể Thao',
                'slug' => Str::slug('Tat Cau Long Li Ning The Thao'),
                'danh_muc_id' => 5,
                'gia_co_ban' => 45000,
                'anh_dai_dien' => 'tat-lining.webp',
            ],
        ];

        DB::table('san_pham')->insert($danhSachPhuKien);
    }
}