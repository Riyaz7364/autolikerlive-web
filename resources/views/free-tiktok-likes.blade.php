@extends('layouts.master')

@section('title', 'TikTok Engagement Community | Connect with Content Creators')
@section('description',
    'Join our community of TikTok users to increase your content visibility through genuine
    engagement. Build connections with other creators and grow your presence organically.')



@section('javascripts')

<script data-cfasync="false" src="//d3t9wb555jg65y.cloudfront.net/?jbwtd=1162446"></script>
<script>(function(s){s.dataset.zone='10482447',s.src='https://n6wxm.com/vignette.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
    <x-mail-wrapper></x-mail-wrapper>

    </script>

@stop
@section('content')
    @php
        $json = json_decode(file_get_contents(public_path('info.json')));

    @endphp
    <x-navbar></x-navbar>
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

        .border-dashes {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='10' ry='10' stroke='%2365656557' stroke-width='3' stroke-dasharray='10' stroke-dashoffset='0' stroke-linecap='round'/%3e%3c/svg%3e");
            border-radius: 10px;
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

        @media only screen and (min-width: 601px) {
            .max-width {
                width: 512px
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

    <header class="bg-dark py-5">
        <div class="container pxc-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col d-none d-lg-block">
                    <x-ads.square></x-ads.square>
                </div>
                <div class="col-md-10 col-lg-6 col-sm-12 pxc-5 text-center">
                    <h1 class="h4 fw-bold mb-3 text-white">
                        {{ __('messages.freeService.title', ['amount' => '10', 'service' => 'TikTok Likes', 'timer' => '15']) }}
                    </h1>
                    <div class="border-dashes p-4 bg-white bg-opacity-75 rounded-4 shadow-sm position-relative">
                        <h2 class="text-center text-dark p-2 h6 mb-4">
                            {!! __('messages.freeService.subTitle', [
                                'service' => 'TikTok',
                                'amount' => '10',
                                'type' => 'Likes',
                                'timer' => '15',
                            ]) !!}
                        </h2>
                        @if ($agent->is('Firefox') || $agent->isAndroidOS())
                            <div class="d-flex flex-column align-items-center gap-3">
                                <div class="position-relative w-100">
                                    <div class="download-badge mx-auto mb-2"
                                        style="width:70px;height:70px;background:linear-gradient(135deg,#ff0050,#00f2ea);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                                        <amp-img src="https://img.icons8.com/color/48/000000/android-os.png" alt="Android"
                                            style="width:40px;height:40px;"></amp-img>
                                    </div>
                                    <span
                                        class="badge bg-success position-absolute top-0 end-0 translate-middle-y px-3 py-2 fs-6"
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
                                    <i class="bi bi-shield-check text-success"></i> 100% Safe & Verified • <i
                                        class="bi bi-clock-history"></i> Updated Regularly
                                </div>
                            </div>
                        @else
                            <div class="tiktok-card">
                                <form method="post" action="{{ route('free-tiktok-views-post') }}" id="form">
                                    @csrf
                                    <input type="hidden" name="type" value="TIKTOK_LIKES">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                <li>{{ $errors->first() }}</li>
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="input-group mb-3">
                                        <input type="text" name="link" class="form-control"
                                            placeholder="Paste your TikTok video link" aria-label="Paste your video link"
                                            aria-describedby="basic-addon2">
                                    </div>
                                    <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>
                                    <div class="col-12 text-center mb-2">
                                        <button class="tiktok-btn" id="sendViewsBtn" type="submit">Send Views</button>
                                    </div>
                                    <div id="countdown" class="btn btn-outline-info btn-block mt-3"
                                        style="font-size:1.2rem;">Ready</div>
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
                        <!-- Temp Mail Center adsbygoogle -->
                        <div class="mt-4">

                        </div>
                    </div>
                </div>
                <div class="col d-none d-xl-block text-center">
                    <x-ads.responsive></x-ads.responsive>
                </div>
            </div>
        </div>
    </header>
    <style>
        .btn-gradient:hover,
        .btn-gradient:focus {
            transform: scale(1.04);
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.18);
            color: #fff !important;
            text-decoration: none;
        }
    </style>
    <section class="bg-light" id="no-ads-in-steps" data-ad-ignore="true">
        {!! toolbanner() !!}
        <div class="text-center p-5">
            <h2 class="text-dark">{{ __('messages.freeService.howItsWork') }}</h2>
            <p>{{ __('messages.freeService.howItsWork_p1', ['service' => 'TikTok Likes', 'timer' => '15', 'amount' => '10']) }}
            </p>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                <div class="card-body m-3">
                    <h1 class="card-title"
                        style="
                            color: #DADADA;
                            font-family: Helvetica, Sans-serif;
                            font-size: 85px;
                            font-weight: 600;">
                        01.</h1>
                    <h6 class="card-subtitle mb-2"
                        style="
              color: #000000;
              font-family: Roboto, Sans-serif;
              font-size: 18px;
              font-weight: 700;
              line-height: 20px;">
                        {{ __('messages.freeService.tour.step1') }}</h6>
                    <p class="card-text">
                        {{ __('messages.freeService.tour.step1_p1', ['service' => 'Likes', 'service' => 'TikTok video']) }}
                    </p>
                </div>
            </div>

            <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                <div class="card-body m-3">
                    <h1 class="card-title"
                        style="
                            color: #DADADA;
                            font-family: Helvetica, Sans-serif;
                            font-size: 85px;
                            font-weight: 600;">
                        02.</h1>
                    <h6 class="card-subtitle mb-2"
                        style="
              color: #000000;
              font-family: Roboto, Sans-serif;
              font-size: 18px;
              font-weight: 700;
              line-height: 20px;">
                        {{ __('messages.freeService.tour.step2') }}</h6>
                    <p class="card-text">{{ __('messages.freeService.tour.step2_p1', ['service' => 'TikTok video']) }}</p>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                <div class="card-body m-3">
                    <h1 class="card-title"
                        style="
                            color: #DADADA;
                            font-family: Helvetica, Sans-serif;
                            font-size: 85px;
                            font-weight: 600;">
                        03.</h1>
                    <h6 class="card-subtitle mb-2"
                        style="
              color: #000000;
              font-family: Roboto, Sans-serif;
              font-size: 18px;
              font-weight: 700;
              line-height: 20px;">
                        {{ __('messages.freeService.tour.step3') }}</h6>
                    <p class="card-text"> {{ __('messages.freeService.tour.step3_p1') }} </p>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                <div class="card-body m-3">
                    <h1 class="card-title"
                        style="
                            color: #DADADA;
                            font-family: Helvetica, Sans-serif;
                            font-size: 85px;
                            font-weight: 600;">
                        04.</h1>
                    <h6 class="card-subtitle mb-2"
                        style="
              color: #000000;
              font-family: Roboto, Sans-serif;
              font-size: 18px;
              font-weight: 700;
              line-height: 20px;">
                        {{ __('messages.freeService.tour.step4', ['type' => 'Likes']) }}</h6>
                    <p class="card-text">{{ __('messages.freeService.tour.step4_p1', ['type' => 'Likes']) }}
                    </p>
                </div>
            </div>

        </div>

        <div class="row text-center p-5">

            <div class="col-md-4">
                <i class="bi bi-balloon-heart-fill infoicon"></i>
                <h4>{{ __('messages.freeService.howItsWork2') }}</h4>
                <p>
                    {{ __('messages.freeService.howItsWork2_p1', [
                        'service_name' => 'TikTok video',
                        'service' => 'TikTok Likes',
                        'timer' => '15',
                    ]) }}
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-unlock-fill infoicon"></i>
                <h4>{{ __('messages.freeService.whyChooseUs') }}</h4>
                <p>
                    {{ __('messages.freeService.whyChooseUs_p1', ['service_name' => 'TikTok']) }}
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-trophy-fill infoicon"></i>
                <h4>{{ __('messages.freeService.ourServices') }}</h4>
                <p>
                    {!! __('messages.freeService.ourServices_p1', ['service' => 'TikTok Likes']) !!}
                </p>
            </div>
        </div>
    </section>

    <section class="bg-dark text-center p-3">
        <h2 class="text-title">{{ __('messages.freeService.whyShould', ['service' => 'TikTok Video Likes']) }}</h2>
        <p class="text-muted">{{ __('messages.freeService.whyShould_p1', ['service' => 'TikTok Likes']) }}</p>

        <img class="rounded mx-auto d-block max-width p-3 m-2"
            src="https://www.autolikerlive.com/images/Free-Tiktok-likes-1024x1024.webp" alt="Free Tiktok Likes" />

    </section>

    <section class="bg-light">
        <div class="container py-5">
            <h2 class="text-muted">
                {{ __('messages.freeService.boost', ['service' => 'TikTok Likes', 'service_name' => 'TikTok']) }}</h2>
            <div class="temp-emailbox-text my-2">
                <p>
                    {{ __('messages.freeService.boost_p1', [
                        'service' => 'TikTok Likes',
                        'servoce_name' => 'TikTok',
                        'type' => 'likes',
                        'amount' => '10',
                    ]) }}
                </p>

                <p>
                    {{ __('messages.freeService.boost_p2', [
                        'service' => 'TikTok Likes',
                        'servoce_name' => 'TikTok',
                    ]) }}
                </p>
            </div>
        </div>

    </section>
    <section>
        <div class="row mt-5">
            <div class="col"></div>
            <div class="col-md-5 col-lg-4 col-sm-12 pxc-5" id="check-order-status">
                <h1 class="h5 text-center">
                    <strong>{{ __('messages.freeService.chceckOrder', ['service' => 'TikTok Likes']) }}</strong>
                </h1>
                <div class="border-dashes p-3 justify-content-center">
                    <h2 class="text-center text-white justify-content-center p-3 h6">Check order status</h2>
                    <form method="post" action="{{ route('submit.check-order') }}" id="form">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{{ $errors->first() }}</li>
                                </ul>
                            </div>
                        @endif
                        <div class="input-group mb-3">
                            <input type="number" name="id" class="form-control" placeholder="Enter your order ID"
                                value="{{ isset($_GET['id']) ? $_GET['id'] : '' }}">

                            <div class="input-group-append">
                                <button class="form-control btn btn-primary" type="submit">Check Order</button>
                            </div>
                        </div>

                    </form>
                    @if (Session::has('orderStatus'))
                        <div class="alert alert-success">
                            <ul>
                                <li>{{ Session::get('orderStatus') }}</li>
                            </ul>
                        </div>
                    @endif
                </div>
                <p class="text-white">
                    {{ __('messages.freeService.chceckOrder_p1', ['service_name' => 'TikTok']) }}
                </p>
            </div>
            <div class="col"></div>
        </div>
    </section>
    <script data-cfasync=”false”>
        // Assuming $timeLeft is the total seconds
        var timeLeft = {{ $timeLeft }};
        var sendViewsBtn = document.getElementById('sendViewsBtn');
        var capchaWidgetID;

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

        var mytimeLeft = 37;

        function successMsg() {
            var minutes = Math.floor(mytimeLeft / 60);
            var seconds = mytimeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('sendViewsBtn').innerHTML = formattedTime;

            if (mytimeLeft <= 0) {
                document.getElementById('sendViewsBtn').innerHTML = `Send Likes`;
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                mytimeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(successMsg, 1000);
            }
        }

        function onSubmit(token) {
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
    <x-ads></x-ads>
@stop
