<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->cascadeOnDelete();
            $table->string('sender', 12)->default('guest')->index(); // guest|admin|system
            $table->text('body');
            $table->boolean('is_read')->default(false);
            $table->string('ip', 64)->nullable();
            $table->timestamps();

            $table->index(['conversation_id', 'id']);
        });

        Schema::create('chat_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 64)->nullable()->index();
            $table->string('guest_token', 128)->nullable()->index();
            $table->string('reason', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_blocks');
    }
};
