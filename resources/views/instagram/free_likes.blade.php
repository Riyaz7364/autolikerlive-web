@extends('layouts.master')

@section('title', 'Free Likes - Autolikerlive.com')
@section('description',
    'Easily view Instagram profile pictures in full size with our Instagram dp download. Enter a
    public profile URL to see high-resolution profile photos. Free and easy to use!')
@section('javascripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>

    <x-mail-wrapper></x-mail-wrapper>
@endsection

@section('content')
    <x-navbar></x-navbar>
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center">Free IG Likes</h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                @livewire('instagram.credits-component')


                <div class="mail-wrapper">
                    <div class="mail-selection mb-3">
                        <div class="border-dashes p-3 justify-content-center">
                            <h1 class="h5 justify-content-center text-center">
                                {{ __('messages.freeService.title', ['amount' => '10', 'service' => 'Instagram Likes', 'timer' => '5']) }}
                            </h1>
                            <h2 class="h6 text-center text-white justify-content-center p-3 text-muted">
                                {!! __('messages.freeService.subTitle', [
                                    'service' => 'Instagram',
                                    'amount' => '10',
                                    'type' => 'Likes',
                                    'timer' => '5',
                                ]) !!}</h2>
                            <h3 class="text-danger">Cost 1 credit</h3>
                            <form method="post" action="{{ route('free-tiktok-views-post') }}" id="form">
                                @csrf
                                <input type="hidden" name="type" value="INSTA_LIKES">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>{{ $errors->first() }}</li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="input-group mb-3">
                                    <input type="text" name="link" class="form-control"
                                        placeholder="Paste your video link" aria-label="Paste your video link"
                                        aria-describedby="basic-addon2">

                                    <div class="input-group-append">
                                        <button class="btn btn-primary" id="sendViewsBtn" type="submit">Send Views</button>
                                    </div>
                                </div>
                                <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>

                            </form>
                            <div class="row pt-4 px-5 text-center">
                                {!! getIcon('instagram', 'feature p-1 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-2 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}

                                <div id="countdown" class="col text-white border h5 rounded btn btn-success text-uppercase">
                                    Ready
                                </div>



                            </div>

                            @if (Session::has('sucess'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{{ Session::get('sucess') }}</li>
                                    </ul>
                                </div>
                                <!-- Share Modal -->
                                <div class="modal fade show" id="shareModal" tabindex="-1"
                                    aria-labelledby="shareModalLabel" style="display: block;" aria-modal="true"
                                    role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark">Thank You for Your Support! ❤️</h5>
                                                <button type="button" class="btn-close"
                                                    onclick="document.querySelector('#shareModal').classList.remove('show')"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p>We appreciate you using our service! Please share and help us grow. 🙏
                                                </p>
                                                <p class="h4 text-danger">(っ◔◡◔)っ ♥ share ♥</p>
                                                <!-- Social Share Buttons -->
                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                    <a href="#" target="_blank" id="facebookShare"
                                                        class="btn btn-primary">Facebook</a>
                                                    <a href="#" target="_blank" id="twitterShare"
                                                        class="btn btn-info text-white">Twitter</a>
                                                    <a href="#" target="_blank" id="whatsappShare"
                                                        class="btn btn-success">WhatsApp</a>
                                                    <a href="#" target="_blank" id="telegramShare"
                                                        class="btn btn-secondary">Telegram</a>
                                                    <a href="#" target="_blank" id="pinterestShare"
                                                        class="btn btn-danger">Pinterest</a>
                                                    <a href="#" target="_blank" id="redditShare"
                                                        class="btn btn-warning">Reddit</a>
                                                    <a href="#" target="_blank" id="snapchatShare"
                                                        class="btn btn-dark">Snapchat</a>
                                                </div>
                                                <a href="https://telegram.me/autolikerlive" class="btn mt-5"
                                                    style="background-color: #0088cc; color: white; border-radius: 5px; padding: 10px 10px; text-decoration: none; display: inline-block; font-weight: bold;">
                                                    {!! getIcon('telegram', 'telegramIcon') !!} Join Telegram Channel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="ad ad-250x250">
                        <!-- Temp Mail Right adsbygoogle -->

                    </div>
                </div>
                <div class="temp-emailbox-text text-center my-2">
                    <p class="text-dark pt-2">I Understand and Agree with <a class="link"
                            href="{{ url('privacy') }}">Privacy Policy</a> and <a class="link"
                            href="{{ url('terms') }}">Terms of Uses</a></p>
                </div>
            </div>

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
                  line-height: 10px;">
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
                  line-height: 10px;">
                                {{ __('messages.freeService.tour.step2') }}</h6>
                            <p class="card-text">
                                {{ __('messages.freeService.tour.step2_p1', ['service' => 'Instagram video']) }}</p>
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
                  line-height: 10px;">
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
                  line-height: 10px;">
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

        </div>
    </main>



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
                document.getElementById('countdown').innerHTML = 'Ready';
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
                document.getElementById('sendViewsBtn').innerHTML = `Ready`;
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

        document.addEventListener('DOMContentLoaded', function() {
            try {
                const pageUrl = encodeURIComponent("https://www.autolikerlive.com/auto-liker-instagram");
                const message = encodeURIComponent(
                    "Instagram Auto Likes - Get Unlimited Free Instagram Likes every 5 minutes 🚀🔥");
                const hashtags = encodeURIComponent("autolikerlive,freeInstaLikes,freeLikes");
                const imageUrl = encodeURIComponent("https://www.autolikerlive.com/images/graphic.webp");

                // Set Share URLs with null checks
                setShareLink("facebookShare", `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`);
                setShareLink("twitterShare",
                    `https://twitter.com/intent/tweet?url=${pageUrl}&text=${message}&hashtags=${hashtags}`);
                setShareLink("whatsappShare", `https://api.whatsapp.com/send?text=${message} ${pageUrl}`);
                setShareLink("telegramShare", `https://t.me/share/url?url=${pageUrl}&text=${message}`);
                setShareLink("pinterestShare",
                    `https://pinterest.com/pin/create/button/?url=${pageUrl}&media=${imageUrl}&description=${message}`
                );
                setShareLink("redditShare", `https://www.reddit.com/submit?url=${pageUrl}&title=${message}`);
                setShareLink("snapchatShare", `https://www.snapchat.com/scan?attachmentUrl=${pageUrl}`);
            } catch (error) {
                console.error("Error setting up share links:", error);
            }
        });



        function setShareLink(elementId, url) {
            const element = document.getElementById(elementId);
            if (element) {
                element.href = url;
            } else {
                console.warn(`Element with ID ${elementId} not found`);
            }
        }
    </script>

@endsection
