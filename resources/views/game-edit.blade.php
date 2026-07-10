@extends('layouts.game')

@section('title', 'Edit Game')
@section('description', 'Edit game information.')



@section('content')
<div class="pb-20">
    <div class="flex items-center justify-between mb-16">
        <h1 class="editor-page-title">Edit: {{ $game->title }}</h1>
        <a href="{{ route('game.editor.edit', $game->id) }}" class="fb-btn fb-btn-sm">🎨 Open Editor</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-12">
            <ul class="m-0" style="padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('game.editor.update-info', $game->id) }}" enctype="multipart/form-data" class="editor-card" style="max-width:600px;">
        @csrf

        <div class="form-group mb-12">
            <label class="editor-label">Title</label>
            <input name="title" type="text" class="fb-input" value="{{ old('title', $game->title) }}" required style="font-size:0.9rem;">
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Slug (URL)</label>
            <input name="slug" type="text" class="fb-input" value="{{ old('slug', $game->slug) }}" required style="font-size:0.9rem;">
            <div class="hint" style="font-size:0.75rem;color:var(--fb-text-secondary);margin-top:4px;">URL-friendly name.</div>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Description</label>
            <textarea name="description" class="fb-input" rows="3" style="font-size:0.9rem;">{{ old('description', $game->description) }}</textarea>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Preview Image</label>
            @if ($game->thumbnail)
                <div style="margin-bottom:6px;">
                    <img src="{{ Storage::disk('public')->url($game->thumbnail) }}" alt="" style="max-height:80px;border-radius:6px;">
                </div>
            @endif
            <input name="thumbnail" type="file" accept="image/*" style="font-size:0.85rem;width:100%;">
            <div class="hint" style="font-size:0.75rem;color:var(--fb-text-secondary);margin-top:4px;">Shown on homepage & game page. Leave empty to keep current.</div>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Background Image</label>
            @if ($game->bg_image)
                <div style="margin-bottom:6px;">
                    <img src="{{ Storage::disk('public')->url($game->bg_image) }}" alt="" style="max-height:80px;border-radius:6px;">
                </div>
            @endif
            <input name="bg_image" type="file" accept="image/*" style="font-size:0.85rem;width:100%;">
            <div class="hint" style="font-size:0.75rem;color:var(--fb-text-secondary);margin-top:4px;">Shown on homepage & game page. Leave empty to keep current.</div>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">OG Title (Facebook share)</label>
            <input name="og_title" type="text" class="fb-input" value="{{ old('og_title', $game->og_title) }}" placeholder="Try it yourself!" style="font-size:0.9rem;">
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">OG Description (Facebook share)</label>
            <textarea name="og_description" class="fb-input" rows="2" style="font-size:0.9rem;">{{ old('og_description', $game->og_description) }}</textarea>
        </div>

        <div class="form-group mb-16">
            <label class="editor-label">Status</label>
            <select name="status" class="fb-input" style="font-size:0.9rem;">
                <option value="draft" {{ (old('status', $game->status) === 'draft') ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ (old('status', $game->status) === 'published') ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="fb-btn fb-btn-green" style="padding:10px 30px;font-size:0.95rem;">
                💾 Save Info
            </button>
            <a href="{{ route('game.editor.edit', $game->id) }}" class="fb-btn fb-btn-outline" style="padding:10px 30px;font-size:0.95rem;">
                🎨 Edit Canvas
            </a>
        </div>
    </form>
</div>
@stop
