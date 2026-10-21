@php
    $sid = request()->cookie('game_session');
    $gameSession = $sid ? \App\Models\GameSession::find($sid) : null;
    $isLoggedIn = (bool) $gameSession;

    // Highlight the Tools menu while browsing any tool page.
    $toolPaths = [
        'services', 'auto-liker-1000-likes', 'facebook-auto-reaction', 'facebook-page-liker',
        'facebook-auto-followers', 'auto-friend-request', 'instagram-comment-liker',
        'free-instagram-likes', 'free-tiktok-views', 'free-tiktok-likes',
        'netshort-video-downloader', 'youtube_thumbnail_extractor', 'sms-bomber',
        'temp-mail', 'message/view', 'findmyfbid',
    ];
    $isToolPage = collect($toolPaths)->contains(fn ($p) => request()->is($p) || request()->is($p . '/*'));
@endphp

<nav class="fb-nav">
    <style>
        .fb-nav-menu { display: flex; align-items: center; gap: 4px; }
        .fb-nav-menu a { color: #4b5563; font-size: 14px; font-weight: 600; padding: 8px 12px; border-radius: 8px; text-decoration: none; white-space: nowrap; }
        .fb-nav-menu a:hover { background: #f3f4f6; color: #111827; text-decoration: none; }
        .fb-nav-menu a.active { color: #1877f2; background: #e8f0fe; }
        .fb-nav-tools { position: relative; }
        .fb-nav-tools-btn {
            display: inline-flex; align-items: center; gap: 4px;
            background: none; border: none; cursor: pointer;
            color: #4b5563; font-family: inherit; font-size: 14px; font-weight: 600;
            padding: 8px 12px; border-radius: 8px; white-space: nowrap;
        }
        .fb-nav-tools-btn:hover, .fb-nav-tools-btn.open { background: #f3f4f6; color: #111827; }
        .fb-nav-tools-btn.active { color: #1877f2; background: #e8f0fe; }
        .fb-nav-tools-btn svg { transition: transform .2s; }
        .fb-nav-tools-btn.open svg { transform: rotate(180deg); }
        .fb-nav-tools-menu {
            display: none; position: absolute; top: calc(100% + 10px); right: 0;
            width: 560px; max-width: calc(100vw - 32px);
            background: #fff; border: 1px solid #e5e7eb; border-radius: 14px;
            box-shadow: 0 18px 44px rgba(0,0,0,.18), 0 2px 6px rgba(0,0,0,.08);
            padding: 10px; z-index: 250;
        }
        .fb-nav-tools-menu.show { display: block; }
        .fb-nav-menu .fb-nav-tools-all {
            display: block; padding: 10px 12px; border-radius: 8px;
            background: #eef4ff; color: #1877f2; font-weight: 700; font-size: 14px;
        }
        .fb-nav-menu .fb-nav-tools-all:hover { background: #e0ebff; color: #1877f2; }
        .fb-nav-tools-divider { height: 1px; background: #eef0f3; margin: 8px 4px; }
        .fb-nav-tools-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2px; }
        .fb-nav-menu .fb-nav-tools-grid a {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 12px; border-radius: 8px;
            color: #374151; font-size: 13.5px; font-weight: 500;
        }
        .fb-nav-menu .fb-nav-tools-grid a:hover { background: #f3f4f6; color: #111827; }
        @media (max-width: 900px) { .fb-nav-menu { display: none; } }
    </style>
    <div class="fb-nav-inner">
        <div class="fb-nav-left">
            <a href="{{ url('/') }}" class="fb-nav-brand" aria-label="Home">Autoliker Live</a>
        </div>

        <div class="fb-nav-menu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/download') }}" class="{{ request()->is('download*') ? 'active' : '' }}">Download</a>
            <a href="{{ url('auto-liker-1000-likes') }}" class="{{ request()->is('auto-liker-1000-likes') ? 'active' : '' }}">FB Liker</a>
            <a href="{{ route('games.hub') }}" class="{{ request()->is('games*') || request()->is('game*') ? 'active' : '' }}">Games</a>
            <div class="fb-nav-tools">
                <button type="button" class="fb-nav-tools-btn {{ $isToolPage ? 'active' : '' }}" id="navToolsBtn"
                    onclick="toggleNavTools(event)" aria-haspopup="true" aria-expanded="false" aria-controls="navToolsMenu">
                    Tools
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 10l5 5 5-5z"/></svg>
                </button>
                <div class="fb-nav-tools-menu" id="navToolsMenu" role="menu" aria-label="All free tools">
                    <a href="{{ url('services') }}" class="fb-nav-tools-all" role="menuitem">🔧 All Free Tools</a>
                    <div class="fb-nav-tools-divider"></div>
                    <div class="fb-nav-tools-grid">
                        <a href="{{ url('auto-liker-1000-likes') }}" role="menuitem">👍 FB Auto Liker</a>
                        <a href="{{ url('facebook-auto-reaction') }}" role="menuitem">⚡ Auto Reactions</a>
                        <a href="{{ url('facebook-page-liker') }}" role="menuitem">📄 Page Liker</a>
                        <a href="{{ url('facebook-auto-followers') }}" role="menuitem">👥 Auto Followers</a>
                        <a href="{{ url('auto-friend-request') }}" role="menuitem">🤝 Auto Friend Request</a>
                        <a href="{{ url('instagram-comment-liker') }}" role="menuitem">📸 IG Comment Liker</a>
                        <a href="{{ route('free-instagram-likes') }}" role="menuitem">❤️ Instagram Likes</a>
                        <a href="{{ route('free-tiktok-views') }}" role="menuitem">🎬 TikTok Views</a>
                        <a href="{{ route('free-tiktok-likes') }}" role="menuitem">🎵 TikTok Likes</a>
                        <a href="{{ route('netshort-video-downloader.show') }}" role="menuitem">🎬 NetShort Downloader</a>
                        <a href="{{ route('youtube_thumbnail_extractor') }}" role="menuitem">🖼️ YouTube Thumbnail Extractor</a>
                        <a href="{{ route('sms-bomber') }}" role="menuitem">💬 SMS Bomber</a>
                        <a href="{{ route('temp-mail') }}" role="menuitem">📧 Temp Mail</a>
                        <a href="{{ url('findmyfbid') }}" role="menuitem">🆔 Find My FB ID</a>
                        <a href="{{ route('games.hub') }}" role="menuitem">🎮 Games</a>
                    </div>
                </div>
            </div>
            <a href="{{ url('/blog/') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
            <a href="{{ url('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
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
        <a href="{{ url('facebook-auto-reaction') }}" class="fb-tools-panel-item">⚡ Auto Reactions</a>
        <a href="{{ url('facebook-page-liker') }}" class="fb-tools-panel-item">📄 Page Liker</a>
        <a href="{{ url('facebook-auto-followers') }}" class="fb-tools-panel-item">👥 Auto Followers</a>
        <a href="{{ url('auto-friend-request') }}" class="fb-tools-panel-item">🤝 Auto Friend Request</a>
        <a href="{{ url('instagram-comment-liker') }}" class="fb-tools-panel-item">📸 IG Comment Liker</a>
        <a href="{{ route('free-instagram-likes') }}" class="fb-tools-panel-item">❤️ Instagram Likes</a>
        <a href="{{ route('free-tiktok-views') }}" class="fb-tools-panel-item">📹 TikTok Views</a>
        <a href="{{ route('free-tiktok-likes') }}" class="fb-tools-panel-item">❤️ TikTok Likes</a>
        <a href="{{ route('netshort-video-downloader.show') }}" class="fb-tools-panel-item">🎬 NetShort Downloader</a>
        <a href="{{ route('youtube_thumbnail_extractor') }}" class="fb-tools-panel-item">🖼️ YouTube Thumbnail Extractor</a>
        <a href="{{ route('sms-bomber') }}" class="fb-tools-panel-item">💬 SMS Bomber</a>
        <a href="{{ route('temp-mail') }}" class="fb-tools-panel-item">📧 Temp Mail</a>
        <a href="{{ url('findmyfbid') }}" class="fb-tools-panel-item">🆔 Find My FB ID</a>
        <a href="{{ route('games.hub') }}" class="fb-tools-panel-item">🎮 Games</a>
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

function toggleNavTools(event) {
    if (event) event.stopPropagation();
    const btn = document.getElementById('navToolsBtn');
    const menu = document.getElementById('navToolsMenu');
    if (!btn || !menu) return;

    const isOpen = menu.classList.toggle('show');
    btn.classList.toggle('open', isOpen);
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
}

document.addEventListener('click', function (e) {
    const menu = document.getElementById('navToolsMenu');
    const btn = document.getElementById('navToolsBtn');
    if (!menu || !btn || !menu.classList.contains('show')) return;
    if (!menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.remove('show');
        btn.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    const menu = document.getElementById('navToolsMenu');
    const btn = document.getElementById('navToolsBtn');
    if (menu && menu.classList.contains('show')) {
        menu.classList.remove('show');
        btn.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
    }
});
</script>
