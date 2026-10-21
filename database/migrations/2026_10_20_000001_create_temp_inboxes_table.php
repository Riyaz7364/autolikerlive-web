<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Temp mail inboxes owned by app instances (the mobile app). An inbox is
     * only readable by whoever holds its inbox_token — that token is issued
     * once, by POST /api/tempmail/create.
     */
    public function up(): void
    {
        Schema::create('temp_inboxes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('inbox_token', 64)->unique();   // secret handed to the creating app
            $table->string('email', 190)->unique();        // full address, e.g. ravi.xk3s9@maildomain.shop
            $table->string('local_part', 100);
            $table->string('domain', 100);
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('last_seen_at')->nullable()->index(); // last fetch/watch touch
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_inboxes');
    }
};
