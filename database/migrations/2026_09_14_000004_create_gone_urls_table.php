<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gone_urls', function (Blueprint $table) {
            $table->id();
            // URL path without leading/trailing slashes, lowercase, e.g. "old-tool" or "game/old-slug"
            $table->string('path')->unique();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gone_urls');
    }
};
