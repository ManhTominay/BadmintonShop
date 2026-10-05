<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('ma_giam_gia', 'ghi_chu')) {
            Schema::table('ma_giam_gia', function (Blueprint $table) {
                $table->text('ghi_chu')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ma_giam_gia', 'ghi_chu')) {
            Schema::table('ma_giam_gia', function (Blueprint $table) {
                $table->dropColumn('ghi_chu');
            });
        }
    }
};