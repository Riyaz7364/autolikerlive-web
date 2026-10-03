<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover" />
    <meta name="revisit-after" content="1 days" />
    <meta name="googlebot" content="noindex, follow" />
    <meta name="robots" content="noindex, follow" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ request()->url() }}" />
    <title>@yield('title') - AutoLikerLive</title>
    <meta name="description" content="@yield('description', 'AutoLikerLive dashboard — boost your profile, manage promotions and earn credits. Fast, safe, and free.')">
    <meta name="theme-color" content="#1877F2" />

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.webp">
    <link rel="icon" type="image/webp" sizes="32x32" href="/images/favicons/favicon-32x32.webp">
    <link rel="icon" type="image/webp" sizes="16x16" href="/images/favicons/favicon-16x16.webp">

    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/autoliker-app.css') }}">
    @stack('styles')
    @yield('javascripts')
    @if (!trim($__env->yieldContent('no-auto-ads')))
        <x-auto-ads />
    @endif
</head>
<body class="alk-body">
@php
    $alkLoginType = isset($user) ? data_get($user, 'loginType', data_get($user, 'login_type', 'FB')) : 'FB';
    $alkUsername = isset($user) ? (string) data_get($user, 'username', '') : '';
    $alkCredits = isset($user) ? data_get($user, 'credits') : null;
    $alkLogoutRoute = $alkLoginType === 'FB' ? 'autoliker.facebook' : 'autoliker.instagram';
@endphp

    {{-- Sticky app bar --}}
    <header class="alk-topbar">
        <div class="alk-topbar-inner">
            <a href="{{ route('autoliker.dashboard') }}" class="alk-brand">
                <span class="alk-brand-logo">⚡</span>
                AutoLiker
                <span class="alk-type-badge">{{ $alkLoginType }}</span>
            </a>
            @if(!is_null($alkCredits))
                <span class="alk-credits" title="Your credits">
                    <img src="{{ url('') }}/images/coins.png" alt="Credits" loading="lazy">
                    <span id="credits">{{ $alkCredits }}</span>
                </span>
            @endif
            <a href="{{ route($alkLogoutRoute) }}" class="alk-user" title="Log out">
                <span class="alk-avatar">{{ strtoupper(mb_substr($alkUsername, 0, 1)) ?: '•' }}</span>
                <span class="alk-name">{{ $alkUsername }}</span>
            </a>
        </div>
    </header>

    {{-- Tab navigation --}}
    <nav class="alk-tabs" aria-label="AutoLiker sections">
        <div class="alk-tabs-inner">
            <a href="{{ route('autoliker.dashboard') }}"
               class="alk-tab {{ request()->routeIs('autoliker.dashboard') ? 'is-active' : '' }}">
                <i class="bi bi-house-door-fill"></i>Home
            </a>
            <a href="{{ route('autoliker.boost') }}"
               class="alk-tab {{ request()->routeIs('autoliker.boost') ? 'is-active' : '' }}">
                <i class="bi bi-rocket-takeoff-fill"></i>Boost
            </a>
            <a href="{{ route('autoliker.view') }}"
               class="alk-tab {{ request()->routeIs('autoliker.view') ? 'is-active' : '' }}">
                <i class="bi bi-list-check"></i>Orders
            </a>
            <a href="{{ route('autoliker.earn') }}"
               class="alk-tab {{ request()->routeIs('autoliker.earn') || request()->routeIs('autoliker.free.*') ? 'is-active' : '' }}">
                <i class="bi bi-coin"></i>Earn
            </a>
        </div>
    </nav>

    <main class="alk-shell">
        {{-- Top ad: responsive leaderboard on desktop, banner on mobile --}}
        <div class="alk-ad d-none d-md-block" aria-label="Advertisement">
            <x-ads.leaderboard />
        </div>
        <div class="alk-ad d-block d-md-none" aria-label="Advertisement">
            <x-ads.mobile-banner />
        </div>

        @yield('content')
    </main>

    <footer class="alk-footer">
        <nav aria-label="Footer">
            <a href="{{ url('/') }}">Games</a>
            <a href="{{ url('services') }}">Free Tools</a>
            <a href="{{ url('privacy') }}">Privacy</a>
            <a href="{{ url('terms') }}">Terms</a>
            <a href="{{ url('contact') }}">Contact</a>
        </nav>
        <div>&copy; autolikerlive.com &mdash; For entertainment purposes only.</div>
    </footer>

    {{-- Sticky bottom anchor (mobile only, scroll-delayed, dismissible) --}}
    <x-ads.anchor />

    @yield('footer')
    @include('components.chat-widget')
</body>
</html>
