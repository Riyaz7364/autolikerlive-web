<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="revisit-after" content="1 days" />
    <meta name="googlebot" content="index, follow" />
    <meta name="robots" content="all" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ request()->url() }}" />
    <title>{{ __('messages.igCommentLiker.meta_title') }} - AutoLikerLive</title>
    <meta name="description" content="{{ __('messages.igCommentLiker.meta_desc') }}">
    <meta name="keywords" content="Instagram comment liker, Increase Instagram comment likes, Best Instagram comment liker 2025, Auto comment liker for Instagram, Get more Instagram comment likes, How to increase Instagram comment likes fast, Best tools to get Instagram comment likes in 2025, Instagram auto comment liker without login, Free Instagram comment liker tool, How to boost Instagram engagement with comment likes, Instagram engagement booster, Social media auto liker 2025, How to get organic Instagram comment likes, Instagram growth hacks 2025, Boost Instagram comments and likes">

    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ __('messages.igCommentLiker.meta_title') }}" />
    <meta property="og:description" content="{{ __('messages.igCommentLiker.meta_desc') }}" />
    <meta property="og:image" content="{{ url('/storage/instaliker_logo.webp') }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ Request::url() }}" />
    <meta name="twitter:title" content="{{ __('messages.igCommentLiker.meta_title') }}" />
    <meta name="twitter:description" content="{{ __('messages.igCommentLiker.meta_desc') }}" />
    <meta name="twitter:image" content="{{ url('/storage/instaliker/app_logo.webp') }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/storage/instaliker/apple-touch-icon.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ url('/storage/instaliker/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ url('/storage/instaliker/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/storage/instaliker/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ url('/storage/instaliker/site.webmanifest') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933" crossorigin="anonymous"></script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "SoftwareApplication",
          "name": "InstaLiker - Instagram Comment Liker",
          "applicationCategory": "SocialNetworkingApplication",
          "operatingSystem": "Android",
          "softwareVersion": "{{ $instaApp->version ?? '1.0.0' }}",
          "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
          "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.8", "ratingCount": "12480" },
          "url": "{{ url('instagram-comment-liker') }}",
          "image": "{{ url('/storage/instaliker/app_logo.webp') }}",
          "description": "Auto-like Instagram comments on any post. Connect your Instagram account, fast, secure and fully automatic."
        },
        {
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
            { "@type": "ListItem", "position": 2, "name": "Free Tools", "item": "{{ url('services') }}" },
            { "@type": "ListItem", "position": 3, "name": "Instagram Comment Liker", "item": "{{ url('instagram-comment-liker') }}" }
          ]
        },
        {
          "@type": "FAQPage",
          "mainEntity": [
            { "@type": "Question", "name": "What is Instagram Comment Liker?", "acceptedAnswer": { "@type": "Answer", "text": "Instagram Comment Liker is a free Android tool by AutoLikerLive that automatically likes Instagram comments on any post to boost engagement, visibility and follower growth." } },
            { "@type": "Question", "name": "Do I need to keep my browser open?", "acceptedAnswer": { "@type": "Answer", "text": "No. Install the InstaLiker APK, log in once, and auto comment likes run automatically. No need to keep your browser open or computer on." } },
            { "@type": "Question", "name": "Is Instagram Comment Liker free and safe?", "acceptedAnswer": { "@type": "Answer", "text": "Yes, it is free to use. Your login is used only to process your likes, and the app uses secure connection handling." } },
            { "@type": "Question", "name": "How fast will I see results?", "acceptedAnswer": { "@type": "Answer", "text": "Most users see auto-likes start within minutes after connecting their account and selecting posts. Results vary by account activity." } }
          ]
        }
      ]
    }
    </script>

    <style>
        :root{
            --icl-purple:#6d28d9; --icl-pink:#ee2a7b; --icl-orange:#f97316;
            --icl-ink:#0f0f1a; --icl-muted:#6b7280; --icl-border:#e9e4f5;
            --icl-grad:linear-gradient(90deg,#4f46e5 0%,#7c3aed 28%,#d6248c 62%,#f97316 100%);
        }
        *{box-sizing:border-box}
        html{-webkit-text-size-adjust:100%}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;color:var(--icl-ink);
            background:radial-gradient(1000px 480px at 12% -10%,rgba(168,85,247,.12),transparent 60%),
            radial-gradient(1000px 480px at 88% -10%,rgba(249,115,22,.12),transparent 60%),#fff;
            min-height:100vh;display:flex;flex-direction:column;line-height:1.55;margin:0}
        a{text-decoration:none}
        /* ===== Slim standalone header (like temp-mail, InstaLiker themed) ===== */
        .icl-topbar{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.94);backdrop-filter:blur(10px);border-bottom:1px solid var(--icl-border)}
        .icl-topbar-inner{max-width:1120px;margin:0 auto;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;gap:12px}
        .icl-topbrand{display:flex;align-items:center;gap:12px;color:var(--icl-ink);font-weight:800;font-size:18px}
        .icl-topbrand:hover{color:var(--icl-ink)}
        .icl-topbrand img{width:42px;height:42px;border-radius:12px;box-shadow:0 6px 16px rgba(124,58,237,.35)}
        .icl-topbrand small{display:block;font-size:12px;font-weight:500;color:var(--icl-muted);line-height:1.1}
        .icl-top-links{display:flex;align-items:center;gap:10px}
        .icl-ghost{border:1px solid var(--icl-border);background:#fff;color:var(--icl-ink);font-weight:600;font-size:14px;padding:9px 16px;border-radius:10px;transition:.2s}
        .icl-ghost:hover{border-color:var(--icl-purple);color:var(--icl-purple)}
        .icl-dl{background:var(--icl-grad);color:#fff!important;border:0;box-shadow:0 6px 16px rgba(214,36,140,.35)}
        .icl-dl:hover{filter:brightness(1.05);color:#fff}
        .hide-sm{display:inline-block}
        /* ===== Page layout (no sidebar) ===== */
        .icl-wrap{width:100%;margin:0 auto;padding:18px 24px 44px;display:flex;flex-direction:column;gap:26px}
        .icl-hero{position:relative;overflow:hidden;background:#fff;border-radius:28px;border:1px solid #f3f4f6;
            box-shadow:0 20px 60px rgba(109,40,217,.08);padding:clamp(1.75rem,4vw,3.5rem)}
        .icl-hero::before{content:'';position:absolute;width:560px;height:560px;left:-180px;top:-220px;
            background:radial-gradient(closest-side,rgba(168,85,247,.45),rgba(168,85,247,0) 70%);filter:blur(10px);pointer-events:none}
        .icl-hero::after{content:'';position:absolute;width:640px;height:640px;right:-220px;top:-240px;
            background:radial-gradient(closest-side,rgba(249,115,22,.45),rgba(249,115,22,0) 70%);filter:blur(10px);pointer-events:none}
        .icl-blob-bottom{position:absolute;width:520px;height:520px;right:-160px;bottom:-260px;
            background:radial-gradient(closest-side,rgba(238,42,123,.35),rgba(238,42,123,0) 70%);filter:blur(10px);pointer-events:none}
        .icl-hero-inner{position:relative;z-index:1}
        .icl-crumbs{font-size:.85rem;color:var(--icl-muted);margin-bottom:1rem}
        .icl-crumbs a{color:var(--icl-muted)}
        .icl-crumbs a:hover{color:var(--icl-purple)}
        .icl-app-icon{width:96px;height:96px;border-radius:26px;background:#fff;box-shadow:0 12px 32px rgba(0,0,0,.12);
            display:flex;align-items:center;justify-content:center;overflow:hidden;margin:0 auto}
        .icl-app-icon img{width:100%;height:100%;object-fit:cover}
        .icl-brand{font-weight:800;font-size:clamp(1.8rem,4vw,2.6rem);letter-spacing:-.02em;text-align:center;
            background:linear-gradient(90deg,#f97316 0%,#ee2a7b 48%,#7c3aed 100%);
            -webkit-background-clip:text;background-clip:text;color:transparent;margin:.75rem 0 .15rem}
        .icl-tagline{color:var(--icl-muted);text-align:center;font-size:1.02rem}
        .icl-h1{font-weight:800;letter-spacing:-.03em;line-height:1.08;text-align:center;
            font-size:clamp(1.7rem,4.5vw,2.9rem);margin:1.1rem auto .75rem;max-width:18ch;color:#111}
        .icl-checks{list-style:none;padding:0;margin:1rem auto 0;max-width:520px;display:grid;gap:.6rem}
        .icl-checks li{display:flex;gap:.65rem;align-items:flex-start;color:#374151;font-size:1rem}
        .icl-checks .ic{flex:0 0 22px;width:22px;height:22px;border-radius:999px;display:flex;align-items:center;justify-content:center;
            background:linear-gradient(135deg,#fdf2f8,#fff7ed);font-size:.85rem}
        .icl-cta-row{display:flex;flex-direction:column;gap:.75rem;margin-top:1.5rem}
        @media(min-width:576px){.icl-cta-row{flex-direction:row;justify-content:center;align-items:center}}
        .icl-btn-insta{display:flex;align-items:center;gap:.9rem;justify-content:space-between;width:100%;
            max-width:520px;margin:0 auto;padding:1rem 1.25rem;border-radius:20px;color:#fff;background:var(--icl-grad);
            box-shadow:0 16px 36px rgba(214,36,140,.35);transition:transform .2s ease,box-shadow .2s ease}
        .icl-btn-insta:hover{color:#fff;transform:translateY(-2px);box-shadow:0 20px 44px rgba(214,36,140,.45)}
        .icl-btn-insta .left{display:flex;align-items:center;gap:.85rem;text-align:left}
        .icl-btn-insta .ig-badge{width:52px;height:52px;border-radius:16px;background:rgba(255,255,255,.22);
            display:flex;align-items:center;justify-content:center;font-size:1.6rem}
        .icl-btn-insta strong{display:block;font-size:1.1rem;line-height:1.2}
        .icl-btn-insta small{display:block;opacity:.9;font-size:.86rem}
        .icl-secure{display:flex;align-items:center;justify-content:center;gap:.45rem;color:var(--icl-muted);font-size:.88rem;margin-top:.85rem}
        .icl-stars{display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.6rem;font-size:.9rem;color:#374151;flex-wrap:wrap}
        .icl-stars .stars{color:#f59e0b;letter-spacing:2px}
        .icl-phone{width:min(300px,86vw);margin:0 auto;background:#fff;border-radius:36px;border:1px solid #eee;
            box-shadow:0 30px 70px rgba(0,0,0,.14);overflow:hidden;position:relative}
        .icl-phone-top{display:flex;justify-content:space-between;align-items:center;padding:.7rem 1rem .2rem;font-size:.78rem;color:#111;font-weight:600}
        .icl-phone-body{padding:1.2rem 1.2rem 1.6rem;text-align:center;position:relative;overflow:hidden}
        .icl-phone-body::before{content:'';position:absolute;width:280px;height:280px;left:-90px;top:-60px;
            background:radial-gradient(closest-side,rgba(168,85,247,.4),transparent 70%)}
        .icl-phone-body::after{content:'';position:absolute;width:300px;height:300px;right:-110px;top:-70px;
            background:radial-gradient(closest-side,rgba(249,158,52,.55),transparent 70%)}
        .icl-phone-inner{position:relative;z-index:1}
        .icl-phone-icon{width:84px;height:84px;border-radius:24px;margin:1.2rem auto .6rem;overflow:hidden;box-shadow:0 10px 26px rgba(0,0,0,.15)}
        .icl-phone-icon img{width:100%;height:100%;object-fit:cover}
        .icl-phone-brand{font-weight:800;font-size:1.7rem;background:linear-gradient(90deg,#f97316,#b5179e,#6d28d9);
            -webkit-background-clip:text;background-clip:text;color:transparent}
        .icl-phone-sub{color:#6b7280;font-size:.88rem;margin-bottom:.9rem}
        .icl-phone-h{font-weight:800;font-size:1.28rem;line-height:1.2;color:#111;margin:.4rem 0 .9rem}
        .icl-phone-feat{text-align:left;font-size:.82rem;color:#4b5563;display:grid;gap:.5rem;margin-bottom:1.1rem}
        .icl-phone-btn{display:flex;align-items:center;gap:.6rem;background:linear-gradient(90deg,#5b5bd6,#a855f7 40%,#ec4899 75%,#f97316);
            color:#fff;border-radius:18px;padding:.8rem .9rem;font-size:.82rem}
        .icl-phone-btn .b{width:38px;height:38px;border-radius:12px;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;font-size:1.2rem}
        .icl-phone-btn strong{display:block;font-size:.9rem}
        .icl-phone-note{font-size:.7rem;color:#6b7280;margin-top:.6rem}
        .icl-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:.8rem;margin-top:1.25rem}
        @media(min-width:768px){.icl-stats{grid-template-columns:repeat(4,1fr)}}
        .icl-stat{background:#faf5ff;border:1px solid #f3e8ff;border-radius:18px;padding:1rem;text-align:center}
        .icl-stat strong{display:block;font-size:1.35rem}
        .icl-stat span{color:var(--icl-muted);font-size:.86rem}
        .icl-section{padding:clamp(1.25rem,3vw,2rem) 0}
        .icl-card{background:#fff;border:1px solid #f3f4f6;border-radius:22px;padding:clamp(1.25rem,3vw,2rem);box-shadow:0 10px 30px rgba(0,0,0,.05)}
        .icl-h2{font-weight:800;letter-spacing:-.02em;font-size:clamp(1.35rem,3vw,2rem);margin-bottom:.5rem;color:#111}
        .icl-lead{color:#4b5563;font-size:1.02rem;max-width:62ch}
        .icl-steps{display:grid;gap:1rem;margin-top:1.25rem}
        @media(min-width:768px){.icl-steps{grid-template-columns:repeat(3,1fr)}}
        .icl-step{background:#fff;border:1px solid #f3f4f6;border-radius:20px;padding:1.25rem;box-shadow:0 10px 30px rgba(0,0,0,.06)}
        .icl-step .n{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;
            font-weight:800;color:#fff;background:linear-gradient(135deg,var(--icl-purple),var(--icl-pink),var(--icl-orange))}
        .icl-feat-grid{display:grid;gap:1rem;margin-top:1.25rem}
        @media(min-width:768px){.icl-feat-grid{grid-template-columns:repeat(2,1fr)}}
        .icl-feat{border:1px solid #f3f4f6;border-radius:20px;padding:1.25rem;background:linear-gradient(180deg,#fff,#fff7ed 160%)}
        .icl-feat h3{font-size:1.05rem;margin:.6rem 0 .35rem}
        .icl-feat p{color:#4b5563;margin:0;font-size:.95rem}
        .icl-video{border-radius:20px;overflow:hidden;box-shadow:0 16px 44px rgba(0,0,0,.12);background:#000}
        .icl-video iframe{width:100%;height:100%;min-height:300px;border:0;display:block}
        @media(min-width:768px){.icl-video iframe{min-height:380px}}
        .icl-faq details{border:1px solid #f3f4f6;border-radius:16px;padding:1rem 1.1rem;background:#fff;margin-bottom:.7rem}
        .icl-faq summary{font-weight:700;cursor:pointer;list-style:none}
        .icl-faq summary::-webkit-details-marker{display:none}
        .icl-faq details p{color:#4b5563;margin:.6rem 0 0}
        .icl-tools{display:flex;flex-wrap:wrap;gap:.6rem;margin-top:1rem}
        .icl-tools a{padding:.6rem 1rem;border-radius:999px;background:#f5f3ff;color:#5b21b6;font-weight:600;font-size:.9rem;border:1px solid #ede9fe}
        .icl-tools a:hover{background:#ede9fe}
        .icl-final{background:linear-gradient(120deg,#4c1d95 0%,#a21caf 55%,#f97316 110%);border-radius:24px;color:#fff;
            padding:clamp(1.5rem,4vw,2.5rem);text-align:center;box-shadow:0 20px 50px rgba(162,28,175,.35)}
        .icl-final a{display:inline-flex;align-items:center;gap:.6rem;background:#fff;color:#7c2d12;font-weight:800;
            padding:.95rem 1.8rem;border-radius:999px;margin-top:1rem}
        .ad-label{font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;color:#9ca3af;margin-bottom:.35rem}
        .ad-slot{overflow:hidden;text-align:center;margin:6px auto;padding:6px 0;max-width:1120px}
        .wordpress{color:#111}
        .wordpress p,.wordpress li{color:#374151!important;line-height:1.75}
        .wordpress h2,.wordpress h3{color:#111!important;margin-top:1.4rem}
        .wordpress img{max-width:100%;height:auto;border-radius:14px}
        /* ===== Footer navbar (main nav moved here) ===== */
        .icl-footer{margin-top:auto;background:#fff;border-top:1px solid var(--icl-border);padding:34px 24px 90px}
        .icl-footer-inner{max-width:1120px;margin:0 auto}
        .icl-footer-grid{display:grid;gap:24px}
        @media(min-width:768px){.icl-footer-grid{grid-template-columns:1.3fr 1fr 1fr}}
        .icl-footer h4{font-size:14px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:#111;margin-bottom:12px}
        .icl-footer-brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:17px;color:#111}
        .icl-footer-brand img{width:38px;height:38px;border-radius:10px}
        .icl-footer p{color:var(--icl-muted);font-size:14px}
        .icl-footer-links{display:grid;gap:8px}
        .icl-footer-links a{color:#4b5563;font-size:14px;font-weight:500}
        .icl-footer-links a:hover{color:var(--icl-purple)}
        .icl-footer-bottom{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-top:24px;padding-top:16px;border-top:1px solid #f3f4f6;color:#9ca3af;font-size:13px}
        @media(max-width:960px){.hide-sm{display:none}}
    </style>
</head>
<body>

    <!-- ===== Standalone header (no main navbar) ===== -->
    <header class="icl-topbar">
        <div class="icl-topbar-inner">
            <a href="{{ url('/') }}" class="icl-topbrand">
                <img src="{{ url('/storage/instaliker/app_logo.webp') }}" alt="InstaLiker logo" width="42" height="42">
                <span>InstaLiker<small>by AutoLikerLive</small></span>
            </a>
            <div class="icl-top-links">
                <a href="{{ url('services') }}" class="icl-ghost hide-sm">All Tools</a>
                <a href="{{ url('/') }}" class="icl-ghost">Home</a>
                <a href="{{ $instaApkUrl ?? url('download') }}" class="icl-ghost icl-dl">⬇ Download APK</a>
            </div>
        </div>
    </header>

    <div class="icl-wrap">
        @php
            // Official InstaLiker app for this page (Admin > App Updates > instaliker).
            // Direct APK link when uploaded, otherwise the generic download page.
            $instaApkUrl = ($instaApp ?? null) && !empty($instaApp->apk_path)
                ? route('apk.download.app', $instaApp->app_name)
                : url('download');
        @endphp
        <nav class="icl-crumbs" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a> &nbsp;/&nbsp;
            <a href="{{ url('services') }}">Free Tools</a> &nbsp;/&nbsp;
            <span aria-current="page">Instagram Comment Liker</span>
        </nav>

        {{-- HERO — mirrors app main screen theme --}}
        <header class="icl-hero">
            <div class="icl-blob-bottom"></div>
            <div class="icl-hero-inner">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <div class="icl-app-icon">
                            <img src="{{ url('/storage/instaliker/app_logo.webp') }}"
                                 alt="InstaLiker - Instagram Comment Liker app icon" width="96" height="96" fetchpriority="high">
                        </div>
                        <div class="icl-brand" aria-hidden="true">InstaLiker</div>
                        <p class="icl-tagline">Instagram Comment Liker</p>

                        <h1 class="icl-h1">{{ __('messages.igCommentLiker.title') }} — Grow your engagement, effortlessly.</h1>
                        <p class="text-center text-muted mx-auto" style="max-width:58ch">{{ __('messages.igCommentLiker.subtitle') }}</p>

                        <ul class="icl-checks">
                            <li><span class="ic">✨</span><span>Connect your Instagram account</span></li>
                            <li><span class="ic">💗</span><span>Auto-like comments on any post</span></li>
                            <li><span class="ic">⚡</span><span>Fast, secure, fully automatic</span></li>
                        </ul>

                        <div class="icl-cta-row">
                            <a href="{{ $instaApkUrl }}" class="icl-btn-insta" aria-label="Download Comment Liker APK">
                                <span class="left">
                                    <span class="ig-badge" aria-hidden="true">📸</span>
                                    <span><strong>Download Comment Liker APK</strong><small>Securely connect your account</small></span>
                                </span>
                                <span aria-hidden="true" style="font-size:1.5rem">→</span>
                            </a>
                        </div>
                        <div class="icl-secure">🔒 Your login is used only to process your likes</div>
                        <div class="icl-stars"><span class="stars" aria-hidden="true">★★★★★</span><span><strong>4.8/5</strong> · 12,480+ reviews · 1M+ downloads · Free</span></div>

                        <div class="icl-stats" aria-label="App highlights">
                            <div class="icl-stat"><strong>1M+</strong><span>Downloads</span></div>
                            <div class="icl-stat"><strong>4.8 ★</strong><span>Average rating</span></div>
                            <div class="icl-stat"><strong>500K+</strong><span>Happy users</span></div>
                            <div class="icl-stat"><strong>⚡ Fast</strong><span>Auto likes in minutes</span></div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="icl-phone" role="img" aria-label="InstaLiker app main screen preview: Grow your engagement effortlessly, login with Instagram">
                            <div class="icl-phone-top"><span>11:37</span><span>📶 🔋 90</span></div>
                            <div class="icl-phone-body">
                                <div class="icl-phone-inner">
                                    <div class="icl-phone-icon">
                                        <img src="{{ url('/storage/instaliker/app_logo.webp') }}" alt="InstaLiker logo" width="84" height="84" loading="lazy">
                                    </div>
                                    <div class="icl-phone-brand">InstaLiker</div>
                                    <div class="icl-phone-sub">Instagram Comment Liker</div>
                                    <div class="icl-phone-h">Grow your engagement, effortlessly.</div>
                                    <div class="icl-phone-feat">
                                        <div>✨ Connect your Instagram account</div>
                                        <div>💗 Auto-like comments on any post</div>
                                        <div>⚡ Fast, secure, fully automatic</div>
                                    </div>
                                    <div class="icl-phone-btn">
                                        <span class="b">📷</span>
                                        <span style="text-align:left"><strong>Login with Instagram</strong><span>Securely connect your account</span></span>
                                        <span style="margin-left:auto">→</span>
                                    </div>
                                    <div class="icl-phone-note">🔒 Your login is used only to process your likes</div>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-muted small mt-2 mb-0">App preview — same look &amp; feel as the InstaLiker APK</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="text-center" role="complementary" aria-label="Advertisement">
            <div class="ad-label">Advertisement</div>
            <div class="ad-slot"><x-ads.leaderboard /></div>
            <div class="ad-slot"><x-ads.mobile-banner /></div>
        </div>

        {{-- Official app of this page — details pulled from Admin > App Updates (instaliker) --}}
        <section class="icl-card" aria-labelledby="icl-app">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <img src="{{ url('/storage/instaliker/app_logo.webp') }}" alt="InstaLiker app icon" width="64" height="64"
                     style="border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,.12)" loading="lazy">
                <div>
                    <h2 class="icl-h2 mb-1" id="icl-app">InstaLiker — Official App of This Page</h2>
                    <p class="icl-lead mb-0">This InstaLiker app belongs to this page (Instagram Comment Liker). Install it on Android and auto-like comments from your phone — no browser needed.</p>
                </div>
            </div>
            <div class="icl-stats" aria-label="InstaLiker app details">
                <div class="icl-stat"><strong>{{ $instaApp->name ?? 'InstaLiker' }}</strong><span>App name</span></div>
                <div class="icl-stat"><strong>v{{ $instaApp->version ?? '1.0.0' }} ({{ $instaApp->release_code ?? 1 }})</strong><span>Version (code)</span></div>
                <div class="icl-stat"><strong>{{ ($instaApp ?? null) && $instaApp->apk_size ? number_format($instaApp->apk_size / 1024 / 1024, 1) . ' MB' : '—' }}</strong><span>APK size</span></div>
                <div class="icl-stat"><strong>{{ ($instaApp ?? null) && $instaApp->updated_at ? $instaApp->updated_at->format('M Y') : '—' }}</strong><span>Updated</span></div>
            </div>
            <div class="icl-cta-row">
                <a href="{{ $instaApkUrl }}" class="icl-btn-insta" aria-label="Download InstaLiker APK">
                    <span class="left">
                        <span class="ig-badge" aria-hidden="true">⬇</span>
                        <span><strong>Download {{ $instaApp->name ?? 'InstaLiker' }} APK</strong><small>{{ ($instaApp ?? null) && $instaApp->apk_path ? 'File: ' . $instaApp->download_filename : 'Free · Android' }}</small></span>
                    </span>
                    <span aria-hidden="true" style="font-size:1.5rem">→</span>
                </a>
            </div>
            <div class="icl-secure">🔒 Always download from autolikerlive.com — free &amp; secure</div>
        </section>

        <section class="icl-card" aria-labelledby="icl-how">
            <h2 class="icl-h2" id="icl-how">How Instagram Comment Liker works</h2>
            <p class="icl-lead">{{ __('messages.igCommentLiker.p1') }}</p>
            <div class="icl-steps">
                <div class="icl-step"><div class="n">1</div><h3 class="h5 mt-3 mb-1">Install the app</h3><p class="text-muted mb-0">Download the free Comment Liker APK from AutoLikerLive and install it on Android.</p></div>
                <div class="icl-step"><div class="n">2</div><h3 class="h5 mt-3 mb-1">Connect Instagram</h3><p class="text-muted mb-0">Log in securely. Your session is used only to process likes — nothing else.</p></div>
                <div class="icl-step"><div class="n">3</div><h3 class="h5 mt-3 mb-1">Auto-like &amp; grow</h3><p class="text-muted mb-0">{{ __('messages.igCommentLiker.p2') }}</p></div>
            </div>
        </section>

        <section class="icl-card" aria-labelledby="icl-features">
            <h2 class="icl-h2" id="icl-features">What this Instagram automation does for you</h2>
            <p class="icl-lead">This Instagram automation helps you boost social proof on autopilot — perfect for creators, brands and giveaway posts.</p>
            <div class="icl-feat-grid">
                <div class="icl-feat"><div style="font-size:1.6rem">📋</div><h3>Auto like a list of posts</h3><p>Auto like comments from any Instagram account — paste a post link or pick from a list and let InstaLiker handle the rest.</p></div>
                <div class="icl-feat"><div style="font-size:1.6rem">💬</div><h3>Auto like comments of posts</h3><p>Push your favourite comment to the top. More comment likes means more visibility in Instagram's ranking.</p></div>
                <div class="icl-feat"><div style="font-size:1.6rem">📈</div><h3>Increase followers via engagement</h3><p>Higher engagement signals bring profile visits and organic followers — the growth hack behind viral comments.</p></div>
                <div class="icl-feat"><div style="font-size:1.6rem">🎁</div><h3>Daily comment likes with APK</h3><p>Gather new Instagram comment likes daily by using the AutoLikerLive APK. No browser, no PC needed.</p></div>
            </div>
            <ul class="mt-3 text-muted">
                {!! __('messages.igCommentLiker.list') !!}
            </ul>
        </section>

        <section class="icl-card" aria-labelledby="icl-video">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <h2 class="icl-h2" id="icl-video">Watch: get Instagram comment likes fast</h2>
                    <p class="icl-lead">See how to install InstaLiker, connect your account and start auto-liking comments. Prefer reading? The step-by-step guide below covers everything.</p>
                    <ul class="text-muted">
                        <li>Best for giveaways, brand posts &amp; pinned comments</li>
                        <li>Works without keeping your browser open</li>
                        <li>Free to start — upgrade only if you need more volume</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="icl-video">
                        <iframe src="https://www.youtube.com/embed/s2usWoxDhJ0?si=6HqJb2f8n_YOmkvu" title="Instagram Comment Liker tutorial — how to auto like Instagram comments" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>

        <div class="text-center" role="complementary" aria-label="Advertisement">
            <div class="ad-label">Advertisement</div>
            <div class="ad-slot"><x-ads.in-article /></div>
        </div>

        <article class="icl-card" aria-labelledby="icl-guide">
            <h2 class="icl-h2" id="icl-guide">{{ isset($posts->title) ? $posts->title : 'Instagram Comment Liker: complete guide 2026' }}</h2>
            <div class="wordpress">{!! isset($posts->content) ? $posts->content : '' !!}</div>

            <h3 class="h4 mt-4">Why comment likes boost your Instagram reach</h3>
            <p class="text-muted">Instagram ranks comments partly by likes. A comment with hundreds of likes stays pinned near the top, earns replies, profile taps and follows. Using a <strong>free Instagram comment liker tool</strong> is one of the fastest, safest ways to <strong>boost Instagram engagement with comment likes</strong> without buying followers.</p>
            <h3 class="h4 mt-3">How to increase Instagram comment likes fast</h3>
            <p class="text-muted">1) Post early on high-traffic reels. 2) Pin your best comment. 3) Run it through InstaLiker to <strong>get more Instagram comment likes</strong> in minutes. 4) Reply to everyone — conversation velocity keeps you ranked. Repeat daily for compounding <strong>organic Instagram growth</strong>.</p>
        </article>

        <section class="icl-card icl-faq" aria-labelledby="icl-faq">
            <h2 class="icl-h2" id="icl-faq">Instagram Comment Liker — FAQs</h2>
            <details open><summary>What is Instagram Comment Liker?</summary><p>The Instagram Comment Liker generates likes for your Instagram comments. Increase engagement on repeat with this auto like tool — ideal for creators, businesses and giveaway hosts.</p></details>
            <details><summary>Is it free?</summary><p>Yes. Download the APK free and start with daily comment likes. The app also offers free Instagram likes, TikTok views/likes and more tools inside AutoLikerLive.</p></details>
            <details><summary>Do I need to keep my browser open?</summary><p>No. Install the app, log in once, and automation runs for you. No need to keep your browser open or computer on.</p></details>
            <details><summary>Is my login safe?</summary><p>Your login is used only to process your likes over a secure connection. Never share OTPs, and download only from autolikerlive.com or Google Play.</p></details>
            <details><summary>How fast will I see results?</summary><p>Most users see likes start within minutes. Speed depends on account standing and post volume — consistent daily use gives the best growth.</p></details>
        </section>

        <section class="icl-final" aria-labelledby="icl-dl">
            <h2 id="icl-dl" class="h3 fw-bold mb-2">Ready to grow your engagement, effortlessly?</h2>
            <p class="mb-0 opacity-75">Join 500K+ users auto-liking Instagram comments with InstaLiker.</p>
            <a href="{{ $instaApkUrl }}" aria-label="Download Comment Liker APK free">⬇ Download Comment Liker APK — Free</a>
            <div class="small mt-2 opacity-75">Android · v{{ $instaApp->release_code ?? 1 }} ({{ $instaApp->version ?? '1.0.0' }}) · Updated {{ ($instaApp ?? null) && $instaApp->updated_at ? $instaApp->updated_at->format('M Y') : '—' }} · 🔒 Secure download</div>
        </section>
    </div>

    <!-- ===== Footer with full navbar (moved out of header) ===== -->
    <footer class="icl-footer">
        <div class="icl-footer-inner">
            <div class="icl-footer-grid">
                <div>
                    <a href="{{ url('/') }}" class="icl-footer-brand">
                        <img src="{{ url('/storage/instaliker/app_logo.webp') }}" alt="AutoLikerLive logo" width="38" height="38">
                        AutoLikerLive
                    </a>
                    <p class="mt-2">Free social growth tools — FB auto liker, Instagram comment liker, TikTok views &amp; likes, SMS bomber and temp mail.</p>
                </div>
                <nav aria-label="Free tools">
                    <h4>🔧 Free Tools</h4>
                    <div class="icl-footer-links">
                        <a href="{{ url('services') }}">🔧 All Free Tools</a>
                        <a href="{{ url('auto-liker-1000-likes') }}">👍 FB Auto Liker</a>
                        <a href="{{ url('instagram-comment-liker') }}">📸 IG Comment Liker</a>
                        <a href="{{ route('free-tiktok-views') }}">📹 TikTok Views</a>
                        <a href="{{ route('free-tiktok-likes') }}">❤️ TikTok Likes</a>
                        <a href="{{ route('free-instagram-likes') }}">📸 Instagram Likes</a>
                        <a href="{{ route('sms-bomber') }}">💬 SMS Bomber</a>
                        <a href="{{ route('temp-mail') }}">📧 Temp Mail</a>
                    </div>
                </nav>
                <nav aria-label="Quick links">
                    <h4>Quick Links</h4>
                    <div class="icl-footer-links">
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{ url('download') }}">Download APK</a>
                        <a href="{{ url('privacy') }}">Privacy Policy</a>
                        <a href="{{ url('terms') }}">Terms of Service</a>
                        <a href="{{ url('contact') }}">Contact Us</a>
                    </div>
                </nav>
            </div>
            <div class="icl-footer-bottom">
                <span>&copy; autolikerlive.com — For entertainment purposes only.</span>
                <span><a href="{{ url('/') }}" style="color:#9ca3af">Games</a> · <a href="{{ url('services') }}" style="color:#9ca3af">Free Tools</a> · <a href="{{ url('auto-liker-1000-likes') }}" style="color:#9ca3af">FB Auto Liker</a></span>
            </div>
        </div>
    </footer>

    <x-bottom-ad></x-bottom-ad>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
