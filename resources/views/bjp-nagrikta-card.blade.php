@extends('layouts.master')

@section('title', 'BJP Bhartiya Nagrikta Card Center - Make Your Own Card')
@section('description', 'Create your own BJP Bhartiya Nagrikta Card for fun. Parody/meme page. Not affiliated with any political party.')

@push('styles')
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #0d0d0d !important; }

    .flag-bar { height: 5px; width: 100%; background: linear-gradient(90deg, #ff9933 33.33%, #ffffff 33.33%, #ffffff 66.66%, #138808 66.66%); }

    .hero {
        background: linear-gradient(135deg, #1a0a00 0%, #3d2000 30%, #5a3000 60%, #1a0a00 100%);
        padding: 50px 20px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,153,51,0.08) 0%, transparent 60%);
        animation: pulse 6s ease-in-out infinite;
    }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }

    .hero-content { position: relative; z-index: 1; max-width: 700px; margin: 0 auto; }
    .hero h1 { font-size: clamp(1.5rem, 5vw, 2.5rem); font-weight: 900; color: #fff; text-shadow: 0 2px 20px rgba(255,153,51,0.3); }
    .hero h1 span { color: #ff9933; }
    .hero p { color: rgba(255,255,255,0.7); font-size: clamp(0.9rem, 2.5vw, 1.1rem); margin-top: 10px; }
    .hero .ashoka { width: 50px; height: 50px; margin: 0 auto 15px; display: block; }

    .disclaimer-badge {
        background: rgba(255,153,51,0.15);
        border: 1px solid rgba(255,153,51,0.3);
        color: #ffb347;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: 20px;
    }

    .sample-section {
        padding: 40px 20px;
        text-align: center;
    }
    .sample-section h2 { color: #fff; font-size: 1.3rem; font-weight: 700; margin-bottom: 5px; }
    .sample-section p { color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 20px; }

    .card-preview {
        max-width: 420px;
        margin: 0 auto;
        background: linear-gradient(135deg, #ff9933, #ff8000);
        padding: 10px;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(255,153,51,0.2);
        transition: box-shadow .3s;
    }
    .card-preview:hover { box-shadow: 0 20px 60px rgba(255,153,51,0.35); }
    .card-preview .inner { background: white; border-radius: 12px; overflow: hidden; }
    .card-preview img { width: 100%; height: auto; display: block; }

    .form-section {
        padding: 30px 20px 50px;
        max-width: 520px;
        margin: 0 auto;
    }
    .form-card {
        background: linear-gradient(145deg, #1a1a1a, #222);
        border: 1px solid rgba(255,153,51,0.15);
        border-radius: 20px;
        padding: 35px 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    }
    .form-card .form-label { color: #ffb347; font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
    .form-card .form-control {
        background: #111;
        border: 2px solid rgba(255,153,51,0.2);
        border-radius: 12px;
        color: white;
        padding: 14px 18px;
        font-size: 1rem;
        transition: all .3s;
    }
    .form-card .form-control:focus {
        border-color: #ff9933;
        box-shadow: 0 0 0 3px rgba(255,153,51,0.15);
        background: #181818;
        color: white;
    }
    .form-card .form-control::placeholder { color: rgba(255,255,255,0.3); }
    .btn-generate {
        background: linear-gradient(135deg, #ff9933, #e68a00);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 16px 30px;
        font-weight: 800;
        font-size: 1.1rem;
        width: 100%;
        transition: all .3s;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-generate:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,153,51,0.3); color: white; }

    .info-section {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px 20px 50px;
    }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
    .info-card {
        background: linear-gradient(145deg, #1a1a1a, #222);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        padding: 22px;
        text-align: center;
    }
    .info-card .icon { font-size: 1.8rem; margin-bottom: 10px; }
    .info-card h4 { color: #ffb347; font-size: 1rem; font-weight: 700; }
    .info-card p { color: rgba(255,255,255,0.5); font-size: 0.85rem; margin: 0; }

    .adsense-content {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
        color: rgba(255,255,255,0.7);
    }
    .adsense-content h2, .adsense-content h3 { color: #ffb347; font-weight: 700; }
    .adsense-content p, .adsense-content li { font-size: 0.9rem; line-height: 1.7; color: rgba(255,255,255,0.6); }
    .adsense-content ul { padding-left: 20px; }
    .adsense-content ul li { margin-bottom: 8px; }
    .adsense-content .step-box {
        background: linear-gradient(145deg, #1a1a1a, #222);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 15px;
    }
    .adsense-content .step-num {
        display: inline-block;
        background: #ff9933;
        color: #111;
        font-weight: 800;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        text-align: center;
        line-height: 28px;
        font-size: 0.85rem;
        margin-right: 10px;
    }

    .disclaimer-footer {
        max-width: 700px;
        margin: 0 auto;
        padding: 0 20px 40px;
        text-align: center;
    }
    .disclaimer-footer .inner {
        background: rgba(255,0,0,0.08);
        border: 1px solid rgba(255,0,0,0.2);
        border-radius: 16px;
        padding: 25px;
    }
    .disclaimer-footer h5 { color: #ff6b6b; font-weight: 800; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 2px; }
    .disclaimer-footer p { color: rgba(255,255,255,0.5); font-size: 0.8rem; margin: 8px 0 0; line-height: 1.6; }

    .alert-success { background: rgba(19,136,8,0.15) !important; border: 1px solid rgba(19,136,8,0.3) !important; color: #6fcf6f !important; border-radius: 12px !important; }
    .alert-danger { background: rgba(255,0,0,0.1) !important; border: 1px solid rgba(255,0,0,0.2) !important; color: #ff6b6b !important; border-radius: 12px !important; }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.85);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: #1a1a1a;
        border-radius: 24px;
        padding: 30px;
        max-width: 550px;
        width: 90%;
        max-height: 95vh;
        overflow-y: auto;
        box-shadow: 0 30px 80px rgba(0,0,0,0.6);
        text-align: center;
        animation: modalIn .3s ease;
    }
    @keyframes modalIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .modal-close {
        position: absolute;
        top: 15px; right: 20px;
        background: none;
        border: none;
        color: rgba(255,255,255,0.3);
        font-size: 1.8rem;
        cursor: pointer;
        transition: color .2s;
        line-height: 1;
    }
    .modal-close:hover { color: white; }
    .modal-box .card-frame {
        background: linear-gradient(135deg, #ff9933, #ff8000);
        padding: 8px;
        border-radius: 16px;
        margin: 10px auto;
        max-width: 420px;
        box-shadow: 0 0 40px rgba(255,153,51,0.3), 0 0 80px rgba(255,153,51,0.15);
    }
    .modal-box .card-frame .inner { background: white; border-radius: 10px; overflow: hidden; }
    .modal-box .card-frame img { width: 100%; height: auto; display: block; }
    .modal-box .modal-title { color: white; font-weight: 800; font-size: 1.2rem; margin-bottom: 4px; }
    .modal-box .modal-sub { color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-bottom: 15px; }

    .btn-fb-share {
        background: #1877f2;
        color: white;
        border: none;
        border-radius: 60px;
        padding: 18px 40px;
        font-weight: 800;
        font-size: 1.2rem;
        width: 100%;
        cursor: pointer;
        transition: all .3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-decoration: none;
        margin: 12px 0;
    }
    .btn-fb-share:hover { background: #166fe5; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(24,119,242,0.35); color: white; }

    .mini-shares {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .mini-share {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 0.7rem;
        color: rgba(255,255,255,0.5);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all .2s;
    }
    .mini-share:hover { background: rgba(255,255,255,0.14); color: white; }
    .mini-share svg { width: 14px; height: 14px; fill: currentColor; }

    @media (max-width: 576px) {
        .hero { padding: 30px 15px 25px; }
        .form-card { padding: 25px 18px; }
        .info-grid { grid-template-columns: 1fr 1fr; }
        .modal-box { padding: 20px; }
        .btn-fb-share { font-size: 1rem; padding: 15px 25px; }
    }
</style>
@endpush

@section('content')
<div class="flag-bar"></div>

<section class="hero">
    <div class="hero-content">
        <div class="disclaimer-badge">PARODY - FOR ENTERTAINMENT ONLY</div>
        <svg class="ashoka" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="45" fill="none" stroke="#ff9933" stroke-width="2"/>
            <circle cx="50" cy="50" r="8" fill="#ff9933"/>
            <line x1="50" y1="5" x2="50" y2="20" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="50" y1="80" x2="50" y2="95" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="5" y1="50" x2="20" y2="50" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="80" y1="50" x2="95" y2="50" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="18" y1="18" x2="29" y2="29" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="71" y1="71" x2="82" y2="82" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="82" y1="18" x2="71" y2="29" stroke="#ff9933" stroke-width="1.5"/>
            <line x1="29" y1="71" x2="18" y2="82" stroke="#ff9933" stroke-width="1.5"/>
        </svg>
        <h1>BJP <span>Bhartiya Nagrikta</span> Card Center</h1>
        <p>Make your very own official-looking card. Just for laughs. Share with friends!</p>
    </div>
</section>

<section class="sample-section">
    <h2>Your card will look like this</h2>
    <p>Enter your Facebook profile URL below to personalize it</p>
    <div class="card-preview" style="position: relative;">
        <div class="inner">
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('bjp_cards/sample.png') }}" alt="Sample BJP Card" loading="lazy">
        </div>
    </div>
</section>

<section class="form-section">
    <div class="form-card">
        <form method="POST" action="{{ route('bjp.nagrikta.card.generate') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Facebook Profile URL or ID</label>
                <input name="fburl" type="text" placeholder="https://facebook.com/zuck"
                    class="form-control" value="{{ old('fburl') }}" required>
            </div>
            <button type="submit" class="btn-generate">Generate My Card</button>
        </form>
    </div>
</section>

@if (\Session::has('error'))
<section style="max-width:520px; margin:0 auto 30px; padding:0 20px;">
    <div class="alert alert-danger text-center">{{ Session::get('error') }}</div>
</section>
@endif

<section class="adsense-content">
    <h2>What is BJP Bhartiya Nagrikta Card?</h2>
    <p>The BJP Bhartiya Nagrikta Card is a fun parody card generator that creates a mock identification card featuring your Facebook profile picture and details. This is purely a meme tool designed for entertainment and social media fun. It is not affiliated with any political party or government institution.</p>

    <h3 style="margin-top:30px;">How to Make Your Card - Step by Step</h3>
    <div class="step-box">
        <span class="step-num">1</span> <strong style="color:white;">Enter your Facebook profile URL</strong> — Paste your Facebook profile link (e.g., https://facebook.com/zuck) or your Facebook numeric ID into the input field above.
    </div>
    <div class="step-box">
        <span class="step-num">2</span> <strong style="color:white;">Click "Generate My Card"</strong> — Our system will fetch your public profile picture and Facebook ID to create your personalized card.
    </div>
    <div class="step-box">
        <span class="step-num">3</span> <strong style="color:white;">Share on Facebook!</strong> — Once generated, share your unique card link with friends and family on Facebook, Twitter, WhatsApp, and more.
    </div>

    <h3 style="margin-top:30px;">Frequently Asked Questions</h3>
    <div class="step-box">
        <p><strong style="color:white;">Is this a real government-issued ID card?</strong><br>No. This is a parody/meme generator. The card is not a real identification document and should not be used for any official purpose.</p>
    </div>
    <div class="step-box">
        <p><strong style="color:white;">Is this website affiliated with BJP or any political party?</strong><br>No. We are not affiliated with the Bharatiya Janata Party (BJP), the Indian National Congress, or any political organization. This is an independent fan-made parody project.</p>
    </div>
    <div class="step-box">
        <p><strong style="color:white;">How do you get my Facebook profile picture?</strong><br>We use Facebook's public Graph API to fetch your profile picture using your Facebook ID. We do not store any personal data or images on our servers permanently after generation.</p>
    </div>
    <div class="step-box">
        <p><strong style="color:white;">Can I use this card as proof of identity?</strong><br>Absolutely not. This card is for entertainment purposes only. Using it as identification would be inappropriate and potentially illegal.</p>
    </div>
    <div class="step-box">
        <p><strong style="color:white;">Why should I share on Facebook?</strong><br>Sharing your card on Facebook allows your friends to see your creative parody card and make their own. It's a fun way to engage with your social circle!</p>
    </div>

    <h3 style="margin-top:30px;">More About This Fun Project</h3>
    <p>This card generator is part of a collection of online tools and utilities available at AutoLikerLive. We provide various social media tools including Facebook auto liker, Instagram downloader, Facebook ID finder, and more. This particular tool was created as a light-hearted meme project inspired by internet culture in India.</p>
    <p>The design features colors inspired by the Indian tricolor - saffron, white, and green - as a tribute to the nation. The card template is a fictional creation and does not represent any actual government document.</p>
    <p>We encourage users to share their cards responsibly and always remember that this is a joke/parody. Do not use this card to misrepresent yourself or deceive others. Always include the parody disclaimer when sharing.</p>
    <p>If you enjoy this tool, you might also like our other free tools: Find My Facebook ID, Instagram Profile Picture Downloader, Facebook Auto Liker, and more. All our tools are free to use and designed with user privacy in mind.</p>
</section>

<section class="info-section">
    <div class="info-grid">
        <div class="info-card">
            <div class="icon">📸</div>
            <h4>Auto Profile</h4>
            <p>We fetch your FB profile pic automatically</p>
        </div>
        <div class="info-card">
            <div class="icon">🔗</div>
            <h4>Shareable Link</h4>
            <p>Get a unique link to share on social media</p>
        </div>
        <div class="info-card">
            <div class="icon">🎭</div>
            <h4>Just for Fun</h4>
            <p>This is a parody card, not a real document</p>
        </div>
        <div class="info-card">
            <div class="icon">🔒</div>
            <h4>Private</h4>
            <p>No data stored. Your privacy is respected</p>
        </div>
    </div>
</section>

<section class="disclaimer-footer">
    <div class="inner">
        <h5>⚠ IMPORTANT NOTICE</h5>
        <p>
            This is a <strong>PARODY / MEME</strong> website. The "BJP Bhartiya Nagrikta Card" is <strong>NOT</strong> a real government-issued document.
            We are <strong>NOT affiliated</strong> with the Bharatiya Janata Party (BJP), the Government of India, or any political organization.
            This is purely for <strong>entertainment purposes</strong>. Do not use this card for any official or identification purposes.
            No personal data is stored or shared.
        </p>
    </div>
</section>

@if (\Session::has('card_hash'))
@php
    $shareUrl = Session::get('share_url');
    $cardImage = Session::get('card_image');
    $cardFbId = Session::get('card_fb_id');
    $cardDate = Session::get('card_date');
@endphp
<div class="modal-overlay active" id="shareModal">
    <div class="modal-box" style="position:relative;">
        <button class="modal-close" onclick="closeModal()">&times;</button>

        <div class="modal-title">Your Card is Ready!</div>
        <div class="modal-sub">{{ $cardFbId }} &middot; {{ $cardDate }}</div>

        <div class="card-frame">
            <div class="inner">
                <img src="{{ $cardImage }}" alt="Your BJP Nagrikta Card">
            </div>
        </div>

        <p style="color:rgba(255,255,255,0.4); font-size:0.75rem; margin:10px 0 16px;">Share on Facebook to show your friends!</p>

        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" class="btn-fb-share" onclick="closeModal()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Share on Facebook
        </a>

        <div class="mini-shares">
            <a href="https://twitter.com/intent/tweet?text={{ urlencode('Check out my BJP Bhartiya Nagrikta Card!') }}&url={{ urlencode($shareUrl) }}" target="_blank" class="mini-share" onclick="closeModal()">
                <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                Twitter
            </a>
            <a href="https://wa.me/?text={{ urlencode('Check out my BJP Bhartiya Nagrikta Card! ' . $shareUrl) }}" target="_blank" class="mini-share" onclick="closeModal()">
                <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                WhatsApp
            </a>
            <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode('BJP Bhartiya Nagrikta Card') }}" target="_blank" class="mini-share" onclick="closeModal()">
                <svg viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.24-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                Telegram
            </a>
            <button class="mini-share" style="cursor:pointer; background:none; border:1px solid rgba(255,255,255,0.1);" onclick="copyLink('{{ $shareUrl }}')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M7.024 3.75c0-.966.784-1.75 1.75-1.75H20.25c.966 0 1.75.784 1.75 1.75v11.498c0 .966-.784 1.75-1.75 1.75H8.774a1.75 1.75 0 01-1.75-1.75V3.75zm1.75-.25a.25.25 0 00-.25.25v11.498c0 .138.112.25.25.25H20.25a.25.25 0 00.25-.25V3.75a.25.25 0 00-.25-.25H8.774z"/><path d="M1.995 10.749a1.75 1.75 0 011.75-1.751H5.25a.75.75 0 010 1.5h-1.5a.25.25 0 00-.25.25L3.5 20.25c0 .138.112.25.25.25h9.5a.25.25 0 00.25-.25v-1.51a.75.75 0 011.5 0v1.51A1.75 1.75 0 0113.25 21h-9.5A1.75 1.75 0 012 19.25l-.005-8.501z"/></svg>
                Copy Link
            </button>
        </div>
    </div>
</div>
@endif

<script>
function closeModal() {
    document.getElementById('shareModal')?.classList.remove('active');
}
function copyLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        const btn = event.target.closest('.mini-share');
        const orig = btn.innerHTML;
        btn.innerHTML = 'Copied!';
        setTimeout(() => btn.innerHTML = orig, 2000);
    });
}
document.addEventListener('click', function(e) {
    const modal = document.getElementById('shareModal');
    if (modal && e.target === modal) closeModal();
});
</script>
@stop