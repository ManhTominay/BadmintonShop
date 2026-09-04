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
        if (!Schema::hasTable('nguoi_dung')) {
            Schema::create('nguoi_dung', function (Blueprint $table) {
                $table->id();
                $table->string('ho_ten');
                $table->string('email')->unique();
                $table->string('so_dien_thoai')->nullable();
                $table->string('mat_khau_hash');
                $table->string('vai_tro')->default('khach_hang');
                $table->rememberToken();
            });
        }

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
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dia_chi_nguoi_dung');
        Schema::dropIfExists('nguoi_dung');
    }
};
