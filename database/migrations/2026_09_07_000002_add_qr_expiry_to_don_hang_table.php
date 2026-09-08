<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('don_hang', 'qr_expires_at')) {
            Schema::table('don_hang', function (Blueprint $table) {
                $table->timestamp('qr_expires_at')->nullable()->after('thoi_diem_thanh_toan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('don_hang', 'qr_expires_at')) {
            Schema::table('don_hang', function (Blueprint $table) {
                $table->dropColumn('qr_expires_at');
            });
        }
    }
};