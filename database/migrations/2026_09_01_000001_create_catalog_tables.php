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
        if (!Schema::hasTable('danh_muc')) {
            Schema::create('danh_muc', function (Blueprint $table) {
                $table->id();
                $table->string('ten_danh_muc');
                $table->string('slug')->nullable()->unique();
                $table->unsignedBigInteger('danh_muc_cha_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('thuong_hieu')) {
            Schema::create('thuong_hieu', function (Blueprint $table) {
                $table->id();
                $table->string('ten_thuong_hieu');
                $table->string('slug')->nullable()->unique();
                $table->string('logo')->nullable();
                $table->text('mo_ta')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('san_pham')) {
            Schema::create('san_pham', function (Blueprint $table) {
                $table->id();
                $table->string('ten_san_pham');
                $table->string('slug')->unique();
                $table->unsignedBigInteger('danh_muc_id')->nullable();
                $table->unsignedBigInteger('thuong_hieu_id')->nullable();
                $table->text('mo_ta')->nullable();
                $table->decimal('gia_co_ban', 12, 0)->default(0);
                $table->string('anh_dai_dien')->nullable();
                $table->boolean('la_san_pham_noi_bat')->default(false);
                $table->boolean('la_san_pham_moi')->default(false);
                $table->boolean('trang_thai_kinh_doanh')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('bien_the_san_pham')) {
            Schema::create('bien_the_san_pham', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('san_pham_id');
                $table->string('size')->nullable();
                $table->string('mau_sac')->nullable();
                $table->string('ma_sku')->nullable();
                $table->integer('so_luong_ton')->default(0);
                $table->integer('so_luong_ton_kho')->nullable()->default(9999);
                $table->decimal('gia', 12, 0)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('thong_so_vot')) {
            Schema::create('thong_so_vot', function (Blueprint $table) {
                $table->unsignedBigInteger('san_pham_id')->primary();
                $table->string('do_cung_than')->nullable();
                $table->string('diem_can_bang')->nullable();
                $table->string('trong_luong_chuandieu')->nullable();
                $table->string('muc_cang_toi_da_kg')->nullable();
                $table->string('chat_lieu_khung')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('don_hang')) {
            Schema::create('don_hang', function (Blueprint $table) {
                $table->id();
                $table->string('ma_don_hang')->nullable();
                $table->unsignedBigInteger('nguoi_dung_id')->nullable();
                $table->string('ten_nguoi_nhan')->nullable();
                $table->string('so_dien_thoai')->nullable();
                $table->text('dia_chi_giao_hang')->nullable();
                $table->decimal('tong_tien_hang', 12, 0)->default(0);
                $table->decimal('phi_van_chuyen', 12, 0)->default(0);
                $table->decimal('so_tien_giam', 12, 0)->default(0);
                $table->decimal('tong_thanh_toan', 12, 0)->default(0);
                $table->string('phuong_thuc_thanh_toan')->nullable();
                $table->string('trang_thai_thanh_toan')->nullable();
                $table->string('trang_thai_don_hang')->nullable();
                $table->string('ma_van_don')->nullable();
                $table->unsignedBigInteger('ma_giam_gia_id')->nullable();
                $table->timestamp('ngay_tao')->nullable();
            });
        }

        if (!Schema::hasTable('chi_tiet_don_hang')) {
            Schema::create('chi_tiet_don_hang', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('don_hang_id');
                $table->unsignedBigInteger('san_pham_id')->nullable();
                $table->unsignedBigInteger('bien_the_id')->nullable();
                $table->integer('so_luong')->default(1);
                $table->decimal('gia', 12, 0)->default(0);
                $table->decimal('thanh_tien', 12, 0)->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_hang');
        Schema::dropIfExists('don_hang');
        Schema::dropIfExists('thong_so_vot');
        Schema::dropIfExists('bien_the_san_pham');
        Schema::dropIfExists('san_pham');
        Schema::dropIfExists('thuong_hieu');
        Schema::dropIfExists('danh_muc');
    }
};
