<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('chat_messages')) {
            Schema::create('chat_messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('nguoi_dung_id');
                $table->unsignedBigInteger('sender_id');
                $table->string('sender_role', 30);
                $table->text('message');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('read_at')->nullable();
                $table->index(['nguoi_dung_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};