@extends('layouts.autoliker')

@section('title', 'Free Views - Autolikerlive.com')
@section('description',
    'Easily view Instagram profile pictures in full size with our Instagram dp download. Enter a
    public profile URL to see high-resolution profile photos. Free and easy to use!')
@section('javascripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>

    <x-mail-wrapper></x-mail-wrapper>
@endsection

@section('content')
    <h1 class="alk-page-title">Free IG Views</h1>

    @livewire('instagram.credits-component')

    <section class="alk-card" aria-label="Free Instagram views form">
        <div class="alk-card-title"><i class="bi bi-eye-fill"></i> {{ __('messages.freeService.title', ['amount' => '10', 'service' => 'Instagram Views', 'timer' => '10']) }}</div>
        <p class="alk-muted">
            {!! __('messages.freeService.subTitle', [
                'service' => 'Instagram',
                'amount' => '100',
                'type' => 'Views',
                'timer' => '10',
            ]) !!}
        </p>
        <p class="fw-bold text-danger mt-2">Cost 1 credit</p>

        <form method="post" action="{{ route('free-tiktok-views-post') }}" id="form">
            @csrf
            <input type="hidden" name="type" value="INSTA_VIEWS">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
            @endif
            <div class="alk-field-row">
                <input type="text" name="link" class="alk-input"
                    placeholder="Paste your video link" aria-label="Paste your video link"
                    aria-describedby="basic-addon2" inputmode="url" autocomplete="off">
                <button class="alk-btn alk-btn-primary" id="sendViewsBtn" type="submit">Send Views</button>
            </div>
            <div class="alk-turnstile">
                <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>
            </div>
        </form>

        <div class="mt-3 text-center">
            <span id="countdown" class="alk-countdown">Ready</span>
        </div>

        @if (Session::has('sucess'))
            <div class="alert alert-success mt-3">
                <ul>
                    <li>{{ Session::get('sucess') }}</li>
                </ul>
            </div>
            <!-- Share Modal -->
            <div class="modal fade show alk-share-modal" id="shareModal" tabindex="-1"
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
                            <div class="alk-share-grid">
                                <a href="#" target="_blank" id="facebookShare" class="alk-mini-btn" style="background:#1877F2;color:#fff;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">Facebook</a>
                                <a href="#" target="_blank" id="twitterShare" class="alk-mini-btn" style="background:#0ea5e9;color:#fff;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">Twitter</a>
                                <a href="#" target="_blank" id="whatsappShare" class="alk-mini-btn" style="background:#16a34a;color:#fff;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">WhatsApp</a>
                                <a href="#" target="_blank" id="telegramShare" class="alk-mini-btn" style="background:#e2e8f0;color:#000;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">Telegram</a>
                                <a href="#" target="_blank" id="pinterestShare" class="alk-mini-btn" style="background:#dc2626;color:#fff;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">Pinterest</a>
                                <a href="#" target="_blank" id="redditShare" class="alk-mini-btn" style="background:#facc15;color:#000;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">Reddit</a>
                            </div>
                            <a href="https://telegram.me/autolikerlive" class="alk-btn mt-3" style="background:#0088cc;color:#fff;min-height:48px;font-size:14px;">{!! getIcon('telegram', 'telegramIcon') !!} Join Telegram Channel</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <p class="alk-muted text-center mt-3" style="font-size:13px;">I Understand and Agree with <a class="link"
                href="{{ url('privacy') }}">Privacy Policy</a> and <a class="link"
                href="{{ url('terms') }}">Terms of Uses</a></p>
    </section>

    <div class="alk-ad" aria-label="Advertisement">
        <x-ads.in-article />
    </div>

    <section class="alk-card" aria-label="How it works">
        <div class="alk-card-title"><i class="bi bi-info-circle"></i> {{ __('messages.freeService.howItsWork') }}</div>
        <p class="alk-muted">{{ __('messages.freeService.howItsWork_p1', ['service' => 'Instagram Views', 'timer' => '10', 'amount' => '100']) }}</p>
        <ol class="alk-steps">
            <li><div><strong>{{ __('messages.freeService.tour.step1') }}</strong><br>{{ __('messages.freeService.tour.step1_p1', ['service' => 'Views', 'service' => 'Instagram video']) }}</div></li>
            <li><div><strong>{{ __('messages.freeService.tour.step2') }}</strong><br>{{ __('messages.freeService.tour.step2_p1', ['service' => 'Instagram video']) }}</div></li>
            <li><div><strong>{{ __('messages.freeService.tour.step3') }}</strong><br>{{ __('messages.freeService.tour.step3_p1') }}</div></li>
            <li><div><strong>{{ __('messages.freeService.tour.step4', ['type' => 'Views']) }}</strong><br>{{ __('messages.freeService.tour.step4_p1', ['type' => 'Views']) }}</div></li>
        </ol>
    </section>

    <section class="alk-card" aria-label="Why choose us">
        <ol class="alk-steps">
            <li><div><strong>{{ __('messages.freeService.howItsWork2') }}</strong><br>{{ __('messages.freeService.howItsWork2_p1', ['service_name' => 'Instagram video', 'service' => 'Instagram Views', 'timer' => '10']) }}</div></li>
            <li><div><strong>{{ __('messages.freeService.whyChooseUs') }}</strong><br>{{ __('messages.freeService.whyChooseUs_p1', ['service_name' => 'Instagram']) }}</div></li>
            <li><div><strong>{{ __('messages.freeService.ourServices') }}</strong><br>{!! __('messages.freeService.ourServices_p1', ['service' => 'Instagram Views']) !!}</div></li>
        </ol>
    </section>

    <script data-cfasync="false">
        // Assuming $timeLeft is the total seconds
        var timeLeft = {{ $timeLeft }};
        var sendViewsBtn = document.getElementById('sendViewsBtn');

        function updateTimer() {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('countdown').innerHTML = formattedTime;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = 'Submit';
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
                    "Instagram Auto Views - Get Unlimited Free Instagram Views every 10 minutes 🚀🔥");
                const hashtags = encodeURIComponent("autolikerlive,freeInstaViews,freeViews");
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
