<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('danh_gia')) {
            Schema::create('danh_gia', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('nguoi_dung_id');
                $table->unsignedBigInteger('don_hang_id');
                $table->unsignedBigInteger('san_pham_id');
                $table->unsignedTinyInteger('so_sao');
                $table->text('noi_dung')->nullable();
                $table->timestamps();

                $table->unique(['nguoi_dung_id', 'don_hang_id', 'san_pham_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gia');
    }
};
