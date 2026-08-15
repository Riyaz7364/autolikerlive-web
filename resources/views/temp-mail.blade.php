<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="temp mail, temporary email, disposable email, fake email, 10 minute email, email burner, anonymous email, free temp mail">
    <link rel="canonical" href="{{ url()->current() }}" />
    <title>{{ __('messages.tempMail.meta_title') }}</title>
    <meta name="description" content="{{ __('messages.tempMail.meta_desc') }}">
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ __('messages.tempMail.meta_title') }}" />
    <meta property="og:description" content="{{ __('messages.tempMail.meta_desc') }}" />
    <meta property="og:image" content="https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ Request::url() }}" />
    <meta name="twitter:title" content="{{ __('messages.tempMail.meta_title') }}" />
    <meta name="twitter:description" content="{{ __('messages.tempMail.meta_desc') }}" />
    <meta name="twitter:image" content="https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Roboto+Mono:wght@500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933" crossorigin="anonymous"></script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "Temp Mail",
  "applicationCategory": "UtilitiesApplication",
  "operatingSystem": "Web",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock"
  },
  "description": "Get a free temp mail address instantly. Temp Mail provides disposable temporary email to protect your privacy, avoid spam, and keep your real inbox clean. No signup required, 100% anonymous.",
  "featureList": [
    "Free disposable temporary email address",
    "Instant email reception",
    "No registration required",
    "100% anonymous and private",
    "Auto-delete after time expires",
    "Multiple domains available",
    "Copy/refresh/change email address"
  ],
  "author": {
    "@type": "Organization",
    "name": "AutoLikerLive",
    "url": "https://autolikerlive.com"
  },
  "url": "{{ Request::url() }}",
  "image": "https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp"
}
</script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is temp mail?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Temp mail (temporary email) is a free disposable email service that gives you a temporary email address which self-destructs after a certain period. It helps you avoid spam, protect your privacy, and keep your real inbox clean when signing up for websites, forums, or Wi-Fi networks."
      }
    },
    {
      "@type": "Question",
      "name": "How does temp mail work?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Temp Mail generates a random email address for you instantly. You can use this address to receive emails (verification codes, confirmations, etc.) which appear in your temporary inbox. The address and all emails are automatically deleted after the expiration time, leaving no trace."
      }
    },
    {
      "@type": "Question",
      "name": "Is temp mail free?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, Temp Mail is 100% free. No signup, no payment, no personal information required. You get a disposable email address instantly and can use it as many times as you need."
      }
    },
    {
      "@type": "Question",
      "name": "Can I send emails from temp mail?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "No, Temp Mail is designed for receiving emails only. It provides a temporary inbox to receive verification emails, confirmation codes, and other incoming messages. Sending emails is not supported."
      }
    },
    {
      "@type": "Question",
      "name": "How long does a temp mail address last?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The temporary email address typically lasts for a set period (e.g., 10 minutes to several hours depending on the domain). After expiration, the address and all received emails are permanently deleted automatically."
      }
    }
  ]
}
</script>

    <style>
        :root {
            --tm: #0d9488;
            --tm-dark: #0f766e;
            --tm-grad: linear-gradient(120deg, #14b8a6, #10b981);
            --ink: #1c1e21;
            --muted: #65676b;
            --bg: #eef4f5;
            --card: #ffffff;
            --border: #e4e6eb;
            --radius: 18px;
            --shadow: 0 12px 34px rgba(13, 148, 136, .14);
            --shadow-lg: 0 24px 60px rgba(15, 70, 70, .22);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1000px 480px at 12% -10%, rgba(20, 184, 166, .16), transparent 60%),
                radial-gradient(1000px 480px at 88% -10%, rgba(16, 185, 129, .13), transparent 60%),
                var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.55;
        }

        a { color: var(--tm); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* ============ Header ============ */
        .tm-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        .tm-header-inner {
            max-width: 1220px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .tm-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-weight: 800;
            font-size: 18px;
        }
        .tm-brand:hover { text-decoration: none; }
        .tm-brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--tm-grad);
            display: grid;
            place-items: center;
            box-shadow: 0 6px 16px rgba(13, 148, 136, .35);
            flex-shrink: 0;
            color: #fff;
        }
        .tm-brand-logo svg { width: 22px; height: 22px; }
        .tm-brand-sub { display: block; font-size: 12px; font-weight: 500; color: var(--muted); line-height: 1.1; }
        .tm-header-links { display: flex; align-items: center; gap: 10px; }
        .tm-ghost {
            border: 1px solid var(--border);
            background: #fff;
            color: var(--ink);
            font-weight: 600;
            font-size: 14px;
            padding: 9px 16px;
            border-radius: 10px;
            transition: .2s;
            cursor: pointer;
        }
        .tm-ghost:hover { border-color: var(--tm); color: var(--tm); text-decoration: none; }

        /* ============ Hero ============ */
        .tm-hero {
            text-align: center;
            padding: 30px 24px 28px;
            background:
                radial-gradient(900px 300px at 12% -10%, rgba(20, 184, 166, .2), transparent 60%),
                radial-gradient(900px 300px at 88% -10%, rgba(16, 185, 129, .16), transparent 60%),
                linear-gradient(180deg, #fff 0%, rgba(13, 148, 136, .06) 100%);
            border-bottom: 1px solid rgba(13, 148, 136, .12);
        }
        .tm-hero-inner { max-width: 1080px; margin: 0 auto; }
        .tm-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--tm);
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 999px;
            box-shadow: 0 2px 8px rgba(13, 148, 136, .08);
        }
        .tm-hero h1 {
            font-size: clamp(30px, 5vw, 48px);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.12;
            margin: 18px 0 12px;
        }
        .tm-hero h1 .grad {
            background: var(--tm-grad);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .tm-hero p {
            color: var(--muted);
            font-size: clamp(15px, 2.4vw, 18px);
            /* max-width: 640px;
            margin: 0 auto; */
        }
        .tm-trust {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 22px;
        }
        .tm-trust-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            padding: 7px 13px;
            border-radius: 999px;
        }
        .tm-trust-pill svg { width: 16px; height: 16px; color: var(--tm); flex-shrink: 0; }
        .tm-hero .tm-card { text-align: left; margin-top: 26px; }

        /* ============ Ad slots ============ */
        .ad-slot { overflow: hidden; text-align: center; margin: 22px auto; padding: 6px 0; }
        .ad-slot.ad-leader { max-width: 1220px; padding: 22px 24px 6px; }
        .side-ad { width: 100%; max-width: 320px; margin: 0 auto; }
        .hide-mobile { display: block; }
        .show-mobile { display: none; }

        /* ============ Main layout ============ */
        .tm-layout {
            width: 100%;
            max-width: 1080px;
            margin: 0 auto;
            padding: 18px 24px 44px;
            display: flex;
            flex-direction: column;
            gap: 26px;
        }
        .tm-main { min-width: 0; display: flex; flex-direction: column; gap: 26px; }
        .tm-split {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 24px;
            align-items: start;
        }
        .tm-split-ad {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        /* ============ Cards ============ */
        .tm-card {
            background: var(--card);
            border-radius: 22px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(13, 148, 136, .14);
            padding: clamp(22px, 3.5vw, 34px);
            position: relative;
        }
        .tm-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            border-radius: 22px 22px 0 0;
            background: var(--tm-grad);
        }
        .tm-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .tm-label svg { width: 20px; height: 20px; color: var(--tm); flex-shrink: 0; }

        /* ============ Mail address box ============ */
        .mail-box {
            display: flex;
            gap: 10px;
            align-items: stretch;
            margin-bottom: 14px;
        }
        .mail-box .mail-input-wrap { position: relative; flex: 1; min-width: 0; }
        .mail-box input {
            width: 100%;
            height: 100%;
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 15px 56px 15px 18px;
            font-family: 'Roboto Mono', monospace;
            font-size: clamp(14px, 2vw, 18px);
            font-weight: 600;
            letter-spacing: .01em;
            color: var(--tm-dark);
            background: #f2fbfa;
            transition: border-color .2s, box-shadow .2s;
        }
        .mail-box input:focus {
            outline: none;
            border-color: var(--tm);
            box-shadow: 0 0 0 4px rgba(13, 148, 136, .14);
            background: #fff;
        }
        .mail-copy-fab {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 11px;
            background: var(--tm-grad);
            color: #fff;
            display: grid;
            place-items: center;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(13, 148, 136, .35);
            transition: transform .15s, box-shadow .2s;
        }
        .mail-copy-fab:hover { transform: translateY(-50%) scale(1.06); }
        .mail-copy-fab svg { width: 18px; height: 18px; }

        .mail-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .tm-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            padding: 11px 16px;
            border-radius: 11px;
            cursor: pointer;
            transition: .2s;
            border: 0;
            background: #fff;
            color: var(--ink);
            border: 2px solid var(--border);
        }
        .tm-action svg { width: 16px; height: 16px; }
        .tm-action:hover { border-color: var(--tm); color: var(--tm); text-decoration: none; }
        .tm-action-primary {
            background: var(--tm-grad);
            color: #fff;
            border: 0;
            box-shadow: 0 6px 16px rgba(13, 148, 136, .3);
        }
        .tm-action-primary:hover { color: #fff; box-shadow: 0 9px 22px rgba(13, 148, 136, .4); }
        .tm-action-danger:hover { border-color: #e11d48; color: #e11d48; }

        .mail-info-text {
            margin-top: 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            color: #0f766e;
            line-height: 1.6;
            background: linear-gradient(120deg, #ecfdf5, #f0fdfa);
            border: 1px solid rgba(13, 148, 136, .18);
            border-left: 4px solid var(--tm);
            border-radius: 12px;
            padding: 12px 14px;
        }
        .mail-info-text svg {
            width: 18px;
            height: 18px;
            color: var(--tm);
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* ============ Inbox ============ */
        .inbox-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }
        .inbox-head h3 {
            font-size: 17px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 0;
        }
        .inbox-head h3 svg { width: 20px; height: 20px; color: var(--tm); }
        .inbox-head .live-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--tm-dark);
            background: #ecfaf7;
            border: 1px solid #bfe9df;
            padding: 5px 11px;
            border-radius: 999px;
        }
        .inbox-head .live-dot .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse 1.6s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.8); }
        }
        .inbox-col-head {
            display: grid;
            grid-template-columns: 1.4fr 2fr 1fr;
            gap: 8px;
            background: var(--tm-grad);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .06em;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 6px;
        }
        .inbox-col-head span:last-child { text-align: right; }
        .inbox-body { min-height: 260px; padding: 6px 0; }

        /* Empty state (used by livewire component) */
        .inbox-empty {
            height: 300px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            text-align: center;
        }
        .inboxWarpMain svg .emptyInboxRotation {
            -webkit-animation: rotation 2s linear infinite;
            animation: rotation 2s linear infinite;
            transform-origin: 50% 50%;
        }
        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(359deg); }
        }
        .inboxWarpMain .inbox-empty .inbox-empty-msg p.emptyInboxTitle {
            color: #585d6a;
            font-size: 20px;
            font-family: 'Roboto Mono', monospace !important;
            font-weight: 400;
            margin-bottom: 5px;
        }
        .inbox-empty .text-muted { color: var(--muted) !important; }

        /* Message rows (rendered by livewire) */
        .viewLink { text-decoration: none; }
        .viewLink:hover { text-decoration: none; }
        .msg-row {
            display: grid;
            grid-template-columns: 1.5fr 1.1fr 1fr;
            gap: 10px;
            align-items: center;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 6px;
            background: #fff;
            border: 1px solid var(--border);
            transition: border-color .15s, box-shadow .15s;
        }
        .msg-row:hover { border-color: var(--tm); box-shadow: 0 6px 16px rgba(13, 148, 136, .12); text-decoration: none; }
        .msg-cell { min-width: 0; display: flex; flex-direction: column; }
        .msg-sender {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .msg-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
        .msg-dot.is-active { background: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, .18); }
        .msg-dot.is-not-active { background: #c4c9cf; }
        .msg-subject {
            font-size: 12.5px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }
        .msg-email {
            font-size: 13px;
            font-family: 'Roboto Mono', monospace;
            color: var(--tm-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .msg-time { text-align: right; font-size: 12px; font-style: italic; color: var(--muted); white-space: nowrap; }

        /* ============ Sections ============ */
        .tm-section-title {
            text-align: center;
            font-size: clamp(22px, 3.5vw, 30px);
            font-weight: 800;
            letter-spacing: -0.01em;
            margin-bottom: 26px;
        }
        .tm-section-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: clamp(20px, 3.5vw, 32px);
            box-shadow: 0 4px 14px rgba(15, 70, 70, .05);
        }
        .tm-section-card h3 { font-size: 18px; font-weight: 800; margin-bottom: 10px; }
        .tm-section-card p { color: var(--muted); font-size: 15px; margin-bottom: 12px; }



        /* ============ Footer ============ */
        .tm-footer {
            margin-top: auto;
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 26px 24px;
            text-align: center;
        }
        .tm-footer-links { display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; margin-bottom: 10px; }
        .tm-footer a { color: var(--muted); font-size: 14px; font-weight: 600; }
        .tm-footer a:hover { color: var(--tm); }
        .tm-footer .copy { color: #9aa0a6; font-size: 13px; }

        /* ============ Modal + Toast ============ */
        .modal-content { border-radius: 18px; border: 0; box-shadow: var(--shadow-lg); }
        .modal-header { border-bottom: 1px solid var(--border) !important; padding: 18px 22px; }
        .modal-title { font-weight: 800; font-size: 19px; }
        .modal-body { padding: 20px 22px; }
        .modal-body label { font-weight: 600; font-size: 14px; margin-bottom: 6px; display: block; }
        .modal-body .form-control, .modal-body .form-select {
            border-radius: 11px;
            border: 2px solid var(--border);
            padding: 11px 14px;
        }
        .modal-body .form-control:focus, .modal-body .form-select:focus {
            border-color: var(--tm);
            box-shadow: 0 0 0 4px rgba(13, 148, 136, .12);
        }
        .modal-body .btn-close { filter: none; }
        .fixedToast {
            position: fixed;
            right: 1.25rem;
            top: 1.25rem;
            z-index: 300;
            border: 0;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            background: #fff;
        }

        /* ============ Page loader bar ============ */
        .pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 4px;
            background: var(--tm-grad);
            transition: width .3s linear;
            z-index: 9999;
        }

        /* ============ Responsive ============ */
        @media (max-width: 960px) {
            .tm-split { grid-template-columns: 1fr; gap: 18px; }
            .tm-split-ad { order: 2; }
            .tm-hero { padding-top: 24px; }
            .inbox-col-head, .msg-row { grid-template-columns: 1.4fr 1fr 1fr; }
            .hide-mobile { display: none; }
            .show-mobile { display: block; }
            .tm-header-links .hide-sm { display: none; }
        }
        @media (max-width: 620px) {
            .tm-hero { padding: 18px 14px 20px; }
            .tm-hero h1 { margin: 12px 0 8px; }
            .tm-trust { margin-top: 12px; }
            .tm-trust-pill { padding: 5px 11px; font-size: 12px; }
            .tm-hero .tm-card { margin-top: 18px; }
            .inbox-col-head { display: none; }
            .msg-row { grid-template-columns: 1fr 1.3fr; gap: 6px; }
            .msg-row .msg-time { grid-column: 1 / -1; text-align: left; padding-left: 22px; }
            .msg-email { grid-column: 1 / -1; padding-left: 22px; }
        }
    </style>
</head>

<body>

    <div class="pageLoader"></div>

    <!-- ============ Header ============ -->
    <header class="tm-header">
        <div class="tm-header-inner">
            <a href="{{ url('/') }}" class="tm-brand">
                <span class="tm-brand-logo">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                </span>
                <span>
                    Temp Mail
                    <span class="tm-brand-sub">by AutoLikerLive</span>
                </span>
            </a>
            <div class="tm-header-links">
                <a href="{{ url('services') }}" class="tm-ghost hide-sm">All Tools</a>
                <a href="{{ url('/') }}" class="tm-ghost">Home</a>
            </div>
        </div>
    </header>

    <!-- ============ Hero ============ -->
    <section class="tm-hero">
        <div class="tm-hero-inner">
            <span class="tm-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                {{ __('messages.tempMail.badge') }}
            </span>
            <h1>{!! __('messages.tempMail.heroTitle') !!}</h1>
            <p>{{ __('messages.tempMail.heroSub') }}</p>
            <div class="tm-trust">
                <span class="tm-trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l8 4v6c0 5.55-3.84 10.74-9 12-5.16-1.26-9-6.45-9-12V6l8-4z"/></svg>
                    100% Free
                </span>
                <span class="tm-trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                    No Signup
                </span>
                <span class="tm-trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm1 14h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    Auto-Delete
                </span>
            </div>

            <!-- Mail address card — full width, above the fold -->
            <div class="tm-card">
                <div class="tm-label">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    {{ __('messages.tempMail.yourAddress') }}
                </div>

                <div class="mail-box">
                    <div class="mail-input-wrap">
                        <input type="text" id="mailbox" value="Loading..." disabled autocomplete="off" spellcheck="false" readonly>
                        <button type="button" class="mail-copy-fab" onclick="copyToClipboard()" aria-label="Copy email">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 1H4a2 2 0 00-2 2v14h2V3h12V1zm3 4H8a2 2 0 00-2 2v14a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2zm0 16H8V7h11v14z"/></svg>
                        </button>
                    </div>
                </div>

                <div class="mail-actions">
                    <button type="button" class="tm-action tm-action-primary" onclick="copyToClipboard()">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 1H4a2 2 0 00-2 2v14h2V3h12V1zm3 4H8a2 2 0 00-2 2v14a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2zm0 16H8V7h11v14z"/></svg>
                        {{ __('messages.tempMail.copy') }}
                    </button>
                    <a href="javascript:;" id="click-to-refresh" class="tm-action">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.65 6.35A7.958 7.958 0 0012 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0112 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/></svg>
                        {{ __('messages.tempMail.refresh') }}
                    </a>
                    <a href="javascript:;" id="click-to-change" class="tm-action d-none">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0020 13c0-4.42-3.58-8-8-8zm-1 12c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 6.74A7.93 7.93 0 004 13c0 4.42 3.58 8 8 8v4l5-5-5-5v4z"/></svg>
                        {{ __('messages.tempMail.newAddress') }}
                    </a>
                    <button type="button" id="changeMailBtn" class="tm-action d-none">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                        {{ __('messages.tempMail.changeAddress') }}
                    </button>
                    <form action="{{ route('deleteMail') }}" method="post" class="d-inline">
                        @csrf
                        <input type="hidden" name="email" id="email_id" value="" disabled>
                        <button type="submit" class="tm-action tm-action-danger">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 19a2 2 0 002 2h8a2 2 0 002-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            {{ __('messages.tempMail.delete') }}
                        </button>
                    </form>
                </div>

                <p class="mail-info-text">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                    {{ __('messages.tempMail.info') }}
                </p>
            </div>

            {{-- Ads inside the header band — desktop leaderboard / mobile banner --}}
            <div class="ad-slot ad-leader hide-mobile">
                <x-ads.leaderboard />
            </div>
            <div class="ad-slot ad-leader show-mobile">
                <x-ads.mobile-banner />
            </div>
        </div>
    </section>

    <!-- ============ Main layout ============ -->
    <div class="tm-layout">
        <main class="tm-main">

            <!-- Inbox card + right ad -->
            <div class="tm-split">
                <div class="tm-card">
                    <div class="inbox-head">
                        <h3>
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            {{ __('messages.tempMail.inboxTitle') }}
                        </h3>
                        <span class="live-dot"><span class="dot"></span> Live · {{ __('messages.tempMail.inboxSub') }}</span>
                    </div>
                    <div class="inbox-col-head">
                        <span>{{ __('messages.tempMail.inboxSender') }}</span>
                        <span>{{ __('messages.tempMail.inboxSubject') }}</span>
                        <span>{{ __('messages.tempMail.inboxView') }}</span>
                    </div>
                    <div class="inbox-body inboxWarpMain" id="messageList">
                        @livewire('tempmail-inbox')
                    </div>
                </div>

                <aside class="tm-split-ad">
                    <div class="side-ad">
                        <x-ads.sidebar />
                    </div>
                </aside>
            </div>

            <!-- Info sections -->
            <section class="tm-section-card">
                <h3>{{ __('messages.tempMail.whatIsTempMail') }}</h3>
                <p>{{ __('messages.tempMail.whatIsTempMail_p1') }}</p>
            </section>

            <section class="tm-section-card">
                <h3>{{ __('messages.tempMail.techBehind') }}</h3>
                <p>{{ __('messages.tempMail.techBehind_p1') }}</p>
                <p>{{ __('messages.tempMail.techBehind_p2') }}</p>
                <p>{{ __('messages.tempMail.techBehind_p3') }}</p>
            </section>

            <section class="tm-section-card">
                <h3>{{ __('messages.tempMail.whatIsTempMail2') }}</h3>
                <p>{{ __('messages.tempMail.whatIsTempMail2_p1') }}</p>
                <p>{{ __('messages.tempMail.whatIsTempMail2_p2') }}</p>
                <p>{{ __('messages.tempMail.whatIsTempMail2_p3') }}</p>
                <p>{{ __('messages.tempMail.conclusion') }}</p>
            </section>

        </main>
    </div>

    <!-- ============ Footer ============ -->
    <footer class="tm-footer">
        <div class="tm-footer-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('services') }}">All Tools</a>
            <a href="{{ url('privacy') }}">Privacy</a>
            <a href="{{ url('terms') }}">Terms</a>
            <a href="{{ url('contact') }}">Contact</a>
        </div>
        <div class="copy">&copy; autolikerlive.com &mdash; For entertainment purposes only.</div>
    </footer>

    <!-- ============ Toast ============ -->
    <div class="toast fixedToast" id="copyToast" role="status" aria-live="polite" aria-atomic="true">
        <div class="toast-body">
            <strong>{{ __('messages.tempMail.copied') }}</strong>
        </div>
    </div>

    <!-- ============ Change Email Modal ============ -->
    <div class="modal fade" id="changeMailModal" tabindex="-1" aria-labelledby="changeMailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changeMailModalLabel">{{ __('messages.tempMail.changeModalTitle') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="random_code_input">{{ __('messages.tempMail.changeModalAlias') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="random_code_input" placeholder="john.doe">
                            <button type="button" id="random_code" class="btn btn-success">{{ __('messages.tempMail.randomName') }}</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name_domain">{{ __('messages.tempMail.changeModalDomain') }}</label>
                        <select class="form-select" id="name_domain" tabindex="-1" aria-hidden="true">
                            <option value="">Loading domains...</option>
                        </select>
                    </div>
                    <button id="change_email" class="btn btn-success w-100">{{ __('messages.tempMail.updateEmail') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.9/dist/axios.min.js"></script>
    <script>
        $(document).ready(function () {
            axios.get(`{{ route('mailbox') }}`)
                .then(function (response) {
                    $('#mailbox').val(response.data.email);
                    $('#email_id').val(response.data.email);
                    $('#email_id').prop('disabled', false);

                    var emails = response.data.list;
                    $('#name_domain').empty();
                    emails.forEach(function (e) {
                        $('#name_domain').append('<option value="' + e.name + '">' + e.name + '</option>');
                    });
                })
                .catch(function (error) {
                    console.error(error);
                });

            $('#random_code').on('click', function () {
                $('#random_code_input').val(generateRandomEmail());
            });

            $('#change_email').on('click', function () {
                $('#email_id').prop('disabled', true);
                var name = $('#random_code_input').val();
                var domain = $('#name_domain').find(':selected').val();
                var email = name + '@' + domain;
                axios.post(`{{ route('updateEmail') }}`, { email: email })
                    .then(function (response) {
                        $('#email_id').prop('disabled', false);
                        if (response.status === 200 && response.data.success) {
                            $('#mailbox').val(email);
                            $('#email_id').val(email);
                            var modalEl = document.getElementById('changeMailModal');
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                            Livewire.dispatch('refreshInbox');
                        }
                    })
                    .catch(function () {
                        $('#email_id').prop('disabled', false);
                    });
            });

            $('#changeMailBtn').on('click', function () {
                var modal = new bootstrap.Modal(document.getElementById('changeMailModal'));
                modal.show();
            });

            $('#click-to-refresh').click(function () {
                Livewire.dispatch('refreshInbox');
            });

            $('#click-to-change').click(function () {
                showLoader();
                axios.post(`{{ route('mailbox') }}`, { refresh: true })
                    .then(function (response) {
                        $('#mailbox').val(response.data.email);
                        $('#email_id').val(response.data.email);
                        $('#email_id').prop('disabled', false);
                        hideLoader();
                    })
                    .catch(function () {
                        hideLoader();
                    });
            });
        });

        function showLoader() {
            var loader = document.querySelector('.pageLoader');
            if (loader) {
                loader.style.height = '4px';
                loader.style.width = '100%';
            }
        }

        function hideLoader() {
            var loader = document.querySelector('.pageLoader');
            if (loader) {
                loader.style.width = '0';
                loader.style.height = '0px';
            }
        }

        function copyToClipboard() {
            var textToCopy = $('#mailbox').val();
            var textArea = document.createElement("textarea");
            textArea.value = textToCopy;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand("copy");
            } catch (e) {}
            document.body.removeChild(textArea);

            var toastEl = document.getElementById('copyToast');
            var toast = bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 1500 });
            toast.show();
        }

        function generateRandomEmail() {
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-.";
            let name = "";
            const nameLength = Math.floor(Math.random() * 8) + 5;
            for (let i = 0; i < nameLength; i++) {
                name += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            if (!/^[a-zA-Z0-9]/.test(name.charAt(0))) {
                name = "a" + name.substring(1);
            }
            if (!/[a-zA-Z0-9]$/.test(name.charAt(name.length - 1))) {
                name = name.substring(0, name.length - 1) + "z";
            }
            name = name.replace(/\.\./g, ".");
            return name;
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('show-loader', (event) => {
                showLoader();
                setTimeout(function () { hideLoader(); }, 1000);
            });
        });
    </script>
</body>
</html>
