<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ request()->url() }}" />
    <title>Free Instagram Likes Every 10 Minutes | AutoLikerLive</title>
    <meta name="description" content="Get 10 free Instagram likes instantly. Paste your post, reel or IGTV link and get free likes every 10 minutes. No login, no password, instant delivery.">
    <meta name="keywords" content="free instagram likes, instagram free likes, get free likes on instagram, instagram likes free, free instagram likes for posts, free instagram reel likes, instagram like generator, boost instagram likes">
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Free Instagram Likes - Get 10 Free Likes Every 10 Minutes | AutoLikerLive" />
    <meta property="og:description" content="Get 10 free Instagram likes instantly. Paste your post link and get free likes every 10 minutes. No login required." />
    <meta property="og:image" content="{{ asset('images/graphic.webp') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ Request::url() }}" />
    <meta name="twitter:title" content="Free Instagram Likes - Get 10 Free Likes Every 10 Minutes" />
    <meta name="twitter:description" content="Get 10 free Instagram likes instantly. Paste your post link and get free likes every 10 minutes." />
    <meta name="twitter:image" content="{{ asset('images/graphic.webp') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tool-header.css') }}">

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "Free Instagram Likes",
  "applicationCategory": "MultimediaApplication",
  "operatingSystem": "Web",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock"
  },
  "description": "Get 10 free Instagram likes instantly. Paste your post, reel or IGTV link and get free likes every 10 minutes. No login or password required.",
  "featureList": [
    "100% free Instagram likes",
    "No login or password required",
    "Instant delivery within minutes",
    "Works every 10 minutes",
    "Safe and secure",
    "Posts, reels and IGTV supported"
  ],
  "author": {
    "@type": "Organization",
    "name": "AutoLikerLive",
    "url": "https://autolikerlive.com"
  },
  "url": "{{ Request::url() }}",
  "image": "{{ asset('images/graphic.webp') }}"
}
</script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is the free Instagram likes service safe?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. We never ask for your Instagram password or login credentials. You only paste a public post link, so your account stays completely protected."
      }
    },
    {
      "@type": "Question",
      "name": "How many free Instagram likes can I get?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "You get 10 free likes with every request. You can submit a new request every 10 minutes, so you can keep growing a post all day long."
      }
    },
    {
      "@type": "Question",
      "name": "Why can't I submit the same link twice in a row?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "To keep the service free for everyone, the same post can only be the most recent one in the queue once. Submit someone else's post, and your own becomes eligible again."
      }
    },
    {
      "@type": "Question",
      "name": "How long does it take to receive Instagram likes?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Likes are typically delivered within minutes after your request is processed. Delivery time can vary with current demand."
      }
    },
    {
      "@type": "Question",
      "name": "Which Instagram URLs are supported?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "All standard Instagram links are supported, including post, reel and IGTV links from instagram.com. Just paste the link and we handle the rest."
      }
    },
    {
      "@type": "Question",
      "name": "Do I need to create an account?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No account creation is required. Paste your link, complete the quick verification, and your free likes are delivered automatically."
      }
    }
  ]
}
</script>

    <style>
        :root {
            /* Instagram brand gradient */
            --ig-purple: #833AB4;
            --ig-red: #FD1D1D;
            --ig-orange: #FCB045;

            /* Temp-mail light base */
            --bg: #f6f8fb;
            --surface: #ffffff;
            --surface-2: #f2f4f8;
            --ink: #16181d;
            --muted: #65676e;
            --border: #e4e7ee;

            --radius: 18px;
            --shadow: 0 12px 34px rgba(131, 58, 180, .12);
            --shadow-sm: 0 4px 14px rgba(22, 24, 29, .06);
            --grad: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--ink);
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.55;
        }

        a { color: var(--ig-purple); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* Header styles live in public/css/tool-header.css (<x-tool-header />) */

        /* ============ Ad slots ============ */
        .ad-slot { overflow: hidden; text-align: center; margin: 22px auto; padding: 6px 0; }
        .ad-slot > div { margin: 0 !important; }
        .ad-slot .ad-container { text-align: center; }
        .ad-slot .d-none { display: block; }
        .ad-slot .d-block { display: block; }
        @media (max-width: 767px) { .ad-slot .d-none { display: none; } .ad-slot .d-md-none { display: block; } }

        /* ============ Hero ============ */
        .hero { text-align: center; padding: 52px 24px 12px; position: relative; overflow: hidden; }
        .hero::before {
            content: "";
            position: absolute;
            inset: -180px 0 auto 0;
            height: 340px;
            background: var(--grad);
            opacity: .1;
            filter: blur(90px);
            pointer-events: none;
        }
        .hero-inner { max-width: 820px; margin: 0 auto; position: relative; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(131, 58, 180, .08);
            border: 1px solid rgba(131, 58, 180, .2);
            color: var(--ig-purple);
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 999px;
        }
        .badge svg { width: 15px; height: 15px; }
        .hero h1 {
            font-size: clamp(30px, 5vw, 52px);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.12;
            margin: 18px 0 12px;
        }
        .hero h1 .grad {
            background: var(--grad);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero p {
            color: var(--muted);
            font-size: clamp(15px, 2.4vw, 18px);
            max-width: 600px;
            margin: 0 auto;
        }
        .trust-row { display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; margin-top: 22px; }
        .trust-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            padding: 7px 13px;
            border-radius: 999px;
        }
        .trust-pill svg { width: 16px; height: 16px; flex-shrink: 0; color: var(--ig-purple); }

        /* ============ Layout ============ */
        .layout {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 18px 24px 44px;
            display: flex;
            flex-direction: column;
            gap: 26px;
        }

        /* ============ Tool Card ============ */
        .tool-card {
            background: var(--surface);
            border-radius: 22px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            padding: clamp(22px, 3.5vw, 36px);
            position: relative;
            max-width: 680px;
            margin: 0 auto;
            width: 100%;
        }
        .tool-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            border-radius: 22px 22px 0 0;
            background: var(--grad);
        }
        .tool-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 14px;
            color: var(--ig-purple);
        }
        .tool-label svg { width: 20px; height: 20px; flex-shrink: 0; }
        .tool-form { display: flex; flex-direction: column; gap: 14px; }
        .input-row { display: flex; gap: 10px; }
        .input-row input {
            flex: 1;
            min-width: 0;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 15px;
            font-family: inherit;
            color: var(--ink);
            background: var(--surface-2);
            transition: border-color .2s, box-shadow .2s;
        }
        .input-row input::placeholder { color: #9a9da6; }
        .input-row input:focus {
            outline: none;
            border-color: var(--ig-purple);
            box-shadow: 0 0 0 4px rgba(131, 58, 180, .12);
        }
        .btn-find {
            border: 0;
            cursor: pointer;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            padding: 14px 24px;
            border-radius: 12px;
            white-space: nowrap;
            background: var(--grad);
            box-shadow: 0 8px 20px rgba(204, 35, 102, .28);
            transition: transform .15s, box-shadow .2s, filter .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-find:hover { transform: translateY(-1px); box-shadow: 0 12px 26px rgba(204, 35, 102, .38); filter: saturate(1.15); text-decoration: none; }
        .btn-find:active { transform: translateY(0); }
        .btn-find:disabled { background: #d7dae2; color: #8b8f99; box-shadow: none; pointer-events: none; }
        .btn-find .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255, 255, 255, .4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        .btn-find.loading .btn-label { display: none; }
        .btn-find.loading .spinner { display: inline-block; }
        .btn-find.loading { pointer-events: none; opacity: .85; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-bar {
            height: 3px;
            background: var(--grad);
            background-size: 200% 100%;
            border-radius: 3px;
            overflow: hidden;
            display: none;
            animation: loadingShimmer 1.2s ease-in-out infinite;
        }
        .loading-bar.active { display: block; }
        @keyframes loadingShimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .hint { font-size: 13px; color: var(--muted); display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
        .hint svg { flex-shrink: 0; }
        .hint code {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px 7px;
            font-size: 12px;
            color: var(--ig-purple);
        }
        .recaptcha-wrap { display: flex; justify-content: center; }

        .timer-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(131, 58, 180, .07);
            border: 1px solid rgba(131, 58, 180, .18);
            color: var(--ig-purple);
            font-size: 14px;
            font-weight: 600;
            padding: 10px 18px;
            border-radius: 12px;
            margin-top: 8px;
            width: 100%;
            justify-content: center;
        }
        .timer-badge svg { flex-shrink: 0; }
        .timer-badge.ready { background: rgba(46, 168, 79, .1); border-color: rgba(46, 168, 79, .3); color: #2fa84f; }

        /* ============ Result ============ */
        .result { margin-top: 16px; border-radius: 14px; overflow: hidden; padding: 18px; text-align: center; }
        .result.success { background: rgba(46, 168, 79, .1); border: 1px solid rgba(46, 168, 79, .3); color: #26893f; }
        .result.fail { background: rgba(253, 29, 29, .06); border: 1px solid rgba(253, 29, 29, .2); color: var(--ig-red); }
        .result p { margin: 0; font-size: 14px; font-weight: 600; }

        /* ============ Sections ============ */
        .section-title {
            text-align: center;
            font-size: clamp(22px, 3.5vw, 32px);
            font-weight: 800;
            letter-spacing: -0.01em;
            margin-bottom: 26px;
            background: var(--grad);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .step-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 18px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: transform .2s, box-shadow .2s;
        }
        .step-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
        .step-num {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: grid; place-items: center;
            background: var(--grad);
            color: #fff;
            font-weight: 800;
            font-size: 17px;
            margin: 0 auto 14px;
            box-shadow: 0 6px 14px rgba(204, 35, 102, .28);
        }
        .step-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
        .step-card p { font-size: 13px; color: var(--muted); }

        .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px 20px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: transform .2s, box-shadow .2s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
        .feature-card .icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: grid; place-items: center;
            background: rgba(131, 58, 180, .09);
            color: var(--ig-purple);
            margin: 0 auto 14px;
        }
        .feature-card .icon svg { width: 24px; height: 24px; }
        .feature-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .feature-card p { font-size: 14px; color: var(--muted); }

        .info-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: clamp(24px, 4vw, 40px);
            text-align: center;
            box-shadow: var(--shadow-sm);
        }
        .info-section h2 { font-size: clamp(20px, 3vw, 28px); font-weight: 800; margin-bottom: 14px; }
        .info-section p { color: var(--muted); font-size: 15px; max-width: 700px; margin: 0 auto 10px; line-height: 1.7; }
        .info-section p:last-child { margin-bottom: 0; }

        /* ============ FAQ ============ */
        .faq-list { display: flex; flex-direction: column; gap: 12px; }
        .faq-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }
        .faq-q {
            width: 100%;
            background: none;
            border: 0;
            text-align: left;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            padding: 17px 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .faq-q:hover { color: var(--ig-purple); }
        .faq-q .chev { transition: transform .25s; flex-shrink: 0; width: 20px; height: 20px; color: var(--ig-purple); }
        .faq-item.open .faq-q .chev { transform: rotate(180deg); }
        .faq-a { display: none; padding: 0 20px 18px; color: var(--muted); font-size: 14px; }
        .faq-item.open .faq-a { display: block; }
        .faq-a p { margin-bottom: 10px; }
        .faq-a p:last-child { margin-bottom: 0; }

        /* ============ Footer ============ */
        .site-footer {
            margin-top: auto;
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 26px 24px;
            text-align: center;
        }
        .site-footer .footer-links { display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; margin-bottom: 10px; }
        .site-footer a { color: var(--muted); font-size: 14px; font-weight: 600; }
        .site-footer a:hover { color: var(--ig-purple); }
        .site-footer .copy { color: #9a9da6; font-size: 13px; }

        /* ============ Responsive ============ */
        @media (max-width: 768px) {
            .hero { padding-top: 34px; }
            .input-row { flex-direction: column; }
            .btn-find { justify-content: center; }
            .steps { grid-template-columns: repeat(2, 1fr); }
            .features { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .steps { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

{{-- Instagram + heart glyphs, reused across the page --}}
    @php
        $instagramGlyphFilled = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12s.014 3.668.072 4.948c.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24s3.668-.014 4.948-.072c4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948s-.014-3.667-.072-4.947c-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>';
        $heartGlyph = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>';
    @endphp

    <!-- ============ Header (shared, temp-mail light theme) ============ -->
    <x-tool-header brand="Instagram Likes" theme="teal" brandUrl="{{ url('free-instagram-likes') }}">{!! $instagramGlyphFilled !!}</x-tool-header>

    <!-- ============ Hero ============ -->
    <section class="hero">
        <div class="hero-inner">
            <span class="badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                100% Free &middot; No Login &middot; Instant Delivery
            </span>
            <h1>Free Instagram Likes &mdash; Get <span class="grad">10 Free Likes</span></h1>
            <p>Boost your Instagram post, reel or IGTV instantly. Get 10 free likes every 10 minutes. Fast, safe, and no password required.</p>
            <div class="trust-row">
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l8 4v6c0 5.55-3.84 10.74-9 12-5.16-1.26-9-6.45-9-12V6l8-4z"/></svg>
                    100% Free
                </span>
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm1-12h-2v4.58l3.21 2.94 1.32-1.44-2.53-2.3V8z"/></svg>
                    Instant Delivery
                </span>
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    No Password
                </span>
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2.05v2.02c3.95.49 7 3.85 7 7.93 0 1.45-.39 2.81-1.06 3.98l1.46 1.46C21.59 15.67 22 13.89 22 12c0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-1.46-1.46C16.14 17.85 14.18 19 12 19z"/></svg>
                    Every 10 Min
                </span>
            </div>
        </div>
    </section>

    <!-- ============ Main layout ============ -->
    <div class="layout">

        <!-- Tool card -->
        <div class="tool-card">
            <div class="tool-label">
                {!! $instagramGlyphFilled !!}
                Enter your Instagram post URL to get 10 free likes
            </div>

            <form method="POST" action="{{ route('free-instagram-likes-post') }}" class="tool-form" id="form">
                @csrf
                <input type="hidden" name="type" value="INSTA_LIKES">
                <div class="input-row">
                    <input
                        type="text"
                        name="link"
                        value="{{ old('link') }}"
                        placeholder="Paste your Instagram post or reel link"
                        autocomplete="off"
                        spellcheck="false"
                        required
                    />
                    <button type="submit" class="btn-find" id="sendViewsBtn">
                        <span class="btn-label">Request Likes</span>
                        <span class="spinner"></span>
                    </button>
                </div>
                <div class="loading-bar" id="loadingBar"></div>
                <div class="hint">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    <span>Example: <code>https://www.instagram.com/p/C1aBcDeFgHi/</code></span>
                </div>

                @if ($errors->any())
                    <div class="result fail">
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <div class="recaptcha-wrap">
                    <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>
                </div>
            </form>

            @if (Session::has('sucess'))
                <div class="result success">
                    <p>{{ Session::get('sucess') }}</p>
                </div>
            @endif

            <div class="timer-badge" id="countdown">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm1-12h-2v4.58l3.21 2.94 1.32-1.44-2.53-2.3V8z"/></svg>
                <span id="timerText">Ready</span>
            </div>
            <p style="color: var(--muted); font-size: 12px; text-align: center; margin-top: 10px;">Results may vary depending on Instagram activity. Use responsibly.</p>
        </div>

        <!-- Ads -->
        <div class="ad-slot ad-leader hide-mobile"><x-ads.leaderboard /></div>
        <div class="ad-slot show-mobile"><x-ads.mobile-banner /></div>

        {{-- Cross-promo: managed in Admin > Promotions --}}
        <x-promo-banner placement="tools" />

        <!-- How it works -->
        <section>
            <h2 class="section-title">How to Get Free Instagram Likes</h2>
            <div class="steps">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <h3>Visit AutoLikerLive</h3>
                    <p>Open our free Instagram likes tool from any device. No app download needed.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">2</div>
                    <h3>Paste Post URL</h3>
                    <p>Copy your Instagram post, reel or IGTV link and paste it into the field above.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">3</div>
                    <h3>Complete Verification</h3>
                    <p>Quick captcha verification to prevent abuse and keep the service free.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">4</div>
                    <h3>Get 10 Likes</h3>
                    <p>Your likes are delivered within minutes. Repeat every 10 minutes.</p>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section>
            <h2 class="section-title">Why Choose Our Instagram Likes Tool</h2>
            <div class="features">
                <div class="feature-card">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                    </div>
                    <h3>Safe &amp; Secure</h3>
                    <p>No password required. 100% safe and private. Your account stays protected.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">
                        {!! $heartGlyph !!}
                    </div>
                    <h3>Fast Delivery</h3>
                    <p>Likes delivered within minutes. Our system processes requests instantly.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2z"/></svg>
                    </div>
                    <h3>Free to Use</h3>
                    <p>Completely free, no hidden fees. Use unlimited times with a 10-minute cooldown.</p>
                </div>
            </div>
        </section>

        <!-- Info section -->
        <section class="info-section">
            <h2>Boost Your Instagram Post Visibility</h2>
            <p>Getting free Instagram likes is the easiest way to boost a post's visibility. More likes early on signal to the Instagram algorithm that your content is worth pushing, which helps it surface on Explore and in the feed of people who follow similar accounts.</p>
            <p>Our tool delivers 10 likes per request with a 10-minute cooldown, so you can keep growing a post's like count throughout the day. To keep the service genuinely free and fair for everybody, the same post can't be the most recent one in the queue twice &mdash; once someone else submits a post, yours becomes eligible again.</p>
            <p>We are one of the most popular and effective places to promote Instagram posts. Through hard work and dedication, we have become known as one of the best platforms for free Instagram engagement. Users enjoy using our service to boost their content and grow their presence on Instagram.</p>
        </section>

        <!-- FAQ -->
        <section>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <button type="button" class="faq-q">
                        Is the free Instagram likes service safe?
                        <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="faq-a">
                        <p>Yes, our free Instagram likes service is 100% safe. We never ask for your Instagram password or login credentials. You only paste a public post link, so your account stays completely protected.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-q">
                        How many free Instagram likes can I get?
                        <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="faq-a">
                        <p>You get 10 free Instagram likes with every request. You can submit a new request every 10 minutes, making it easy to keep boosting a post throughout the day.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-q">
                        Why can't I submit the same link twice in a row?
                        <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="faq-a">
                        <p>That's our fair-use rule. The same post can only sit at the front of the queue once &mdash; if you try to add it again immediately, you'll get a "please wait your turn" message. Submit any different post (yours or a friend's) and your own becomes eligible again. It's how we stop one person from farming likes on a single post while keeping the tool free for everyone.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-q">
                        How long does it take to receive Instagram likes?
                        <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="faq-a">
                        <p>Likes are typically delivered within minutes after your request is processed. Delivery time may vary depending on current demand and Instagram's processing speed.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-q">
                        Which Instagram URLs are supported?
                        <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="faq-a">
                        <p>We support all standard Instagram links: posts, reels and IGTV. Just paste the URL from the share sheet of your post and we'll handle the rest.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-q">
                        Do I need to create an account?
                        <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>
                    <div class="faq-a">
                        <p>No account creation is required. Simply paste your Instagram post link, complete the verification, and your likes will be delivered automatically.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- ============ Footer ============ -->
    <footer class="site-footer">
        <div class="footer-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('services') }}">All Tools</a>
            <a href="{{ url('privacy') }}">Privacy</a>
            <a href="{{ url('terms') }}">Terms</a>
            <a href="{{ url('contact') }}">Contact</a>
        </div>
        <div class="copy">&copy; autolikerlive.com &mdash; For entertainment purposes only.</div>
    </footer>

    <!-- Back-to-back repeat modal: same post can't go twice in a row -->
    <div id="repeatModal" style="display:none; position:fixed; inset:0; z-index:2000; align-items:center; justify-content:center; padding:18px; background:rgba(22,24,29,.6);">
        <style>
            #repeatModal .repeat-card { background:#fff; border-radius:18px; max-width:440px; width:100%; padding:26px 22px 22px; text-align:center; box-shadow:0 24px 60px rgba(0,0,0,.28); }
            #repeatModal .repeat-icon { width:58px; height:58px; margin:0 auto 12px; border-radius:50%; display:grid; place-items:center; font-size:28px; background:#fdf0f5; }
            #repeatModal h4 { font-weight:800; font-size:19px; margin-bottom:8px; color:#16181d; }
            #repeatModal .repeat-ok { display:inline-block; font-size:12px; font-weight:700; color:#26893f; background:#e9f8ee; border-radius:999px; padding:4px 12px; margin-bottom:12px; }
            #repeatModal p { font-size:14px; color:#4b4f56; margin-bottom:10px; }
            #repeatModal .repeat-share { display:flex; gap:10px; margin-top:14px; }
            #repeatModal .repeat-btn { flex:1; border:0; border-radius:12px; padding:13px 10px; font-size:15px; font-weight:700; cursor:pointer; font-family:inherit; }
            #repeatModal .repeat-btn-share { background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color:#fff; }
            #repeatModal .repeat-btn-ok { background:#f2f4f8; color:#16181d; }
        </style>
        <div class="repeat-card" role="dialog" aria-modal="true" aria-labelledby="repeatModalTitle">
            <div class="repeat-icon">&#9203;</div>
            <h4 id="repeatModalTitle">Please wait your turn</h4>
            <span class="repeat-ok">&#10004; This is not an error</span>
            <p>This exact post was just submitted and is still the <strong>latest one in the queue</strong>.</p>
            <p>Fair-use rule: the same post <strong>can't be added twice in a row</strong>. You can submit this post again <strong>after someone else adds their post</strong>.</p>
            <p>&#128161; <strong>Tip:</strong> share this page with friends &mdash; more people joining means your turn comes faster.</p>
            <div class="repeat-share">
                <button type="button" id="repeatShareBtn" class="repeat-btn repeat-btn-share">Share this page</button>
                <button type="button" id="repeatOkBtn" class="repeat-btn repeat-btn-ok">Got it</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var timeLeft = {{ $timeLeft }};
            var sendViewsBtn = document.getElementById('sendViewsBtn');
            var timerText = document.getElementById('timerText');
            var countdown = document.getElementById('countdown');
            var loadingBar = document.getElementById('loadingBar');
            var form = document.getElementById('form');

            function updateTimer() {
                var minutes = Math.floor(timeLeft / 60);
                var seconds = timeLeft % 60;
                var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

                if (timerText) timerText.textContent = formattedTime;
                countdown.classList.remove('ready');

                if (timeLeft <= 0) {
                    if (timerText) timerText.textContent = 'Ready';
                    countdown.classList.add('ready');
                    sendViewsBtn.disabled = false;
                } else {
                    timeLeft--;
                    sendViewsBtn.disabled = true;
                    setTimeout(updateTimer, 1000);
                }
            }

            var successTime = 30;
            function successMsg() {
                var minutes = Math.floor(successTime / 60);
                var seconds = successTime % 60;
                var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

                if (sendViewsBtn) {
                    sendViewsBtn.innerHTML = '<span class="btn-label">' + formattedTime + '</span>';
                }

                if (successTime <= 0) {
                    if (sendViewsBtn) {
                        sendViewsBtn.innerHTML = '<span class="btn-label">Request Likes</span>';
                    }
                    sendViewsBtn.disabled = false;
                } else {
                    successTime--;
                    sendViewsBtn.disabled = true;
                    setTimeout(successMsg, 1000);
                }
            }

            // ---- Fair-queue: same post can't go twice in a row ----
            var lastInstagramLink = @json($lastInstagramLink ?? null);
            var repeatBlockedFromServer = @json(session('instagram_repeat_blocked', false));

            // Mirror of InstagramController@normalizeInstagramLink.
            function normalizeInstagramLink(u) {
                u = (u || '').trim();
                if (!u) return '';
                var h = u.indexOf('#');
                if (h !== -1) u = u.slice(0, h);
                return u.replace(/\/+$/, '').toLowerCase();
            }

            // Mirror of InstagramController@extractInstagramCode.
            function extractInstagramCode(link) {
                link = (link || '').trim();
                if (!link) return '';
                var m = link.match(/instagram\.com\/(?:[^/?]+\/)?(?:p|reel|reels|tv|share)\/([A-Za-z0-9_-]+)/i);
                if (m) return m[1];
                m = link.match(/^(?:https?:\/\/)?(?:www\.)?instagram\.com\/?([A-Za-z0-9_-]{5,})\/?/i);
                if (m) return m[1];
                if (/^[A-Za-z0-9_-]{5,}$/.test(link)) return link;
                return '';
            }

            function openRepeatModal() {
                var m = document.getElementById('repeatModal');
                if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
            }
            function closeRepeatModal() {
                var m = document.getElementById('repeatModal');
                if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
            }

            function sharePage() {
                var data = {
                    title: document.title,
                    text: 'Get free Instagram likes — join me here:',
                    url: window.location.href
                };
                if (navigator.share) {
                    navigator.share(data).catch(function () {});
                } else if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(data.url).then(function () {
                        alert('Link copied! Share it with your friends.');
                    }).catch(function () {
                        prompt('Copy and share this link:', data.url);
                    });
                } else {
                    prompt('Copy and share this link:', data.url);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                var ok = document.getElementById('repeatOkBtn');
                if (ok) ok.addEventListener('click', closeRepeatModal);
                var share = document.getElementById('repeatShareBtn');
                if (share) share.addEventListener('click', sharePage);
                var modal = document.getElementById('repeatModal');
                if (modal) modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeRepeatModal();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeRepeatModal();
                });
                if (repeatBlockedFromServer) openRepeatModal();
            });

            if (form) {
                form.addEventListener('submit', function (e) {
                    var linkInput = form.querySelector('input[name="link"]');
                    var code = extractInstagramCode(linkInput ? linkInput.value : '');
                    var current = normalizeInstagramLink(code);
                    if (current && lastInstagramLink && current === normalizeInstagramLink(lastInstagramLink)) {
                        e.preventDefault();
                        openRepeatModal();
                        return false;
                    }
                    sendViewsBtn.classList.add('loading');
                    sendViewsBtn.disabled = true;
                    loadingBar.classList.add('active');
                });
            }

            if ({{ Session::has('sucess') ? 'true' : 'false' }}) {
                successMsg();
            } else {
                updateTimer();
            }

            var faqQs = document.querySelectorAll('.faq-q');
            faqQs.forEach(function (q) {
                q.addEventListener('click', function () {
                    var item = q.parentElement;
                    var isOpen = item.classList.contains('open');
                    faqQs.forEach(function (other) {
                        other.parentElement.classList.remove('open');
                    });
                    if (!isOpen) item.classList.add('open');
                });
            });
        })();
    </script>
@include('components.chat-widget')
</body>
</html>