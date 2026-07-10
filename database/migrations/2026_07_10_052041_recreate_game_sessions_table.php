<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('game_sessions');

        Schema::create('game_sessions', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('username');
            $table->string('profile_pic');
            $table->string('dob', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_sessions');

        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_token', 64)->unique();
            $table->string('login_type', 20);
            $table->string('fb_id', 50)->nullable();
            $table->string('fb_username')->nullable();
            $table->string('fb_profile_pic')->nullable();
            $table->string('manual_name')->nullable();
            $table->string('manual_image')->nullable();
            $table->string('manual_unique_id', 20)->nullable();
            $table->timestamp('last_active')->nullable();
            $table->timestamps();
        });
    }
};
