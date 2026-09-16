<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->boolean('show_on_fb_1000_likes')->default(false)->after('show_on_tiktok_likes');
            $table->boolean('show_on_landing')->default(false)->after('show_on_fb_1000_likes');
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['show_on_fb_1000_likes', 'show_on_landing']);
        });
    }
};
