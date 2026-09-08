<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            if (!Schema::hasColumn('don_hang', 'sepay_transaction_id')) {
                $table->string('sepay_transaction_id')->nullable()->unique();
            }

            if (!Schema::hasColumn('don_hang', 'thoi_diem_thanh_toan')) {
                $table->timestamp('thoi_diem_thanh_toan')->nullable();
            }

            if (!Schema::hasColumn('don_hang', 'qr_expires_at')) {
                $table->timestamp('qr_expires_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('don_hang', function (Blueprint $table) {
            if (Schema::hasColumn('don_hang', 'sepay_transaction_id')) {
                $table->dropUnique(['sepay_transaction_id']);
                $table->dropColumn('sepay_transaction_id');
            }

            if (Schema::hasColumn('don_hang', 'thoi_diem_thanh_toan')) {
                $table->dropColumn('thoi_diem_thanh_toan');
            }

            if (Schema::hasColumn('don_hang', 'qr_expires_at')) {
                $table->dropColumn('qr_expires_at');
            }
        });
    }
};