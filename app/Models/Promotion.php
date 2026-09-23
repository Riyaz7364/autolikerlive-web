<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'badge_text',
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'emoji',
        'image_url',
        'theme',
        'short_name',
        'show_on_tiktok_views',
        'show_on_tiktok_likes',
        'show_on_fb_1000_likes',
        'show_on_landing',
        'show_on_homepage',
        'show_on_tools',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'show_on_tiktok_views' => 'boolean',
        'show_on_tiktok_likes' => 'boolean',
        'show_on_fb_1000_likes' => 'boolean',
        'show_on_landing' => 'boolean',
        'show_on_homepage' => 'boolean',
        'show_on_tools' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Active promos for a given placement, cached for 5 minutes.
     * $placement: 'tiktok_views' | 'tiktok_likes' | 'fb_1000_likes' | 'landing' | 'homepage' | 'tools'
     * NOTE: there is intentionally no 'app' placement — /app/* pages render
     * inside the Android WebView where external redirects/downloads don't
     * work, so promos never show there.
     */
    public static function activeFor(string $placement)
    {
        $map = [
            'tiktok_likes' => 'show_on_tiktok_likes',
            'fb_1000_likes' => 'show_on_fb_1000_likes',
            'landing' => 'show_on_landing',
            'homepage' => 'show_on_homepage',
            'tiktok_views' => 'show_on_tiktok_views',
            'tools' => 'show_on_tools',
        ];
        $column = $map[$placement] ?? 'show_on_tiktok_views';

        return Cache::remember("promotions_active_{$placement}", 300, function () use ($column) {
            return self::where('is_active', true)
                ->where($column, true)
                ->orderBy('sort_order')
                ->orderByDesc('updated_at')
                ->get();
        });
    }

    public static function flushPlacementCache(): void
    {
        Cache::forget('promotions_active_tiktok_views');
        Cache::forget('promotions_active_tiktok_likes');
        Cache::forget('promotions_active_fb_1000_likes');
        Cache::forget('promotions_active_landing');
        Cache::forget('promotions_active_homepage');
        Cache::forget('promotions_active_tools');
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::flushPlacementCache());
        static::deleted(fn () => self::flushPlacementCache());
    }
}
