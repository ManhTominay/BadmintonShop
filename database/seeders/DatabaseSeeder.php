<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'ten_danh_muc' => 'Vợt Cầu Lông', 'slug' => 'vot-cau-long', 'danh_muc_cha_id' => null],
            ['id' => 2, 'ten_danh_muc' => 'Giày Cầu Lông', 'slug' => 'giay-cau-long', 'danh_muc_cha_id' => null],
            ['id' => 3, 'ten_danh_muc' => 'Cầu Cầu Lông', 'slug' => 'cau-cau-long', 'danh_muc_cha_id' => null],
            ['id' => 4, 'ten_danh_muc' => 'Quần Áo Cầu Lông', 'slug' => 'quan-ao', 'danh_muc_cha_id' => null],
            ['id' => 5, 'ten_danh_muc' => 'Phụ Kiện Cầu Lông', 'slug' => 'phu-kien', 'danh_muc_cha_id' => null],
        ];

        foreach ($categories as $category) {
            DB::table('danh_muc')->updateOrInsert(
                ['id' => $category['id']],
                [
                    'ten_danh_muc' => $category['ten_danh_muc'],
                    'slug' => $category['slug'],
                    'danh_muc_cha_id' => $category['danh_muc_cha_id'],
                ]
            );
        }

        $this->call([
            UserSeeder::class,
            VoucherSeeder::class,
            VotSeeder::class,
            GiaySeeder::class,
            CauSeeder::class,
            QuanAoSeeder::class,
            PhuKienSeeder::class,
        ]);
    }
}