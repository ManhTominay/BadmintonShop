<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('don_hang', 'ly_do_huy')) {
            Schema::table('don_hang', function (Blueprint $table) {
                $table->string('ly_do_huy')->nullable()->after('trang_thai_don_hang');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('don_hang', 'ly_do_huy')) {
            Schema::table('don_hang', function (Blueprint $table) {
                $table->dropColumn('ly_do_huy');
            });
        }
    }
};
