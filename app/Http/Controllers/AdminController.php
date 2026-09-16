<?php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use App\Models\FacebookSetting;
use App\Models\Game;
use App\Models\Listing;
use App\Models\Promotion;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'listings_total' => Listing::count(),
            'listings_linked' => Listing::whereNotNull('post_id')->count(),
            'games_total' => Game::count(),
            'games_published' => Game::where('status', 'published')->count(),
            'apps_total' => AppRelease::count(),
            'apps_active' => AppRelease::where('is_active', true)->count(),
            'facebook_configured' => FacebookSetting::whereNotNull('lsd')->orWhereNotNull('fb_cookie')->exists(),
            'promotions_total' => Promotion::count(),
            'promotions_active' => Promotion::where('is_active', true)->count(),
        ];
        $stats['listings_unlinked'] = $stats['listings_total'] - $stats['listings_linked'];

        $apps = AppRelease::orderBy('name')->get();
        $recentListings = Listing::orderBy('name')->limit(5)->get();
        $recentGames = Game::orderBy('created_at', 'desc')->limit(5)->get();
        $promotions = Promotion::orderBy('sort_order')->orderByDesc('updated_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'apps', 'recentListings', 'recentGames', 'promotions'));
    }
}
