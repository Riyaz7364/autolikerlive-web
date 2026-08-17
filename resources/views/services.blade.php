@extends('layouts.master')

@section('title', 'Free Auto Liker, Facebook Tools & Social Media Services')
@section('description', 'Free Facebook auto liker, auto reactions, auto followers, page liker, Instagram comment liker, TikTok tools, SMS bomber, and more social media tools. Fast, safe, and free.')
@section('keywords', 'auto liker, facebook auto liker, free facebook liker, auto reactions, facebook auto followers, page liker, instagram comment liker, tiktok auto liker, sms bomber, social media tools')

@push('styles')
    <style>
        h5, p { color: #000; }

        .sv-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 3rem 1.5rem 2.5rem;
            text-align: center;
            border-radius: 0 0 2rem 2rem;
            margin: -1rem -0.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .sv-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(83,178,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .sv-hero h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.75rem;
            position: relative;
        }
        .sv-hero h1 span { color: #53b2ff; }
        .sv-hero p {
            color: rgba(255,255,255,0.75);
            font-size: 1rem;
            max-width: 520px;
            margin: 0 auto 1.5rem;
            position: relative;
        }
        .sv-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            position: relative;
        }
        .sv-stat-item {
            text-align: center;
        }
        .sv-stat-num {
            font-size: 1.4rem;
            font-weight: 800;
            color: #53b2ff;
        }
        .sv-stat-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sv-tabs {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            -webkit-overflow-scrolling: touch;
        }
        .sv-tabs::-webkit-scrollbar { display: none; }
        .sv-tab {
            flex-shrink: 0;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            white-space: nowrap;
        }
        .sv-tab.active, .sv-tab:hover {
            background: #0f3460;
            color: #fff;
            border-color: #0f3460;
        }

        .sv-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sv-section-title .sv-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }
        .sv-section-title .sv-dot.fb { background: #1877f2; }
        .sv-section-title .sv-dot.ig { background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
        .sv-section-title .sv-dot.tt { background: #010101; }
        .sv-section-title .sv-dot.ut { background: #6366f1; }
        .sv-section-title .sv-dot.gm { background: #10b981; }

        .sv-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 640px) { .sv-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .sv-grid { grid-template-columns: repeat(3, 1fr); } }

        .sv-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .sv-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        }
        .sv-card-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .sv-card-icon.fb-bg { background: #eff6ff; }
        .sv-card-icon.ig-bg { background: #fdf2f8; }
        .sv-card-icon.tt-bg { background: #f5f5f5; }
        .sv-card-icon.ut-bg { background: #eef2ff; }
        .sv-card-icon.gm-bg { background: #ecfdf5; }
        .sv-card-body { flex: 1; min-width: 0; }
        .sv-card-body h5 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 0.25rem;
        }
        .sv-card-body p {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0 0 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .sv-card-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: #0f3460;
            text-decoration: none;
        }
        .sv-card-btn svg {
            width: 14px;
            height: 14px;
            transition: transform 0.15s;
        }
        .sv-card:hover .sv-card-btn svg { transform: translateX(2px); }

        .sv-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.55rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .sv-badge-free { background: #dcfce7; color: #166534; }
        .sv-badge-popular { background: #fef3c7; color: #92400e; }
        .sv-badge-new { background: #ede9fe; color: #5b21b6; }

        .sv-featured {
            border: 2px solid #0f3460 !important;
            background: linear-gradient(135deg, #0f3460 0%, #1a1a2e 100%) !important;
        }
        .sv-featured h5 { color: #fff !important; }
        .sv-featured p { color: rgba(255,255,255,0.7) !important; }
        .sv-featured .sv-card-icon { background: rgba(255,255,255,0.15) !important; }
        .sv-featured .sv-card-btn { color: #53b2ff !important; }

        .sv-trust {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            padding: 1.5rem 0;
            border-top: 1px solid #f1f5f9;
            border-bottom: 1px solid #f1f5f9;
            margin: 1rem 0 2rem;
            text-align: center;
        }
        .sv-trust-icon { font-size: 1.5rem; margin-bottom: 0.25rem; }
        .sv-trust-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #1e293b;
        }
        .sv-trust-sub {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        .sv-category-section {
            display: none;
        }
        .sv-category-section.show {
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="sv-hero">
        <h1>Free <span>Social Media</span> Tools</h1>
        <p>Boost your online presence with our free, safe, and instant tools. No login required.</p>
        <div class="sv-stats">
            <div class="sv-stat-item">
                <div class="sv-stat-num">12+</div>
                <div class="sv-stat-label">Free Tools</div>
            </div>
            <div class="sv-stat-item">
                <div class="sv-stat-num">100%</div>
                <div class="sv-stat-label">Free & Safe</div>
            </div>
            <div class="sv-stat-item">
                <div class="sv-stat-num">0s</div>
                <div class="sv-stat-label">No Survey</div>
            </div>
        </div>
    </div>

    <div class="sv-tabs">
        <button class="sv-tab active" onclick="filterTools('all')">All Tools</button>
        <button class="sv-tab" onclick="filterTools('facebook')">Facebook</button>
        <button class="sv-tab" onclick="filterTools('instagram')">Instagram</button>
        <button class="sv-tab" onclick="filterTools('tiktok')">TikTok</button>
        <button class="sv-tab" onclick="filterTools('utility')">Utility</button>
        <button class="sv-tab" onclick="filterTools('games')">Games</button>
    </div>

    <div id="sv-all">

        <div class="sv-category-section show" data-cat="facebook">
            <div class="sv-section-title"><span class="sv-dot fb"></span> Facebook Tools</div>
            <div class="sv-grid">
                <a href="{{ url('auto-liker-1000-likes') }}" class="sv-card sv-featured">
                    <div class="sv-card-icon">👍</div>
                    <div class="sv-card-body">
                        <span class="sv-badge sv-badge-popular">Most Popular</span>
                        <h5>Facebook Auto Liker</h5>
                        <p>Get up to 1000 likes on your Facebook posts instantly.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ url('facebook-auto-reaction') }}" class="sv-card">
                    <div class="sv-card-icon fb-bg">⚡</div>
                    <div class="sv-card-body">
                        <h5>Auto Reactions</h5>
                        <p>Add love, wow, haha reactions to your posts automatically.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ url('facebook-page-liker') }}" class="sv-card">
                    <div class="sv-card-icon fb-bg">📄</div>
                    <div class="sv-card-body">
                        <h5>Page Liker</h5>
                        <p>Boost your Facebook page likes and grow your audience.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ url('facebook-auto-followers') }}" class="sv-card">
                    <div class="sv-card-icon fb-bg">👥</div>
                    <div class="sv-card-body">
                        <h5>Auto Followers</h5>
                        <p>Get free Facebook followers instantly with one click.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ url('auto-friend-request') }}" class="sv-card">
                    <div class="sv-card-icon fb-bg">🤝</div>
                    <div class="sv-card-body">
                        <h5>Auto Friend Request</h5>
                        <p>Send automatic friend requests and grow your list.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="sv-category-section show" data-cat="instagram">
            <div class="sv-section-title"><span class="sv-dot ig"></span> Instagram Tools</div>
            <div class="sv-grid">
                <a href="{{ url('instagram-comment-liker') }}" class="sv-card">
                    <div class="sv-card-icon ig-bg">📸</div>
                    <div class="sv-card-body">
                        <span class="sv-badge sv-badge-free">Free</span>
                        <h5>Comment Liker</h5>
                        <p>Get free likes on your Instagram comments instantly.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ route('free-instagram-likes') }}" class="sv-card sv-featured">
                    <div class="sv-card-icon">❤️</div>
                    <div class="sv-card-body">
                        <span class="sv-badge sv-badge-popular">Popular</span>
                        <h5>Instagram Likes</h5>
                        <p>Get free likes on posts and photos. Fast, no login needed.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="sv-category-section show" data-cat="tiktok">
            <div class="sv-section-title"><span class="sv-dot tt"></span> TikTok Tools</div>
            <div class="sv-grid">
                <a href="{{ route('free-tiktok-views') }}" class="sv-card sv-featured">
                    <div class="sv-card-icon">🎬</div>
                    <div class="sv-card-body">
                        <span class="sv-badge sv-badge-popular">Most Popular</span>
                        <h5>TikTok Views</h5>
                        <p>Get free TikTok views on your videos instantly.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ route('free-tiktok-likes') }}" class="sv-card">
                    <div class="sv-card-icon tt-bg">🎵</div>
                    <div class="sv-card-body">
                        <h5>TikTok Likes</h5>
                        <p>Increase engagement and visibility on your TikToks.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="sv-category-section show" data-cat="utility">
            <div class="sv-section-title"><span class="sv-dot ut"></span> Utility Tools</div>
            <div class="sv-grid">
                <a href="{{ route('sms-bomber') }}" class="sv-card">
                    <div class="sv-card-icon ut-bg">💬</div>
                    <div class="sv-card-body">
                        <h5>SMS Bomber</h5>
                        <p>Send multiple SMS messages at once for testing.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ route('temp-mail') }}" class="sv-card">
                    <div class="sv-card-icon ut-bg">📧</div>
                    <div class="sv-card-body">
                        <h5>Temp Mail</h5>
                        <p>Get a temporary disposable email. Protect your privacy.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
                <a href="{{ url('findmyfbid') }}" class="sv-card">
                    <div class="sv-card-icon ut-bg">🆔</div>
                    <div class="sv-card-body">
                        <h5>Find My FB ID</h5>
                        <p>Find your Facebook profile ID using your profile URL.</p>
                        <span class="sv-card-btn">Use Tool <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="sv-category-section show" data-cat="games">
            <div class="sv-section-title"><span class="sv-dot gm"></span> Games</div>
            <div class="sv-grid">
                <a href="{{ url('/') }}" class="sv-card">
                    <div class="sv-card-icon gm-bg">🎮</div>
                    <div class="sv-card-body">
                        <span class="sv-badge sv-badge-new">New</span>
                        <h5>Facebook Image Games</h5>
                        <p>Create fun profile picture frames & viral photo cards.</p>
                        <span class="sv-card-btn">Play Games <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></span>
                    </div>
                </a>
            </div>
        </div>

    </div>

    <div class="sv-trust">
        <div>
            <div class="sv-trust-icon">🔒</div>
            <div class="sv-trust-label">Safe & Secure</div>
            <div class="sv-trust-sub">No passwords needed</div>
        </div>
        <div>
            <div class="sv-trust-icon">⚡</div>
            <div class="sv-trust-label">Instant Results</div>
            <div class="sv-trust-sub">Delivered in seconds</div>
        </div>
        <div>
            <div class="sv-trust-icon">💰</div>
            <div class="sv-trust-label">100% Free</div>
            <div class="sv-trust-sub">No hidden charges</div>
        </div>
    </div>

    <x-ads.leaderboard />
    <x-ads.mobile-banner />

@stop

@push('scripts')
<script>
function filterTools(cat) {
    document.querySelectorAll('.sv-tab').forEach(function(t) { t.classList.remove('active'); });
    event.target.classList.add('active');
    document.querySelectorAll('.sv-category-section').forEach(function(s) {
        if (cat === 'all') {
            s.classList.add('show');
        } else {
            s.classList.toggle('show', s.dataset.cat === cat);
        }
    });
}
</script>
@endpush