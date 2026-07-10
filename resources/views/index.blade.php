@extends('layouts.game')

@section('title', 'Fun Games')
@section('description', 'Create and share fun Facebook image games with your friends. Free entertainment games.')

@section('content')
<div class="pb-20">
    <div class="page-header mb-16">
        <h1>🎮 Fun Image Games</h1>
        <p>Create & share fun images with your Facebook friends</p>
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
                        <div class="og-title">{{ $game->title }}</div>
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