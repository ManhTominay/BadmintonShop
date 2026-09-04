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
        if (!Schema::hasTable('ma_giam_gia')) {
            Schema::create('ma_giam_gia', function (Blueprint $table) {
                $table->id();
                $table->string('ma_code', 50)->unique();
                $table->string('loai_giam_gia', 50)->default('percent');
                $table->decimal('gia_tri_giam', 12, 2)->default(0);
                $table->decimal('don_hang_toi_thieu', 12, 2)->default(0);
                $table->decimal('giam_toi_da', 12, 2)->default(0);
                $table->integer('so_luong_dung')->default(0);
                $table->dateTime('ngay_bat_dau')->nullable();
                $table->dateTime('ngay_ket_thuc')->nullable();
                $table->string('trang_thai', 50)->default('active');
                $table->boolean('trang_thai_kich_hoat')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ma_giam_gia');
    }
};
