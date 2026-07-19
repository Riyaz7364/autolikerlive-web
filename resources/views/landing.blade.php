@extends('layouts.master')

@section('title', ucwords($keyword) . ' - Free Online Tool')
@section('description', 'Free ' . ucwords($keyword) . ' tool. ' . ($posts->title ?? 'Use our free social media tools online. Fast, safe, and free. No login required.') . ' Try it now on AutoLikerLive.')
@section('keywords', $keyword . ', ' . $keyword . ' free, auto liker, facebook auto liker, ' . $keyword . ' online, autolikerlive, ' . $keyword . ' without survey')

@section('javascripts')
    <style>
        .landing-hero {
            background: #0f3460;
            padding: 2.5rem 2rem;
            color: white;
            border-radius: 16px;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .landing-hero::before { display: none; }
        .landing-hero h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            letter-spacing: -0.02em;
            color: #ffffff !important;
        }
        .landing-hero .hero-sub {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 520px;
            margin: 0 auto;
            position: relative;
            line-height: 1.6;
            color: #ffffff !important;
        }
        .landing-hero .hero-badge {
            color: #ffffff !important;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(83,178,255,0.15);
            border: 1px solid rgba(83,178,255,0.3);
            color: #53b2ff;
            padding: 0.3rem 0.9rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1rem;
            position: relative;
        }

        .blog-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 16px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
        }
        .blog-card .article-label {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0f3460;
            background: #e8f0fe;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            margin-bottom: 0.75rem;
        }
        .blog-card .article-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a2e !important;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .wordpress {
            color: #2d2d2d;
            font-size: 1.05rem;
            line-height: 1.85;
        }
        .wordpress h1, .wordpress h2, .wordpress h3, .wordpress h4 {
            color: #1a1a2e;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }
        .wordpress h1 { font-size: 1.6rem; }
        .wordpress h2 { font-size: 1.35rem; }
        .wordpress h3 { font-size: 1.15rem; }
        .wordpress p {
            color: #2d2d2d;
            margin-bottom: 1rem;
            line-height: 1.85;
        }
        .wordpress img {
            max-width: 100%;
            border-radius: 10px;
            margin: 1rem 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .wordpress a {
            color: #0f3460;
            font-weight: 500;
            text-decoration: underline;
            text-decoration-color: rgba(15,52,96,0.3);
            text-underline-offset: 2px;
        }
        .wordpress a:hover {
            color: #53b2ff;
            text-decoration-color: #53b2ff;
        }
        .wordpress ul, .wordpress ol {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }
        .wordpress li {
            margin-bottom: 0.5rem;
            line-height: 1.7;
        }
        .wordpress blockquote {
            border-left: 3px solid #53b2ff;
            padding: 0.75rem 1.25rem;
            margin: 1.5rem 0;
            background: #f0f7ff;
            border-radius: 0 8px 8px 0;
            font-style: italic;
            color: #444;
        }
        .wordpress code {
            background: #f0f0f0;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            font-size: 0.9em;
            color: #e74c3c;
        }
        .wordpress pre {
            background: #1a1a2e;
            color: #e0e0e0;
            padding: 1rem;
            border-radius: 10px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        .wordpress pre code {
            background: none;
            color: inherit;
            padding: 0;
        }
        .wordpress table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            border-radius: 8px;
            overflow: hidden;
        }
        .wordpress table th,
        .wordpress table td {
            padding: 0.6rem 0.8rem;
            border: 1px solid #e9ecef;
            text-align: left;
            font-size: 0.95rem;
        }
        .wordpress table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #1a1a2e;
        }
        .wordpress table tr:hover td {
            background: #f8f9fa;
        }

        .no-post-banner {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            padding: 2.5rem 2rem;
            border-radius: 16px;
            text-align: center;
            margin-bottom: 2rem;
        }
        .no-post-banner h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .no-post-banner p {
            opacity: 0.8;
            max-width: 400px;
            margin: 0 auto;
        }

        .tools-section {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
        }
        .tools-section .section-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1a1a2e;
            font-size: 1.15rem;
        }
        .tool-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.1rem;
            background: #fff;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
            margin-bottom: 0.6rem;
        }
        .tool-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            color: #0f3460;
            border-color: rgba(15,52,96,0.1);
        }
        .tool-card .tool-icon {
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f7ff;
            border-radius: 10px;
            flex-shrink: 0;
        }
        .tool-card .tool-info strong {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 0.15rem;
        }
        .tool-card .tool-info small {
            color: #888;
            font-size: 0.78rem;
            line-height: 1.4;
        }

        .cta-banner {
            background: linear-gradient(135deg, #0f3460, #1a1a2e);
            border-radius: 16px;
            padding: 1.75rem;
            text-align: center;
            color: white;
            margin-bottom: 1.5rem;
        }
        .cta-banner h3 {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.4rem;
        }
        .cta-banner p {
            opacity: 0.8;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .cta-banner .btn-cta {
            display: inline-block;
            background: #53b2ff;
            color: #1a1a2e;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .cta-banner .btn-cta:hover {
            background: #7fc4ff;
            transform: translateY(-1px);
        }

        .breadcrumb-top {
            font-size: 0.82rem;
            color: #888;
            margin-bottom: 1rem;
            padding-top: 0.5rem;
        }
        .breadcrumb-top a {
            color: #0f3460;
            text-decoration: none;
        }
        .breadcrumb-top a:hover {
            text-decoration: underline;
        }

        .divider {
            border: none;
            border-top: 1px solid #eee;
            margin: 1.5rem 0;
        }

        .toc-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 3px solid #53b2ff;
        }
        .toc-card .toc-title {
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #0f3460;
            margin-bottom: 0.5rem;
        }
        .toc-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .toc-card li {
            padding: 0.25rem 0;
        }
        .toc-card li a {
            color: #444;
            text-decoration: none;
            font-size: 0.88rem;
            transition: color 0.2s;
        }
        .toc-card li a:hover {
            color: #0f3460;
        }
        .toc-card li a::before {
            content: '\2022';
            color: #53b2ff;
            margin-right: 0.5rem;
        }

        .related-section {
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .landing-hero { padding: 2rem 1.25rem; }
            .landing-hero h1 { font-size: 1.4rem; }
            .blog-card { padding: 1.25rem; }
            .tools-section { padding: 1.25rem; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var headings = document.querySelectorAll('.wordpress h2, .wordpress h3');
            if (headings.length > 2) {
                var toc = document.querySelector('.toc-list');
                if (toc) {
                    headings.forEach(function(h, i) {
                        h.id = 'section-' + i;
                        var li = document.createElement('li');
                        var a = document.createElement('a');
                        a.href = '#section-' + i;
                        a.textContent = h.textContent;
                        li.appendChild(a);
                        toc.appendChild(li);
                    });
                    document.querySelector('.toc-card').style.display = 'block';
                }
            }
        });
    </script>
@endsection

@section('content')
    <div class="breadcrumb-top">
        <a href="{{ url('/') }}">Home</a> / <span>{{ ucwords($keyword) }}</span>
    </div>

    <div class="landing-hero">
        <span class="hero-badge">Free Online Tool</span>
        <h1>{{ ucwords($keyword) }}</h1>
        <p class="hero-sub">Use our free {{ ucwords($keyword) }} tool online. Fast, safe, and no login required.</p>
    </div>

    @if ($posts && isset($posts->title) && $posts->title)
        <div class="blog-card">
            <span class="article-label">Guide</span>
            <h2 class="article-title">{{ $posts->title }}</h2>

            @if ($posts && isset($posts->title))
                <div class="toc-card" style="display:none;">
                    <div class="toc-title">On This Page</div>
                    <ul class="toc-list"></ul>
                </div>
            @endif

            <div class="wordpress">
                {!! $posts->content !!}
            </div>
        </div>
    @else
        <div class="no-post-banner">
            <p>Content coming soon. Check out our other free tools below.</p>
        </div>
    @endif

    <div class="cta-banner">
        <h3>Need Help With Something Else?</h3>
        <p>We have free tools for Facebook, Instagram, TikTok and more.</p>
        <a href="{{ url('services') }}" class="btn-cta">Browse All Tools</a>
    </div>

    <div class="related-section">
        <div class="tools-section">
            <div class="section-title">Related Tools</div>

            <a href="{{ url('auto-liker-1000-likes') }}" class="tool-card">
                <span class="tool-icon">👍</span>
                <span class="tool-info">
                    <strong>Facebook Auto Liker</strong>
                    <small>Get up to 1000 likes on your Facebook posts instantly.</small>
                </span>
            </a>

            <a href="{{ url('instagram-comment-liker') }}" class="tool-card">
                <span class="tool-icon">📸</span>
                <span class="tool-info">
                    <strong>Instagram Comment Liker</strong>
                    <small>Get free likes on your Instagram comments.</small>
                </span>
            </a>

            <a href="{{ route('free-tiktok-views') }}" class="tool-card">
                <span class="tool-icon">🎬</span>
                <span class="tool-info">
                    <strong>Free TikTok Views</strong>
                    <small>Boost your TikTok video views for free.</small>
                </span>
            </a>

            <a href="{{ route('free-tiktok-likes') }}" class="tool-card">
                <span class="tool-icon">❤️</span>
                <span class="tool-info">
                    <strong>Free TikTok Likes</strong>
                    <small>Get real likes on your TikTok videos.</small>
                </span>
            </a>

            <a href="{{ route('free-instagram-likes') }}" class="tool-card">
                <span class="tool-icon">✨</span>
                <span class="tool-info">
                    <strong>Free Instagram Likes</strong>
                    <small>Boost your Instagram posts with free likes.</small>
                </span>
            </a>

            <a href="{{ url('fbsub') }}" class="tool-card">
                <span class="tool-icon">👥</span>
                <span class="tool-info">
                    <strong>Facebook Auto Followers</strong>
                    <small>Get free followers on your Facebook profile.</small>
                </span>
            </a>
        </div>
    </div>
@endsection
