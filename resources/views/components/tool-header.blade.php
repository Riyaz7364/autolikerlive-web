@props([
    'brand' => 'AutoLikerLive',
    // URL the brand logo points to. Defaults to site home, temp-mail pages pass temp-mail URL.
    'brandUrl' => null,
    // Theme: tiktok (dark) | teal (temp-mail, light) | purple (instaliker, light)
    'theme' => 'tiktok',
    // Optional image logo (e.g. InstaLiker app icon). When set, renders <img> instead of the SVG slot.
    'logoUrl' => null,
    'logoAlt' => null,
    // Optional extra CTA in header (used by Instagram Comment Liker for Download APK).
    'downloadUrl' => null,
    'downloadLabel' => 'Download APK',
])

@php
    $brandUrl = $brandUrl ?? url('/');
    $logoAlt = $logoAlt ?? ($brand . ' logo');
@endphp

{{-- Shared sticky tool header. Styles live in public/css/tool-header.css --}}
<header class="tool-header" data-theme="{{ $theme }}">
    <div class="tool-header-inner">
        <a href="{{ $brandUrl }}" class="tool-brand">
            @if ($logoUrl)
                <img class="tool-brand-img" src="{{ $logoUrl }}" alt="{{ $logoAlt }}" width="42" height="42">
            @else
                <span class="tool-brand-logo">{{ $slot }}</span>
            @endif
            <span class="tool-brand-text">
                <span class="tool-brand-name">{{ $brand }}</span>
                <span class="tool-brand-sub">by AutoLikerLive</span>
            </span>
        </a>
        <nav class="tool-header-links" aria-label="Quick links">
            <a href="{{ url('services') }}" class="tool-ghost tool-hide-sm">All Tools</a>
            <a href="{{ url('/') }}" class="tool-ghost">Home</a>
            @if ($downloadUrl)
                <a href="{{ $downloadUrl }}" class="tool-ghost tool-dl">⬇ {{ $downloadLabel }}</a>
            @endif
        </nav>
    </div>
</header>
