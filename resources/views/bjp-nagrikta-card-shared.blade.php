@php
    $pageTitle = 'BJP Bhartiya Nagrikta Card - Shared Card';
    $pageDesc = 'Check out this BJP Bhartiya Nagrikta Card! Make your own at AutolikerLive.';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}" />

    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $pageTitle }}" />
    <meta property="og:description" content="{{ $pageDesc }}" />
    <meta property="og:image" content="{{ $imageUrl }}" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="600" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $pageTitle }}" />
    <meta name="twitter:description" content="{{ $pageDesc }}" />
    <meta name="twitter:image" content="{{ $imageUrl }}" />

    {{-- Bootstrap CSS removed for Tailwind migration --}}
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: linear-gradient(135deg, #1a0a00 0%, #3d2000 50%, #1a0a00 100%); min-height: 100vh; display: flex; flex-direction: column; align-items: center; font-family: system-ui, -apple-system, sans-serif; }
        .container { max-width: 600px; width: 100%; padding: 20px; }
        .card-frame { background: linear-gradient(135deg, #ff9933 0%, #ffb347 50%, #ff9933 100%); padding: 12px; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); margin: 30px 0; }
        .card-frame .inner { background: white; border-radius: 12px; overflow: hidden; }
        .card-frame img { width: 100%; height: auto; display: block; }
        .btn-share { padding: 14px 30px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all .3s; border: none; cursor: pointer; }
        .btn-share:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); }
        .btn-facebook { background: #1877f2; color: white; }
        .btn-twitter { background: #000; color: white; }
        .btn-whatsapp { background: #25d366; color: white; }
        .btn-telegram { background: #0088cc; color: white; }
        .btn-primary-custom { background: linear-gradient(135deg, #ff9933, #ff8000); color: white; border: none; border-radius: 50px; padding: 14px 30px; font-weight: 700; text-decoration: none; display: inline-block; transition: all .3s; }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,153,51,0.4); color: white; }
        .footer-text { color: rgba(255,255,255,0.5); font-size: 0.8rem; text-align: center; margin-top: 30px; padding: 20px; }
        .flag-stripe { height: 4px; background: linear-gradient(90deg, #ff9933 33.33%, white 33.33%, white 66.66%, #138808 66.66%); width: 100%; position: fixed; top: 0; left: 0; z-index: 100; }
        .copy-btn { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 50px; padding: 10px 20px; font-size: 0.9rem; cursor: pointer; transition: all .3s; }
        .copy-btn:hover { background: rgba(255,255,255,0.2); }
    </style>
</head>
<body>
    <div class="flag-stripe"></div>
    <div class="container text-center">
        <h1 class="text-white" style="margin-top: 20px; font-size: 1.5rem; font-weight: 800;">BJP Bhartiya Nagrikta Card</h1>
        <p class="text-white-50" style="margin-bottom: 0;">Share this card with your friends!</p>

        <div class="card-frame">
            <div class="inner">
                <img src="{{ $imageUrl }}" alt="BJP Bhartiya Nagrikta Card">
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn-share btn-facebook">Facebook</a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode('Check out my BJP Bhartiya Nagrikta Card!') }}&url={{ urlencode(url()->current()) }}" target="_blank" class="btn-share btn-twitter">Twitter</a>
            <a href="https://wa.me/?text={{ urlencode('Check out my BJP Bhartiya Nagrikta Card! ' . url()->current()) }}" target="_blank" class="btn-share btn-whatsapp">WhatsApp</a>
            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode('BJP Bhartiya Nagrikta Card') }}" target="_blank" class="btn-share btn-telegram">Telegram</a>
        </div>

        <div style="margin-top: 20px;">
            <button class="copy-btn" onclick="copyLink()">Copy Link</button>
        </div>

        <div style="margin-top: 30px;">
            <a href="{{ route('bjp.nagrikta.card') }}" class="btn-primary-custom">Make Your Own Card</a>
        </div>

        <div class="footer-text">
            This is a PARODY/MEME page. Not affiliated with any political party. Not a real government document.
        </div>
    </div>

    <script>
        function copyLink() {
            navigator.clipboard.writeText('{{ url()->current() }}').then(() => {
                const btn = event.target;
                const orig = btn.textContent;
                btn.textContent = 'Copied!';
                setTimeout(() => btn.textContent = orig, 2000);
            });
        }
    </script>
</body>
</html>