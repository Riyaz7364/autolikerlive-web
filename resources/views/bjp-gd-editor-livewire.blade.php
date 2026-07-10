@extends('layouts.master')

@section('title', 'BJP Card GD Editor - Livewire')
@section('description', 'Live GD Editor with live preview')

@push('styles')
<style>
    body { background: #111 !important; }
    .editor-wrap { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
    .editor-wrap h1 { color: #ff9933; font-weight: 800; font-size: 1.5rem; }
    .editor-wrap .sub { color: rgba(255,255,255,0.4); font-size: 0.85rem; margin-bottom: 25px; }
</style>
@endpush

@section('content')
<div class="editor-wrap">
    <h1>GD Editor <span style="color:rgba(255,255,255,0.2); font-size:0.9rem;">Livewire</span></h1>
    <p class="sub">Tweak coordinates and preview without page reload</p>
    <livewire:bjp-card-editor />
</div>
@stop