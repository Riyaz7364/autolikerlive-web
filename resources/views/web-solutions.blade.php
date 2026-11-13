@extends('layouts.master')

@section('title', 'Web Solutions – Websites, Apps & SaaS | AutoLikerLive')
@section('description', 'Custom websites, web apps, SaaS platforms and Flutter mobile apps built by AutoLikerLive. See selected work including GymSaaS, GrowNext, Chatter, Temp Mail and more.')
@section('keywords', 'web development, website design, Laravel developer, Flutter app developer, SaaS development, Razorpay integration, freelance web developer India')
@section('full-width', '1')

@push('styles')
<style>
    .ws-page {
        --ws-ink: #0b1220;
        --ws-body: #4b5565;
        --ws-muted: #707b8c;
        --ws-blue: #1877f2;
        --ws-blue-dark: #0b5ed7;
        --ws-line: #e4eaf2;
        --ws-soft: #f5f8fd;
        --ws-white: #ffffff;
        color: var(--ws-ink);
        padding: 18px 0 48px;
    }
    .ws-page * { box-sizing: border-box; }
    .ws-page a { text-decoration: none; }
    .ws-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--ws-blue);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }
    .ws-eyebrow::before {
        content: "";
        width: 22px;
        height: 2px;
        background: currentColor;
        border-radius: 999px;
    }
    .ws-hero {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(280px, .65fr);
        gap: clamp(28px, 5vw, 64px);
        align-items: center;
        padding: clamp(28px, 5vw, 64px);
        border-radius: 26px;
        color: #fff;
        background:
            radial-gradient(circle at 90% 12%, rgba(56, 189, 248, .34), transparent 34%),
            radial-gradient(circle at 16% 100%, rgba(37, 99, 235, .45), transparent 40%),
            linear-gradient(135deg, #07111f 0%, #0b2447 52%, #114d9e 100%);
        box-shadow: 0 24px 60px rgba(7, 17, 31, .18);
    }
    .ws-hero::after {
        content: "";
        position: absolute;
        right: -120px;
        bottom: -160px;
        width: 420px;
        height: 420px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 50%;
        box-shadow: 0 0 0 42px rgba(255, 255, 255, .035), 0 0 0 96px rgba(255, 255, 255, .025);
        pointer-events: none;
    }
    .ws-hero-main { position: relative; z-index: 1; }
    .ws-hero .ws-eyebrow { color: #8ec5ff; }
    .ws-hero h1 {
        margin: 16px 0 18px;
        color: #fff;
        font-size: clamp(34px, 5.4vw, 62px);
        line-height: 1.04;
        letter-spacing: -.045em;
        font-weight: 800;
    }
    .ws-hero h1 span {
        color: #9fd0ff;
        display: inline;
    }
    .ws-hero-lead {
        max-width: 640px;
        margin: 0;
        color: #d7e5f7;
        font-size: clamp(16px, 1.6vw, 18px);
        line-height: 1.7;
    }
    .ws-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }
    .ws-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 46px;
        padding: 12px 20px;
        border: 0;
        border-radius: 11px;
        font-weight: 700;
        font-size: 14px;
        line-height: 1;
        cursor: pointer;
        transition: transform .18s ease, background .18s ease, box-shadow .18s ease;
    }
    .ws-btn:hover { transform: translateY(-1px); }
    .ws-btn-primary {
        color: #fff;
        background: var(--ws-blue);
        box-shadow: 0 10px 24px rgba(24, 119, 242, .28);
    }
    .ws-btn-primary:hover { color: #fff; background: var(--ws-blue-dark); }
    .ws-btn-ghost {
        color: #fff;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .24);
    }
    .ws-btn-ghost:hover { color: #fff; background: rgba(255, 255, 255, .14); }
    .ws-chip-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 26px;
    }
    .ws-chip-row span {
        padding: 7px 11px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .07);
        color: #dbeafe;
        font-size: 12px;
        font-weight: 600;
    }
    .ws-hero-panel {
        position: relative;
        z-index: 1;
        padding: 24px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 18px;
        background: rgba(255, 255, 255, .08);
        backdrop-filter: blur(10px);
    }
    .ws-panel-label {
        margin-bottom: 16px;
        color: #9fd0ff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }
    .ws-panel-list {
        display: grid;
        gap: 16px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .ws-panel-list li {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .ws-panel-list b {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 26px;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .14);
        color: #bfdbfe;
        font-size: 11px;
    }
    .ws-panel-list strong {
        display: block;
        color: #fff;
        font-size: 14px;
        line-height: 1.35;
    }
    .ws-panel-list small {
        display: block;
        margin-top: 3px;
        color: #c3d6ea;
        font-size: 12px;
        line-height: 1.45;
    }
    .ws-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1px;
        margin-top: 18px;
        overflow: hidden;
        border: 1px solid var(--ws-line);
        border-radius: 16px;
        background: var(--ws-line);
    }
    .ws-stat {
        padding: 18px 16px;
        background: #fff;
        text-align: center;
    }
    .ws-stat b {
        display: block;
        color: var(--ws-ink);
        font-size: 24px;
        line-height: 1;
        letter-spacing: -.03em;
    }
    .ws-stat span {
        display: block;
        margin-top: 7px;
        color: var(--ws-muted);
        font-size: 12px;
        font-weight: 600;
    }
    .ws-section {
        margin-top: clamp(42px, 6vw, 72px);
        scroll-margin-top: 90px;
    }
    .ws-section-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 24px;
    }
    .ws-section-head h2 {
        margin: 10px 0 0;
        color: var(--ws-ink);
        font-size: clamp(27px, 3.5vw, 40px);
        line-height: 1.12;
        letter-spacing: -.035em;
        font-weight: 800;
    }
    .ws-section-head p {
        max-width: 440px;
        margin: 0;
        color: var(--ws-body);
        font-size: 14px;
        line-height: 1.7;
    }
    .ws-services {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid var(--ws-line);
        border-left: 1px solid var(--ws-line);
    }
    .ws-service {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        min-height: 118px;
        padding: 20px;
        border-right: 1px solid var(--ws-line);
        border-bottom: 1px solid var(--ws-line);
        background: #fff;
    }
    .ws-service b {
        flex: 0 0 32px;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #eaf2ff;
        color: var(--ws-blue);
        font-size: 11px;
    }
    .ws-service h3 {
        margin: 0 0 5px;
        color: var(--ws-ink);
        font-size: 15px;
        font-weight: 700;
    }
    .ws-service p {
        margin: 0;
        color: var(--ws-muted);
        font-size: 12.5px;
        line-height: 1.55;
    }
    .ws-note {
        flex: 0 0 auto;
        color: var(--ws-muted);
        font-size: 12px;
        font-weight: 600;
    }
    .ws-work-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid var(--ws-line);
        border-left: 1px solid var(--ws-line);
    }
    .ws-work-item {
        display: flex;
        flex-direction: column;
        min-height: 208px;
        padding: 20px;
        border-right: 1px solid var(--ws-line);
        border-bottom: 1px solid var(--ws-line);
        background: #fff;
        transition: background .18s ease;
    }
    .ws-work-item:hover { background: #f7faff; }
    .ws-work-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }
    .ws-work-top h3 {
        margin: 0;
        font-size: 17px;
        line-height: 1.25;
        letter-spacing: -.02em;
        font-weight: 800;
    }
    .ws-work-top h3 a { color: var(--ws-ink); }
    .ws-work-top h3 a:hover { color: var(--ws-blue); }
    .ws-work-arrow {
        flex: 0 0 auto;
        color: var(--ws-blue);
        font-size: 18px;
        line-height: 1;
        transition: transform .18s ease;
    }
    .ws-work-item:hover .ws-work-arrow { transform: translate(2px, -2px); }
    .ws-work-type {
        margin-top: 6px;
        color: var(--ws-blue);
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }
    .ws-work-item p {
        flex: 1;
        margin: 11px 0 16px;
        color: var(--ws-body);
        font-size: 13px;
        line-height: 1.6;
    }
    .ws-work-foot {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        gap: 10px;
        margin-top: auto;
    }
    .ws-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    .ws-tags span {
        padding: 4px 7px;
        border-radius: 5px;
        background: var(--ws-soft);
        color: #526072;
        font-size: 10.5px;
        font-weight: 600;
    }
    .ws-work-links {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .ws-work-links a {
        color: var(--ws-blue);
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }
    .ws-work-links a:hover { color: var(--ws-blue-dark); }
    .ws-process-wrap {
        padding: clamp(24px, 4vw, 42px);
        border: 1px solid var(--ws-line);
        border-radius: 20px;
        background: var(--ws-soft);
    }
    .ws-process {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }
    .ws-step {
        padding-top: 18px;
        border-top: 2px solid #cdddf6;
    }
    .ws-step b {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #fff;
        color: var(--ws-blue);
        font-size: 11px;
        box-shadow: 0 2px 8px rgba(11, 36, 71, .08);
    }
    .ws-step h3 {
        margin: 11px 0 6px;
        color: var(--ws-ink);
        font-size: 15px;
        font-weight: 700;
    }
    .ws-step p {
        margin: 0;
        color: var(--ws-muted);
        font-size: 12.5px;
        line-height: 1.55;
    }
    .ws-contact {
        display: grid;
        grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr);
        gap: 0;
        margin-top: clamp(42px, 6vw, 72px);
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid var(--ws-line);
        background: #fff;
        scroll-margin-top: 80px;
        box-shadow: 0 18px 46px rgba(11, 18, 32, .07);
    }
    .ws-contact-copy {
        padding: clamp(26px, 4vw, 44px);
        color: #fff;
        background:
            radial-gradient(circle at 100% 0, rgba(56, 189, 248, .28), transparent 36%),
            linear-gradient(145deg, #0b2447, #0b1220);
    }
    .ws-contact-copy .ws-eyebrow { color: #8ec5ff; }
    .ws-contact-copy h2 {
        margin: 14px 0 14px;
        color: #fff;
        font-size: clamp(27px, 3.4vw, 40px);
        line-height: 1.12;
        letter-spacing: -.035em;
        font-weight: 800;
    }
    .ws-contact-copy > p {
        margin: 0;
        color: #c9d8e9;
        font-size: 14px;
        line-height: 1.7;
    }
    .ws-contact-list {
        display: grid;
        gap: 12px;
        margin: 24px 0 0;
        padding: 0;
        list-style: none;
    }
    .ws-contact-list li {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        color: #dbeafe;
        font-size: 13px;
        line-height: 1.5;
    }
    .ws-contact-list li::before {
        content: "";
        flex: 0 0 6px;
        width: 6px;
        height: 6px;
        margin-top: 6px;
        border-radius: 50%;
        background: #60a5fa;
    }
    .ws-contact-links {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 26px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, .14);
    }
    .ws-contact-links a {
        color: #9fd0ff;
        font-size: 12.5px;
        font-weight: 700;
    }
    .ws-contact-links a:hover { color: #fff; }
    .ws-form-card { padding: clamp(26px, 4vw, 44px); }
    .ws-form-card h3 {
        margin: 0 0 6px;
        color: var(--ws-ink);
        font-size: 21px;
        letter-spacing: -.02em;
        font-weight: 800;
    }
    .ws-form-card > p {
        margin: 0 0 20px;
        color: var(--ws-muted);
        font-size: 13px;
    }
    .ws-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }
    .ws-field { display: block; }
    .ws-field span {
        display: block;
        margin-bottom: 6px;
        color: #3b4556;
        font-size: 12px;
        font-weight: 700;
    }
    .ws-field input,
    .ws-field select,
    .ws-field textarea {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d9e2ee;
        border-radius: 9px;
        background: #fff;
        color: var(--ws-ink);
        font: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    .ws-field input:focus,
    .ws-field select:focus,
    .ws-field textarea:focus {
        border-color: #7cb4f8;
        box-shadow: 0 0 0 3px rgba(24, 119, 242, .12);
    }
    .ws-field textarea { resize: vertical; min-height: 108px; }
    .ws-field-full { margin-top: 14px; }
    .ws-field-error {
        display: block;
        margin-top: 5px;
        color: #c0392b;
        font-size: 11px;
        font-weight: 600;
    }
    .ws-hp {
        position: absolute !important;
        left: -9999px !important;
        width: 1px;
        height: 1px;
        overflow: hidden;
    }
    .ws-form-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 16px;
    }
    .ws-form-status {
        min-height: 18px;
        margin: 0;
        color: var(--ws-muted);
        font-size: 12px;
        line-height: 1.45;
    }
    .ws-form-status.is-success { color: #15803d; font-weight: 700; }
    .ws-form-status.is-error { color: #c0392b; font-weight: 700; }
    .ws-form-note {
        margin: 12px 0 0;
        color: #8a94a5;
        font-size: 11px;
        line-height: 1.5;
    }
    .ws-alert {
        margin-bottom: 16px;
        padding: 11px 13px;
        border: 1px solid #b9e5c5;
        border-radius: 9px;
        background: #effaf2;
        color: #15803d;
        font-size: 13px;
        font-weight: 600;
    }
    .ws-alert.is-error {
        border-color: #f1c4be;
        background: #fff4f2;
        color: #b3261e;
    }
    .ws-modal {
        position: fixed;
        inset: 0;
        z-index: 1200;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 18px;
    }
    .ws-modal.is-open { display: flex; }
    .ws-modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(4, 10, 20, .66);
        backdrop-filter: blur(3px);
    }
    .ws-modal-panel {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 480px;
        max-height: calc(100vh - 36px);
        overflow: auto;
        padding: 28px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 30px 90px rgba(0, 0, 0, .32);
    }
    .ws-modal-panel h2 {
        margin: 10px 0 8px;
        color: var(--ws-ink);
        font-size: 27px;
        line-height: 1.15;
        letter-spacing: -.03em;
        font-weight: 800;
    }
    .ws-modal-panel > p {
        margin: 0 0 18px;
        color: var(--ws-body);
        font-size: 13px;
        line-height: 1.6;
    }
    .ws-modal-panel .ws-field { margin-bottom: 12px; }
    .ws-modal-panel .ws-btn { width: 100%; margin-top: 4px; }
    .ws-modal-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 50%;
        background: #f1f5fb;
        color: #526072;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
    }
    .ws-modal-close:hover { background: #e6edf7; color: #0b1220; }
    .ws-modal-note {
        margin: 10px 0 0;
        color: #8a94a5;
        font-size: 10.5px;
        line-height: 1.5;
        text-align: center;
    }
    body.ws-modal-open { overflow: hidden; }
    @media (max-width: 980px) {
        .ws-hero { grid-template-columns: 1fr; }
        .ws-hero-panel { display: none; }
        .ws-services { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ws-work-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ws-process { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ws-contact { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .ws-page { padding-top: 10px; }
        .ws-hero { padding: 24px 20px; border-radius: 18px; }
        .ws-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .ws-section-head { display: block; }
        .ws-section-head p { margin-top: 12px; }
        .ws-services,
        .ws-work-grid,
        .ws-process { grid-template-columns: 1fr; }
        .ws-service { min-height: 0; }
        .ws-work-item { min-height: 0; }
        .ws-form-grid { grid-template-columns: 1fr; }
        .ws-form-bottom { align-items: stretch; flex-direction: column; }
        .ws-form-bottom .ws-btn { width: 100%; }
        .ws-modal-panel { padding: 24px 20px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ws-page *, .ws-page *::before, .ws-page *::after {
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $services = [
        ['title' => 'Website design & development', 'copy' => 'Fast, responsive business sites and landing pages built to convert.'],
        ['title' => 'Web apps & SaaS', 'copy' => 'Dashboards, subscriptions, payments, roles, and back-office workflows.'],
        ['title' => 'Mobile apps', 'copy' => 'Flutter apps for Android and iOS with native integrations where needed.'],
        ['title' => 'AI integrations', 'copy' => 'AI-assisted features, automation, content tools, and API-powered workflows.'],
        ['title' => 'E-commerce & payments', 'copy' => 'Checkout, Razorpay subscriptions, invoices, refunds, and transfer flows.'],
        ['title' => 'APIs & integrations', 'copy' => 'Third-party APIs, webhooks, queues, and reliable background processing.'],
    ];

    $steps = [
        ['title' => 'Brief', 'copy' => 'We agree on the goal, scope, and the smallest useful first version.'],
        ['title' => 'Build', 'copy' => 'I work in clear milestones and keep you updated with working previews.'],
        ['title' => 'Review', 'copy' => 'You test the real flows; I fix issues and tighten the details.'],
        ['title' => 'Launch', 'copy' => 'Deploy, hand over, and stay available for the next iteration.'],
    ];
@endphp

<div class="ws-page">
    <section class="ws-hero">
        <div class="ws-hero-main">
            <div class="ws-eyebrow">Web Solutions</div>
            <h1>Websites, apps &amp; SaaS that <span>move business forward.</span></h1>
            <p class="ws-hero-lead">
                I design and build practical digital products — from conversion-focused websites
                to Laravel SaaS platforms and Flutter mobile apps. Clear scope, direct communication,
                and code built to keep working after launch.
            </p>
            <div class="ws-hero-actions">
                <a href="#contact-form" class="ws-btn ws-btn-primary">Start a project</a>
                <a href="#work" class="ws-btn ws-btn-ghost">See selected work</a>
            </div>
            <div class="ws-chip-row">
                <span>Websites</span>
                <span>Laravel &amp; PHP</span>
                <span>Flutter</span>
                <span>SaaS</span>
                <span>AI integrations</span>
            </div>
        </div>

        <aside class="ws-hero-panel" aria-label="What I build">
            <div class="ws-panel-label">Built for real use</div>
            <ul class="ws-panel-list">
                <li>
                    <b>01</b>
                    <div>
                        <strong>Websites &amp; landing pages</strong>
                        <small>Responsive, fast, and focused on the action you want visitors to take.</small>
                    </div>
                </li>
                <li>
                    <b>02</b>
                    <div>
                        <strong>Web apps &amp; SaaS</strong>
                        <small>Subscriptions, payments, admin panels, and multi-tenant workflows.</small>
                    </div>
                </li>
                <li>
                    <b>03</b>
                    <div>
                        <strong>Mobile apps</strong>
                        <small>Flutter apps with Firebase, APIs, notifications, and native bridges.</small>
                    </div>
                </li>
            </ul>
        </aside>
    </section>

    <section class="ws-stats" aria-label="Project highlights">
        <div class="ws-stat"><b>12</b><span>Selected builds</span></div>
        <div class="ws-stat"><b>6</b><span>Mobile apps</span></div>
        <div class="ws-stat"><b>5</b><span>Live websites</span></div>
        <div class="ws-stat"><b>24h</b><span>Reply target</span></div>
    </section>

    <section class="ws-section" id="services">
        <div class="ws-section-head">
            <div>
                <div class="ws-eyebrow">What I do</div>
                <h2>One partner from idea to launch.</h2>
            </div>
            <p>
                You do not need a separate designer, backend developer, and mobile developer for
                every small product. I can own the build end to end and bring in specialists only
                when the scope truly needs it.
            </p>
        </div>

        <div class="ws-services">
            @foreach ($services as $index => $service)
                <div class="ws-service">
                    <b>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</b>
                    <div>
                        <h3>{{ $service['title'] }}</h3>
                        <p>{{ $service['copy'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ws-section" id="work">
        <div class="ws-section-head">
            <div>
                <div class="ws-eyebrow">Selected work</div>
                <h2>Products, platforms, and live sites.</h2>
            </div>
            <span class="ws-note">Details sourced from live sites and project READMEs.</span>
        </div>

        <div class="ws-work-grid">
            @foreach ($projects as $project)
                <article class="ws-work-item">
                    <div class="ws-work-top">
                        <h3>
                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">
                                {{ $project['name'] }}
                            </a>
                        </h3>
                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="ws-work-arrow" aria-label="Open {{ $project['name'] }}">&#8599;</a>
                    </div>
                    <div class="ws-work-type">{{ $project['type'] }}</div>
                    <p>{{ $project['description'] }}</p>
                    <div class="ws-work-foot">
                        <div class="ws-tags">
                            @foreach ($project['tags'] as $tag)
                                <span>{{ $tag }}</span>
                            @endforeach
                        </div>
                        <div class="ws-work-links">
                            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">
                                {{ $project['link_label'] }} &#8599;
                            </a>
                            @if (! empty($project['secondary_url']))
                                <a href="{{ $project['secondary_url'] }}" target="_blank" rel="noopener noreferrer">
                                    {{ $project['secondary_label'] }} &#8599;
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ws-section ws-process-wrap">
        <div class="ws-section-head">
            <div>
                <div class="ws-eyebrow">How it works</div>
                <h2>A simple, transparent process.</h2>
            </div>
            <p>No long discovery theatre. We define the outcome, build in small steps, and keep the feedback loop short.</p>
        </div>

        <div class="ws-process">
            @foreach ($steps as $index => $step)
                <div class="ws-step">
                    <b>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</b>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ws-contact" id="contact-form">
        <div class="ws-contact-copy">
            <div class="ws-eyebrow">Start a project</div>
            <h2>Tell me what you want to build.</h2>
            <p>
                Share the goal, the must-have features, and any deadline you have. I will reply
                with the next practical step — usually a short set of questions and a clear estimate.
            </p>
            <ul class="ws-contact-list">
                <li>Websites, web apps, SaaS, and Flutter apps.</li>
                <li>New builds, improvements, and rescue work.</li>
                <li>Direct communication — no account manager in between.</li>
            </ul>
            <div class="ws-contact-links">
                <a href="mailto:contact@autolikerlive.com">contact@autolikerlive.com</a>
                <a href="https://www.freelancer.in/u/tRSstudios?sb=t" target="_blank" rel="noopener noreferrer">
                    Freelancer profile &#8599;
                </a>
            </div>
        </div>

        <div class="ws-form-card">
            <h3>Project enquiry</h3>
            <p>Fields marked * are required.</p>

            @if (session('lead_success'))
                <div class="ws-alert">{{ session('lead_success') }}</div>
            @endif

            @if ($errors->any())
                <div class="ws-alert is-error">Please check the highlighted fields and try again.</div>
            @endif

            <form method="POST" action="{{ route('web-solutions.leads.store') }}" data-ws-lead-form>
                @csrf
                <div class="ws-hp" aria-hidden="true">
                    <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <div class="ws-form-grid">
                    <label class="ws-field">
                        <span>Name *</span>
                        <input type="text" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name">
                        @error('name')<span class="ws-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="ws-field">
                        <span>Email *</span>
                        <input type="email" name="email" value="{{ old('email') }}" required maxlength="190" autocomplete="email">
                        @error('email')<span class="ws-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="ws-field">
                        <span>Phone</span>
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="40" autocomplete="tel">
                        @error('phone')<span class="ws-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="ws-field">
                        <span>Company</span>
                        <input type="text" name="company" value="{{ old('company') }}" maxlength="190" autocomplete="organization">
                        @error('company')<span class="ws-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="ws-field">
                        <span>Project type</span>
                        <select name="project_type">
                            <option value="">Select one</option>
                            @foreach (['website' => 'Website', 'web-app' => 'Web app / SaaS', 'mobile-app' => 'Mobile app', 'ai-integration' => 'AI integration', 'other' => 'Other'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('project_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('project_type')<span class="ws-field-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="ws-field">
                        <span>Budget</span>
                        <select name="budget">
                            <option value="">Select one</option>
                            @foreach (['under-500' => 'Under $500', '500-1500' => '$500 – $1,500', '1500-5000' => '$1,500 – $5,000', '5000-plus' => '$5,000+', 'not-sure' => 'Not sure yet'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('budget') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('budget')<span class="ws-field-error">{{ $message }}</span>@enderror
                    </label>
                </div>

                <label class="ws-field ws-field-full">
                    <span>Project details *</span>
                    <textarea name="message" required maxlength="5000" placeholder="What are you building, and what should it do?">{{ old('message') }}</textarea>
                    @error('message')<span class="ws-field-error">{{ $message }}</span>@enderror
                </label>

                <div class="ws-form-bottom">
                    <p class="ws-form-status" role="status" aria-live="polite"></p>
                    <button type="submit" class="ws-btn ws-btn-primary">Send enquiry</button>
                </div>
                <p class="ws-form-note">No mailing list. Your details are only used to reply to this enquiry.</p>
            </form>
        </div>
    </section>
</div>

<div class="ws-modal" id="wsContactModal" role="dialog" aria-modal="true" aria-labelledby="wsContactModalTitle" aria-hidden="true">
    <div class="ws-modal-backdrop" data-ws-modal-close></div>
    <div class="ws-modal-panel">
        <button type="button" class="ws-modal-close" data-ws-modal-close aria-label="Close dialog">&times;</button>
        <div class="ws-eyebrow">Let’s talk</div>
        <h2 id="wsContactModalTitle">Have a project in mind?</h2>
        <p>Leave your name, email, and a short note. I will reply within one business day.</p>
        <form method="POST" action="{{ route('web-solutions.leads.store') }}" data-ws-lead-form>
            @csrf
            <div class="ws-hp" aria-hidden="true">
                <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            </div>
            <label class="ws-field">
                <span>Name *</span>
                <input type="text" name="name" required maxlength="120" autocomplete="name">
            </label>
            <label class="ws-field">
                <span>Email *</span>
                <input type="email" name="email" required maxlength="190" autocomplete="email">
            </label>
            <label class="ws-field">
                <span>What do you need? *</span>
                <textarea name="message" required maxlength="5000" placeholder="A short description of your project"></textarea>
            </label>
            <div class="ws-form-status" role="status" aria-live="polite"></div>
            <button type="submit" class="">Send enquiry</button>
            <p class="ws-modal-note">No mailing list. Your details are only used to reply to this enquiry.</p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var modal = document.getElementById('wsContactModal');
    var modalKey = 'ws-contact-modal-shown';
    var lastFocused = null;

    function openModal() {
        if (!modal) return;
        lastFocused = document.activeElement;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('ws-modal-open');
        var firstField = modal.querySelector('input[name="name"]');
        if (firstField) {
            window.setTimeout(function () { firstField.focus(); }, 80);
        }
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('ws-modal-open');
        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus();
        }
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target.closest('[data-ws-modal-close]')) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        var shown = false;
        try { shown = window.sessionStorage.getItem(modalKey) === '1'; } catch (e) {}

        if (!shown) {
            var onScroll = function () {
                if (shown) return;
                var doc = document.documentElement;
                var max = doc.scrollHeight - window.innerHeight;
                var progress = max > 0 ? window.scrollY / max : 0;

                if (progress >= 0.7) {
                    shown = true;
                    try { window.sessionStorage.setItem(modalKey, '1'); } catch (e) {}
                    openModal();
                    window.removeEventListener('scroll', onScroll);
                }
            };
            window.addEventListener('scroll', onScroll, { passive: true });
        }
    }

    document.querySelectorAll('[data-ws-lead-form]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var button = form.querySelector('button[type="submit"]');
            var status = form.querySelector('.ws-form-status');
            var originalText = button ? button.textContent : '';

            if (button) {
                button.disabled = true;
                button.textContent = 'Sending…';
            }
            if (status) {
                status.textContent = '';
                status.className = 'ws-form-status';
            }

            var payload = new FormData(form);
            var token = document.querySelector('meta[name="csrf-token"]');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
                },
                body: payload,
                credentials: 'same-origin'
            })
            .then(function (response) {
                return response.json().catch(function () { return {}; }).then(function (data) {
                    return { ok: response.ok, status: response.status, data: data };
                });
            })
            .then(function (result) {
                if (result.ok) {
                    form.reset();
                    if (status) {
                        status.textContent = result.data.message || 'Thanks! Your message has been received.';
                        status.className = 'ws-form-status is-success';
                    }
                    if (modal && modal.contains(form)) {
                        window.setTimeout(closeModal, 2600);
                    }
                    return;
                }

                var message = result.data.message || 'Something went wrong. Please try again.';
                if (result.data.errors) {
                    var keys = Object.keys(result.data.errors);
                    if (keys.length && result.data.errors[keys[0]].length) {
                        message = result.data.errors[keys[0]][0];
                    }
                }
                if (status) {
                    status.textContent = message;
                    status.className = 'ws-form-status is-error';
                }
            })
            .catch(function () {
                if (status) {
                    status.textContent = 'Could not send right now. Please try again or email contact@autolikerlive.com.';
                    status.className = 'ws-form-status is-error';
                }
            })
            .finally(function () {
                if (button) {
                    button.disabled = false;
                    button.textContent = originalText;
                }
            });
        });
    });
})();
</script>
@endpush