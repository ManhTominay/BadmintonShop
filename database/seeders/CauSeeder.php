<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $danhSachCau = [
            [
                'ten_san_pham' => 'Quả Cầu Lông Victor NCS MAX',
                'slug' => Str::slug('Qua Cau Long Victor NCS MAX'),
                'gia_co_ban' => 410000,
                'anh_dai_dien' => 'cau-victor-NCSMAX.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Victor Master No.7',
                'slug' => Str::slug('Qua Cau Long Victor Master No 7'),
                'gia_co_ban' => 480000,
                'anh_dai_dien' => 'cau-victor-master-no7.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Thành Công 77',
                'slug' => Str::slug('Qua Cau Long Thanh Cong 77'),
                'gia_co_ban' => 315000,
                'anh_dai_dien' => 'cau-thanhcong77.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Ba Sao Pro2',
                'slug' => Str::slug('Qua Cau Long Ba Sao Pro2'),
                'gia_co_ban' => 250000,
                'anh_dai_dien' => 'caubasaoporo2.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Ba Sao ProX',
                'slug' => Str::slug('Qua Cau Long Ba Sao ProX'),
                'gia_co_ban' => 320000,
                'anh_dai_dien' => 'caubasaoproX.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Victor Lark 5',
                'slug' => Str::slug('Qua Cau Long Victor Lark 5'),
                'gia_co_ban' => 325000,
                'anh_dai_dien' => 'cau-victor-lark5.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ten_san_pham' => 'Quả Cầu Lông Nhựa Victor NCS-TUC24',
                'slug' => Str::slug('Qua Cau Long Nhua Victor NCS TUC24'),
                'gia_co_ban' => 200000,
                'anh_dai_dien' => 'cau-nhua-victor-NCS-TUC24.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Thay 'san_phams' bằng tên bảng sản phẩm trong database của bạn
        DB::table('san_pham')->insert($danhSachCau);
    }
}