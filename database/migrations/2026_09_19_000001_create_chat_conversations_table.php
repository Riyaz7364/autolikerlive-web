<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('guest_token', 128)->unique();
            $table->string('name', 120);
            $table->string('email', 190)->nullable();
            $table->string('page_url', 500)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('ip', 64)->nullable()->index();
            $table->string('country', 120)->nullable();
            $table->string('city', 120)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser', 120)->nullable();
            $table->string('browser_version', 40)->nullable();
            $table->string('platform', 120)->nullable();
            $table->string('device', 60)->default('desktop'); // desktop|mobile|tablet
            $table->string('status', 20)->default('open')->index(); // open|pending|resolved|closed|blocked
            $table->text('blocked_reason')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->unsignedInteger('admin_unread')->default(0);
            $table->unsignedInteger('guest_unread')->default(0);
            $table->timestamp('last_message_at')->nullable()->index();
            $table->timestamp('last_admin_seen_at')->nullable();
            $table->timestamp('last_guest_seen_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'last_message_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};
