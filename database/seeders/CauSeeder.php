<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CauSeeder extends Seeder
{
    public function run()
    {
        // 1. Thêm danh mục Cầu Cầu Lông với id = 3
        DB::table('danh_muc')->updateOrInsert(
            ['id' => 3],
            [
                'ten_danh_muc' => 'Cầu Cầu Lông',
                'slug' => 'cau-cau-long',
                'danh_muc_cha_id' => null
            ]
        );

        // 2. Chèn danh sách sản phẩm quả cầu vào danh_muc_id = 3
        $danhSachCau = [
            [
                'ten_san_pham' => 'Quả Cầu Lông Victor NCS MAX',
                'slug' => Str::slug('Qua Cau Long Victor NCS MAX'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 410000,
                'anh_dai_dien' => 'cau-victor-NCSMAX.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Victor Master No.7',
                'slug' => Str::slug('Qua Cau Long Victor Master No 7'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 480000,
                'anh_dai_dien' => 'cau-victor-master-no7.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Thành Công 77',
                'slug' => Str::slug('Qua Cau Long Thanh Cong 77'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 315000,
                'anh_dai_dien' => 'cau-thanhcong77.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Ba Sao Pro2',
                'slug' => Str::slug('Qua Cau Long Ba Sao Pro2'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 250000,
                'anh_dai_dien' => 'caubasaoporo2.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Ba Sao ProX',
                'slug' => Str::slug('Qua Cau Long Ba Sao ProX'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 320000,
                'anh_dai_dien' => 'caubasaoproX.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Victor Lark 5',
                'slug' => Str::slug('Qua Cau Long Victor Lark 5'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 325000,
                'anh_dai_dien' => 'cau-victor-lark5.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Nhựa Victor NCS-TUC24',
                'slug' => Str::slug('Qua Cau Long Nhua Victor NCS TUC24'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 200000,
                'anh_dai_dien' => 'cau-nhua-victor-NCS-TUC24.webp',
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Yonex AS40',
                'slug' => Str::slug('Qua Cau Long Yonex AS40'),
                'danh_muc_id' => 3,
                'gia_co_ban' => 1659000,
                'anh_dai_dien' => 'qua_cau_yonexAS40.webp',
            ],
        ];

        // 3. Sử dụng updateOrInsert theo slug để chống lỗi trùng lặp khi chạy lại
        foreach ($danhSachCau as $item) {
            DB::table('san_pham')->updateOrInsert(
                ['slug' => $item['slug']],
                [
                    'ten_san_pham' => $item['ten_san_pham'],
                    'danh_muc_id' => $item['danh_muc_id'],
                    'gia_co_ban' => $item['gia_co_ban'],
                    'anh_dai_dien' => $item['anh_dai_dien'],
                ]
            );
        }
    }
}