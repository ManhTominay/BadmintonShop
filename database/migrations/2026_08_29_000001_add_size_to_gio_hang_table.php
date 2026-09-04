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
        if (Schema::hasTable('gio_hang')) {
            Schema::table('gio_hang', function (Blueprint $table) {
                if (!Schema::hasColumn('gio_hang', 'size')) {
                    $table->string('size')->nullable()->after('so_luong');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gio_hang', function (Blueprint $table) {
            if (Schema::hasColumn('gio_hang', 'size')) {
                $table->dropColumn('size');
            }
        });
    }
};
