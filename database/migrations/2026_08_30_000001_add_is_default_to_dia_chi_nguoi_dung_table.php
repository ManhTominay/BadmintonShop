<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('dia_chi_nguoi_dung')) {
            Schema::create('dia_chi_nguoi_dung', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('nguoi_dung_id');
                $table->string('ten_nguoi_nhan');
                $table->string('so_dien_thoai');
                $table->string('tinh_thanh');
                $table->string('phuong_xa');
                $table->string('dia_chi_chi_tiet');
                $table->boolean('is_default')->default(false);
            });
            return;
        }

        Schema::table('dia_chi_nguoi_dung', function (Blueprint $table) {
            if (!Schema::hasColumn('dia_chi_nguoi_dung', 'is_default')) {
                $table->boolean('is_default')->default(false)->after('dia_chi_chi_tiet');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('dia_chi_nguoi_dung')) {
            Schema::table('dia_chi_nguoi_dung', function (Blueprint $table) {
                if (Schema::hasColumn('dia_chi_nguoi_dung', 'is_default')) {
                    $table->dropColumn('is_default');
                }
            });
        }
    }
};
