@extends('layouts.autoliker')

@section('title', 'Dashboard '.$user['loginType'])
@section('description', '')

{{-- Auto ads are loaded via layouts.autoliker (top + anchor units) --}}

@section('content')
@php
    $loginType = data_get($user, 'loginType', data_get($user, 'login_type', 'FB'));
    $isFB = $loginType === 'FB';
    $profilePic = url('storage/profiles/profile_' . data_get($user, 'uid')) . '.jpeg';
@endphp
    <h1 class="alk-page-title">Dashboard</h1>

    {{-- Profile hero --}}
    <section class="alk-hero" aria-label="Profile overview">
        <div class="alk-hero-top">
            <img class="alk-hero-pic" src="{{ $profilePic }}" alt="Profile picture of {{ data_get($user, 'username') }}"
                loading="lazy" onerror="this.onerror=null;this.src='/storage/profiles/dummy.png';">
            <div style="min-width:0;">
                <div class="alk-hero-name">{{ data_get($user, 'name') }}</div>
                <div class="alk-hero-sub">{{ '@' . data_get($user, 'username') }}</div>
                <span class="alk-hero-pill">{{ $isFB ? 'Facebook Auto Liker' : 'Instagram Auto Liker' }}</span>
            </div>
        </div>
        <div class="alk-stats">
            <div class="alk-stat">
                <b>{{ data_get($user, 'followers', 0) }}</b>
                <span>Followers</span>
            </div>
            <div class="alk-stat">
                <b>{{ data_get($user, 'followings', '—') }}</b>
                <span>Following</span>
            </div>
            <div class="alk-stat">
                <b>{{ data_get($user, 'credits', 0) }}</b>
                <span>Credits</span>
            </div>
        </div>
    </section>

    {{-- Quick actions --}}
    <section class="alk-card" aria-label="Quick actions">
        <div class="alk-card-title"><i class="bi bi-lightning-charge-fill"></i> Quick actions</div>
        <div class="alk-grid">
            <a href="{{ route('autoliker.boost') }}" class="alk-action is-boost">
                <i class="bi bi-rocket-takeoff-fill"></i>
                Boost Profile
                <small>Send likes &amp; follows</small>
            </a>
            <a href="{{ route('autoliker.view') }}" class="alk-action">
                <i class="bi bi-list-check text-primary"></i>
                My Orders
                <small>Track promotions</small>
            </a>
            <a href="{{ route('autoliker.earn') }}" class="alk-action">
                <i class="bi bi-coin text-warning"></i>
                Earn Credits
                <small>Like &amp; follow to earn</small>
            </a>
            <a href="{{ route('autoliker.settings') }}" class="alk-action">
                <i class="bi bi-gear-fill text-secondary"></i>
                Settings
                <small>Earn source &amp; more</small>
            </a>
        </div>
    </section>

    <div class="alk-ad" aria-label="Advertisement">
        <x-ads.in-article />
    </div>

    {{-- Help --}}
    <section class="alk-card" aria-label="How your dashboard works">
        <div class="alk-card-title"><i class="bi bi-info-circle"></i> How it works</div>
        <ol class="alk-steps">
            <li><div><strong>Boost</strong> sends likes or follows to your public post or profile.</div></li>
            <li><div><strong>Orders</strong> shows live progress — pause, resume or delete anytime.</div></li>
            <li><div><strong>Earn</strong> gives you credits for engaging with others' posts.</div></li>
        </ol>
        <div class="alk-note">
            <span>💡</span>
            <span>Always boost the correct account — check the username in the top bar before submitting.</span>
        </div>
        <div class="text-center mt-3">
            <a href="/contact" class="alk-btn" style="border:2px solid var(--alk-border); min-height:48px; font-size:14px;">
                Send feedback
            </a>
        </div>
    </section>
@endsection
