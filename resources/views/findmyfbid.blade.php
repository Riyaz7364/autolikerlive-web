<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    <title>{{ __('messages.findmyfbid.meta_title') }}</title>
    <meta name="description" content="{{ __('messages.findmyfbid.meta_desc') }}">
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ __('messages.findmyfbid.meta_title') }}" />
    <meta property="og:description" content="{{ __('messages.findmyfbid.meta_desc') }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ Request::url() }}" />
    <meta name="twitter:title" content="{{ __('messages.findmyfbid.meta_title') }}" />
    <meta name="twitter:description" content="{{ __('messages.findmyfbid.meta_desc') }}" />
    <meta name="twitter:image" content="https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp" />

    <meta name="keywords" content="find facebook id, facebook id finder, fb id finder, facebook profile id, facebook page id, facebook group id, facebook numeric id, facebook graph api id, free facebook id tool" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "Find My Facebook ID",
  "applicationCategory": "UtilitiesApplication",
  "operatingSystem": "Web",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock"
  },
  "description": "Find your Facebook ID instantly with our free FB ID finder. Enter a profile, page, or group URL to get the unique numeric ID in seconds. No signup required. Works for profiles, pages, and groups.",
  "featureList": [
    "Free Facebook ID lookup tool",
    "Supports profiles, pages, and groups",
    "Instant numeric ID retrieval",
    "No registration required",
    "Works with Facebook Graph API",
    "Copy ID with one click",
    "Open profile directly from result"
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
      "name": "What is a Facebook ID?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "A Facebook ID is a unique numerical identifier assigned to every Facebook profile, page, and group. It's used internally by Facebook's systems and by developers working with the Facebook Graph API to identify specific accounts programmatically."
      }
    },
    {
      "@type": "Question",
      "name": "How do I find my Facebook ID?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Simply copy your Facebook profile, page, or group URL from the browser address bar, paste it into our finder tool, and click 'Find Facebook ID'. Your unique numeric ID will be displayed instantly."
      }
    },
    {
      "@type": "Question",
      "name": "Is the Facebook ID finder free?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, Find My Facebook ID is 100% free. No signup, no payment, and no personal information required. You can look up as many IDs as you need."
      }
    },
    {
      "@type": "Question",
      "name": "Does this work for Facebook pages and groups?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, the tool works for Facebook profiles, pages, and groups. Just paste any valid Facebook URL and it will extract the numeric ID."
      }
    },
    {
      "@type": "Question",
      "name": "Why can't I find my Facebook ID?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "If your profile is set to private or you've disabled 'Do you want search engines outside of Facebook to link to your profile?', the ID cannot be retrieved. Enable this setting in Facebook privacy settings and try again."
      }
    }
  ]
}
</script>

    <style>
        :root {
            --fb: #1877f2;
            --fb-dark: #0d65d9;
            --ink: #1c1e21;
            --muted: #65676b;
            --bg: #eef1f6;
            --card: #ffffff;
            --border: #e4e6eb;
            --green: #2fa84f;
            --green-bg: #e9f8ee;
            --amber: #b26a00;
            --amber-bg: #fff4e0;
            --radius: 18px;
            --shadow: 0 12px 34px rgba(24, 119, 242, .12);
            --shadow-lg: 0 24px 60px rgba(15, 45, 90, .22);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html { -webkit-text-size-adjust: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(1000px 480px at 12% -10%, rgba(24, 119, 242, .16), transparent 60%),
                radial-gradient(1000px 480px at 88% -10%, rgba(18, 183, 106, .13), transparent 60%),
                var(--bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.55;
        }

        a { color: var(--fb); text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* ============ Header ============ */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        .site-header-inner {
            max-width: 1220px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
            font-weight: 800;
            font-size: 18px;
        }
        .brand:hover { text-decoration: none; }
        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2ea4ff, var(--fb));
            display: grid;
            place-items: center;
            box-shadow: 0 6px 16px rgba(24, 119, 242, .35);
            flex-shrink: 0;
        }
        .brand-logo span { color: #fff; font-weight: 800; font-size: 21px; }
        .brand-sub { display: block; font-size: 12px; font-weight: 500; color: var(--muted); line-height: 1.1; }
        .header-links { display: flex; align-items: center; gap: 10px; }
        .btn-ghost {
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
        .btn-ghost:hover { border-color: var(--fb); color: var(--fb); text-decoration: none; }

        /* ============ Hero ============ */
        .hero { text-align: center; padding: 48px 24px 8px; }
        .hero-inner { max-width: 860px; margin: 0 auto; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--fb);
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 999px;
            box-shadow: 0 2px 8px rgba(24, 119, 242, .08);
        }
        .hero h1 {
            font-size: clamp(30px, 5vw, 48px);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.12;
            margin: 18px 0 12px;
        }
        .hero h1 .grad {
            background: linear-gradient(120deg, var(--fb), #12b76a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .hero p {
            color: var(--muted);
            font-size: clamp(15px, 2.4vw, 18px);
            max-width: 640px;
            margin: 0 auto;
        }
        .trust-row {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 22px;
        }
        .trust-pill {
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
        .trust-pill svg { width: 16px; height: 16px; color: var(--fb); flex-shrink: 0; }

        /* ============ Ad slots ============ */
        .ad-slot {
            overflow: hidden;
            text-align: center;
            margin: 22px auto;
            padding: 6px 0;
        }
        .ad-slot.ad-leader { max-width: 1220px; padding: 22px 24px 6px; }
        .ad-slot.ad-inline { max-width: 1220px; padding: 4px 0; }
        .side-ad { width: 100%; max-width: 320px; margin: 0 auto; }
        .hide-mobile { display: block; }
        .show-mobile { display: none; }

        /* ============ Main layout (desktop 2-col) ============ */
        .layout {
            width: 100%;
            max-width: 1220px;
            margin: 0 auto;
            padding: 18px 24px 44px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 28px;
            align-items: start;
        }
        .main-col { min-width: 0; display: flex; flex-direction: column; gap: 26px; }
        .side-col {
            position: sticky;
            top: 78px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        /* ============ Tool Card ============ */
        .tool-card {
            background: var(--card);
            border-radius: 22px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(24, 119, 242, .12);
            padding: clamp(22px, 3.5vw, 36px);
            position: relative;
        }
        .tool-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 5px;
            border-radius: 22px 22px 0 0;
            background: linear-gradient(90deg, var(--fb), #12b76a);
        }
        .tool-label {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .tool-label svg { width: 20px; height: 20px; color: var(--fb); flex-shrink: 0; }
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
            transition: border-color .2s, box-shadow .2s;
            background: #fbfcfe;
        }
        .input-row input:focus {
            outline: none;
            border-color: var(--fb);
            box-shadow: 0 0 0 4px rgba(24, 119, 242, .14);
            background: #fff;
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
            background: linear-gradient(120deg, var(--fb), var(--fb-dark));
            box-shadow: 0 8px 20px rgba(24, 119, 242, .35);
            transition: transform .15s, box-shadow .2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-find:hover { transform: translateY(-1px); box-shadow: 0 12px 26px rgba(24, 119, 242, .42); }
        .btn-find:active { transform: translateY(0); }
        .btn-find svg { width: 18px; height: 18px; }
        .hint {
            font-size: 13px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }
        .hint code {
            background: #f2f5f9;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px 7px;
            font-size: 12px;
            color: var(--ink);
        }
        .recaptcha-wrap { display: flex; justify-content: center; }
        .g-recaptcha { transform: scale(.92); transform-origin: top center; }

        /* ============ Result ============ */
        .result { margin-top: 20px; border-radius: 14px; overflow: hidden; }
        .result.success { background: var(--green-bg); border: 1px solid #bfe8cd; padding: 22px; text-align: center; }
        .result.success .check {
            width: 52px; height: 52px; margin: 0 auto 10px;
            border-radius: 50%;
            background: var(--green);
            color: #fff;
            display: grid; place-items: center;
            box-shadow: 0 8px 18px rgba(47, 168, 79, .35);
        }
        .result.success .check svg { width: 28px; height: 28px; }
        .result.success .label { font-size: 14px; font-weight: 600; color: var(--muted); }
        .fb-id {
            font-size: clamp(24px, 4.5vw, 36px);
            font-weight: 800;
            letter-spacing: .02em;
            color: var(--green);
            margin: 6px 0 14px;
            word-break: break-all;
            font-variant-numeric: tabular-nums;
        }
        .result-actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            padding: 11px 18px;
            border-radius: 11px;
            cursor: pointer;
            transition: .2s;
            border: 0;
        }
        .btn svg { width: 17px; height: 17px; }
        .btn-primary {
            background: linear-gradient(120deg, var(--fb), var(--fb-dark));
            color: #fff;
            box-shadow: 0 6px 16px rgba(24, 119, 242, .3);
        }
        .btn-primary:hover { box-shadow: 0 9px 22px rgba(24, 119, 242, .4); text-decoration: none; }
        .btn-outline {
            background: #fff;
            color: var(--fb);
            border: 2px solid var(--fb);
        }
        .btn-outline:hover { background: rgba(24, 119, 242, .06); text-decoration: none; }

        .result.fail { background: var(--amber-bg); border: 1px solid #f5d9a8; padding: 22px; text-align: center; }
        .result.fail .warn {
            width: 52px; height: 52px; margin: 0 auto 10px;
            border-radius: 50%;
            background: #f59e0b;
            color: #fff;
            display: grid; place-items: center;
            box-shadow: 0 8px 18px rgba(245, 158, 11, .35);
        }
        .result.fail .warn svg { width: 28px; height: 28px; }
        .result.fail .label { font-size: 18px; font-weight: 800; color: var(--amber); }
        .result.fail .desc { font-size: 14px; color: #8a6a2b; margin: 6px 0 14px; }

        /* ============ Sections ============ */
        .section-title {
            text-align: center;
            font-size: clamp(22px, 3.5vw, 30px);
            font-weight: 800;
            letter-spacing: -0.01em;
            margin-bottom: 26px;
        }
        .section-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: clamp(20px, 3.5vw, 32px);
            box-shadow: 0 4px 14px rgba(15, 45, 90, .05);
        }
        .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .step-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 20px;
            position: relative;
            box-shadow: 0 4px 14px rgba(15, 45, 90, .05);
            transition: transform .2s, box-shadow .2s;
        }
        .step-card:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(15, 45, 90, .12); }
        .step-num {
            width: 38px; height: 38px;
            border-radius: 12px;
            display: grid; place-items: center;
            background: linear-gradient(135deg, var(--fb), #12b76a);
            color: #fff;
            font-weight: 800;
            font-size: 17px;
            margin-bottom: 14px;
            box-shadow: 0 6px 14px rgba(24, 119, 242, .3);
        }
        .step-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .step-card p { font-size: 14px; color: var(--muted); }

        .info-card h3 { font-size: 18px; font-weight: 800; margin-bottom: 10px; }
        .info-card p { color: var(--muted); font-size: 15px; margin-bottom: 12px; }
        .examples { margin: 6px 0 16px; padding-left: 0; list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .examples code {
            display: block;
            background: #f2f5f9;
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 9px 13px;
            font-size: 13px;
            color: var(--fb-dark);
            word-break: break-all;
            font-weight: 600;
        }
        .examples.invalid code { color: #c0392b; background: #fdf0ee; border-color: #f3c1bb; }

        /* ============ Sidebar widgets ============ */
        .side-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 4px 14px rgba(15, 45, 90, .05);
        }
        .side-card h3 {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .side-card h3 svg { width: 18px; height: 18px; color: var(--fb); }
        .side-links { list-style: none; display: flex; flex-direction: column; gap: 2px; }
        .side-links a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 9px 10px;
            border-radius: 9px;
            color: var(--ink);
            font-size: 14px;
            font-weight: 600;
            transition: background .15s, color .15s;
        }
        .side-links a:hover { background: #f0f4ff; color: var(--fb); text-decoration: none; }
        .side-links a svg { width: 16px; height: 16px; color: var(--muted); flex-shrink: 0; }
        .side-links a:hover svg { color: var(--fb); }

        /* ============ FAQ ============ */
        .faq-list { display: flex; flex-direction: column; gap: 12px; }
        .faq-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(15, 45, 90, .04);
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
        .faq-q:hover { color: var(--fb); }
        .faq-q .chev { transition: transform .25s; flex-shrink: 0; width: 20px; height: 20px; color: var(--fb); }
        .faq-item.open .faq-q .chev { transform: rotate(180deg); }
        .faq-a { display: none; padding: 0 20px 18px; color: var(--muted); font-size: 14px; }
        .faq-item.open .faq-a { display: block; }
        .faq-a p { margin-bottom: 10px; }
        .faq-a p:last-child { margin-bottom: 0; }

        /* ============ Footer ============ */
        .site-footer {
            margin-top: auto;
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 26px 24px;
            text-align: center;
        }
        .site-footer .footer-links { display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; margin-bottom: 10px; }
        .site-footer a { color: var(--muted); font-size: 14px; font-weight: 600; }
        .site-footer a:hover { color: var(--fb); }
        .site-footer .copy { color: #9aa0a6; font-size: 13px; }

        /* ============ Modal ============ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 25, 47, .62);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 200;
        }
        .modal-overlay.show { display: flex; }
        .modal {
            background: var(--card);
            border-radius: 20px;
            max-width: 560px;
            width: 100%;
            max-height: 92vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: modalIn .28s ease;
        }
        @keyframes modalIn {
            from { transform: translateY(26px) scale(.97); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }
        .modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 20px 22px 0;
        }
        .modal-head h3 { font-size: 19px; font-weight: 800; line-height: 1.3; }
        .modal-head .close {
            background: #f0f2f5;
            border: 0;
            border-radius: 50%;
            width: 34px; height: 34px;
            cursor: pointer;
            display: grid; place-items: center;
            flex-shrink: 0;
            color: var(--muted);
            transition: .2s;
        }
        .modal-head .close:hover { background: #e4e6eb; color: var(--ink); }
        .modal-head .close svg { width: 18px; height: 18px; }
        .modal-sub { padding: 8px 22px 0; color: var(--muted); font-size: 14px; }
        .modal video {
            width: 100%;
            display: block;
            margin: 16px 0 0;
            background: #000;
            max-height: 320px;
            border-radius: 0;
        }
        .modal-steps { padding: 18px 22px; list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .modal-steps li {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 14px;
            color: var(--ink);
        }
        .modal-steps .n {
            width: 26px; height: 26px;
            border-radius: 8px;
            flex-shrink: 0;
            display: grid; place-items: center;
            background: var(--fb);
            color: #fff;
            font-weight: 800;
            font-size: 13px;
        }
        .modal-cta { padding: 0 22px 22px; text-align: center; }

        /* ============ Responsive ============ */
        @media (max-width: 960px) {
            .layout { grid-template-columns: 1fr; gap: 24px; }
            .side-col { position: static; }
            .hero { padding-top: 34px; }
            .input-row { flex-direction: column; }
            .btn-find { justify-content: center; }
            .steps { grid-template-columns: 1fr; }
            .hide-mobile { display: none; }
            .show-mobile { display: block; }
            .header-links .hide-sm { display: none; }
        }
    </style>
</head>

<body data-fail="{{ Session::has('fail') ? '1' : '0' }}">

    <!-- ============ Header ============ -->
    <header class="site-header">
        <div class="site-header-inner">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-logo"><span>f</span></span>
                <span>
                    FindMyFBID
                    <span class="brand-sub">by AutoLikerLive</span>
                </span>
            </a>
            <div class="header-links">
                <a href="{{ url('services') }}" class="btn-ghost hide-sm">All Tools</a>
                <a href="{{ url('/') }}" class="btn-ghost">Home</a>
            </div>
        </div>
    </header>

    <!-- ============ Hero ============ -->
    <section class="hero">
        <div class="hero-inner">
            <span class="badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                {{ __('messages.findmyfbid.badge') }}
            </span>
            <h1>{!! __('messages.findmyfbid.heroTitle') !!}</h1>
            <p>{{ __('messages.findmyfbid.heroSub') }}</p>
            <div class="trust-row">
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l8 4v6c0 5.55-3.84 10.74-9 12-5.16-1.26-9-6.45-9-12V6l8-4z"/></svg>
                    100% Free
                </span>
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                    No Login Needed
                </span>
                <span class="trust-pill">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm1-12h-2v4.58l3.21 2.94 1.32-1.44-2.53-2.3V8z"/></svg>
                    Instant Results
                </span>
            </div>
        </div>
    </section>

    {{-- Leaderboard — desktop, above the fold --}}
    <div class="ad-slot ad-leader hide-mobile">
        <x-ads.leaderboard />
    </div>
    {{-- Mobile banner — mobile, above the fold --}}
    <div class="ad-slot ad-leader show-mobile">
        <x-ads.mobile-banner />
    </div>

    <!-- ============ Main layout ============ -->
    <div class="layout">
        <div class="main-col">

            <!-- Tool card -->
            <div class="tool-card">
                <div class="tool-label">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 3A6.5 6.5 0 0116 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5-1.5 1.5-5-5v-.79l-.27-.27A6.516 6.516 0 019.5 16 6.5 6.5 0 019.5 3zm0 2C7 5 5 7 5 9.5S7 14 9.5 14 14 12 14 9.5 12 5 9.5 5z"/></svg>
                    {{ __('messages.findmyfbid.input.label') }}
                </div>

                <form method="POST" action="{{ route('searchFBID') }}" class="tool-form">
                    @csrf
                    <div class="input-row">
                        <input
                            type="text"
                            name="fburl"
                            value="{{ old('fburl') }}"
                            placeholder="{{ __('messages.findmyfbid.input.hint') }}"
                            autocomplete="url"
                            spellcheck="false"
                            required
                        />
                        <button type="submit" class="btn-find">
                            {{ __('messages.findmyfbid.button') }}
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
                        </button>
                    </div>
                    <div class="hint">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        <span>Example: <code>https://www.facebook.com/YourProfileName</code></span>
                    </div>
                    <div class="recaptcha-wrap">
                        <div class="g-recaptcha" data-sitekey="6LdbfxIpAAAAAMOXiTKag0ZwQp1T0HSfj4hiLJ-E"></div>
                    </div>
                </form>

                {{-- Success --}}
                @if (Session::has('message'))
                    <div class="result success">
                        <div class="check">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                        </div>
                        <div class="label">{{ __('messages.findmyfbid.success.title') }}</div>
                        <div class="fb-id">{{ Session::get('message') }}</div>
                        <div class="result-actions">
                            <button type="button" class="btn btn-primary" data-copy="{{ Session::get('message') }}">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 1H4a2 2 0 00-2 2v14h2V3h12V1zm3 4H8a2 2 0 00-2 2v14a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2zm0 16H8V7h11v14z"/></svg>
                                <span class="copy-label">{{ __('messages.findmyfbid.success.copy') }}</span>
                            </button>
                            @if (old('fburl'))
                                <a href="{{ old('fburl') }}" target="_blank" rel="noopener nofollow" class="btn btn-outline">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 19H5V5h7V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                                    {{ __('messages.findmyfbid.success.openProfile') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Failure --}}
                @if (Session::has('fail'))
                    <div class="result fail">
                        <div class="warn">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                        </div>
                        <div class="label">{{ __('messages.findmyfbid.fail.title') }}</div>
                        <div class="desc">{{ __('messages.findmyfbid.fail.desc') }}</div>
                        <div class="result-actions">
                            <button type="button" class="btn btn-primary" id="openTutorialBtn">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                {{ __('messages.findmyfbid.fail.watch') }}
                            </button>
                            <a href="https://www.facebook.com/settings/?tab=how_people_find_and_contact_you" target="_blank" rel="noopener nofollow" class="btn btn-outline">
                                {{ __('messages.findmyfbid.fail.settings') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- In-article ad — between tool and content --}}
            <div class="ad-slot ad-inline">
                <x-ads.in-article />
            </div>

            <!-- How it works -->
            <section>
                <h2 class="section-title">{{ __('messages.findmyfbid.how.title') }}</h2>
                <div class="steps">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h3>{{ __('messages.findmyfbid.how.step1t') }}</h3>
                        <p>{{ __('messages.findmyfbid.how.step1d') }}</p>
                    </div>
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h3>{{ __('messages.findmyfbid.how.step2t') }}</h3>
                        <p>{{ __('messages.findmyfbid.how.step2d') }}</p>
                    </div>
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h3>{{ __('messages.findmyfbid.how.step3t') }}</h3>
                        <p>{{ __('messages.findmyfbid.how.step3d') }}</p>
                    </div>
                </div>
            </section>

            <!-- Info -->
            <section class="section-card info-card">
                <h3>What is a Facebook ID?</h3>
                <p>{{ __('messages.findmyfbid.faq_q1_p1') }}</p>
                <p>{{ __('messages.findmyfbid.faq_q1_p2') }}</p>

                <h3 style="margin-top:16px;">Valid profile URLs look like this</h3>
                <ul class="examples">
                    <li><code>https://facebook.com/zuck</code></li>
                    <li><code>https://www.facebook.com/profile.php?id=100001533612613</code></li>
                    <li><code>https://m.facebook.com/ChrisHughes</code></li>
                </ul>

                <h3 style="margin-top:16px;">This is NOT a valid profile URL</h3>
                <ul class="examples invalid">
                    <li><code>Mark Zukerburg</code></li>
                    <li><code>mark@fb.com</code></li>
                </ul>

                <h3 style="margin-top:16px;">Pages &amp; Groups</h3>
                <p>{{ __('messages.findmyfbid.findFBPage_p1') }}</p>
                <ul class="examples">
                    <li><code>https://www.facebook.com/FacebookIndia/</code></li>
                    <li><code>https://www.facebook.com/groups/NationalGeographicPhotoofTheDay/</code></li>
                </ul>
            </section>

            <!-- FAQ -->
            <section>
                <h2 class="section-title">{{ __('messages.findmyfbid.faq.title') }}</h2>
                <div class="faq-list">
                    <div class="faq-item">
                        <button type="button" class="faq-q">
                            {{ __('messages.findmyfbid.faq_q1') }}
                            <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div class="faq-a">
                            <p>{{ __('messages.findmyfbid.faq_q1_p1') }}</p>
                            <p>{{ __('messages.findmyfbid.faq_q1_p2') }}</p>
                            <p>{{ __('messages.findmyfbid.faq_q1_p3') }}</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button type="button" class="faq-q">
                            {{ __('messages.findmyfbid.faq_q2') }}
                            <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div class="faq-a">
                            <p>{{ __('messages.findmyfbid.faq_q2_p1') }}</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button type="button" class="faq-q">
                            {{ __('messages.findmyfbid.faq_q3') }}
                            <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div class="faq-a">
                            <p>{{ __('messages.findmyfbid.faq_q3_p1') }}</p>
                            <p>{{ __('messages.findmyfbid.faq_q3_p2') }}</p>
                            <p>
                                {{ __('messages.findmyfbid.faq_q3_p3') }}
                                @if (old('fburl'))
                                    <a href="{{ old('fburl') }}" target="_blank" rel="noopener nofollow">{{ old('fburl') }}</a>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button type="button" class="faq-q">
                            {{ __('messages.findmyfbid.faq_q4') }}
                            <svg class="chev" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div class="faq-a">
                            <p>{{ __('messages.findmyfbid.faq_q4_p1') }}</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- ============ Sidebar ============ -->
        <aside class="side-col">
            <div class="side-ad">
                <x-ads.sidebar />
            </div>

            <div class="side-card">
                <h3>
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2A10 10 0 002 12c0 5.52 4.48 10 10 10s10-4.48 10-10S17.52 2 11.99 2zM13 17h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    Need your ID? Tips
                </h3>
                <ul class="side-links">
                    <li><a href="#"><span>Use a full profile link, not your name</span><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></a></li>
                    <li><a href="{{ url('services') }}"><span>Browse all free tools</span><svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg></a></li>
                </ul>
            </div>

            <div class="side-card">
                <h3>
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.66 5.66L20.5 2.5H8.7a6.5 6.5 0 100 13h1.1a6.49 6.49 0 007.86-9.84z"/></svg>
                    Popular Tools
                </h3>
                <ul class="side-links">
                    <li><a href="{{ url('services') }}">All Free Tools<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg></a></li>
                    <li><a href="{{ route('instagram.findInstaId') }}">Find Instagram ID<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg></a></li>
                    <li><a href="{{ url('auto-liker-1000-likes') }}">FB Auto Liker<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg></a></li>
                </ul>
            </div>

            <div class="side-ad">
                <x-ads.sidebar />
            </div>
        </aside>
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

    <!-- ============ Tutorial Modal ============ -->
    <div class="modal-overlay" id="tutorialModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal">
            <div class="modal-head">
                <h3 id="modalTitle">{{ __('messages.findmyfbid.modal.title') }}</h3>
                <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>
            </div>
            <div class="modal-sub">{{ __('messages.findmyfbid.modal.subtitle') }}</div>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/ALOXKMY_fNE?si=OAb30CgzI60aWzsQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            <ol class="modal-steps">
                <li><span class="n">1</span><span>{{ __('messages.findmyfbid.modal.step1') }}</span></li>
                <li><span class="n">2</span><span>{{ __('messages.findmyfbid.modal.step2') }}</span></li>
                <li><span class="n">3</span><span>{{ __('messages.findmyfbid.modal.step3') }}</span></li>
            </ol>
            <div class="modal-cta">
                <a href="https://www.facebook.com/settings/?tab=how_people_find_and_contact_you" target="_blank" rel="noopener nofollow" class="btn btn-primary" style="width:100%;justify-content:center;">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 19H5V5h7V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                    {{ __('messages.findmyfbid.modal.openSettings') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('tutorialModal');
            var video = document.getElementById('tutorialVideo');
            var autoFail = document.body.getAttribute('data-fail') === '1';

            function openModal() {
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
                if (video) video.play();
            }
            function closeModal() {
                modal.classList.remove('show');
                document.body.style.overflow = '';
                if (video) video.pause();
            }

            document.getElementById('openTutorialBtn') &&
                document.getElementById('openTutorialBtn').addEventListener('click', openModal);
            document.getElementById('closeModalBtn') &&
                document.getElementById('closeModalBtn').addEventListener('click', closeModal);

            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });

            if (autoFail) openModal();

            var copyBtns = document.querySelectorAll('[data-copy]');
            copyBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = btn.getAttribute('data-copy');
                    var label = btn.querySelector('.copy-label');
                    function done() {
                        if (label) {
                            var original = label.textContent;
                            label.textContent = '{{ __('messages.findmyfbid.success.copied') }}';
                            setTimeout(function () { label.textContent = original; }, 1800);
                        }
                    }
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(id).then(done)['catch'](function () { fallback(id); done(); });
                    } else {
                        fallback(id); done();
                    }
                });
            });

            function fallback(text) {
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); } catch (e) {}
                document.body.removeChild(ta);
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
</body>
</html>
