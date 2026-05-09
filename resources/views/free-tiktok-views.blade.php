@extends('layouts.master')

@section('title',
    __('messages.freeService.meta_title', [
    'title' => 'TikTok Auto Views',
    'service_name' => 'Tiktok Views',
    'timer' => '5',
    ]))
@section('description',
    __('messages.freeService.meta_desc', [
    'service_name' => 'TikTok',
    'title' => 'TikTok Auto Views',
    'service_type' => 'views',
    'timer' => '5',
    ]))
@section('ogimage', asset('images/free-tiktok-views.png'))
@section('javascripts')

    <script data-cfasync="false" src="//d3t9wb555jg65y.cloudfront.net/?jbwtd=1162446"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
    </script>
    <x-mail-wrapper></x-mail-wrapper>
    <style type="text/css">
        .login-with-google-btn {
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 42px;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 14px 15px;
        }

        .login-with-google-btn:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .login-with-google-btn:active {
            background-color: #eeeeee;
        }

        .login-with-google-btn:focus {
            outline: none;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
        }

        .login-with-google-btn:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            cursor: not-allowed;
        }

        .temp-emailbox-text p {
            color: #7a7c80;
            font-size: 14px !important;
            font-family: 'Roboto Mono', monospace !important;
            font-weight: 500 !important;
            padding: 0;
            margin: 0;
        }



        .bg-light h4,
        p {
            color: black
        }

        .infoicon {
            color: #00b3fe;
            font-size: 60px;
            padding: 15px;
        }

        .tiktokIcon {
            color: white;
        }

        .emoji-size {
            width: 3rem;
        }

        @media only screen and (max-width: 600px) {
            .max-width {
                width: 100%
            }
        }
    </style>

    <style>
        body,
        .bg-dark {
            background: #010101 !important;
        }

        .tiktok-header {
            background: linear-gradient(90deg, #010101 60%, #25F4EE 100%);
            color: #fff;
            padding: 2rem 0 1rem 0;
            border-bottom: 4px solid #FE2C55;
            text-align: center;
        }

        .tiktok-header .tiktok-logo {
            font-size: 3rem;
            color: #FE2C55;
            margin-bottom: 0.5rem;
        }

        .tiktok-header h1 {
            font-family: 'Montserrat', 'Arial', sans-serif;
            font-weight: 900;
            letter-spacing: 2px;
            color: #fff;
        }

        .tiktok-header p {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .tiktok-card {
            background: #181818;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
            padding: 2rem 2rem 1rem 2rem;
            margin: 2rem auto;
            max-width: 500px;
            width: -webkit-fill-available;
            color: #fff;
        }

        .tiktok-card input,
        .tiktok-card button {
            border-radius: 2rem !important;
            font-size: 1.1rem;
        }

        .tiktok-card input {
            background: #222;
            color: #fff;
            border: 1px solid #25F4EE;
        }

        .tiktok-card input:focus {
            border-color: #FE2C55;
            box-shadow: 0 0 0 2px #FE2C5533;
        }

        .tiktok-btn {
            background: linear-gradient(90deg, #FE2C55 60%, #25F4EE 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            padding: 0.75rem 2rem;
            margin-top: 1rem;
            transition: background 0.2s;
            box-shadow: 0 2px 8px #FE2C5533;
        }

        .tiktok-btn:disabled {
            background: #444;
            color: #ccc;
        }

        .tiktok-features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            margin: 2rem 0;
        }

        .tiktok-feature-card {
            background: #222;
            border-radius: 1rem;
            padding: 1.5rem;
            color: #fff;
            min-width: 220px;
            max-width: 300px;
            flex: 1 1 220px;
            box-shadow: 0 2px 8px #25F4EE22;
            text-align: center;
        }

        .tiktok-feature-card i {
            font-size: 2.5rem;
            color: #25F4EE;
            margin-bottom: 0.5rem;
        }

        .tiktok-feature-card h4 {
            color: #FE2C55;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .tiktok-section-title {
            color: #25F4EE;
            font-weight: bold;
            margin: 2rem 0 1rem 0;
            text-align: center;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .tiktok-img {
            border-radius: 1rem;
            margin: 2rem auto;
            display: block;
            max-width: 350px;
            box-shadow: 0 4px 24px #FE2C5522;
        }

        .tiktok-terms {
            color: #aaa;
            font-size: 0.95rem;
            margin-top: 2rem;
            text-align: center;
        }

        p {
            color: white;
        }

        @media (max-width: 600px) {
            .tiktok-card {
                padding: 1rem;
            }

            .tiktok-features {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>

@stop
@section('content')
    <x-navbar></x-navbar>
    <div class="tiktok-header">
        <div class="tiktok-logo">
            <i class="bi bi-music-note-beamed"></i>
        </div>
        <h1>Free TikTok Views</h1>
        <p>Get 100+ Free TikTok Views Every 5 Minutes 🚀</p>
    </div>
    @if ($agent->is('Firefox') || $agent->isAndroidOS())
        <div class="d-flex flex-column align-items-center gap-3">
            <div class="position-relative w-100">
                <div class="download-badge mx-auto mb-2"
                    style="width:70px;height:70px;background:linear-gradient(135deg,#ff0050,#00f2ea);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                    <amp-img src="https://img.icons8.com/color/48/000000/android-os.png" alt="Android"
                        style="width:40px;height:40px;"></amp-img>
                </div>
                <span class="badge bg-success position-absolute top-0 end-0 translate-middle-y px-3 py-2 fs-6"
                    style="font-size:0.9rem;">
                    <i class="bi bi-stars"></i> New Version!
                </span>
            </div>
            <div class="mb-2">
                <span class="fw-bold text-primary fs-5">Tiktok Auto Liker App</span>
                <span class="text-muted d-block small">Fast, Safe & Free</span>
            </div>
            <a href="{{ route('apk.download') }}" onclick="zxndnnndje('c872f424=account');"
                class="btn btn-gradient btn-lg px-5 py-3 rounded-pill d-flex align-items-center justify-content-center gap-2 shadow"
                style="background:linear-gradient(90deg,#ff0050 0%,#00f2ea 100%);color:#fff;font-size:1.25rem;font-weight:600;transition:transform 0.2s;">
                {!! getIcon('android2', '') !!}
                <span>Download Now</span>
                <i class="bi bi-arrow-down-circle-fill fs-4 ms-2"></i>
            </a>
            <div class="text-muted small mt-2">
                <i class="bi bi-shield-check text-success"></i> 100% Safe & Verified • <i class="bi bi-clock-history"></i>
                Updated Regularly
            </div>
        </div>
    @else
        <div class="tiktok-card">
            <form method="post" action="{{ route('free-tiktok-views-post') }}" id="form">
                @csrf
                <input type="hidden" name="type" value="FREE_TIKTOK">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first() }}</li>
                        </ul>
                    </div>
                @endif
                <div class="input-group mb-3">
                    <input type="text" name="link" class="form-control" placeholder="Paste your TikTok video link"
                        aria-label="Paste your video link" aria-describedby="basic-addon2">
                </div>
                <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>
                <div class="col-12 text-center mb-2">
                    <button class="tiktok-btn" id="sendViewsBtn" type="submit">Send Views</button>
                </div>
                <div id="countdown" class="btn btn-outline-info btn-block mt-3" style="font-size:1.2rem;">Ready</div>
                <!-- Temp Mail Center adsbygoogle -->

            </form>
            @if (Session::has('sucess'))
                <div class="alert alert-success mt-3">
                    <ul>
                        <li>{{ Session::get('sucess') }}</li>
                    </ul>
                </div>
            @endif
        </div>
    @endif
    <div class="tiktok-section-title">How It Works</div>
    <div class="tiktok-features" style="align-content: center;">
        <div class="tiktok-feature-card">
            <i class="bi bi-clipboard-check"></i>
            <h4> {{ __('messages.freeService.tour.step1') }}</h4>
            <p> {{ __('messages.freeService.tour.step1_p1', ['service' => 'views', 'service' => 'TikTok video']) }}</p>
        </div>
        <div class="tiktok-feature-card">
            <i class="bi bi-clock-history"></i>
            <h4> {{ __('messages.freeService.tour.step2') }}</h4>
            <p>{{ __('messages.freeService.tour.step2_p1', ['service' => 'TikTok video']) }}</p>
        </div>
        <div class="tiktok-feature-card">
            <i class="bi bi-rocket-takeoff"></i>
            <h4> {{ __('messages.freeService.tour.step3') }}</h4>
            <p>{{ __('messages.freeService.tour.step3_p1') }}</p>
        </div>
        <div class="tiktok-feature-card">
            <i class="bi bi-rocket-takeoff text-white"></i>
            <h4> {{ __('messages.freeService.tour.step4', ['type' => 'views']) }}</h4>
            <p>{{ __('messages.freeService.tour.step4_p1', ['type' => 'views']) }}</p>
        </div>
    </div>

    <img class="tiktok-img" src="https://www.autolikerlive.com/assets/images/tiktok_view_15.webp" alt="Free Tiktok Views" />

    <div class="tiktok-section-title">{{ __('messages.freeService.whyChooseUs') }}</div>
    <div class="tiktok-features">
        <div class="tiktok-feature-card">
            <i class="bi bi-shield-check"></i>
            <h4>Safe & Secure</h4>
            <p>No password required. 100% safe and private.</p>
        </div>
        <div class="tiktok-feature-card">
            <i class="bi bi-lightning-charge"></i>
            <h4>Fast Delivery</h4>
            <p>Views delivered within minutes, every time.</p>
        </div>
        <div class="tiktok-feature-card">
            <i class="bi bi-gift"></i>
            <h4>Completely Free</h4>
            <p>No hidden charges. Unlimited free TikTok views.</p>
        </div>
    </div>
    <div class="tiktok-section-title">
        {{ __('messages.freeService.boost', ['service' => 'TikTok Views', 'service_name' => 'TikTok']) }}
    </div>
    <div class="tiktok-card" style="max-width: 700px;">
        <div class="temp-emailbox-text my-2">
            <p>
                {{ __('messages.freeService.boost_p1', [
                    'service' => 'TikTok Views',
                    'servoce_name' => 'TikTok',
                    'type' => 'views',
                    'amount' => '100',
                ]) }}
            </p>
            <p>
                {{ __('messages.freeService.boost_p2', [
                    'service' => 'TikTok Views',
                    'servoce_name' => 'TikTok',
                ]) }}
            </p>
        </div>
    </div>



    <div class="tiktok-terms">
        <p>
            By using this service, you agree to our <a href="{{ url('privacy') }}" class="text-info">Privacy Policy</a> and
            <a href="{{ url('terms') }}" class="text-info">Terms of Use</a>.
        </p>
    </div>

    <script data-cfasync=”false”>
        // Assuming $timeLeft is the total seconds
        var timeLeft = {{ $timeLeft }};
        var sendViewsBtn = document.getElementById('sendViewsBtn');

        function updateTimer() {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('countdown').innerHTML = formattedTime;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = 'Ready'; //'Ready';
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                timeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(updateTimer, 1000);
            }
        }

        var mytimeLeft = 30;

        function successMsg() {
            var minutes = Math.floor(mytimeLeft / 60);
            var seconds = mytimeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('sendViewsBtn').innerHTML = formattedTime;

            if (mytimeLeft <= 0) {
                document.getElementById('sendViewsBtn').innerHTML = `Send Views`;
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                mytimeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(successMsg, 1000);
            }
        }

        function onSubmit(token) {

            // window.open('https://chikraighotoops.com/4/8461951', '_blank');

            document.getElementById("form").submit();
        }



        successMsg();
        updateTimer();

        const pageUrl = encodeURIComponent(window.location.href);
        const message = encodeURIComponent("TikTok Auto Views - Get Unlimited Free TikTok Views every 15 minutes 🚀🔥");
        const hashtags = encodeURIComponent("autolikerlive,freetiktokviews");
        const imageUrl = encodeURIComponent("https://example.com/images/tiktok_views.png"); // Change to your image

        // Set Share URLs
        document.getElementById("facebookShare").href = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
        document.getElementById("twitterShare").href =
            `https://twitter.com/intent/tweet?url=${pageUrl}&text=${message}&hashtags=${hashtags}`;
        document.getElementById("whatsappShare").href = `https://api.whatsapp.com/send?text=${message} ${pageUrl}`;
        document.getElementById("telegramShare").href = `https://t.me/share/url?url=${pageUrl}&text=${message}`;
        document.getElementById("pinterestShare").href =
            `https://pinterest.com/pin/create/button/?url=${pageUrl}&media=${imageUrl}&description=${message}`;
        document.getElementById("redditShare").href = `https://www.reddit.com/submit?url=${pageUrl}&title=${message}`;
        document.getElementById("snapchatShare").href = `https://www.snapchat.com/scan?attachmentUrl=${pageUrl}`;
    </script>
    {{-- <x-ads></x-ads> --}}
@stop
