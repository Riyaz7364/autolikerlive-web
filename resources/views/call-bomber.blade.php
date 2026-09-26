<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="AutoLikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ request()->url() }}" />
    <title>Auto Liker Live Call Bomber | SMS Bomber Tool - AutoLikerLive</title>
    <meta name="description" content="Auto Liker Live Call Bomber - Professional Call Bomber and SMS Bomber tool for testing call service reliability and delivery rates.">
    <meta name="keywords" content="auto liker live call bomber, call bomber, sms bomber, auto liker, facebook auto liker, free call bomber, bomb call service" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Auto Liker Live Call Bomber | SMS Bomber Tool" />
    <meta property="og:description" content="Auto Liker Live Call Bomber - Professional Call Bomber and SMS Bomber tool for testing call service reliability and delivery rates." />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Auto Liker Live Call Bomber | SMS Bomber Tool" />
    <meta name="twitter:description" content="Professional Call Bomber and SMS Bomber tool for testing call service reliability and delivery rates." />

    <link rel="icon" type="image/png" href="/favicons/bomber/files/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicons/bomber/files/favicon.svg" />
    <link rel="shortcut icon" href="/favicons/bomber/files/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/bomber/files/apple-touch-icon.png" />
    <link rel="manifest" href="/favicons/bomber/files/site.webmanifest" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?render=6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb" async defer></script>
    <x-auto-ads />

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            { "@type": "Question", "name": "Is the call bomber free?", "acceptedAnswer": { "@type": "Answer", "text": "Yes. You can run up to 30 test calls per run, completely free and without creating an account." } },
            { "@type": "Question", "name": "Which numbers can I test?", "acceptedAnswer": { "@type": "Answer", "text": "Only numbers you own or have explicit permission to test. Numbers on the protection blocklist are automatically refused." } },
            { "@type": "Question", "name": "What is the difference between call and SMS testing?", "acceptedAnswer": { "@type": "Answer", "text": "Call testing places automated voice calls through voice gateways, while SMS testing dispatches text messages where the gateway supports it." } },
            { "@type": "Question", "name": "How do the speed settings work?", "acceptedAnswer": { "@type": "Answer", "text": "Slow sends one request every 4 seconds, medium every 2 seconds and fast every 1 second." } },
            { "@type": "Question", "name": "How do I block my number?", "acceptedAnswer": { "@type": "Answer", "text": "Enter your number in the Protect your number box and submit. It is added to the blocklist." } }
        ]
    }
    </script>

    <style>
        /* ============ SMS Bomber — mobile-first, full-bleed ============ */
        *, *::before, *::after { box-sizing: border-box; }
        html { -webkit-text-size-adjust: 100%; }
        body {
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1c1e21;
            background:
                radial-gradient(900px 420px at 10% -8%, rgba(79,70,229,.14), transparent 60%),
                radial-gradient(900px 420px at 90% -8%, rgba(22,163,74,.10), transparent 60%),
                #eef1f6;
            line-height: 1.55;
            min-height: 100vh;
        }

        .sb-topbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e4e6eb;
        }
        .sb-topbar-in {
            max-width: 960px; margin: 0 auto;
            padding: 10px 14px;
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
        }
        .sb-brand { display: flex; align-items: center; gap: 10px; color: #1c1e21; font-weight: 800; font-size: 16px; text-decoration: none; }
        .sb-brand-badge {
            width: 36px; height: 36px; border-radius: 11px; flex-shrink: 0;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: grid; place-items: center; color: #fff;
            box-shadow: 0 5px 14px rgba(79,70,229,.35);
        }
        .sb-brand-badge svg { width: 19px; height: 19px; }
        .sb-brand small { display: block; font-size: 11px; font-weight: 500; color: #65676b; }
        .sb-nav { display: flex; gap: 8px; }
        .sb-nav a {
            font-size: 13px; font-weight: 600; color: #1c1e21; text-decoration: none;
            border: 1px solid #e4e6eb; background: #fff; border-radius: 9px; padding: 8px 12px;
        }
        .sb-nav a:hover { border-color: #4f46e5; color: #4f46e5; }

        .sb-wrap { max-width: 960px; margin: 0 auto; padding: 14px 12px 44px; display: flex; flex-direction: column; gap: 16px; }

        /* ---- Hero ---- */
        .sb-hero {
            position: relative; overflow: hidden;
            border-radius: 18px; padding: 22px 18px;
            color: #fff; background: linear-gradient(135deg, #312e81 0%, #4f46e5 45%, #7c3aed 100%);
            box-shadow: 0 14px 36px rgba(79,70,229,.28);
        }
        .sb-hero::before {
            content: ''; position: absolute; width: 340px; height: 340px; right: -120px; top: -140px;
            background: radial-gradient(closest-side, rgba(255,255,255,.22), transparent 70%); pointer-events: none;
        }
        .sb-hero-in { position: relative; z-index: 1; display: flex; gap: 16px; align-items: center; }
        .sb-hero-txt { flex: 1; min-width: 0; }
        .sb-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.28);
            color: #fff; font-size: 12px; font-weight: 600; padding: 6px 12px; border-radius: 999px;
        }
        .sb-badge .dot { width: 7px; height: 7px; border-radius: 50%; background: #4ade80; box-shadow: 0 0 0 3px rgba(74,222,128,.25); animation: sb-pulse 1.8s infinite; }
        @keyframes sb-pulse { 0%,100% { opacity: 1; } 50% { opacity: .45; } }
        .sb-hero h1 { color: #fff; font-size: 24px; font-weight: 800; letter-spacing: -.02em; line-height: 1.15; margin: 10px 0 8px; }
        .sb-hero h1 .grad { background: linear-gradient(90deg, #fde68a, #f9a8d4); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .sb-hero p { color: rgba(255,255,255,.85); font-size: 14px; margin: 0; }
        .sb-pills { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 12px; }
        .sb-pills span {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22);
            color: #fff; font-size: 12px; font-weight: 600; padding: 6px 11px; border-radius: 999px;
        }
        .sb-pills svg { width: 13px; height: 13px; flex-shrink: 0; }
        .sb-hero-art img { width: 104px; height: auto; border-radius: 22px; box-shadow: 0 14px 34px rgba(0,0,0,.35); flex-shrink: 0; }
        .sb-notice {
            position: relative; z-index: 1;
            display: flex; gap: 9px; align-items: flex-start;
            margin-top: 14px; background: rgba(0,0,0,.28); border: 1px solid rgba(255,255,255,.25);
            border-radius: 12px; padding: 10px 12px; font-size: 12.5px; line-height: 1.6; color: #fff;
        }
        .sb-notice svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px; color: #fde68a; }
        .sb-notice strong { color: #fde68a; }

        /* ---- Tool card ---- */
        .sb-card { background: #fff; border: 1px solid #e4e6eb; border-radius: 18px; box-shadow: 0 10px 30px rgba(28,30,33,.07); overflow: hidden; }
        .sb-card-head { padding: 18px; color: #fff; background: linear-gradient(120deg, #4f46e5, #7c3aed); position: relative; overflow: hidden; }
        .sb-card-head::after { content: ''; position: absolute; width: 220px; height: 220px; right: -80px; top: -100px; background: radial-gradient(closest-side, rgba(255,255,255,.25), transparent 70%); }
        .sb-card-head h2 { position: relative; z-index: 1; color: #fff; font-size: 18px; font-weight: 800; margin: 0 0 2px; display: flex; align-items: center; gap: 9px; }
        .sb-card-head h2 svg { width: 20px; height: 20px; }
        .sb-card-head p { position: relative; z-index: 1; margin: 0; color: rgba(255,255,255,.85); font-size: 13.5px; }
        .sb-card-body { padding: 16px 14px; display: flex; flex-direction: column; gap: 16px; }

        .sb-flash { display: flex; align-items: center; gap: 10px; background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; font-size: 14px; font-weight: 600; border-radius: 12px; padding: 12px 14px; }
        .sb-flash svg { width: 18px; height: 18px; flex-shrink: 0; }

        .sb-label { display: flex; align-items: center; gap: 7px; font-size: 13.5px; font-weight: 700; margin-bottom: 8px; }
        .sb-label svg { width: 16px; height: 16px; color: #4f46e5; flex-shrink: 0; }
        .sb-label small { font-weight: 500; color: #65676b; }
        .sb-chips { display: flex; flex-wrap: wrap; gap: 6px; }
        .sb-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: #eef2ff; border: 1px solid #c7d2fe; color: #4338ca;
            font-size: 12px; font-weight: 700; padding: 6px 11px; border-radius: 999px;
        }
        .sb-chip .dot { width: 7px; height: 7px; border-radius: 50%; background: #16a34a; }
        .sb-empty { font-size: 13.5px; color: #65676b; background: #f0f2f5; border-radius: 10px; padding: 12px 14px; }

        .sb-field { min-width: 0; }
        .sb-phone-row { display: flex; gap: 8px; }
        .sb-select, .sb-input {
            font-family: inherit; border: 2px solid #e4e6eb; border-radius: 12px;
            padding: 13px 12px; font-size: 16px; color: #1c1e21; background: #fff;
            transition: border-color .2s, box-shadow .2s; width: 100%; min-width: 0;
        }
        .sb-select { flex: 0 1 118px; min-width: 0; cursor: pointer; font-size: 14px; padding-left: 8px; padding-right: 4px; }
        .sb-input { flex: 1; }
        .sb-input::placeholder { color: #9aa0a6; }
        .sb-select:focus, .sb-input:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 4px rgba(79,70,229,.13); }
        .sb-hint { font-size: 12px; color: #65676b; margin-top: 6px; }

        .sb-seg { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .sb-seg3 { grid-template-columns: 1fr 1fr 1fr; }
        .sb-seg input { position: absolute; opacity: 0; pointer-events: none; }
        .sb-seg label {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            border: 2px solid #e4e6eb; border-radius: 12px; padding: 12px 6px;
            font-size: 13.5px; font-weight: 700; color: #65676b; cursor: pointer; transition: .18s; text-align: center;
        }
        .sb-seg label svg { width: 16px; height: 16px; flex-shrink: 0; }
        .sb-seg input:checked + label { border-color: #4f46e5; background: #eef2ff; color: #4338ca; box-shadow: 0 0 0 3px rgba(79,70,229,.12); }
        .sb-seg input:disabled + label { opacity: .45; cursor: not-allowed; background: #f0f2f5; }

        .sb-count-row { display: flex; gap: 8px; align-items: stretch; }
        .sb-count-row .sb-input { text-align: center; font-weight: 800; }
        .sb-count-row input[type=number] { -moz-appearance: textfield; appearance: textfield; }
        .sb-count-row input::-webkit-outer-spin-button, .sb-count-row input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .sb-preset {
            border: 2px solid #e4e6eb; background: #fff; color: #4f46e5;
            font-weight: 800; font-size: 13px; font-family: inherit;
            border-radius: 12px; padding: 0 12px; cursor: pointer; transition: .18s; flex-shrink: 0;
        }
        .sb-preset:hover, .sb-preset.active { border-color: #4f46e5; background: #eef2ff; }

        .sb-status { display: none; align-items: center; gap: 10px; border-radius: 12px; padding: 12px 14px; font-size: 13.5px; font-weight: 600; }
        .sb-status.show { display: flex; }
        .sb-status.ok { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
        .sb-status.err { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
        .sb-progress { display: none; }
        .sb-progress.show { display: block; }
        .sb-progress-top { display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #4338ca; margin-bottom: 8px; }
        .sb-bar { height: 10px; border-radius: 999px; background: #eef2ff; overflow: hidden; }
        .sb-bar-fill { height: 100%; width: 0%; border-radius: 999px; background: linear-gradient(90deg, #4f46e5, #8b5cf6); transition: width .3s ease; }

        .sb-actions { display: flex; gap: 10px; }
        .sb-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 9px;
            font-family: inherit; font-size: 15px; font-weight: 800;
            border: 0; border-radius: 14px; cursor: pointer;
            padding: 15px 20px; transition: transform .15s, box-shadow .2s, opacity .2s;
            flex: 1;
        }
        .sb-btn svg { width: 19px; height: 19px; flex-shrink: 0; }
        .sb-btn-start { color: #fff; background: linear-gradient(120deg, #16a34a, #059669); box-shadow: 0 8px 20px rgba(22,163,74,.35); }
        .sb-btn-start:hover { transform: translateY(-1px); }
        .sb-btn-stop { color: #fff; background: linear-gradient(120deg, #dc2626, #b91c1c); flex: 0 0 130px; }
        .sb-btn:disabled { opacity: .7; cursor: wait; transform: none; }
        .sb-spinner { display: none; width: 18px; height: 18px; flex-shrink: 0; border: 2.5px solid rgba(255,255,255,.4); border-top-color: #fff; border-radius: 50%; animation: sb-spin .7s linear infinite; }
        .sb-btn.loading .sb-spinner { display: inline-block; }
        @keyframes sb-spin { to { transform: rotate(360deg); } }
        .sb-stay { text-align: center; font-size: 12px; color: #65676b; }

        .sb-success { display: none; text-align: center; background: #f0fdf4; border: 1.5px dashed #86efac; border-radius: 16px; padding: 26px 18px; }
        .sb-success.show { display: block; }
        .sb-success .big-icon { width: 58px; height: 58px; margin: 0 auto 12px; border-radius: 50%; background: #dcfce7; color: #16a34a; display: grid; place-items: center; }
        .sb-success .big-icon svg { width: 30px; height: 30px; }
        .sb-success h3 { color: #15803d; font-size: 18px; font-weight: 800; margin: 0 0 6px; }
        .sb-success p { color: #65676b; font-size: 13.5px; margin: 0 0 16px; }

        .sb-info { display: flex; gap: 10px; align-items: flex-start; border-radius: 14px; padding: 13px 14px; font-size: 13px; line-height: 1.65; }
        .sb-info svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; }
        .sb-info.blue { background: #eff6ff; border: 1px solid #bfdbfe; }
        .sb-info.blue svg { color: #2563eb; }
        .sb-info h4 { font-size: 13.5px; font-weight: 800; margin: 0 0 3px; }
        .sb-info p { margin: 0; color: #4b5563; }

        .sb-protect { background: #f8faff; border: 1.5px dashed #c7d2fe; border-radius: 16px; padding: 16px 14px; }
        .sb-protect h4 { display: flex; align-items: center; gap: 8px; font-size: 14.5px; font-weight: 800; color: #4338ca; margin: 0 0 3px; }
        .sb-protect h4 svg { width: 17px; height: 17px; }
        .sb-protect p { font-size: 13px; color: #65676b; margin: 0 0 10px; }
        .sb-protect-row { display: flex; flex-direction: column; gap: 8px; }
        .sb-btn-protect { background: #4f46e5; color: #fff; box-shadow: 0 6px 16px rgba(79,70,229,.3); }
        .sb-btn-protect:hover { background: #4338ca; }

        /* ---- Content sections ---- */
        .sb-sec-title { font-size: 20px; font-weight: 800; letter-spacing: -.01em; margin: 8px 0 2px; text-align: center; }
        .sb-sec-sub { text-align: center; color: #65676b; font-size: 14px; margin: 0 0 16px; }
        .sb-grid3 { display: grid; grid-template-columns: 1fr; gap: 10px; }
        .sb-feat {
            background: #fff; border: 1px solid #e4e6eb; border-radius: 16px;
            padding: 18px 16px; display: flex; gap: 13px; align-items: flex-start;
            box-shadow: 0 4px 14px rgba(28,30,33,.05);
        }
        .sb-feat .ic { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; flex-shrink: 0; }
        .sb-feat .ic svg { width: 23px; height: 23px; }
        .sb-feat .ic.indigo { background: #eef2ff; color: #4f46e5; }
        .sb-feat .ic.amber { background: #fffbeb; color: #d97706; }
        .sb-feat .ic.green { background: #ecfdf5; color: #16a34a; }
        .sb-feat h3 { font-size: 15px; font-weight: 800; margin: 0 0 4px; }
        .sb-feat p { font-size: 13.5px; color: #65676b; margin: 0; line-height: 1.6; }

        .sb-cols { display: grid; grid-template-columns: 1fr; gap: 10px; }
        .sb-list-card { background: #fff; border: 1px solid #e4e6eb; border-radius: 16px; padding: 18px 16px; }
        .sb-list-card h3 { display: flex; align-items: center; gap: 8px; font-size: 15px; font-weight: 800; margin: 0 0 12px; }
        .sb-list-card h3 svg { width: 19px; height: 19px; }
        .sb-list-card.do h3 { color: #15803d; }
        .sb-list-card.dont h3 { color: #b45309; }
        .sb-list-card ul { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 9px; }
        .sb-list-card li { display: flex; gap: 8px; align-items: flex-start; font-size: 13.5px; color: #4b5563; line-height: 1.55; }
        .sb-list-card li svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px; }
        .sb-list-card.do li svg { color: #16a34a; }
        .sb-list-card.dont li svg { color: #dc2626; }
        .sb-legal { text-align: center; font-size: 12.5px; color: #65676b; background: #fff; border: 1px solid #e4e6eb; border-radius: 14px; padding: 15px 16px; line-height: 1.7; }
        .sb-legal strong { color: #1c1e21; }

        .sb-faq { display: flex; flex-direction: column; gap: 8px; }
        .sb-faq details { background: #fff; border: 1px solid #e4e6eb; border-radius: 13px; padding: 14px 15px; }
        .sb-faq summary { font-weight: 700; font-size: 14.5px; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .sb-faq summary::-webkit-details-marker { display: none; }
        .sb-faq summary svg { width: 18px; height: 18px; color: #4f46e5; flex-shrink: 0; transition: transform .2s; }
        .sb-faq details[open] summary svg { transform: rotate(180deg); }
        .sb-faq details p { color: #65676b; font-size: 13.5px; margin: 9px 0 0; line-height: 1.7; }

        .sb-tools { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
        .sb-tools a { padding: 10px 16px; border-radius: 999px; background: #eef2ff; color: #4338ca; font-weight: 700; font-size: 13.5px; border: 1px solid #e0e7ff; text-decoration: none; transition: .18s; }
        .sb-tools a:hover { background: #4f46e5; color: #fff; border-color: #4f46e5; }

        .sb-ad { text-align: center; overflow: hidden; }
        .sb-ad-desktop { display: none; }
        .sb-ad-mobile { display: block; }

        .sb-footer { background: #fff; border-top: 1px solid #e4e6eb; padding: 22px 14px; text-align: center; }
        .sb-footer .links { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; margin-bottom: 8px; }
        .sb-footer a { color: #65676b; font-size: 13.5px; font-weight: 600; text-decoration: none; }
        .sb-footer a:hover { color: #4f46e5; }
        .sb-footer .copy { color: #9aa0a6; font-size: 12.5px; }

        /* ---- Tablet / desktop ---- */
        @media (min-width: 640px) {
            .sb-wrap { padding: 22px 20px 56px; gap: 22px; }
            .sb-hero { border-radius: 22px; padding: 34px 32px; }
            .sb-hero h1 { font-size: clamp(28px, 4vw, 40px); }
            .sb-hero p { font-size: 16px; }
            .sb-hero-art img { width: clamp(130px, 16vw, 190px); }
            .sb-card { border-radius: 22px; }
            .sb-card-head { padding: 22px 28px; }
            .sb-card-head h2 { font-size: 20px; }
            .sb-card-body { padding: 26px; gap: 20px; }
            .sb-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
            .sb-protect-row { flex-direction: row; }
            .sb-protect-row .sb-input { flex: 1; }
            .sb-protect-row .sb-btn { flex: 0 0 auto; }
            .sb-grid3 { grid-template-columns: repeat(3, 1fr); gap: 14px; }
            .sb-feat { flex-direction: column; text-align: center; align-items: center; padding: 24px 18px; }
            .sb-cols { grid-template-columns: 1fr 1fr; gap: 14px; }
            .sb-ad-desktop { display: block; }
            .sb-ad-mobile { display: none; }
            .sb-sec-title { font-size: clamp(22px, 3vw, 28px); }
        }
    </style>
</head>
<body>

    <header class="sb-topbar">
        <div class="sb-topbar-in">
            <a href="{{ url('/') }}" class="sb-brand">
                <span class="sb-brand-badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg></span>
                <span>Call Bomber<small>by AutoLikerLive</small></span>
            </a>
            <nav class="sb-nav">
                <a href="{{ route('sms-bomber') }}">SMS Bomber</a>
                <a href="{{ url('services') }}">All Tools</a>
            </nav>
        </div>
    </header>

    <div class="sb-wrap">

        {{-- ============ Hero ============ --}}
        <section class="sb-hero">
            <div class="sb-hero-in">
                <div class="sb-hero-txt">
                    <span class="sb-badge"><span class="dot"></span> Free load-testing tool &middot; No signup</span>
                    <h1>Call Bomber &mdash; <span class="grad">Test Call Delivery</span> in Seconds</h1>
                    <p>Fire test calls through live voice gateways to verify delivery rates and service reliability on numbers you own or are authorized to test.</p>
                    <div class="sb-pills">
                        <span><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> 100% Free</span>
                        <span><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2.05v2.02c3.95.49 7 3.85 7 7.93 0 1.45-.39 2.81-1.06 3.98l1.46 1.46C21.59 15.67 22 13.89 22 12c0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-1.46-1.46C16.14 17.85 14.18 19 12 19z"/></svg> Up to 30 tests</span>
                        <span><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg> Consent required</span>
                    </div>
                </div>
                <div class="sb-hero-art">
                    <img src="{{ asset('images/smsbomberiocn.webp') }}" alt="SMS Bomber tool illustration" width="190" height="190" loading="lazy">
                </div>
            </div>
            <div class="sb-notice">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 21h22L12 2zm1 14h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                <span><strong>Professional use only.</strong> Only test numbers you own or have explicit permission to test. Misuse for spam or harassment is strictly prohibited.</span>
            </div>
        </section>

        @if (session()->has('message'))
            <div class="sb-flash" role="status">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                {{ session('message') }}
            </div>
        @endif

        {{-- ============ Tool card ============ --}}
        <section class="sb-card" aria-label="SMS testing tool">
            <div class="sb-card-head">
                <h2><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg> SMS Service Tester</h2>
                <p>Pick a gateway region, enter the target number and start your call delivery test.</p>
            </div>
            <div class="sb-card-body">

                <div>
                    <div class="sb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 8h16v11H4z" opacity=".3"/><path d="M20 6H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 13H4V8h16v11z"/></svg> Available gateway regions</div>
                    @if (isset($status) && count($status))
                        <div class="sb-chips">
                            @foreach ($status as $item)
                                <span class="sb-chip"><span class="dot"></span>{{ $item->name }} (+{{ $item->code }})</span>
                            @endforeach
                        </div>
                    @else
                        <div class="sb-empty">No gateway regions are online right now. Please try again later.</div>
                    @endif
                </div>

                <div class="sb-success" id="smsb-success" role="status">
                    <div class="big-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>
                    <h3>Testing completed</h3>
                    <p id="smsb-success-text">All test messages were dispatched. Check the handset delivery report.</p>
                    <div class="sb-actions" style="justify-content:center">
                        <button type="button" class="sb-btn sb-btn-protect" id="smsb-again" style="flex:0 0 auto;padding:13px 30px">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.65 6.35A7.958 7.958 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/></svg>
                            Run a new test
                        </button>
                    </div>
                </div>

                <form id="smsb-form" method="post" novalidate>
                    @csrf
                    <div class="sb-form-grid">
                        <div class="sb-field">
                            <div class="sb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24 11.4 11.4 0 0 0 3.57.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02z"/></svg> Target phone number</div>
                            <div class="sb-phone-row">
                                <select name="code" id="smsb-code" class="sb-select" aria-label="Country code">
                                    @foreach ($status ?? [] as $item)
                                        <option value="{{ $item->code }}" data-item="{{ json_encode($item) }}">{{ $item->name }} (+{{ $item->code }})</option>
                                    @endforeach
                                </select>
                                <input id="smsb-number" type="tel" inputmode="numeric" autocomplete="tel" name="number" class="sb-input" placeholder="e.g. 01712345678" required>
                                <input type="hidden" id="smsb-recaptcha" name="recaptcha-token">
                            </div>
                            <div class="sb-hint">Number only, without the country code or leading +.</div>
                        </div>

                        <div class="sb-field">
                            <div class="sb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/></svg> Test type</div>
                            <div class="sb-seg" role="radiogroup" aria-label="Test type">
                                <input type="radio" name="call" id="smsb-mode-sms" value="0">
                                <label for="smsb-mode-sms"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg> SMS test</label>
                                <input type="radio" name="call" id="smsb-mode-call" value="1" checked>
                                <label for="smsb-mode-call"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24 11.4 11.4 0 0 0 3.57.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02z"/></svg> Call test</label>
                            </div>
                            <div class="sb-hint" id="smsb-mode-hint">Call testing is available for this region.</div>
                        </div>

                        <div class="sb-field">
                            <div class="sb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2.05v2.02c3.95.49 7 3.85 7 7.93 0 1.45-.39 2.81-1.06 3.98l1.46 1.46C21.59 15.67 22 13.89 22 12c0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-1.46-1.46C16.14 17.85 14.18 19 12 19z"/></svg> Test count <small>(max 30)</small></div>
                            <div class="sb-count-row">
                                <input id="smsb-count" type="number" class="sb-input" value="5" min="1" max="30" step="1" inputmode="numeric" required>
                                <button type="button" class="sb-preset" data-count="5">5</button>
                                <button type="button" class="sb-preset" data-count="10">10</button>
                                <button type="button" class="sb-preset" data-count="20">20</button>
                            </div>
                        </div>

                        <div class="sb-field">
                            <div class="sb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg> Test speed</div>
                            <div class="sb-seg sb-seg3" role="radiogroup" aria-label="Test speed">
                                <input type="radio" name="speed" id="smsb-slow" value="slow">
                                <label for="smsb-slow">Slow</label>
                                <input type="radio" name="speed" id="smsb-medium" value="medium">
                                <label for="smsb-medium">Med</label>
                                <input type="radio" name="speed" id="smsb-fast" value="fast" checked>
                                <label for="smsb-fast">Fast</label>
                            </div>
                            <div class="sb-hint">Slow · 4s &nbsp;/&nbsp; Medium · 2s &nbsp;/&nbsp; Fast · 1s per request.</div>
                        </div>
                    </div>

                    <div style="margin-top:16px;display:flex;flex-direction:column;gap:12px">
                        <div class="sb-status" id="smsb-status" role="status"></div>

                        <div class="sb-progress" id="smsb-progress">
                            <div class="sb-progress-top"><span id="smsb-progress-text">0 / 0 sent</span><span id="smsb-progress-pct">0%</span></div>
                            <div class="sb-bar"><div class="sb-bar-fill" id="smsb-bar"></div></div>
                            <div class="sb-hint" id="smsb-note" style="margin-top:8px">Preparing secure request...</div>
                        </div>

                        <div class="sb-actions">
                            <button class="sb-btn sb-btn-start" type="submit" id="smsb-start">
                                <span class="sb-spinner"></span>
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                <span id="smsb-start-text">Start test</span>
                            </button>
                            <button class="sb-btn sb-btn-stop" type="button" id="smsb-stop" hidden>
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 6h12v12H6z"/></svg>
                                Stop
                            </button>
                        </div>
                        <div class="sb-stay">Keep this tab open while the test runs for accurate results.</div>
                    </div>
                </form>

                <div class="sb-info blue">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    <div><h4>Testing guidelines</h4><p>This tool is for legitimate SMS gateway testing and debugging only. You must own the target number or have explicit consent from its owner, and you must comply with your local telecommunications laws.</p></div>
                </div>

                <div class="sb-protect">
                    <h4><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg> Protect your number</h4>
                    <p>Add a number to the blocklist and this tool will refuse to test it.</p>
                    <form action="{{ route('save-bomber') }}" method="post">
                        @csrf
                        <div class="sb-protect-row">
                            <input type="text" class="sb-input" name="number" inputmode="numeric" placeholder="Mobile number without country code" required>
                            <button type="submit" class="sb-btn sb-btn-protect">Protect number</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

        <div class="sb-ad sb-ad-desktop">
            <x-ads.leaderboard />
        </div>
        <div class="sb-ad sb-ad-mobile">
            <x-ads.mobile-banner />
        </div>

        {{-- ============ Info ============ --}}
        <section>
            <h2 class="sb-sec-title">Why test your call gateway?</h2>
            <p class="sb-sec-sub">Delivery rates vary by carrier, region and time of day. Verify before you deploy.</p>
            <div class="sb-grid3">
                <div class="sb-feat">
                    <div class="ic indigo"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg></div>
                    <div><h3>Real delivery checks</h3><p>Place live test calls through production voice gateways and confirm they actually connect on the handset.</p></div>
                </div>
                <div class="sb-feat">
                    <div class="ic amber"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg></div>
                    <div><h3>Responsible by design</h3><p>Built-in 30-message cap, consent requirement and a self-serve blocklist keep testing legitimate.</p></div>
                </div>
                <div class="sb-feat">
                    <div class="ic green"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg></div>
                    <div><h3>Call + SMS gateways</h3><p>Compare voice and SMS OTP delivery side by side and find the most reliable service for your region.</p></div>
                </div>
            </div>
        </section>

        {{-- ============ Best practices ============ --}}
        <section>
            <h2 class="sb-sec-title">Call Testing Best Practices</h2>
            <p class="sb-sec-sub">Professional guidelines for responsible call testing.</p>
            <div class="sb-cols">
                <div class="sb-list-card do">
                    <h3><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Recommended</h3>
                    <ul>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Always get explicit consent before testing a number you don't own.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Prefer your own devices or dedicated test numbers where possible.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Use slow speed for carrier-sensitive routes; fast for load checks.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Document your test runs for compliance and debugging.</li>
                    </ul>
                </div>
                <div class="sb-list-card dont">
                    <h3><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 21h22L12 2zm1 14h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg> Never do this</h3>
                    <ul>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Never use this tool for harassment, spam or pranks.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Never test strangers' numbers without their permission.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Never ignore local telecom and privacy regulations.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg> Never exceed what you need — small samples are usually enough.</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- ============ FAQ ============ --}}
        <section>
            <h2 class="sb-sec-title">Frequently asked questions</h2>
            <p class="sb-sec-sub">Everything you need to know before running a test.</p>
            <div class="sb-faq">
                <details open>
                    <summary>Is the call bomber free? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Yes. You can run up to 30 test calls per run, completely free and without creating an account. Just pick a gateway region, enter the number and start.</p>
                </details>
                <details>
                    <summary>Which numbers can I test? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Only numbers you own or have explicit permission to test. Numbers on our protection blocklist are automatically refused, and abuse may lead to access restrictions.</p>
                </details>
                <details>
                    <summary>What is the difference between call and SMS testing? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Call testing places automated voice calls through voice gateways, while SMS testing dispatches text messages. Call testing is only enabled for regions where the gateway supports it — otherwise the option is disabled automatically.</p>
                </details>
                <details>
                    <summary>How do the speed settings work? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Slow sends one request every 4 seconds, medium every 2 seconds and fast every 1 second. Use slow for sensitive carrier routes and fast when you want a quick load sample.</p>
                </details>
                <details>
                    <summary>How do I block my number? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Enter your number in the "Protect your number" box above and submit. It is added to the blocklist and this tool will refuse any future test against it.</p>
                </details>
            </div>
        </section>

        <div class="sb-legal">
            <strong>Legal compliance notice.</strong> This tool is provided for legitimate call testing and development purposes only. You are responsible for complying with all applicable laws and carrier terms. We do not condone harassment, spam or any other misuse.
        </div>

        <section>
            <h2 class="sb-sec-title">More free tools</h2>
            <p class="sb-sec-sub">Keep exploring AutoLikerLive.</p>
            <div class="sb-tools">
                <a href="{{ route('sms-bomber') }}">SMS Bomber</a>
                <a href="{{ route('temp-mail') }}">Temp Mail</a>
                <a href="{{ route('free-tiktok-views') }}">TikTok Views</a>
                <a href="{{ route('free-tiktok-likes') }}">TikTok Likes</a>
                <a href="{{ route('free-instagram-likes') }}">Instagram Likes</a>
                <a href="{{ url('services') }}">All Tools</a>
            </div>
        </section>

    </div>

    <footer class="sb-footer">
        <div class="links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('services') }}">All Tools</a>
            <a href="{{ route('sms-bomber') }}">SMS Bomber</a>
            <a href="{{ url('privacy') }}">Privacy</a>
            <a href="{{ url('terms') }}">Terms</a>
        </div>
        <div class="copy">&copy; autolikerlive.com &mdash; For entertainment purposes only.</div>
    </footer>

    <script>
        (function () {
            var form = document.getElementById('smsb-form');
            var codeSelect = document.getElementById('smsb-code');
            var numberInput = document.getElementById('smsb-number');
            var countInput = document.getElementById('smsb-count');
            var recaptchaInput = document.getElementById('smsb-recaptcha');
            var modeSms = document.getElementById('smsb-mode-sms');
            var modeCall = document.getElementById('smsb-mode-call');
            var modeHint = document.getElementById('smsb-mode-hint');
            var statusBox = document.getElementById('smsb-status');
            var progress = document.getElementById('smsb-progress');
            var progressText = document.getElementById('smsb-progress-text');
            var progressPct = document.getElementById('smsb-progress-pct');
            var bar = document.getElementById('smsb-bar');
            var startBtn = document.getElementById('smsb-start');
            var startText = document.getElementById('smsb-start-text');
            var stopBtn = document.getElementById('smsb-stop');
            var successPanel = document.getElementById('smsb-success');
            var successText = document.getElementById('smsb-success-text');
            var noteBox = document.getElementById('smsb-note');
            var csrf = document.querySelector('meta[name="csrf-token"]');
            var csrfToken = csrf ? csrf.getAttribute('content') : '';

            var SPEED_DELAY = { slow: 4000, medium: 2000, fast: 1000 };
            var MAX_COUNT = 30;

            var running = false;
            var stopRequested = false;
            var controller = null;
            var total = 0;
            var done = 0;

            function showStatus(type, html) {
                statusBox.className = 'sb-status show ' + type;
                statusBox.textContent = html;
            }
            function hideStatus() {
                statusBox.className = 'sb-status';
                statusBox.textContent = '';
            }
            function updateProgress() {
                var pct = total > 0 ? Math.round((done / total) * 100) : 0;
                bar.style.width = pct + '%';
                progressText.textContent = done + ' / ' + total + ' sent';
                progressPct.textContent = pct + '%';
                if (noteBox) noteBox.textContent = done < total ? ('Call attempts are being sent one by one (' + done + ' of ' + total + ').') : 'All call attempts have been finished.';
            }
            function failRun(message) {
                stopRequested = true;
                setBusy(false);
                progress.classList.remove('show');
                showStatus('err', message);
                if (noteBox) noteBox.textContent = message;
            }
            function selectedItem() {
                var opt = codeSelect.options[codeSelect.selectedIndex];
                if (!opt) return null;
                try { return JSON.parse(opt.getAttribute('data-item')); } catch (e) { return null; }
            }
            function syncMode() {
                var item = selectedItem();
                var callsAllowed = !item || parseInt(item.calls, 10) !== 0;
                if (!callsAllowed) {
                    modeSms.checked = true;
                    modeCall.disabled = true;
                    modeHint.textContent = 'Call testing is not available for this region — SMS only.';
                } else {
                    modeCall.disabled = false;
                    modeHint.textContent = 'Call testing is available for this region.';
                }
            }

            countInput.addEventListener('input', function () {
                var v = parseInt(countInput.value, 10);
                if (isNaN(v)) return;
                if (v > MAX_COUNT) countInput.value = MAX_COUNT;
                if (v < 1 && countInput.value !== '') countInput.value = 1;
                document.querySelectorAll('.sb-preset').forEach(function (b) {
                    b.classList.toggle('active', parseInt(b.getAttribute('data-count'), 10) === parseInt(countInput.value, 10));
                });
            });
            document.querySelectorAll('.sb-preset').forEach(function (b) {
                b.addEventListener('click', function () {
                    countInput.value = b.getAttribute('data-count');
                    countInput.dispatchEvent(new Event('input'));
                });
            });

            codeSelect.addEventListener('change', syncMode);
            syncMode();

            function setBusy(busy) {
                running = busy;
                startBtn.disabled = busy;
                startBtn.classList.toggle('loading', busy);
                startText.textContent = busy ? 'Testing…' : 'Start test';
                stopBtn.hidden = !busy;
                codeSelect.disabled = busy;
                numberInput.disabled = busy;
                countInput.disabled = busy;
            }

            function finish() {
                setBusy(false);
                progress.classList.remove('show');
                if (!stopRequested && done >= total && total > 0) {
                    form.style.display = 'none';
                    successText.textContent = 'All ' + total + ' test requests were dispatched. Check the handset delivery report.';
                    successPanel.classList.add('show');
                    successPanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            function sendOne(delay) {
                if (stopRequested || done >= total) { finish(); return; }
                if (noteBox) noteBox.textContent = 'Connecting to gateway ' + (done + 1) + ' of ' + total + '...';
                if (typeof grecaptcha === 'undefined' || !grecaptcha.execute) {
                    showStatus('err', 'Captcha failed to load. Please refresh and try again.');
                    setBusy(false);
                    return;
                }
                grecaptcha.ready(function () {
                    if (stopRequested) { finish(); return; }
                    grecaptcha.execute('6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb', { action: 'submit' }).then(function (token) {
                        if (stopRequested) { finish(); return; }
                        recaptchaInput.value = token;
                        controller = new AbortController();
                        fetch('{{ route('send-bomber') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: new FormData(form),
                            signal: controller.signal
                        }).then(function (res) { return res.json().catch(function () { return {}; }); }).then(function (data) {
                            if (data && data.success === false) { failRun(data.message || 'Request failed. Please try again.'); return; }
                            done++;
                            updateProgress();
                            if (done < total) {
                                setTimeout(function () { sendOne(delay); }, delay);
                            } else {
                                finish();
                            }
                        }).catch(function (err) {
                            if (err && err.name === 'AbortError') return;
                            done++;
                            updateProgress();
                            if (done < total && !stopRequested) {
                                setTimeout(function () { sendOne(delay); }, delay);
                            } else {
                                finish();
                            }
                        });
                    }).catch(function () {
                        showStatus('err', 'Captcha verification failed. Please try again.');
                        setBusy(false);
                    });
                });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                if (running) return;

                var number = (numberInput.value || '').trim();
                if (!number) {
                    showStatus('err', 'Please enter the target phone number.');
                    numberInput.focus();
                    return;
                }
                total = parseInt(countInput.value, 10) || 0;
                if (total < 1) total = 1;
                if (total > MAX_COUNT) { total = MAX_COUNT; countInput.value = MAX_COUNT; }

                var speed = (form.querySelector('input[name="speed"]:checked') || {}).value || 'fast';
                var delay = SPEED_DELAY[speed] || 1000;

                hideStatus();
                successPanel.classList.remove('show');
                form.style.display = '';
                done = 0;
                stopRequested = false;
                progress.classList.add('show');
                updateProgress();
                setBusy(true);
                showStatus('ok', 'Test started — sending ' + total + ' request(s)…');
                sendOne(delay);
            });

            stopBtn.addEventListener('click', function () {
                stopRequested = true;
                if (controller) { try { controller.abort(); } catch (e) {} }
                showStatus('err', 'Stopping… finishing the current request.');
                setBusy(false);
                progress.classList.remove('show');
            });

            document.getElementById('smsb-again').addEventListener('click', function () {
                successPanel.classList.remove('show');
                form.style.display = '';
                form.reset();
                document.getElementById('smsb-fast').checked = true;
                modeSms.checked = true;
                syncMode();
                hideStatus();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();
    </script>
</body>
</html>
