@extends('layouts.game')

@section('title', 'Manage Games')
@section('description', 'Manage your image games.')

@section('sidebar')
    <div class="widget">
        <h3>📋 Admin</h3>
        <p class="text-sm">Manage your published game collection.</p>
    </div>
@stop

@section('content')
<div class="pb-20">
    <div class="flex items-center justify-between mb-16">
        <h1 class="editor-page-title">My Games</h1>
        <a href="{{ route('game.editor.create') }}" class="fb-btn fb-btn-sm">+ New Game</a>
    </div>

    @if (\Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if ($games->count() === 0)
        <div class="empty-state">
            <p class="empty-state-text mb-12">No games yet.</p>
            <a href="{{ route('game.editor.create') }}" class="fb-btn fb-btn-sm">Create your first game</a>
        </div>
    @else
        <div class="admin-list">
            @foreach ($games as $game)
                <div class="admin-list-item">
                    <div class="admin-list-header">
                        <div style="display:flex;align-items:center;gap:12px;">
                            @if ($game->thumbnail)
                                <img src="{{ Storage::disk('public')->url($game->thumbnail) }}" alt="" style="width:48px;height:36px;border-radius:6px;object-fit:cover;flex-shrink:0;">
                            @endif
                            <div>
                                <h2 class="admin-list-title">{{ $game->title }}</h2>
                                <span class="admin-list-badge admin-list-badge-{{ $game->status === 'published' ? 'published' : 'draft' }}">{{ $game->status }}</span>
                            </div>
                        </div>
                    </div>
                    @if ($game->description)
                        <p class="admin-list-desc">{{ Str::limit($game->description, 80) }}</p>
                    @endif
                    <div class="admin-list-actions">
                        <a href="{{ route('game.editor.edit-info', $game->id) }}" class="fb-btn fb-btn-sm fb-btn-outline">Edit Info</a>
                        <a href="{{ route('game.editor.edit', $game->id) }}" class="fb-btn fb-btn-sm">Editor</a>
                        <a href="{{ route('game.show', $game->slug) }}" class="fb-btn fb-btn-sm fb-btn-outline" target="_blank">View</a>
                        <form method="POST" action="{{ route('game.editor.delete', $game->id) }}" onsubmit="return confirm('Delete this game?')" class="m-0">
                            @csrf @method('DELETE')
                            <button type="submit" class="fb-btn fb-btn-sm fb-btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@stop