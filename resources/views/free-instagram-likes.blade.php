@extends('layouts.master')

@section('title',
    __('messages.freeService.meta_title', [
    'title' => 'Instagram Auto Likes',
    'service_name' => 'Instagram Likes',
    'timer' => '5',
    ]))
@section('description',
    __('messages.freeService.meta_desc', [
    'service_name' => 'Instagram',
    'title' => 'Instagram Auto Likes',
    'service_type' => 'Likes',
    'timer' => '5',
    ]))

@section('javascripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
   <script>(function(s){s.dataset.zone='10482447',s.src='https://n6wxm.com/vignette.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
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
    </style>
@stop
@section('content')
    @php
        $reactions = [
            'like' => 1,
            'love' => 2,
            'care' => 16,
            'haha' => 4,
            'wow' => 3,
            'sad' => 7,
            'engry' => 8,
        ];

        $json = json_decode(file_get_contents(url('') . '/Download/info.json'));

    @endphp
    <header class="bg-dark py-5">
        <div class="container pxc-5">

            <div class="mail-wrapper">


                <div class="mail-selection mb-3">
                    <div class="card text-center fw-bold">
                        <div class="card-header bg-warning">
                            Login with Instagram Username
                        </div>
                    </div>
                    <div class="border-dashes p-3 justify-content-center ">


                        <h5>Login Method</h5>
                        <p class="text-white">
                            {!! getIcon('bi-heart-pulse-fill', 'text-success') !!} HEARTS &nbsp;
                            {!! getIcon('bi-play-fill', 'text-success') !!} VIEWS &nbsp;
                            {!! getIcon('instagram', 'text-success') !!} FOLLOWERS</p>
                        <form method="post" action="{{ route('autoliker.login') }}" id="form">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>{{ $errors->first() }}</li>
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username Here"
                                        aria-label="Search your Instagram username" aria-describedby="basic-addon2">
                                </div>

                                <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>


                                <div class="col-12 text-center">
                                    <button class="btn btn-primary mb-2" id="submitBtn" type="submit">
                                        <span class="spinner-border spinner-border-sm text-light d-none"
                                            id="startsms_spinner" role="status" aria-hidden="true"></span>
                                        <span class="btn-text">Search Account</span></button>


                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- Temp Mail Center adsbygoogle -->

                    <div class="temp-emailbox-text text-center my-2">
                        <p class="text-dark pt-2 text-white">I Understand and Agree with <a class="link"
                                href="{{ url('privacy') }}">Privacy Policy</a> and <a class="link"
                                href="{{ url('terms') }}">Terms of Uses</a></p>
                    </div>

                </div>


            </div>
        </div>
    </header>
    <section class="bg-light" id="no-ads-in-steps">

        <div class="text-center p-5">
            <h2 class="text-dark">{{ __('messages.freeService.howItsWork') }}</h2>
            <p>{{ __('messages.freeService.howItsWork_p1', ['service' => 'Instagram Likes', 'timer' => '5', 'amount' => '10']) }}
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
                        {{ __('messages.freeService.tour.step1_p1', ['service' => 'Likes', 'service' => 'Instagram video']) }}
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
                    <p class="card-text">{{ __('messages.freeService.tour.step2_p1', ['service' => 'Instagram video']) }}
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
                        03.</h1>
                    <h6 class="card-subtitle mb-2"
                        style="
              color: #000000;
              font-family: Roboto, Sans-serif;
              font-size: 18px;
              font-weight: 700;
              line-height: 20px;">
                        {{ __('messages.freeService.tour.step3') }}</h6>
                    <p class="card-text">{{ __('messages.freeService.tour.step3_p1') }} </p>
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
                    <p class="card-text">{{ __('messages.freeService.tour.step4_p1', ['type' => 'Likes']) }}</p>
                </div>
            </div>

        </div>

        <div class="row text-center p-5">

            <div class="col-md-4">
                <i class="bi bi-balloon-heart-fill infoicon"></i>
                <h4>{{ __('messages.freeService.howItsWork2') }}</h4>
                <p>
                    {{ __('messages.freeService.howItsWork2_p1', [
                        'service_name' => 'Instagram video',
                        'service' => 'Instagram Likes',
                        'timer' => '5',
                    ]) }}
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-unlock-fill infoicon"></i>
                <h4>{{ __('messages.freeService.whyChooseUs') }}</h4>
                <p>
                    {{ __('messages.freeService.whyChooseUs_p1', ['service_name' => 'Instagram']) }}
                </p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-trophy-fill infoicon"></i>
                <h4>{{ __('messages.freeService.ourServices') }}</h4>
                <p>
                    {!! __('messages.freeService.ourServices_p1', ['service' => 'Instagram Likes']) !!}
                </p>
            </div>
        </div>
    </section>

    <section class="bg-dark text-center p-3">
        <h2 class="text-title">{{ __('messages.freeService.whyShould', ['service' => 'Instagram Video Likes']) }}</h2>
        <p class="text-muted">{{ __('messages.freeService.whyShould_p1', ['service' => 'Instagram Likes']) }}</p>

        {{-- <img class="rounded mx-auto d-block max-width p-3 m-2" src="https://www.autolikerlive.com/assets/images/tiktok_view_15.webp" alt="Free Instagram Likes" /> --}}

    </section>

    <section class="bg-light">
        <div class="container py-5">

            <div class="row">
                <div class="col-md-6 col-lg-8 col-sm-12 mb-5"></div>
                <h2 class="text-muted">
                    {{ __('messages.freeService.boost', ['service' => 'Instagram Likes', 'service_name' => 'Instagram']) }}
                </h2>
                <div class="temp-emailbox-text my-2">
                    <p>
                        {{ __('messages.freeService.boost_p1', [
                            'service' => 'Instagram Likes',
                            'servoce_name' => 'Instagram',
                            'type' => 'likes',
                            'amount' => '10',
                        ]) }}
                    </p>

                    <p>
                        {{ __('messages.freeService.boost_p2', [
                            'service' => 'Instagram Likes',
                            'servoce_name' => 'Instagram',
                        ]) }}
                    </p>
                </div>
                <div class="col-md-3 col-lg-4 col-sm-2"></div>
            </div>
        </div>

    </section>
    <script data-cfasync="false">
        document.getElementById('submitBtn').addEventListener('click', function() {
            const form = document.getElementById('form');
            form.submit();
            const btn = this;
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Searching...';
        });


        // Assuming $timeLeft is the total seconds
        var timeLeft = {{ $timeLeft }};
        var sendViewsBtn = document.getElementById('sendViewsBtn');

        function updateTimer() {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('countdown').innerHTML = formattedTime;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = 'Ready';
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                timeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(updateTimer, 1000);
            }
        }

        var mytimeLeft = 5;

        function successMsg() {
            var minutes = Math.floor(mytimeLeft / 60);
            var seconds = mytimeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('sendViewsBtn').innerHTML = formattedTime;

            if (mytimeLeft <= 0) {
                document.getElementById('sendViewsBtn').innerHTML = `Search Account`;
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
@stop
