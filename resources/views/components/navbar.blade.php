@php
    $sid = request()->cookie('game_session');
    $gameSession = $sid ? \App\Models\GameSession::find($sid) : null;
    $isLoggedIn = (bool) $gameSession;
@endphp

<nav class="fb-nav">
    <div class="fb-nav-inner">
        <div class="fb-nav-left">
            <a href="{{ url('/') }}" class="fb-nav-brand" aria-label="Home">Autoliker Live</a>
        </div>

        <div class="fb-nav-right">
            @if ($isLoggedIn)
                <div class="fb-nav-user-wrap">
                    <button class="fb-nav-user-btn" onclick="toggleUserMenu()" aria-label="Account">
                        @if ($gameSession->profile_pic)
                            <img src="{{ $gameSession->profile_pic }}" class="fb-nav-avatar" alt="">
                        @else
                            <span class="fb-nav-avatar-fallback">👤</span>
                        @endif
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="fb-nav-chevron"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="fb-nav-dropdown" id="userMenu">
                        <div class="fb-nav-dropdown-header">
                            @if ($gameSession->profile_pic)
                                <img src="{{ $gameSession->profile_pic }}" class="fb-nav-dropdown-avatar" alt="">
                            @else
                                <span class="fb-nav-dropdown-avatar-fallback">👤</span>
                            @endif
                            <div>
                                <div class="fb-nav-dropdown-name">{{ $gameSession->name ?? $gameSession->username }}</div>

                            </div>
                        </div>
                        <div class="fb-nav-dropdown-divider"></div>
                        <a href="{{ route('session.logout') }}" class="fb-nav-dropdown-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 17v-3H9v-4h7V7l5 5-5 5zM14 2a2 2 0 012 2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2h9z"/></svg>
                            Log Out
                        </a>
                    </div>
                </div>
            @else
                <a href="{{ route('session.login', ['redirect' => url()->current()]) }}" class="fb-nav-login">Log In</a>
            @endif
        </div>
    </div>
</nav>

<div class="fb-bottom-nav">
    <a href="{{ url('/') }}" class="fb-bottom-nav-item {{ request()->is('/') ? 'active' : '' }}">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M4 21V9l8-6 8 6v12h-6v-7h-4v7H4z"/></svg>
        <span>Home</span>
    </a>
    <a href="{{ $isLoggedIn ? url('/my-images') : route('session.login', ['redirect' => url('/my-images')]) }}" class="fb-bottom-nav-item {{ request()->is('my-images*') ? 'active' : '' }}">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
        <span>My Images</span>
    </a>
    <button class="fb-bottom-nav-item" onclick="toggleToolsPanel()">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 00.12-.61l-1.92-3.32a.488.488 0 00-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.484.484 0 00-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58a.49.49 0 00-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
        <span>Tools</span>
    </button>
</div>

<div class="fb-overlay" id="toolsOverlay" onclick="toggleToolsPanel()"></div>
<div class="fb-tools-panel" id="toolsPanel">
    <div class="fb-tools-panel-header">
        <span class="fb-tools-panel-title">🔧 Free Tools</span>
        <button class="fb-tools-panel-close" onclick="toggleToolsPanel()">✕</button>
    </div>
    <div class="fb-tools-panel-list">
        <a href="{{ url('services') }}" class="fb-tools-panel-item fb-tools-panel-all">🔧 All Free Tools</a>
        <div class="fb-tools-panel-divider"></div>
        <a href="{{ url('auto-liker-1000-likes') }}" class="fb-tools-panel-item">👍 FB Auto Liker</a>
        <a href="{{ url('instagram-comment-liker') }}" class="fb-tools-panel-item">📸 IG Comment Liker</a>
        <a href="{{ route('free-tiktok-views') }}" class="fb-tools-panel-item">📹 TikTok Views</a>
        <a href="{{ route('free-tiktok-likes') }}" class="fb-tools-panel-item">❤️ TikTok Likes</a>
        <a href="{{ route('free-instagram-likes') }}" class="fb-tools-panel-item">📸 Instagram Likes</a>
        <a href="{{ route('sms-bomber') }}" class="fb-tools-panel-item">💬 SMS Bomber</a>
        <a href="{{ route('temp-mail') }}" class="fb-tools-panel-item">📧 Temp Mail</a>
    </div>
</div>

<script>
function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    if (menu) {
        menu.classList.toggle('show');
        const closeHandler = function(e) {
            if (!menu.contains(e.target) && !e.target.closest('.fb-nav-user-btn')) {
                menu.classList.remove('show');
                document.removeEventListener('click', closeHandler);
            }
        };
        setTimeout(() => document.addEventListener('click', closeHandler), 0);
    }
}

function toggleToolsPanel() {
    document.getElementById('toolsPanel').classList.toggle('open');
    document.getElementById('toolsOverlay').classList.toggle('show');
}
</script>
