<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // internal label, e.g. "InstaLiker launch"
            $table->string('badge_text')->nullable(); // e.g. "NEW APP"
            $table->string('title'); // e.g. "Try our new Instagram Comment Liker"
            $table->string('subtitle')->nullable();
            $table->string('button_text')->default('Try it now');
            $table->string('button_url'); // e.g. /instagram-comment-liker
            $table->string('emoji')->default('📸')->nullable();
            $table->string('image_url')->nullable();
            // placement controls
            $table->boolean('show_on_tiktok_views')->default(true);
            $table->boolean('show_on_tiktok_likes')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
