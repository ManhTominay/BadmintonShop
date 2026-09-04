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
        if (!Schema::hasTable('gio_hang')) {
            Schema::create('gio_hang', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('nguoi_dung_id');
                $table->unsignedBigInteger('bien_the_id')->nullable();
                $table->integer('so_luong')->default(1);
                $table->string('size')->nullable();
                $table->unsignedBigInteger('cuoc_kem_bien_the_id')->nullable();
                $table->string('so_kg_cang')->nullable();
            });
        }

        if (Schema::hasTable('gio_hang')) {
            Schema::table('gio_hang', function (Blueprint $table) {
                if (!Schema::hasColumn('gio_hang', 'nguoi_dung_id')) {
                    $table->unsignedBigInteger('nguoi_dung_id');
                }
                if (!Schema::hasColumn('gio_hang', 'bien_the_id')) {
                    $table->unsignedBigInteger('bien_the_id')->nullable();
                }
                if (!Schema::hasColumn('gio_hang', 'so_luong')) {
                    $table->integer('so_luong')->default(1);
                }
                if (!Schema::hasColumn('gio_hang', 'size')) {
                    $table->string('size')->nullable();
                }
                if (!Schema::hasColumn('gio_hang', 'cuoc_kem_bien_the_id')) {
                    $table->unsignedBigInteger('cuoc_kem_bien_the_id')->nullable();
                }
                if (!Schema::hasColumn('gio_hang', 'so_kg_cang')) {
                    $table->string('so_kg_cang')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gio_hang');
    }
};
