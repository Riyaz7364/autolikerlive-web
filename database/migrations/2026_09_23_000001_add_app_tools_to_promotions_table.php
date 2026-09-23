<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->boolean('show_on_app')->default(false)->after('show_on_homepage');
            $table->boolean('show_on_tools')->default(false)->after('show_on_app');
        });

        // Seed cross-promos for the highest-traffic pages (Sep 2026 GA):
        // - /app/* (autoliker, rajeliker, permission): push TikTok tools + APK download
        // - tools pages (call-bomber, download, session/login): push comment-liker + TikTok
        DB::table('promotions')->where('name', 'InstaLiker launch')->update(['show_on_tools' => true]);
        DB::table('promotions')->where('name', 'RajeLiker on FB1000')->update(['show_on_app' => true]);

        DB::table('promotions')->updateOrInsert(
            ['name' => 'TikTok free likes & views'],
            [
                'badge_text' => 'FREE',
                'title' => 'Free TikTok Likes & Views every 15 minutes',
                'subtitle' => 'No login needed — instant free TikTok boost from autolikerlive.com',
                'button_text' => 'Get free boost',
                'button_url' => '/free-tiktok-likes',
                'emoji' => '🎵',
                'image_url' => null,
                'theme' => 'default',
                'short_name' => 'TikTok Free',
                'show_on_tiktok_views' => false,
                'show_on_tiktok_likes' => false,
                'show_on_fb_1000_likes' => false,
                'show_on_landing' => false,
                'show_on_homepage' => false,
                'show_on_app' => true,
                'show_on_tools' => true,
                'is_active' => true,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn(['show_on_app', 'show_on_tools']);
        });
    }
};
