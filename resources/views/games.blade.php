@extends('layouts.game')

@section('title', 'Free Facebook Image Games & Profile Picture Maker')
@section('description', 'Play free Facebook image games, profile picture frames and viral photo cards. Fun games to play free and share with friends on Facebook.')
@section('keywords', 'facebook image games, profile picture maker, photo frame maker, viral image games, image game maker, free facebook games')

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
                            <img src="{{ Storage::disk('public')->url($game->thumbnail) }}" alt="{{ $game->title }}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                        @else
                            🎮
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
</div>
@stop

@section('sidebar')
    <div class="widget">
        <h3>⚠️ Disclaimer</h3>
        <p>These games are for <strong>entertainment purposes only</strong>. All images are auto-generated and do not reflect real traits, abilities, or facts.</p>
    </div>

    <div class="widget">
        <h3>🔧 Free Tools</h3>
        <div class="flex flex-col gap-8">
            <a href="{{ route('free-tiktok-views') }}">TikTok Views</a>
            <a href="{{ route('free-tiktok-likes') }}">TikTok Likes</a>
            <a href="{{ route('free-instagram-likes') }}">Instagram Likes</a>
            <a href="{{ url('services') }}">All Tools →</a>
        </div>
    </div>
@stop
