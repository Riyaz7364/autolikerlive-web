@props([
    'variant' => 'full',
    'class' => '',
])

@php
    $playUrl = 'https://play.google.com/store/apps/details?id=com.tempmail.autolikerlive';
    $appIcon = url('/storage/temp-mail/web-app-manifest-192x192.png');
    $playBadge = 'https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png';
@endphp

@once
<style>
    /* ===== Temp Mail Android app promo (self-contained) ===== */
    .tmapp {
        --tmapp-ink: #042f2e;
        --tmapp-teal: #14b8a6;
        --tmapp-soft: rgba(255, 255, 255, .78);
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(0, .65fr);
        gap: 32px;
        align-items: center;
        width: 100%;
        padding: 34px 38px;
        border-radius: 24px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(620px 300px at 8% -20%, rgba(45, 212, 191, .38), transparent 62%),
            radial-gradient(520px 320px at 96% 118%, rgba(16, 185, 129, .34), transparent 60%),
            linear-gradient(135deg, #042f2e 0%, #0f766e 58%, #115e59 100%);
        border: 1px solid rgba(45, 212, 191, .38);
        box-shadow: 0 22px 60px rgba(13, 148, 136, .28);
        isolation: isolate;
    }

    .tmapp::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, .16) 1px, transparent 1px);
        background-size: 22px 22px;
        opacity: .35;
        pointer-events: none;
        z-index: -1;
        mask-image: linear-gradient(110deg, #000 0%, transparent 68%);
        -webkit-mask-image: linear-gradient(110deg, #000 0%, transparent 68%);
    }

    .tmapp-copy { min-width: 0; }

    .tmapp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .26);
        color: #ecfdf5;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 6px 12px;
        border-radius: 999px;
        margin-bottom: 14px;
    }

    .tmapp-title {
        font-size: clamp(22px, 3.2vw, 31px);
        font-weight: 800;
        line-height: 1.16;
        letter-spacing: -.02em;
        margin: 0 0 10px;
        color: #fff;
    }

    .tmapp-title .grad {
        background: linear-gradient(100deg, #5eead4, #a7f3d0 55%, #fde68a);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .tmapp-sub {
        color: var(--tmapp-soft);
        font-size: 14.5px;
        line-height: 1.6;
        margin: 0 0 16px;
        max-width: 52ch;
    }

    .tmapp-feats {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        list-style: none;
        margin: 0 0 20px;
        padding: 0;
    }

    .tmapp-feats li {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .16);
        color: #ecfdf5;
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 999px;
    }

    .tmapp-feats li::before {
        content: '✓';
        color: #5eead4;
        font-weight: 900;
    }

    .tmapp-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .tmapp-play-badge {
        display: inline-block;
        line-height: 0;
        border-radius: 10px;
        transition: transform .2s ease, filter .2s ease;
    }

    .tmapp-play-badge:hover,
    .tmapp-play-badge:focus-visible {
        transform: translateY(-2px);
        filter: brightness(1.06);
    }

    .tmapp-play-badge img {
        display: block;
        height: 56px;
        width: auto;
    }

    .tmapp-link {
        color: #ecfdf5 !important;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none !important;
        border-bottom: 1px solid rgba(236, 253, 245, .45);
        padding-bottom: 2px;
        white-space: nowrap;
    }

    .tmapp-link:hover { border-bottom-color: #5eead4; color: #5eead4 !important; }

    .tmapp-note {
        margin-top: 12px;
        color: rgba(236, 253, 245, .62);
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* -------- Phone mockup (pure CSS, no screenshots) -------- */
    .tmapp-visual {
        display: flex;
        justify-content: center;
        perspective: 900px;
    }

    .tmapp-phone {
        position: relative;
        width: min(224px, 100%);
        padding: 10px;
        border-radius: 34px;
        background: linear-gradient(160deg, #f8fafc, #cbd5e1);
        box-shadow: 0 30px 60px rgba(0, 0, 0, .35), inset 0 0 0 2px rgba(255, 255, 255, .6);
        transform: rotate(-4deg);
    }

    .tmapp-phone::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: 74px;
        height: 20px;
        border-radius: 0 0 14px 14px;
        background: #0f172a;
        z-index: 2;
    }

    .tmapp-screen {
        border-radius: 26px;
        background: #f0fdfa;
        padding: 26px 11px 13px;
        overflow: hidden;
    }

    .tmapp-app-head {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .tmapp-app-head img {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        box-shadow: 0 3px 8px rgba(13, 148, 136, .28);
    }

    .tmapp-app-head strong {
        display: block;
        color: #0f172a;
        font-size: 12.5px;
        line-height: 1.2;
    }

    .tmapp-app-head small {
        display: block;
        color: #64748b;
        font-size: 9.5px;
        line-height: 1.3;
    }

    .tmapp-addr {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        background: linear-gradient(120deg, #0d9488, #10b981);
        color: #fff;
        border-radius: 10px;
        padding: 8px 9px;
        font-size: 9.5px;
        font-weight: 700;
        margin-bottom: 10px;
        box-shadow: 0 6px 14px rgba(13, 148, 136, .25);
    }

    .tmapp-addr span {
        background: rgba(255, 255, 255, .2);
        border-radius: 6px;
        padding: 3px 6px;
        font-size: 8.5px;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .tmapp-mail {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        background: #fff;
        border: 1px solid #d1fae5;
        border-radius: 10px;
        padding: 8px 8px;
        margin-bottom: 6px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, .05);
    }

    .tmapp-mail .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #14b8a6;
        margin-top: 3px;
        flex-shrink: 0;
    }

    .tmapp-mail strong {
        display: block;
        color: #0f172a;
        font-size: 9.5px;
        line-height: 1.35;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 138px;
    }

    .tmapp-mail small {
        display: block;
        color: #64748b;
        font-size: 8.5px;
        line-height: 1.3;
    }

    .tmapp-mail.read { opacity: .68; }
    .tmapp-mail.read .dot { background: #cbd5e1; }

    /* -------- Compact variant -------- */
    .tmapp-compact {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 16px;
        text-decoration: none !important;
        color: #fff !important;
        grid-template-columns: none;
        box-shadow: 0 12px 30px rgba(13, 148, 136, .24);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .tmapp-compact:hover,
    .tmapp-compact:focus-visible {
        transform: translateY(-2px);
        box-shadow: 0 16px 38px rgba(13, 148, 136, .32);
        color: #fff !important;
    }

    .tmapp-compact::before { opacity: .22; }

    .tmapp-compact-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        flex-shrink: 0;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
    }

    .tmapp-compact-text {
        flex: 1;
        min-width: 0;
        line-height: 1.3;
    }

    .tmapp-compact-text strong {
        display: block;
        font-size: 14px;
        font-weight: 800;
    }

    .tmapp-compact-text small {
        display: block;
        font-size: 11.5px;
        color: rgba(236, 253, 245, .78);
    }

    .tmapp-compact-cta {
        flex-shrink: 0;
        background: #fff;
        color: #0f766e;
        font-size: 13px;
        font-weight: 800;
        padding: 9px 14px;
        border-radius: 10px;
        white-space: nowrap;
    }

    @media (max-width: 820px) {
        .tmapp {
            grid-template-columns: 1fr;
            padding: 26px 22px;
            gap: 22px;
        }

        .tmapp-visual { display: none; }
        .tmapp-sub { font-size: 14px; }
    }

    @media (max-width: 520px) {
        .tmapp { padding: 22px 16px; border-radius: 20px; }
        .tmapp-actions { gap: 12px; }
        .tmapp-play-badge img { height: 50px; }
        .tmapp-feats li { font-size: 11.5px; padding: 5px 10px; }
        .tmapp-compact { padding: 10px 12px; }
        .tmapp-compact-cta { padding: 8px 11px; font-size: 12px; }
    }
</style>
@endonce

@if ($variant === 'compact')
    <a href="{{ $playUrl }}"
       class="tmapp tmapp-compact {{ $class }}"
       target="_blank" rel="noopener noreferrer"
       aria-label="Get the Temp Mail Android app on Google Play">
        <img src="{{ $appIcon }}" alt="" width="42" height="42" class="tmapp-compact-icon" loading="lazy" decoding="async">
        <span class="tmapp-compact-text">
            <strong>Temp Mail for Android</strong>
            <small>Free on Google Play · No signup</small>
        </span>
        <span class="tmapp-compact-cta">Get app →</span>
    </a>
@else
    <section class="tmapp {{ $class }}" aria-label="Temp Mail for Android on Google Play">
        <div class="tmapp-copy">
            <span class="tmapp-eyebrow">📱 Now on Google Play</span>
            <h2 class="tmapp-title">Take your temp inbox <span class="grad">with you</span></h2>
            <p class="tmapp-sub">
                The official <strong>Temp Mail – Disposable Email</strong> Android app from AutoLikerLive.
                Get a disposable address, copy it in one tap, and refresh your inbox to check new messages —
                no signup, no clutter in your real inbox.
            </p>
            <ul class="tmapp-feats">
                <li>One-tap copy</li>
                <li>Quick inbox refresh</li>
                <li>No signup</li>
                <li>100% free</li>
            </ul>
            <div class="tmapp-actions">
                <a href="{{ $playUrl }}" class="tmapp-play-badge"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Get Temp Mail – Disposable Email on Google Play">
                    <img src="{{ $playBadge }}" alt="Get it on Google Play" width="145" height="56" loading="lazy" decoding="async">
                </a>
                <a href="{{ $playUrl }}" class="tmapp-link"
                   target="_blank" rel="noopener noreferrer">View on Google Play →</a>
            </div>
            <div class="tmapp-note">🔒 Free · Android · No signup required</div>
        </div>

        <div class="tmapp-visual" aria-hidden="true">
            <div class="tmapp-phone">
                <div class="tmapp-screen">
                    <div class="tmapp-app-head">
                        <img src="{{ $appIcon }}" alt="" width="30" height="30" loading="lazy" decoding="async">
                        <span>
                            <strong>Temp Mail</strong>
                            <small>Disposable email</small>
                        </span>
                    </div>
                    <div class="tmapp-addr">you@emailbox.click <span>Copy</span></div>
                    <div class="tmapp-mail">
                        <span class="dot"></span>
                        <span><strong>Your verification code</strong><small>Acme Support · now</small></span>
                    </div>
                    <div class="tmapp-mail">
                        <span class="dot"></span>
                        <span><strong>Welcome aboard</strong><small>Newsletter · 2m</small></span>
                    </div>
                    <div class="tmapp-mail read">
                        <span class="dot"></span>
                        <span><strong>Order confirmed</strong><small>Shop · 9m</small></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
