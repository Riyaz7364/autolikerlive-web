@extends('layouts.game')

@section('title', 'My Images')

@section('content')
<div class="pb-20">
    <div class="page-header mb-16">
        <h1>🖼️ My Images</h1>
        <p>Your generated images</p>
    </div>

    @if (count($images) > 0)
        <div class="flex flex-col gap-16">
            @foreach ($images as $img)
                <div class="fb-card">
                    <img src="{{ $img['url'] }}" style="width:100%;display:block;">
                    <div class="p-16 flex items-center justify-between" style="border-top:1px solid var(--fb-border-light);">
                        <span class="text-sm text-secondary">{{ $img['created_at'] }}</span>
                        <a href="{{ $img['url'] }}" download class="fb-btn fb-btn-sm">Download</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🎨</div>
            <p class="empty-state-text">You haven't created any images yet.</p>
            <a href="{{ url('/') }}" class="fb-btn mt-16">Browse Games</a>
        </div>
    @endif
</div>
@stop
