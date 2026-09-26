@extends('layouts.game')

@section('title', (isset($keyword) && $keyword ? \Illuminate\Support\Str::limit(ucwords(str_replace('-', ' ', $keyword)) . ' - Free Online Tool', 44, '') : 'Facebook Auto Liker | Instagram Auto Follow'))
@section('description', (isset($keyword) && $keyword ? \Illuminate\Support\Str::limit('Free ' . ucwords(str_replace('-', ' ', $keyword)) . ' tool. Use it free online — fast, safe, no login required. Try it now on AutoLikerLive.', 155, '') : 'Get free Facebook auto followers, likes, reactions and Instagram followers. Download the app or use free online tools. Safe, fast, no password.'))
@section('keywords', 'auto liker live, autolikerlive, auto liker, facebook auto liker, facebook auto followers, instagram auto follow, fb liker 1000 likes, free facebook liker, auto react facebook, facebook auto followers, fb auto liker, facebook page liker')

@section('content')
<div class="pb-20">
    @if (!isset($keyword) || !$keyword)
        {{-- ============ Old-style homepage (dark, 2025 restoration) ============ --}}
        <style>
            .oh-wrap { background: #0b1526; color: #e8edf5; border-radius: 16px; overflow: hidden; }
            .oh-wrap.oh-full { border-radius: 0; min-height: calc(100vh - 56px); min-height: calc(100svh - 56px); display: flex; flex-direction: column; justify-content: center; }
            .oh-wrap.oh-full .oh-hero { max-width: 1200px; width: 100%; margin: 0 auto; }
            .oh-wrap.oh-full .oh-feats, .oh-wrap.oh-full .oh-pills { max-width: 1200px; width: 100%; margin-left: auto; margin-right: auto; }
            .oh-hero { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 1.5rem; align-items: center; padding: 2.5rem 2rem; }
            .oh-hero h1 { color: #fff; font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: 0 0 0.5rem; }
            .oh-hero p.sub { color: #c4cfe3; font-size: 1.02rem; margin: 0 0 1.25rem; }
            .oh-app-row { display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap; }
            .oh-app-row img { width: 56px; height: 56px; border-radius: 14px; }
            .oh-btn { display: inline-block; background: #0b5ed7; color: #fff !important; font-weight: 700; padding: 0.7rem 1.4rem; border-radius: 10px; text-decoration: none; }
            .oh-btn:hover { background: #0a58ca; text-decoration: none; }
            .oh-btn.ghost { background: transparent; border: 1.5px solid #3b82f6; color: #cfe2ff !important; }
            .oh-hero-art img { width: 100%; height: auto; aspect-ratio: 16/9; border-radius: 12px; display: block; background: #111f38; }
            .oh-feats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; padding: 0 2rem 2rem; }
            .oh-feat { background: #111f38; border: 1px solid #22345c; border-radius: 12px; padding: 1.25rem 1.25rem 1.1rem; }
            .oh-feat h2 { color: #fff; font-size: 1.02rem; margin: 0 0 0.5rem; }
            .oh-feat p { color: #c3cfe6; font-size: 0.88rem; margin: 0; }
            .oh-feat p a, .oh-dark-sec p a, .page-header p a { text-decoration: underline; text-underline-offset: 2px; }
            .oh-feat .ic { font-size: 1.5rem; }
            .oh-pills { padding: 0 2rem 2.25rem; }
            .oh-pills h2 { color: #fff; font-size: 1.05rem; margin: 0 0 0.9rem; text-align: center; }
            .oh-pill-grid { display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; }
            .oh-pill-grid a { background: #0b5ed7; color: #fff !important; font-size: 0.8rem; font-weight: 600; padding: 0.42rem 0.85rem; border-radius: 6px; text-decoration: none; }
            .oh-pill-grid a:hover { background: #0a58ca; text-decoration: none; }
            .oh-light { background: #f4f6fb; color: #1a1a2e; border-radius: 16px; padding: 2.25rem 2rem; margin-top: 1.5rem; }
            .oh-light h2 { color: #1a1a2e; font-size: 1.3rem; margin: 0 0 0.4rem; text-align: center; }
            .oh-light p.lead { text-align: center; color: #5b6478; font-size: 0.92rem; margin: 0 0 1.5rem; }
            .oh-blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
            .oh-blog-card { background: #fff; border: 1px solid #e3e8f2; border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; }
            .oh-blog-card img { width: 100%; height: 150px; object-fit: cover; display: block; }
            .oh-blog-card .b-body { padding: 0.9rem 1rem 1rem; display: flex; flex-direction: column; gap: 0.4rem; flex: 1; }
            .oh-blog-card .b-date { font-size: 0.72rem; color: #5b6478; }
            .oh-blog-card .b-title { font-size: 0.88rem; font-weight: 700; color: #1a1a2e; line-height: 1.35; }
            .oh-blog-card .b-ex { font-size: 0.8rem; color: #5b6478; flex: 1; }
            .oh-blog-card .b-more { font-size: 0.82rem; font-weight: 700; color: #0b5ed7; text-decoration: none; }
            .oh-dark-sec { background: #0b1526; color: #e8edf5; border-radius: 16px; padding: 2.25rem 2rem; margin-top: 1.5rem; }
            .oh-dark-sec h2 { color: #fff; font-size: 1.3rem; margin: 0 0 0.6rem; text-align: center; }
            .oh-dark-sec h3 { color: #fff; font-size: 1.02rem; margin: 1.4rem 0 0.5rem; }
            .oh-dark-sec p, .oh-dark-sec li { color: #c3cfe6; font-size: 0.9rem; }
            .oh-dark-sec a { color: #a8c8ff; }
            .oh-dark-sec ul { padding-left: 1.2rem; margin: 0.4rem 0; }
            .oh-video { max-width: 640px; margin: 1rem auto 0; }
            .oh-video button, .oh-video .oh-video-ph { display: block; width: 100%; aspect-ratio: 16/9; border: 0; border-radius: 10px; overflow: hidden; background: #000; cursor: pointer; padding: 0; position: relative; }
            .oh-video img { width: 100%; height: 100%; object-fit: cover; display: block; opacity: 0.85; }
            .oh-video .oh-play { position: absolute; inset: 0; display: grid; place-items: center; }
            .oh-video .oh-play span { width: 68px; height: 48px; border-radius: 12px; background: #f00; color: #fff; display: grid; place-items: center; font-size: 22px; }
            .oh-video-ph { display: grid; place-items: center; background: #1e293b; color: #94a3b8; font-size: 0.9rem; }
            .oh-faq p { margin: 0 0 0.9rem; }
            @media (max-width: 860px) {
                .oh-hero { grid-template-columns: 1fr; padding: 1.75rem 1.25rem; }
                .oh-feats { grid-template-columns: 1fr; padding: 0 1.25rem 1.5rem; }
                .oh-pills { padding: 0 1.25rem 1.75rem; }
                .oh-light, .oh-dark-sec { padding: 1.75rem 1.25rem; }
                .oh-blog-grid { grid-template-columns: 1fr; }
            }
        </style>

        @section('hero')
        <div class="oh-wrap oh-full">
            {{-- Hero --}}
            <div class="oh-hero">
                <div>
                    <h1>Autoliker Live</h1>
                    <p class="sub">Download Autoliker Live: Get Auto Followers and Auto Likes on Your Account for Free!</p>
                    <div class="oh-app-row">
                        <img src="{{ asset('images/icon.webp') }}" alt="Autoliker Live app icon" width="56" height="56">
                        <a href="{{ url('/download') }}" class="oh-btn">⬇ Download APP</a>
                        <a href="{{ url('auto-liker-1000-likes') }}" class="oh-btn ghost">Get 1000 Free Likes</a>
                    </div>
                </div>
                <div class="oh-hero-art">
                    <img src="{{ url('/storage/app-icons/home_promo.webp') }}" alt="Autoliker Live - Facebook auto followers and auto likes" loading="eager" fetchpriority="high">
                </div>
            </div>

            {{-- 4 feature boxes --}}
            <div class="oh-feats">
                <div class="oh-feat">
                    <div class="ic">🧰</div>
                    <h2>Services Provided</h2>
                    <p>AutolikerLive specializes in Facebook Auto Followers, auto likes and reactions — plus Instagram auto follow, TikTok likes &amp; views and FB Sub. Free tools, regular updates, growing every month.</p>
                </div>
                <div class="oh-feat">
                    <div class="ic">🔒</div>
                    <h2>Security</h2>
                    <p>Your privacy comes first. The app stores no Facebook account information on our servers — access tokens and cookies stay only on your device, under your control.</p>
                </div>
                <div class="oh-feat">
                    <div class="ic">🛡️</div>
                    <h2>Anti-Spam Protection</h2>
                    <p>Strict zero-tolerance policy against spam. Your private Facebook data is never sent to any third party — your account stays protected from unwanted activity.</p>
                </div>
                <div class="oh-feat">
                    <div class="ic">🎧</div>
                    <h2>Support</h2>
                    <p>Questions about the auto liker, FB Sub or TikTok tools? Our support team helps beginners and pros alike — reach us anytime via the <a href="{{ url('contact') }}">contact page</a>.</p>
                </div>
            </div>

            {{-- Blue pill listing grid --}}
            <div class="oh-pills">
                <h2>Free Facebook &amp; Social Media Tools</h2>
                <div class="oh-pill-grid">
                    <a href="{{ url('auto-liker-1000-likes') }}">FB Auto Liker 1000 Likes</a>
                    <a href="{{ url('fbsub') }}">FBSub Liker</a>
                    <a href="{{ route('free-instagram-likes') }}">Instagram Auto Follow</a>
                    <a href="{{ route('free-instagram-likes') }}">Instagram Likes</a>
                    <a href="{{ route('free-tiktok-views') }}">TikTok Views</a>
                    <a href="{{ route('free-tiktok-likes') }}">TikTok Likes</a>
                    <a href="{{ route('findmyfbid') }}">Find My FB ID</a>
                    <a href="{{ route('temp-mail') }}">Temp Mail</a>
                    <a href="{{ route('sms-bomber') }}">SMS Bomber</a>
                    <a href="{{ url('/download') }}">Download App</a>
                    @if (isset($linkedPosts) && count($linkedPosts) > 0)
                        @foreach ($linkedPosts as $lp)
                            <a href="{{ url($lp['slug']) }}">{{ $lp['name'] }}</a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        @stop

        {{-- How to use + video (lite facade: thumbnail only until click) --}}
        <div class="oh-light">
            <h2>How to use Autoliker Live</h2>
            <p class="lead">Facing trouble in use? Watch the tutorial — 5 minutes to master the FB Autoliker app: download, paste your public profile link, verify, submit. No password, no access token.</p>
            @php
                // Paste the YouTube video ID here when ready. Empty = placeholder only (zero external requests).
                $tutorialVideoId = '';
            @endphp
            <div class="oh-video">
                @if ($tutorialVideoId)
                    <button type="button" id="homeVideoFacade" data-video="{{ $tutorialVideoId }}" aria-label="Play Autoliker Live tutorial video">
                        <img src="https://i.ytimg.com/vi/{{ $tutorialVideoId }}/hqdefault.jpg" alt="Autoliker Live video tutorial" width="640" height="360" loading="lazy" decoding="async">
                        <span class="oh-play"><span>▶</span></span>
                    </button>
                @else
                    <div class="oh-video-ph">🎬 Video tutorial coming soon</div>
                @endif
            </div>
            <script>
                (function () {
                    var f = document.getElementById('homeVideoFacade');
                    if (!f) return;
                    f.addEventListener('click', function () {
                        var id = f.getAttribute('data-video');
                        var frame = document.createElement('iframe');
                        frame.width = '640'; frame.height = '360';
                        frame.title = 'Autoliker Live tutorial video';
                        frame.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
                        frame.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
                        frame.setAttribute('allowfullscreen', '');
                        frame.loading = 'lazy';
                        frame.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0';
                        frame.style.cssText = 'width:100%;aspect-ratio:16/9;height:auto;border:0;border-radius:10px;';
                        f.replaceWith(frame);
                    }, { passive: true });
                })();
            </script>
        </div>

        {{-- From our blog --}}
        @if (isset($latestPosts) && count($latestPosts) > 0)
        <div class="oh-light">
            <h2>From our blog</h2>
            <p class="lead">Tricks &amp; tips for social media growth. We update Android and desktop tricks to make your internet experience enjoyable.</p>
            <div class="oh-blog-grid">
                @foreach ($latestPosts as $bp)
                    <div class="oh-blog-card">
                        @if (!empty($bp->image))
                            <img src="{{ $bp->image }}" alt="{{ $bp->title }}" loading="lazy" decoding="async">
                        @endif
                        <div class="b-body">
                            <div class="b-date">{{ date('M d, Y', strtotime($bp->created_at)) }}</div>
                            <div class="b-title">{{ $bp->title }}</div>
                            @if (!empty($bp->excerpt))
                                <div class="b-ex">{{ $bp->excerpt }}</div>
                            @endif
                            <a class="b-more" href="{{ $bp->url }}">Read More →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Dark marketing section --}}
        <div class="oh-dark-sec">
            <h2>Boost Your Social Media Presence with AutolikerLive</h2>
            <p style="text-align:center;">Welcome to AutolikerLive: exclusive free tools — <strong>Autoliker</strong>, <strong>FB Sub</strong> and <strong>TikTok Auto Liker</strong> — to grow your profiles quickly and organically. Creators, businesses and influencers get noticed here.</p>
            <h3>Why Choose AutolikerLive?</h3>
            <ul>
                <li><strong>Increase Engagement:</strong> boost auto followers, likes, shares and comments to improve visibility.</li>
                <li><strong>Save Time:</strong> set up and forget — automated services work around the clock.</li>
                <li><strong>Grow Your Followers:</strong> organically grow your social media presence.</li>
            </ul>
            <h3>Getting Started with AutolikerLive</h3>
            <p>Open the <a href="{{ url('auto-liker-1000-likes') }}">Autoliker</a>, <a href="{{ url('fbsub') }}">FB Sub</a> or <a href="{{ route('free-tiktok-likes') }}">TikTok auto liker</a>, paste a public link, verify and submit. For personalized help, <a href="{{ url('contact') }}">get in touch</a> — let's boost your presence together.</p>
            <h3>AutolikerLive FAQ</h3>
            <div class="oh-faq">
                <p><strong>What is Autoliker Live?</strong><br>Free social growth tools: Facebook auto followers and auto likes, Instagram auto follow and likes, TikTok likes and views, FB Sub liker, temp mail and more.</p>
                <p><strong>Is Autoliker Live free?</strong><br>Yes — the app and all online tools are free with no hidden charges.</p>
                <p><strong>Is it safe? Do you need my password?</strong><br>Never. Only public profile links are used; app login data never leaves your device.</p>
                <p><strong>How fast will I see results?</strong><br>Most users see engagement start within minutes, subject to short fair-use cooldowns.</p>
            </div>
        </div>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "What is Autoliker Live?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Free social growth tools: Facebook auto followers and auto likes, Instagram auto follow and likes, TikTok likes and views, FB Sub liker, temp mail and more."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is Autoliker Live free?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. The app and all online tools are free with no hidden charges."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is it safe? Do you need my password?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Never. Only public profile links are used; app login data never leaves your device."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How fast will I see results?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Most users see engagement start within minutes, subject to short fair-use cooldowns."
                    }
                }
            ]
        }
        </script>
    @endif

    @if (isset($keyword) && $keyword)
    <div class="page-header mb-16">
        <h1>{{ ucwords(str_replace('-', ' ', $keyword)) }}</h1>
        <p>{{ 'Use our free ' . ucwords(str_replace('-', ' ', $keyword)) . ' tool online. Fast, safe, and no login required.' }}</p>
    </div>
    @else
    <div class="page-header mb-16">
        <h2 style="font-size:1.25rem;">Latest Games</h2>
        <p>Fresh image games &amp; viral photo cards. Play free, share with friends — <a href="{{ route('games.hub') }}">see all games →</a></p>
    </div>
    @endif

    @if (count($games) > 0)
        <div class="games-list">
            @foreach ($games as $index => $game)
                @if ((isset($keyword) && $keyword) || $index < 3)
                <a href="{{ route('game.show', $game->slug) }}" class="og-card">
                    <div class="og-img" style="background: linear-gradient(135deg, {{ $game->bg_color ?? '#1a1a2e' }}, {{ $game->bg_color ?? '#16213e' }}); overflow:hidden;">
                        @if ($game->thumbnail)
                            <img src="{{ Storage::disk('public')->url($game->thumbnail) }}" alt="{{ $game->title }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            @switch($game->slug)
                                @case('which-bollywood-star-are-you') 🎬 @break
                                @case('my-facebook-superpower') ⚡ @break
                                @case('my-facebook-report-card') 📋 @break
                                @case('which-animal-are-you') 🦁 @break
                                @case('my-facebook-award') 🏆 @break
                                @default 🎮
                            @endswitch
                        @endif
                    </div>
                    <div class="og-bottom">
                        <div class="og-title">{{ resolveGameTitle($game->title) }}</div>
                        @if ($game->description)
                            <div class="og-desc">{{ $game->description }}</div>
                        @endif
                    </div>
                </a>
                @endif
            @endforeach
        </div>
        @if ((!isset($keyword) || !$keyword) && count($games) > 3)
            <div style="text-align:center; margin-top:1rem;">
                <a href="{{ route('games.hub') }}" class="btn btn-outline">🎮 Play all {{ count($games) }} games →</a>
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🎮</div>
            <p class="empty-state-text">No games available yet.</p>
        </div>
    @endif

    @if (isset($linkedPosts) && count($linkedPosts) > 0)
        <div class="listing-tags" style="margin-top:2rem; padding:1.5rem; background:#f8f9fa; border-radius:12px;">
            <h3 style="font-size:1rem; font-weight:700; color:#1a1a2e; margin-bottom:0.75rem;">More Free Tools</h3>
            <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">
                @foreach ($linkedPosts as $lp)
                    <a href="{{ url($lp['slug']) }}" style="display:inline-block; padding:0.4rem 0.9rem; background:#fff; border:1px solid #ddd; border-radius:50px; font-size:0.82rem; color:#333; text-decoration:none; transition:all 0.2s;">{{ $lp['name'] }}</a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@stop

@section('sidebar')
    {{-- Cross-promo banners (sidebar only, compact): managed in Admin > Promotions (Homepage) --}}
    <x-promo-banner placement="homepage" variant="compact" />

    <div class="widget">
        <h3>⚠️ Disclaimer</h3>
        <p>These games are for <strong>entertainment purposes only</strong>. All images are auto-generated and do not reflect real traits, abilities, or facts.</p>
    </div>

    <div class="widget">
        <h3>🔧 Free Tools</h3>
        <div class="flex flex-col gap-8">
            <a href="{{ route('free-tiktok-views') }}">TikTok Views</a>
            <a href="{{ route('free-tiktok-likes') }}">TikTok Likes</a>
            <a href="{{ route('free-instagram-likes') }}">Instagram Likes</a>
            <a href="{{ route('sms-bomber') }}">SMS Bomber</a>
            <a href="{{ route('temp-mail') }}">Temp Mail</a>
            <a href="{{ url('services') }}">All Tools →</a>
        </div>
    </div>

    <div class="widget">
        <h3>🎮 Quick Links</h3>
        <div class="flex flex-col gap-8">
            <a href="{{ route('games.hub') }}">All Games</a>
            <a href="{{ url('/download') }}">⬇️ Download AutoLiker app</a>
            <a href="{{ url('privacy') }}">Privacy Policy</a>
            <a href="{{ url('terms') }}">Terms of Service</a>
            <a href="{{ url('contact') }}">Contact Us</a>
        </div>
    </div>

    @if (isset($tags) && count($tags) > 0)
        <div class="widget">
            <h3>🏷️ Tags</h3>
            <div class="flex flex-wrap gap-6">
                @foreach ($tags as $tag)
                    @if ($tag->link != null)
                        <a href="{{ url($tag->link) }}" class="tag-pill">{{ $tag->name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
@stop
