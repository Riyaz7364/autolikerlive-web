@extends('layouts.game')

@section('title', 'Free Facebook Image Games & Profile Picture Maker')
@section('description', 'AutoLikerLive offers free Facebook auto liker with 1000 likes, Facebook image games, profile picture maker, auto reactions, auto followers, and more social media tools. Fast, safe, and free.')
@section('keywords', 'auto liker live, autolikerlive, auto liker, facebook auto liker, fb liker 1000 likes, facebook image games, profile picture maker, free facebook liker, auto react facebook, facebook auto followers, photo frame maker, viral image games, image game maker, fb auto liker, facebook page liker')

@section('content')
<div class="pb-20">
    <div class="page-header mb-16">
        <h1>Free Facebook Image Games & Profile Picture Maker</h1>
        <p>Create fun image games, profile picture frames & viral photo cards for Facebook. Play free, share with friends!</p>
    </div>

    @if (count($games) > 0)
        <div class="games-list">
            @foreach ($games as $game)
                <a href="{{ route('game.show', $game->slug) }}" class="og-card">
                    <div class="og-img" style="background: linear-gradient(135deg, {{ $game->bg_color ?? '#1a1a2e' }}, {{ $game->bg_color ?? '#16213e' }}); overflow:hidden;">
                        @if ($game->thumbnail)
                            <img src="{{ Storage::disk('public')->url($game->thumbnail) }}" alt="{{ $game->title }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            @switch($game->slug)
                                @case('which-bollywood-star-are-you') 🎬 @break
                                @case('my-facebook-superpower') ⚡ @break
                                @case('my-facebook-report-card') 📋 @break
                                @case('which-animal-are-you') 🦁 @break
                                @case('my-facebook-award') 🏆 @break
                                @default 🎮
                            @endswitch
                        @endif
                    </div>
                    <div class="og-bottom">
                        <div class="og-title">{{ resolveGameTitle($game->title) }}</div>
                        @if ($game->description)
                            <div class="og-desc">{{ $game->description }}</div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🎮</div>
            <p class="empty-state-text">No games available yet.</p>
        </div>
    @endif

    @if (isset($linkedPosts) && count($linkedPosts) > 0)
        <div class="listing-tags" style="margin-top:2rem; padding:1.5rem; background:#f8f9fa; border-radius:12px;">
            <h3 style="font-size:1rem; font-weight:700; color:#1a1a2e; margin-bottom:0.75rem;">More Free Tools</h3>
            <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">
                @foreach ($linkedPosts as $lp)
                    <a href="{{ url($lp['slug']) }}" style="display:inline-block; padding:0.4rem 0.9rem; background:#fff; border:1px solid #ddd; border-radius:50px; font-size:0.82rem; color:#333; text-decoration:none; transition:all 0.2s;">{{ $lp['name'] }}</a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@stop