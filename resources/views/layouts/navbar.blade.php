<nav class="fb-nav">
    <div class="fb-nav-inner">
        <div class="fb-nav-left">
            <a href="{{ url('/') }}" class="fb-nav-logo" aria-label="Home">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="10" fill="#1877f2"/><path d="M30 20c0-5.523-4.477-10-10-10S10 14.477 10 20c0 4.991 3.657 9.128 8.438 9.879v-6.988h-2.54V20h2.54v-2.203c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V20h2.773l-.443 2.89h-2.33v6.989C26.343 29.128 30 24.991 30 20z" fill="#fff"/></svg>
            </a>
        </div>

        @php
            $token = request()->cookie('game_session');
            $gameSession = $token ? \App\Models\GameSession::where('session_token', $token)->first() : null;
            $isAdmin = \Illuminate\Support\Facades\Session::get('admin_auth') === env('ADMIN_SECRET_KEY', 'change-me');
        @endphp

        <div class="fb-nav-center">
            <div class="fb-nav-links">
                <a href="{{ url('/') }}" class="fb-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M4 21V9l8-6 8 6v12h-6v-7h-4v7H4z"/></svg>
                    <span>Home</span>
                </a>
                <a href="{{ url('/privacy') }}" class="fb-nav-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    <span>Privacy</span>
                </a>
                @if ($isAdmin)
                    <a href="{{ route('game.editor.list') }}" class="fb-nav-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58a.49.49 0 00.12-.61l-1.92-3.32a.488.488 0 00-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54a.484.484 0 00-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58a.49.49 0 00-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                        <span>Admin</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="fb-nav-right">
            @if ($gameSession)
                <div class="fb-nav-user-wrap">
                    <button class="fb-nav-user-btn" onclick="toggleUserMenu()" aria-label="Account">
                        @if ($gameSession->login_type === 'fb' && $gameSession->fb_profile_pic)
                            <img src="{{ $gameSession->fb_profile_pic }}" class="fb-nav-avatar" alt="">
                        @elseif ($gameSession->manual_image)
                            <img src="{{ $gameSession->manual_image }}" class="fb-nav-avatar" alt="">
                        @else
                            <span class="fb-nav-avatar-fallback">👤</span>
                        @endif
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="fb-nav-chevron"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="fb-nav-dropdown" id="userMenu">
                        <div class="fb-nav-dropdown-header">
                            @if ($gameSession->login_type === 'fb' && $gameSession->fb_profile_pic)
                                <img src="{{ $gameSession->fb_profile_pic }}" class="fb-nav-dropdown-avatar" alt="">
                            @elseif ($gameSession->manual_image)
                                <img src="{{ $gameSession->manual_image }}" class="fb-nav-dropdown-avatar" alt="">
                            @else
                                <span class="fb-nav-dropdown-avatar-fallback">👤</span>
                            @endif
                            <div>
                                <div class="fb-nav-dropdown-name">{{ $gameSession->manual_name ?? $gameSession->fb_username ?? 'User' }}</div>
                                <div class="fb-nav-dropdown-subtitle">{{ $gameSession->login_type === 'fb' ? 'Facebook' : 'Guest' }}</div>
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

@push('footer')
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
</script>
@endpush
