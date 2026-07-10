@extends('layouts.game')

@section('title', 'Create Game')
@section('description', 'Create a new image game.')

@section('sidebar')
    <div class="widget">
        <h3>📝 Create Game</h3>
        <p class="text-sm">Fill in the basic info for your game. After creating, you'll be taken to the editor to design the canvas.</p>
    </div>
    <div class="widget">
        <h3>📖 Tips</h3>
        <ul class="styled-ol" style="line-height:1.7;padding-left:16px;">
            <li>Choose a catchy title</li>
            <li>Upload a preview image for the homepage</li>
            <li>You can edit everything later</li>
        </ul>
    </div>
    <div class="widget">
        <a href="{{ route('game.editor.list') }}" class="widget-back-link">← Back to List</a>
    </div>
@stop

@section('content')
<div class="pb-20">
    <div class="flex items-center justify-between mb-16">
        <h1 class="editor-page-title">Create New Game</h1>
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

    <form method="POST" action="{{ route('game.editor.store') }}" enctype="multipart/form-data" class="editor-card" style="max-width:600px;">
        @csrf

        <div class="form-group mb-12">
            <label class="editor-label">Title</label>
            <input name="title" type="text" class="fb-input" value="{{ old('title') }}" required style="font-size:0.9rem;">
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Slug (URL)</label>
            <input name="slug" type="text" class="fb-input" value="{{ old('slug') }}" required style="font-size:0.9rem;">
            <div class="hint" style="font-size:0.75rem;color:var(--fb-text-secondary);margin-top:4px;">URL-friendly name. e.g. "my-awesome-game"</div>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Description</label>
            <textarea name="description" class="fb-input" rows="3" style="font-size:0.9rem;">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">Preview Image (shown on homepage & game page)</label>
            <input name="thumbnail" type="file" accept="image/*" style="font-size:0.85rem;width:100%;">
            <div class="hint" style="font-size:0.75rem;color:var(--fb-text-secondary);margin-top:4px;">Recommended: 400x300px. Will be shown on the games list and game page.</div>
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">OG Title (Facebook share title)</label>
            <input name="og_title" type="text" class="fb-input" value="{{ old('og_title') }}" placeholder="Try it yourself!" style="font-size:0.9rem;">
        </div>

        <div class="form-group mb-12">
            <label class="editor-label">OG Description (Facebook share description)</label>
            <textarea name="og_description" class="fb-input" rows="2" style="font-size:0.9rem;">{{ old('og_description') }}</textarea>
        </div>

        <div class="form-group mb-16">
            <label class="editor-label">Status</label>
            <select name="status" class="fb-input" style="font-size:0.9rem;">
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <button type="submit" class="fb-btn fb-btn-green" style="padding:10px 30px;font-size:0.95rem;">
            ✨ Create Game & Open Editor
        </button>
    </form>
</div>
@stop
