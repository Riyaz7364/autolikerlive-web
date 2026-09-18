@extends('layouts.master')

@section('title', 'SMS Bomber - Free SMS & Call Load Tester')
@section('description', 'Free SMS bomber and call bomber load-testing tool for developers and businesses. Test SMS delivery rates and gateway reliability on your own numbers. Fast, free, no signup.')
@section('keywords', 'sms bomber, call bomber, sms load tester, sms gateway test, free sms bomber, bulk sms test')

@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6Le9PSErAAAAAHw5ToZq73TKSIqMwmuPi7y4wZkj" async defer></script>
@stop

@push('styles')
    <style>
        /* ============ SMS Bomber page (scoped, no framework dependency) ============ */
        .smsb-wrap { display: flex; flex-direction: column; gap: 22px; }

        /* ---- Hero ---- */
        .smsb-hero {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            padding: clamp(26px, 4vw, 44px);
            color: #fff;
            background: linear-gradient(135deg, #312e81 0%, #4f46e5 45%, #7c3aed 100%);
            box-shadow: 0 18px 44px rgba(79, 70, 229, .28);
        }
        .smsb-hero::before {
            content: '';
            position: absolute;
            width: 420px; height: 420px;
            right: -140px; top: -160px;
            background: radial-gradient(closest-side, rgba(255,255,255,.22), transparent 70%);
            pointer-events: none;
        }
        .smsb-hero::after {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            left: -120px; bottom: -140px;
            background: radial-gradient(closest-side, rgba(0,0,0,.25), transparent 70%);
            pointer-events: none;
        }
        .smsb-hero-inner { position: relative; z-index: 1; display: grid; grid-template-columns: 1fr auto; gap: 24px; align-items: center; }
        .smsb-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.28);
            color: #fff; font-size: 13px; font-weight: 600;
            padding: 7px 14px; border-radius: 999px;
        }
        .smsb-badge .dot { width: 8px; height: 8px; border-radius: 50%; background: #4ade80; box-shadow: 0 0 0 3px rgba(74,222,128,.25); animation: smsb-pulse 1.8s infinite; }
        @keyframes smsb-pulse { 0%,100% { opacity: 1; } 50% { opacity: .45; } }
        .smsb-hero h1 { color: #fff; font-size: clamp(26px, 4vw, 40px); font-weight: 800; letter-spacing: -.02em; line-height: 1.12; margin: 14px 0 10px; }
        .smsb-hero h1 .grad { background: linear-gradient(90deg, #fde68a, #f9a8d4); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .smsb-hero p.smsb-sub { color: rgba(255,255,255,.85); font-size: clamp(14px, 2vw, 17px); max-width: 52ch; margin: 0; }
        .smsb-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 18px; }
        .smsb-pill {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            color: #fff; font-size: 13px; font-weight: 600;
            padding: 7px 13px; border-radius: 999px;
        }
        .smsb-pill svg { width: 15px; height: 15px; flex-shrink: 0; }
        .smsb-hero-art { display: flex; align-items: center; justify-content: center; }
        .smsb-hero-art img {
            width: clamp(120px, 16vw, 190px); height: auto;
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(0,0,0,.35);
            background: rgba(255,255,255,.1);
        }
        .smsb-notice {
            position: relative; z-index: 1;
            display: flex; gap: 10px; align-items: flex-start;
            margin-top: 20px;
            background: rgba(0,0,0,.28);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 14px;
            padding: 12px 15px;
            font-size: 13px; line-height: 1.6; color: #fff;
        }
        .smsb-notice svg { width: 18px; height: 18px; flex-shrink: 0; margin-top: 2px; color: #fde68a; }
        .smsb-notice strong { color: #fde68a; }

        /* ---- Cards ---- */
        .smsb-card {
            background: #fff;
            border: 1px solid #e4e6eb;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(28, 30, 33, .07);
            overflow: hidden;
        }
        .smsb-card-head {
            padding: 22px clamp(18px, 3vw, 30px);
            color: #fff;
            background: linear-gradient(120deg, #4f46e5, #7c3aed);
            position: relative; overflow: hidden;
        }
        .smsb-card-head::after {
            content: ''; position: absolute; width: 260px; height: 260px; right: -90px; top: -110px;
            background: radial-gradient(closest-side, rgba(255,255,255,.25), transparent 70%);
        }
        .smsb-card-head h2 { position: relative; z-index: 1; color: #fff; font-size: 20px; font-weight: 800; margin: 0 0 4px; display: flex; align-items: center; gap: 10px; }
        .smsb-card-head h2 svg { width: 22px; height: 22px; }
        .smsb-card-head p { position: relative; z-index: 1; margin: 0; color: rgba(255,255,255,.82); font-size: 14px; }
        .smsb-card-body { padding: clamp(18px, 3vw, 30px); display: flex; flex-direction: column; gap: 20px; }

        /* ---- Flash ---- */
        .smsb-flash {
            display: flex; align-items: center; gap: 10px;
            background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46;
            font-size: 14px; font-weight: 600;
            border-radius: 12px; padding: 12px 16px;
        }
        .smsb-flash svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ---- Service chips ---- */
        .smsb-label { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #1c1e21; margin-bottom: 10px; }
        .smsb-label svg { width: 17px; height: 17px; color: #4f46e5; }
        .smsb-label small { font-weight: 500; color: #65676b; }
        .smsb-chips { display: flex; flex-wrap: wrap; gap: 7px; }
        .smsb-chip {
            display: inline-flex; align-items: center; gap: 6px;
            background: #eef2ff; border: 1px solid #c7d2fe; color: #4338ca;
            font-size: 12.5px; font-weight: 700;
            padding: 6px 12px; border-radius: 999px;
        }
        .smsb-chip .dot { width: 7px; height: 7px; border-radius: 50%; background: #16a34a; }
        .smsb-empty { font-size: 14px; color: #65676b; background: #f0f2f5; border-radius: 10px; padding: 12px 14px; }

        /* ---- Form grid ---- */
        .smsb-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .smsb-field { min-width: 0; }
        .smsb-phone-row { display: flex; gap: 10px; }
        .smsb-select, .smsb-input {
            font-family: inherit;
            border: 2px solid #e4e6eb;
            border-radius: 12px;
            padding: 13px 14px;
            font-size: 15px;
            color: #1c1e21;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
            min-width: 0;
        }
        .smsb-select { flex: 0 0 132px; cursor: pointer; }
        .smsb-input { flex: 1; }
        .smsb-input::placeholder { color: #9aa0a6; }
        .smsb-select:focus, .smsb-input:focus {
            outline: none; border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, .13);
        }
        /* hide number spinners (we use tel/text inputs) */
        .smsb-hint { font-size: 12.5px; color: #65676b; margin-top: 7px; }

        /* ---- Segmented radios ---- */
        .smsb-seg { display: flex; gap: 8px; }
        .smsb-seg input { position: absolute; opacity: 0; pointer-events: none; }
        .smsb-seg label {
            flex: 1;
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            border: 2px solid #e4e6eb; border-radius: 12px;
            padding: 12px 10px;
            font-size: 14px; font-weight: 700; color: #65676b;
            cursor: pointer; transition: .18s;
            text-align: center;
        }
        .smsb-seg label svg { width: 17px; height: 17px; }
        .smsb-seg input:checked + label { border-color: #4f46e5; background: #eef2ff; color: #4338ca; box-shadow: 0 0 0 3px rgba(79,70,229,.12); }
        .smsb-seg input:disabled + label { opacity: .45; cursor: not-allowed; background: #f0f2f5; }
        .smsb-seg label:hover { border-color: #c7d2fe; }

        /* ---- Count row ---- */
        .smsb-count-row { display: flex; gap: 8px; align-items: stretch; }
        .smsb-count-row .smsb-input { text-align: center; font-weight: 800; font-size: 17px; }
        .smsb-preset {
            border: 2px solid #e4e6eb; background: #fff; color: #4f46e5;
            font-weight: 800; font-size: 13px; font-family: inherit;
            border-radius: 12px; padding: 0 14px; cursor: pointer; transition: .18s;
        }
        .smsb-preset:hover, .smsb-preset.active { border-color: #4f46e5; background: #eef2ff; }

        /* ---- Status / progress ---- */
        .smsb-status {
            display: none; align-items: center; gap: 10px;
            border-radius: 12px; padding: 12px 16px;
            font-size: 14px; font-weight: 600;
        }
        .smsb-status.show { display: flex; }
        .smsb-status.ok { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; }
        .smsb-status.err { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
        .smsb-status svg { width: 18px; height: 18px; flex-shrink: 0; }
        .smsb-progress { display: none; }
        .smsb-progress.show { display: block; }
        .smsb-progress-top { display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #4338ca; margin-bottom: 8px; }
        .smsb-bar { height: 10px; border-radius: 999px; background: #eef2ff; overflow: hidden; }
        .smsb-bar-fill {
            height: 100%; width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            transition: width .3s ease;
        }

        /* ---- Buttons ---- */
        .smsb-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .smsb-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 9px;
            font-family: inherit; font-size: 15px; font-weight: 800;
            border: 0; border-radius: 14px; cursor: pointer;
            padding: 14px 26px; transition: transform .15s, box-shadow .2s, opacity .2s;
            flex: 1; min-width: 170px;
        }
        .smsb-btn svg { width: 19px; height: 19px; }
        .smsb-btn-start { color: #fff; background: linear-gradient(120deg, #16a34a, #059669); box-shadow: 0 8px 20px rgba(22,163,74,.35); }
        .smsb-btn-start:hover { transform: translateY(-1px); box-shadow: 0 12px 26px rgba(22,163,74,.45); }
        .smsb-btn-stop { color: #fff; background: linear-gradient(120deg, #dc2626, #b91c1c); box-shadow: 0 8px 20px rgba(220,38,38,.35); }
        .smsb-btn-stop:hover { transform: translateY(-1px); }
        .smsb-btn:disabled { opacity: .7; cursor: wait; transform: none; }
        .smsb-spinner {
            display: none; width: 18px; height: 18px; flex-shrink: 0;
            border: 2.5px solid rgba(255,255,255,.4); border-top-color: #fff;
            border-radius: 50%; animation: smsb-spin .7s linear infinite;
        }
        .smsb-btn.loading .smsb-spinner { display: inline-block; }
        @keyframes smsb-spin { to { transform: rotate(360deg); } }
        .smsb-stay { text-align: center; font-size: 12.5px; color: #65676b; }

        /* ---- Success panel ---- */
        .smsb-success {
            display: none; text-align: center;
            background: #f0fdf4; border: 1.5px dashed #86efac;
            border-radius: 16px; padding: 30px 22px;
        }
        .smsb-success.show { display: block; }
        .smsb-success .big-icon {
            width: 62px; height: 62px; margin: 0 auto 14px;
            border-radius: 50%; background: #dcfce7; color: #16a34a;
            display: grid; place-items: center;
        }
        .smsb-success .big-icon svg { width: 32px; height: 32px; }
        .smsb-success h3 { color: #15803d; font-size: 19px; font-weight: 800; margin: 0 0 6px; }
        .smsb-success p { color: #65676b; font-size: 14px; margin: 0 0 18px; }

        /* ---- Info boxes ---- */
        .smsb-info {
            display: flex; gap: 11px; align-items: flex-start;
            border-radius: 14px; padding: 14px 16px;
            font-size: 13.5px; line-height: 1.65; color: #1c1e21;
        }
        .smsb-info svg { width: 19px; height: 19px; flex-shrink: 0; margin-top: 2px; }
        .smsb-info.blue { background: #eff6ff; border: 1px solid #bfdbfe; }
        .smsb-info.blue svg { color: #2563eb; }
        .smsb-info.amber { background: #fffbeb; border: 1px solid #fde68a; }
        .smsb-info.amber svg { color: #d97706; }
        .smsb-info h4 { font-size: 14px; font-weight: 800; margin: 0 0 4px; }
        .smsb-info p { margin: 0; color: #4b5563; }

        /* ---- Protect card ---- */
        .smsb-protect { background: #f8faff; border: 1.5px dashed #c7d2fe; border-radius: 16px; padding: 20px; }
        .smsb-protect h4 { display: flex; align-items: center; gap: 8px; font-size: 15px; font-weight: 800; color: #4338ca; margin: 0 0 4px; }
        .smsb-protect h4 svg { width: 18px; height: 18px; }
        .smsb-protect p { font-size: 13.5px; color: #65676b; margin: 0 0 12px; }
        .smsb-protect-row { display: flex; gap: 10px; }
        .smsb-protect-row .smsb-input { flex: 1; }
        .smsb-btn-protect {
            flex: 0 0 auto; min-width: 0;
            background: #4f46e5; color: #fff; box-shadow: 0 6px 16px rgba(79,70,229,.3);
        }
        .smsb-btn-protect:hover { background: #4338ca; }

        /* ---- Content sections ---- */
        .smsb-section-title { font-size: clamp(20px, 3vw, 27px); font-weight: 800; color: #1c1e21; letter-spacing: -.01em; margin: 0 0 4px; text-align: center; }
        .smsb-section-sub { text-align: center; color: #65676b; font-size: 15px; margin: 0 0 22px; }
        .smsb-info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .smsb-info-card {
            background: #fff; border: 1px solid #e4e6eb; border-radius: 18px;
            padding: 24px 20px; text-align: center;
            box-shadow: 0 6px 18px rgba(28,30,33,.05);
            transition: transform .2s, box-shadow .2s;
        }
        .smsb-info-card:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(79,70,229,.12); }
        .smsb-info-card .ic {
            width: 56px; height: 56px; margin: 0 auto 14px;
            border-radius: 18px; display: grid; place-items: center;
        }
        .smsb-info-card .ic svg { width: 27px; height: 27px; }
        .smsb-info-card .ic.indigo { background: #eef2ff; color: #4f46e5; }
        .smsb-info-card .ic.amber { background: #fffbeb; color: #d97706; }
        .smsb-info-card .ic.green { background: #ecfdf5; color: #16a34a; }
        .smsb-info-card h3 { font-size: 16px; font-weight: 800; color: #1c1e21; margin: 0 0 8px; }
        .smsb-info-card p { font-size: 14px; color: #65676b; margin: 0; line-height: 1.65; }

        .smsb-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .smsb-list-card { background: #fff; border: 1px solid #e4e6eb; border-radius: 18px; padding: 24px 22px; }
        .smsb-list-card h3 { display: flex; align-items: center; gap: 9px; font-size: 16px; font-weight: 800; margin: 0 0 14px; }
        .smsb-list-card h3 svg { width: 20px; height: 20px; }
        .smsb-list-card.do h3 { color: #15803d; }
        .smsb-list-card.dont h3 { color: #b45309; }
        .smsb-list-card ul { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 10px; }
        .smsb-list-card li { display: flex; gap: 9px; align-items: flex-start; font-size: 14px; color: #4b5563; line-height: 1.55; }
        .smsb-list-card li svg { width: 17px; height: 17px; flex-shrink: 0; margin-top: 2px; }
        .smsb-list-card.do li svg { color: #16a34a; }
        .smsb-list-card.dont li svg { color: #dc2626; }
        .smsb-legal {
            text-align: center; font-size: 13px; color: #65676b;
            background: #fff; border: 1px solid #e4e6eb; border-radius: 16px;
            padding: 18px 22px; line-height: 1.7;
        }
        .smsb-legal strong { color: #1c1e21; }

        /* ---- FAQ ---- */
        .smsb-faq { display: flex; flex-direction: column; gap: 10px; }
        .smsb-faq details { background: #fff; border: 1px solid #e4e6eb; border-radius: 14px; padding: 16px 18px; }
        .smsb-faq summary { font-weight: 700; font-size: 15px; color: #1c1e21; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .smsb-faq summary::-webkit-details-marker { display: none; }
        .smsb-faq summary svg { width: 18px; height: 18px; color: #4f46e5; flex-shrink: 0; transition: transform .2s; }
        .smsb-faq details[open] summary svg { transform: rotate(180deg); }
        .smsb-faq details p { color: #65676b; font-size: 14px; margin: 10px 0 0; line-height: 1.7; }

        /* ---- Related tools ---- */
        .smsb-tools { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
        .smsb-tools a {
            padding: 10px 18px; border-radius: 999px;
            background: #eef2ff; color: #4338ca; font-weight: 700; font-size: 14px;
            border: 1px solid #e0e7ff; transition: .18s;
        }
        .smsb-tools a:hover { background: #4f46e5; color: #fff; text-decoration: none; border-color: #4f46e5; }

        .smsb-ad { text-align: center; overflow: hidden; }

        /* ---- Responsive ---- */
        @media (max-width: 720px) {
            .smsb-hero-inner { grid-template-columns: 1fr; }
            .smsb-hero-art { display: none; }
            .smsb-grid { grid-template-columns: 1fr; }
            .smsb-info-grid { grid-template-columns: 1fr; }
            .smsb-cols { grid-template-columns: 1fr; }
            .smsb-protect-row { flex-direction: column; }
            .smsb-btn { min-width: 0; }
        }
    </style>
@endpush

@section('content')
    <div class="smsb-wrap">

        {{-- ============ Hero ============ --}}
        <section class="smsb-hero">
            <div class="smsb-hero-inner">
                <div>
                    <span class="smsb-badge"><span class="dot"></span> Free load-testing tool &middot; No signup</span>
                    <h1>SMS Bomber &mdash; <span class="grad">Test SMS Delivery</span> in Seconds</h1>
                    <p class="smsb-sub">Fire test messages through live SMS gateways to verify delivery rates and gateway reliability on numbers you own or are authorized to test.</p>
                    <div class="smsb-pills">
                        <span class="smsb-pill"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> 100% Free</span>
                        <span class="smsb-pill"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2.05v2.02c3.95.49 7 3.85 7 7.93 0 1.45-.39 2.81-1.06 3.98l1.46 1.46C21.59 15.67 22 13.89 22 12c0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-1.46-1.46C16.14 17.85 14.18 19 12 19z"/></svg> Up to 30 tests</span>
                        <span class="smsb-pill"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg> Consent required</span>
                    </div>
                    <div class="smsb-notice">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 21h22L12 2zm1 14h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        <span><strong>Professional use only.</strong> Only test numbers you own or have explicit permission to test. Misuse for spam or harassment is strictly prohibited.</span>
                    </div>
                </div>
                <div class="smsb-hero-art">
                    <img src="{{ asset('images/smsbomberiocn.webp') }}" alt="SMS Bomber tool illustration" width="190" height="190" loading="lazy">
                </div>
            </div>
        </section>

        @if (session()->has('message'))
            <div class="smsb-flash" role="status">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                {{ session('message') }}
            </div>
        @endif

        {{-- ============ Tool card ============ --}}
        <section class="smsb-card" aria-label="SMS testing tool">
            <div class="smsb-card-head">
                <h2><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg> SMS Service Tester</h2>
                <p>Pick a gateway region, enter the target number and start your delivery test.</p>
            </div>
            <div class="smsb-card-body">

                <div>
                    <div class="smsb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 8h16v11H4z" opacity=".3"/><path d="M20 6H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 13H4V8h16v11z"/></svg> Available gateway regions</div>
                    @if (isset($status) && count($status))
                        <div class="smsb-chips">
                            @foreach ($status as $item)
                                <span class="smsb-chip"><span class="dot"></span>{{ $item->name }} (+{{ $item->code }})</span>
                            @endforeach
                        </div>
                    @else
                        <div class="smsb-empty">No gateway regions are online right now. Please try again later.</div>
                    @endif
                </div>

                {{-- Success panel --}}
                <div class="smsb-success" id="smsb-success" role="status">
                    <div class="big-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>
                    <h3>Testing completed</h3>
                    <p id="smsb-success-text">All test messages were dispatched. Check the handset delivery report.</p>
                    <div class="smsb-actions" style="justify-content:center">
                        <button type="button" class="smsb-btn smsb-btn-protect" id="smsb-again" style="flex:0 0 auto;padding:12px 30px">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.65 6.35A7.958 7.958 0 0 0 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08A5.99 5.99 0 0 1 12 18c-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/></svg>
                            Run a new test
                        </button>
                    </div>
                </div>

                {{-- Test form --}}
                <form id="smsb-form" method="post" novalidate>
                    @csrf
                    <div class="smsb-grid">
                        <div class="smsb-field">
                            <div class="smsb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24 11.4 11.4 0 0 0 3.57.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02z"/></svg> Target phone number</div>
                            <div class="smsb-phone-row">
                                <select name="code" id="smsb-code" class="smsb-select" aria-label="Country code">
                                    @foreach ($status ?? [] as $item)
                                        <option value="{{ $item->code }}" data-item="{{ json_encode($item) }}">{{ $item->name }} (+{{ $item->code }})</option>
                                    @endforeach
                                </select>
                                <input id="smsb-number" type="tel" inputmode="numeric" autocomplete="tel" name="number" class="smsb-input" placeholder="e.g. 01712345678" required>
                                <input type="hidden" id="smsb-recaptcha" name="recaptcha-token">
                            </div>
                            <div class="smsb-hint">Number only, without the country code or leading +.</div>
                        </div>

                        <div class="smsb-field">
                            <div class="smsb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z"/></svg> Test type</div>
                            <div class="smsb-seg" role="radiogroup" aria-label="Test type">
                                <input type="radio" name="call" id="smsb-mode-sms" value="0" checked>
                                <label for="smsb-mode-sms"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg> SMS test</label>
                                <input type="radio" name="call" id="smsb-mode-call" value="1">
                                <label for="smsb-mode-call"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24 11.4 11.4 0 0 0 3.57.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02z"/></svg> Call test</label>
                            </div>
                            <div class="smsb-hint" id="smsb-mode-hint">Call testing is available for this region.</div>
                        </div>

                        <div class="smsb-field">
                            <div class="smsb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-7 9h-2V7h-2v5H5v-2h2V7H5v2H4v2h3v3h2v-3h2v3h2v-3h2v3h2v-2h-2z" opacity=".9"/></svg> Test count <small>(max 30)</small></div>
                            <div class="smsb-count-row">
                                <input id="smsb-count" type="number" class="smsb-input" value="5" min="1" max="30" step="1" required>
                                <button type="button" class="smsb-preset" data-count="5">5</button>
                                <button type="button" class="smsb-preset" data-count="10">10</button>
                                <button type="button" class="smsb-preset" data-count="20">20</button>
                            </div>
                        </div>

                        <div class="smsb-field">
                            <div class="smsb-label"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2.05v2.02c3.95.49 7 3.85 7 7.93 0 1.45-.39 2.81-1.06 3.98l1.46 1.46C21.59 15.67 22 13.89 22 12c0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-1.46-1.46C16.14 17.85 14.18 19 12 19z"/></svg> Test speed</div>
                            <div class="smsb-seg" role="radiogroup" aria-label="Test speed">
                                <input type="radio" name="speed" id="smsb-slow" value="slow">
                                <label for="smsb-slow">Slow · 4s</label>
                                <input type="radio" name="speed" id="smsb-medium" value="medium">
                                <label for="smsb-medium">Medium · 2s</label>
                                <input type="radio" name="speed" id="smsb-fast" value="fast" checked>
                                <label for="smsb-fast">Fast · 1s</label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:18px;display:flex;flex-direction:column;gap:12px">
                        <div class="smsb-status" id="smsb-status" role="status"></div>

                        <div class="smsb-progress" id="smsb-progress">
                            <div class="smsb-progress-top"><span id="smsb-progress-text">0 / 0 sent</span><span id="smsb-progress-pct">0%</span></div>
                            <div class="smsb-bar"><div class="smsb-bar-fill" id="smsb-bar"></div></div>
                        </div>

                        <div class="smsb-actions">
                            <button class="smsb-btn smsb-btn-start" type="submit" id="smsb-start">
                                <span class="smsb-spinner"></span>
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                <span id="smsb-start-text">Start test</span>
                            </button>
                            <button class="smsb-btn smsb-btn-stop" type="button" id="smsb-stop" hidden>
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 6h12v12H6z"/></svg>
                                Stop
                            </button>
                        </div>
                        <div class="smsb-stay">Keep this tab open while the test runs for accurate results.</div>
                    </div>
                </form>

                <div class="smsb-info blue">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    <div><h4>Testing guidelines</h4><p>This tool is for legitimate SMS gateway testing and debugging only. You must own the target number or have explicit consent from its owner, and you must comply with your local telecommunications laws.</p></div>
                </div>

                <div class="smsb-protect">
                    <h4><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg> Protect your number</h4>
                    <p>Add a number to the blocklist and this tool will refuse to test it.</p>
                    <form action="{{ route('save-bomber') }}" method="post">
                        @csrf
                        <div class="smsb-protect-row">
                            <input type="text" class="smsb-input" name="number" inputmode="numeric" placeholder="Mobile number without country code" required>
                            <button type="submit" class="smsb-btn smsb-btn-protect">Protect number</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>

        <div class="smsb-ad">
            <x-ads.leaderboard />
            <x-ads.mobile-banner />
        </div>

        {{-- ============ Info ============ --}}
        <section>
            <h2 class="smsb-section-title">Why test your SMS gateway?</h2>
            <p class="smsb-section-sub">Delivery rates vary by carrier, region and time of day. Verify before you deploy.</p>
            <div class="smsb-info-grid">
                <div class="smsb-info-card">
                    <div class="ic indigo"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-9 9H7V9h4zm6 0h-4V9h4z"/></svg></div>
                    <h3>Real delivery checks</h3>
                    <p>Send live test messages through production gateways and confirm they actually arrive on the handset — not just that the API returned "sent".</p>
                </div>
                <div class="smsb-info-card">
                    <div class="ic amber"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg></div>
                    <h3>Responsible by design</h3>
                    <p>Built-in 30-message cap, consent requirement and a self-serve blocklist keep testing legitimate and protect everyday users from abuse.</p>
                </div>
                <div class="smsb-info-card">
                    <div class="ic green"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg></div>
                    <h3>SMS + call gateways</h3>
                    <p>Regions with voice support can run call tests too, so you can compare SMS and voice OTP delivery side by side.</p>
                </div>
            </div>
        </section>

        {{-- ============ Best practices ============ --}}
        <section>
            <h2 class="smsb-section-title">Testing best practices</h2>
            <p class="smsb-section-sub">Professional guidelines for responsible SMS testing.</p>
            <div class="smsb-cols">
                <div class="smsb-list-card do">
                    <h3><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Recommended</h3>
                    <ul>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Always get explicit consent before testing a number you don't own.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Prefer your own devices or dedicated test numbers where possible.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Use slow speed for carrier-sensitive routes; fast for load checks.</li>
                        <li><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Document your test runs for compliance and debugging.</li>
                    </ul>
                </div>
                <div class="smsb-list-card dont">
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
            <h2 class="smsb-section-title">Frequently asked questions</h2>
            <p class="smsb-section-sub">Everything you need to know before running a test.</p>
            <div class="smsb-faq">
                <details open>
                    <summary>Is the SMS bomber free? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Yes. You can run up to 30 test messages per run, completely free and without creating an account. Just pick a gateway region, enter the number and start.</p>
                </details>
                <details>
                    <summary>Which numbers can I test? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>Only numbers you own or have explicit permission to test. Numbers on our protection blocklist are automatically refused, and abuse may lead to access restrictions.</p>
                </details>
                <details>
                    <summary>What is the difference between SMS and call testing? <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg></summary>
                    <p>SMS testing dispatches text messages through SMS gateways, while call testing places automated voice calls. Call testing is only enabled for regions where the gateway supports it — otherwise the option is disabled automatically.</p>
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

        <div class="smsb-legal">
            <strong>Legal compliance notice.</strong> This tool is provided for legitimate SMS testing and development purposes only. You are responsible for complying with all applicable laws and carrier terms. We do not condone harassment, spam or any other misuse.
        </div>

        {{-- ============ Related tools ============ --}}
        <section>
            <h2 class="smsb-section-title">More free tools</h2>
            <p class="smsb-section-sub">Keep exploring AutoLikerLive.</p>
            <div class="smsb-tools">
                <a href="{{ route('call-bomber') }}">Call Bomber</a>
                <a href="{{ route('temp-mail') }}">Temp Mail</a>
                <a href="{{ route('free-tiktok-views') }}">TikTok Views</a>
                <a href="{{ route('free-tiktok-likes') }}">TikTok Likes</a>
                <a href="{{ route('free-instagram-likes') }}">Instagram Likes</a>
                <a href="{{ url('services') }}">All Tools</a>
            </div>
        </section>

    </div>
@stop

@section('footer')
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
                statusBox.className = 'smsb-status show ' + type;
                statusBox.innerHTML = html;
            }
            function hideStatus() {
                statusBox.className = 'smsb-status';
                statusBox.innerHTML = '';
            }
            function updateProgress() {
                var pct = total > 0 ? Math.round((done / total) * 100) : 0;
                bar.style.width = pct + '%';
                progressText.textContent = done + ' / ' + total + ' sent';
                progressPct.textContent = pct + '%';
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

            // Count clamp + presets
            countInput.addEventListener('input', function () {
                var v = parseInt(countInput.value, 10);
                if (isNaN(v)) return;
                if (v > MAX_COUNT) countInput.value = MAX_COUNT;
                if (v < 1 && countInput.value !== '') countInput.value = 1;
                document.querySelectorAll('.smsb-preset').forEach(function (b) {
                    b.classList.toggle('active', parseInt(b.getAttribute('data-count'), 10) === parseInt(countInput.value, 10));
                });
            });
            document.querySelectorAll('.smsb-preset').forEach(function (b) {
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
                if (typeof grecaptcha === 'undefined' || !grecaptcha.execute) {
                    showStatus('err', 'Captcha failed to load. Please refresh and try again.');
                    setBusy(false);
                    return;
                }
                grecaptcha.ready(function () {
                    if (stopRequested) { finish(); return; }
                    grecaptcha.execute('6Le9PSErAAAAAHw5ToZq73TKSIqMwmuPi7y4wZkj', { action: 'submit' }).then(function (token) {
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
                        }).then(function (res) { return res.text(); }).then(function () {
                            done++;
                            updateProgress();
                            if (done < total) {
                                setTimeout(function () { sendOne(delay); }, delay);
                            } else {
                                finish();
                            }
                        }).catch(function (err) {
                            if (err && err.name === 'AbortError') return;
                            // Count failed attempts too so the run always terminates.
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
@stop
