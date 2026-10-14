<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            if (!Schema::hasColumn('don_hang', 'ngan_hang_hoan_tien')) {
                $table->string('ngan_hang_hoan_tien', 100)->nullable();
            }

            if (!Schema::hasColumn('don_hang', 'ten_chu_tai_khoan_hoan_tien')) {
                $table->string('ten_chu_tai_khoan_hoan_tien', 100)->nullable();
            }

            if (!Schema::hasColumn('don_hang', 'so_tai_khoan_hoan_tien')) {
                $table->string('so_tai_khoan_hoan_tien', 34)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            foreach ([
                'ngan_hang_hoan_tien',
                'ten_chu_tai_khoan_hoan_tien',
                'so_tai_khoan_hoan_tien',
            ] as $column) {
                if (Schema::hasColumn('don_hang', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
