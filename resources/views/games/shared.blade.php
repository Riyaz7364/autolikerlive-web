@php
    $ogTitle = $game->og_title ?: 'Try it yourself!';
    $ogDesc = $game->og_description ?: 'Create your own fun image. Share with friends!';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $ogTitle }}</title>
    <meta name="description" content="{{ $ogDesc }}" />

    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $ogTitle }}" />
    <meta property="og:description" content="{{ $ogDesc }}" />
    <meta property="og:image" content="{{ $imageUrl }}" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="600" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $ogTitle }}" />
    <meta name="twitter:description" content="{{ $ogDesc }}" />
    <meta name="twitter:image" content="{{ $imageUrl }}" />

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
         crossorigin="anonymous"></script>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background: #f0f2f5; min-height:100vh; display:flex; flex-direction:column; align-items:center; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; }
        .wrap { max-width:500px; width:100%; padding:20px; }
        .card-frame { background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden; margin:20px 0; }
        .card-frame img { width:100%; height:auto; display:block; }
        h1 { font-size:1.2rem; font-weight:800; color:#1c1e21; text-align:center; margin-top:20px; }
        p { color:#65676b; text-align:center; font-size:0.9rem; }
        .fb-share { display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:14px; background:#1877f2; color:#fff; border:none; border-radius:8px; font-size:1rem; font-weight:700; cursor:pointer; text-decoration:none; transition:background .2s; }
        .fb-share:hover { background:#166fe5; color:#fff; }
        .btn-try { display:block; text-align:center; margin-top:12px; padding:12px; background:#fff; color:#1877f2; border:2px solid #1877f2; border-radius:8px; font-weight:700; font-size:0.95rem; text-decoration:none; }
        .btn-try:hover { background:#1877f2; color:#fff; }
        .footer-note { text-align:center; margin-top:20px; font-size:0.75rem; color:#65676b; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>{{ $game->title }}</h1>
        <p>Share this with your friends!</p>

        <div class="card-frame">
            <img src="{{ $imageUrl }}" alt="{{ $game->title }}">
        </div>

        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="fb-share">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            Share on Facebook
        </a>

        <a href="{{ route('game.show', $game->slug) }}" class="btn-try">{{ $game->og_title ?: 'Try it yourself!' }}</a>

        <div style="margin-top:20px; text-align:center;">
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-8426510303593933"
                 data-ad-slot="7888884839"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        <div style="margin-top:12px; text-align:center;">
            <ins class="adsbygoogle"
                 style="display:inline-block;width:320px;height:50px"
                 data-ad-client="ca-pub-8426510303593933"
                 data-ad-slot="5606482216"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>

        <div class="footer-note">For entertainment purposes only &bull; autolikerlive.com</div>
    </div>
</body>
</html>