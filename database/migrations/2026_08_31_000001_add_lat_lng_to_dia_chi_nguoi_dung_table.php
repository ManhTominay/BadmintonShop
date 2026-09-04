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
            return;
        }

        Schema::table('dia_chi_nguoi_dung', function (Blueprint $table) {
            if (!Schema::hasColumn('dia_chi_nguoi_dung', 'lat')) {
                $table->decimal('lat', 10, 7)->nullable()->after('dia_chi_chi_tiet');
            }

            if (!Schema::hasColumn('dia_chi_nguoi_dung', 'lng')) {
                $table->decimal('lng', 10, 7)->nullable()->after('lat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('dia_chi_nguoi_dung')) {
            return;
        }

        Schema::table('dia_chi_nguoi_dung', function (Blueprint $table) {
            if (Schema::hasColumn('dia_chi_nguoi_dung', 'lng')) {
                $table->dropColumn('lng');
            }

            if (Schema::hasColumn('dia_chi_nguoi_dung', 'lat')) {
                $table->dropColumn('lat');
            }
        });
    }
};
