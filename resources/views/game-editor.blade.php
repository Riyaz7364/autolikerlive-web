@extends('layouts.game')

@section('title', 'Game Editor')
@section('description', 'Create and edit image games.')


@push('styles')
<style>.blog-sidebar { display: none !important; }</style>
@endpush

@section('sidebar')
    {{-- No sidebar on editor page --}}
@stop

@section('content')
<div class="pb-20">
    <div class="flex items-center justify-between mb-16">
        <h1 class="editor-page-title">Game Editor</h1>
    </div>

    @if (\Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if (isset($gameId))
        <livewire:game-editor :gameId="$gameId" wire:key="{{ $gameId }}" />
    @else
        <livewire:game-editor />
    @endif
</div>
@stop