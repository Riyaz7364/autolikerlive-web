@extends('layouts.master')

@section('title', 'FBsub - TikTok Auto liker and Auto Views')
@section('description',
    'Boost Tiktok engagement with our freer FBsub auto liker & views tool. Get likes,
    followers, views, shares, and comments hassle-free, no login required')

@section('javascripts')
    <x-mail-wrapper></x-mail-wrapper>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
     crossorigin="anonymous"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endsection

@push('styles')
    <style type="text/css">
        .login-with-telegram-btn {
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 42px;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAAXNSR0IArs4c6QAAAo9JREFUOE+NlEtIVHEUxn/nf++87aH0ELWHmUGhvbQypchF2QtbRBIurHXbaFVB7VsFLdpGEBkR0cMCSYksFIxaFIGkhEUYBvm4M82M956YmaZ5pNFdnvP9v+87ryv84zvwVCM/g6zwDBIM8b23UaYWgktxouG6+iL11DHHJeAIgpXGCB7KAB4XIg6DPYclnv+2kEhVWp7rI6ANMAuoK8pbn8qe/laZzWJyRKqyq1+HBG38V7nZnIqMEZStg00ynTEM7OtT2/H0nqJH/4fkDxm894dM46tmiaWJtvfqZk/d1/C7H/OwWSjVYaXcr7z4kWkboOrR/rbNfpgmqnuSuK1Ix3xuAkZpLfM4X+ejNGDo+fSTcx/sPKh8fHfQqpX1jzVgkZxRxZdPVBt0uVjvY+NSQ9gWJuIeFUHD5WGHWxP+Ak3bddfIhgdamST5OWVNgf3LlTO1FlvKMvYnE0rMVSqDBiNwoi/KsJPTTJfksUMq70arjGWNZyVWaozjFcqhtUEiJX58AqtDJjMVoOVJjPH4nx5lgu7cTqnqHg8lreWpEdpZV7guJQmHm4dL2bLYImRlaDyFdfeixItnYrQ6jVjWHb2vSHt+4TYe15ps+ken6awJs7sqzMDnKMdeCkhu/UT4MnkiuCodWdKdaMCbGyre5hqZYSzhx4dyusplxBGezYaLh9sxdTJ8J0Oduq+SWK/C3gKUeiCZS9G5JGIMmIL+jEXdUD1d4uQ8XldfIBJ9o7Bpvn0qjgl8tU14m9MpE6lc4dFeHQlYpZX9qO76K5dlElJHO+riNdO16FsuXCx1dSTA0vImVK4INKD5YvpRxZxFZnrpKnfyn/71PyrgvaErcJ2VeBhsM8mp8JeFyv4F0Ofj1/amqo0AAAAASUVORK5CYII=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 14px 15px;
        }

        .login-with-google-btn {
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 42px;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAAXNSR0IArs4c6QAAArVJREFUOE+Vk01IVFEUx//nvnkzgwud1D6sRSKCQYROU0lkJDlQLQLFDMSSPtH2LVzFREJBBa0KbGGRCX3iwjQZHQs/oPyY0haKCakVjVo56uA0vndPzNjYm0HD3urde87/d8//3HMJcR+7XGKyq3EvGMXEcIIpkwAzgG/E4g2DnymK/iK5tc9vlJJx8TXfkaoKugugEIgJxRzHoC86cVFaW09PNLCczQ5HwrSNPoIpLb7Kldc0vt7zdmsMaCwvb12COTQI8BaDiIn5tS5EM0EGJLBTYToJQCUWQyEKHd7s8Y7FgHyHHHfEoqg0QIalwmc3uHu7CeDo/ueCPSlmli4G39ro6RuN6VHQY8niCetQ4Hk6eM4MME9oVt2R1uydWpvFpSziNvWCBN1mKTBbmwE5ZSlPdXsf/A8kAgq5zfWCuDQi1IU27bbZNt3wBYwgZ/XPOiaRZXAZew5TE4Xcpk5BtC8cYdCA6gxlx1fjrJ7rl0R2Wm0kiF9RqNXUIUB5ERCJD2rBrx0rgZiEfTW7DHSR1qqG+3EinLQgFVk/sz254njs1IatgZQ/1ggMJoLJzoBYcoIG0trU82DUBMmEU9/349NiUkVv2ZOafzU7/6o/U9FNI1GnDOki7rBmdM6njF722zEDS/j6fWYZzO0ua1oetnhowZXAfRYo//uIQgcj/7mPiq5rTBcNzRwH9MreoZwWuFwyCnI8Lkmy+k5fs8weqAjfeETMPKxrUzlLoLqyRN204AWQEX2s4XEmiUEmtDBoXpC+TUIpFsyq5ccxWPxHQKxqUlF3tVeZ3y9Xl9/uMs35BkYIlL6WYVSCWXrieNU596XEe5GBNIpyagttJivdBIkzq8IipbJPsijpL33aEfNo40S0+2FJNoR+lImcAGWCpZmJJgH2EkSjZtFevitqmDHqfgPi3haa1/vu9gAAAABJRU5ErkJggg==);
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
        .bg-light p {
            color: black;
        }

        .infoicon {
            color: #00b3fe;
            font-size: 60px;
            padding: 15px;
        }

        .emoji-size {
            width: 3rem;
        }

        .hero-panel {
            max-width: 760px;
            margin: 0 auto;
        }

        .profile-search-card {
            background: rgba(255, 255, 255, 0.04);
        }

        .profile-search-actions {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .profile-search-actions .btn {
            min-width: 210px;
        }

        .ad-slot {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 90px;
            margin: 1.5rem 0;
            padding: 1rem;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.65);
            background: rgba(255, 255, 255, 0.06);
            border: 1px dashed rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            text-align: center;
        }

        .ad-slot-side {
            min-height: 280px;
            position: sticky;
            top: 90px;
        }

        @media (max-width: 991.98px) {
            .ad-slot-side {
                min-height: 120px;
                position: static;
            }
        }
    </style>
@endpush

@section('content')
    <header class="bg-dark py-5">
        <div class="container pxc-5">
            <div class="row gx-5 align-items-start justify-content-center">
                <div class="col-12 col-xl-8">
                    <div class="hero-panel">
                        <h1 class="h5 text-center text-white mb-4">FBsub - Get Auto followers and Auto Reactions</h1>

                        <div class="border-dashes p-3 p-md-4 justify-content-center">
                            <h5 class="text-center text-white justify-content-center p-3">
                                Autoliker<strong class="text-danger">Live</strong> Services
                            </h5>

                            <div class="mail-wrapper">
                                <div class="mail-selection mb-3">
                                    <div class="card text-center fw-bold">
                                        <div class="card-header facebook-btn">
                                            Login with Facebook Profile Link
                                        </div>
                                    </div>

                                    <div class="border-dashes profile-search-card p-3 p-md-4 justify-content-center">
                                        <h5 class="text-white">Login Method</h5>
                                        <p class="text-white">
                                            {!! getIcon('bi-heart-pulse-fill', 'text-success') !!} Reactions &nbsp;
                                            {!! getIcon('bi-play-fill', 'text-success') !!} Views &nbsp;
                                            {!! getIcon('facebook', 'text-success') !!} Followers
                                        </p>

                                        <form method="post" action="{{ route('login.facebook') }}" id="profileSearchForm" novalidate>
                                            @csrf

                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        <li>{{ $errors->first() }}</li>
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label for="username" class="form-label text-white mb-2">
                                                    <strong>Facebook Profile URL</strong>
                                                </label>
                                                <input type="url" class="form-control form-control-lg" id="username"
                                                    name="username" placeholder="Enter full Facebook profile URL" required
                                                    autocomplete="off">
                                                <small class="text-muted d-block mt-2">
                                                    Example: https://facebook.com/zuck or https://www.facebook.com/profile.php?id=123456789
                                                </small>
                                                <div class="invalid-feedback">
                                                    Please enter a valid Facebook profile URL.
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center mb-2">
                                                <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>
                                            </div>

                                            <div class="profile-search-actions">
                                                <button id="submitBtn" type="submit" class="btn"
                                                    style="background-color: #1877F2; color: white; border: none; border-radius: 8px; font-weight: 600; padding: 10px 40px; font-size: 16px;">
                                                    <span class="spinner-border spinner-border-sm text-white d-none" role="status" aria-hidden="true"></span>
                                                    <span class="btn-text">Search Profile</span>
                                                </button>
                                            </div>

                                            @if (session('fail'))
                                                <div class="mt-3 text-center">
                                                    <p class="h5 text-danger mb-2">Unable to access the Facebook profile.</p>
                                                    <p class="text-white-50 mb-3">Please ensure your profile is visible to
                                                        search engines.</p>
                                                    <a target="_blank" rel="nofollow noopener"
                                                        href="https://www.facebook.com/settings/?tab=how_people_find_and_contact_you"
                                                        class="facebook-btn btn btn-sm mb-3"
                                                        style="border-radius: 20px; padding: 8px 20px;">
                                                        Open Facebook Profile Settings
                                                    </a>
                                                    <video class="img-fluid rounded" controls>
                                                        <source src="https://www.autolikerlive.com/assets/videos/facebook_setting.mp4" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @endif

                                            <div class="ad-slot" aria-label="Advertisement">
                                               <!-- Temp Mail Center -->
													<ins class="adsbygoogle"
    													style="display:block"
     													data-ad-client="ca-pub-8426510303593933"
     													data-ad-slot="5208281991"
     													data-ad-format="auto"
     													data-full-width-responsive="true"></ins>
													<script>
     													(adsbygoogle = window.adsbygoogle || []).push({});
													</script>
                                            </div>

                                            <div class="mt-4 text-center">
                                                <p class="text-white mb-3"><strong>Get More Features</strong></p>
                                                <a href="{{ route('download.page') }}"
                                                    onclick="zxndnnndje('c872f424=account');"
                                                    class="btn btn-outline-primary btn-sm"
                                                    style="border-radius: 20px; padding: 8px 20px;">
                                                    <i class="bi bi-download" style="margin-right: 8px;"></i>
                                                    Download App for Better Experience
                                                </a>
                                                <p class="text-muted mt-2" style="font-size: 12px;">
                                                    Available for Android
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row justify-content-center g-2">
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="{{ route('autoliker.instagram') }}"
                                            class="w-100 btn instgram-btn bg-white">IG LIKER</a>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="{{ route('free-tiktok-views') }}"
                                            class="w-100 btn border tiktok-btn bg-white">Free TIKTOK Views</a>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="{{ route('download.page') }}"
                                            class="w-100 btn facebook-btn bg-white">Comment Liker</a>
                                    </div>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-12 col-xl-4 mt-4 mt-xl-0">
                    <div class="ad-slot ad-slot-side" aria-label="Advertisement">
                        <!-- Google side ad slot: paste adsbygoogle unit here -->
                    </div>
                    {{-- <x-native-ads></x-native-ads> --}}
                </aside>
            </div>
        </div>
    </header>

    <section class="bg-light" data-ad-ignore="true">
        <div class="container py-5">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <i class="bi bi-balloon-heart-fill infoicon"></i>
                    <h4>Active Users</h4>
                    <p>
                        Our Tool offers the ability to generate active likes with each submission, allowing users to potentially
                        receive up to many likes in a single day. Our Auto Liker is greatly adored by users. We have users from
                        various parts of the world, with a notable presence from the United States, United Kingdom, and India.
                    </p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-unlock-fill infoicon"></i>
                    <h4>NO SPAM</h4>
                    <p>
                        We hold an intense aversion towards Spam. Our fbsub has been thoroughly tested and proven to be
                        completely secure and reliable. We refrain from automatically posting using users' access tokens. We
                        refrain from selling Likes and bartering Tokens. You can trust us to keep you safe.
                    </p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-trophy-fill infoicon"></i>
                    <h4>Working Tools</h4>
                    <p>
                        Our website offers a range of tools that are guaranteed to work at 100% efficiency, providing instant
                        service for your chosen needs. If you encounter any difficulties while using our site, we recommend
                        watching our tutorial for assistance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12 mb-5">
                    <h2 class="text-muted">Boost Your Facebook Likes with fbsub</h2>
                    <div class="temp-emailbox-text my-2">
                        <p>When it comes to increasing the number of likes on your Facebook posts, fbsub stands out as the
                            top-notch website in the market. This tool enables you to get more reactions and comments on your
                            photos.</p>

                        <p>If you have a Facebook page, its success is determined by the number of likes it receives. Having a
                            substantial number of likes puts you in a favorable position, but if you are lacking, you may need
                            assistance to achieve your goals. fbsub can do it all for you.</p>

                        <p>The fbsub app offers convenience by streamlining your work, and the best part is that you can use our
                            services for free, with the assurance that they are safe and protected. Unlike many other apps on
                            the market, fbsub allows you to share content on various platforms, including groups, pages, and
                            your friends' timelines.</p>

                        <p>Posting your content everywhere can be a monumental task that consumes a significant amount of your
                            time, but fbsub can get it done within minutes. Don't miss out on the opportunity to have some fun
                            on Facebook using the incredible fbsub app.</p>

                        <p>We recommend using the app for a faster and more efficient experience, although you still have the
                            option of using the web page to accomplish these tasks. Take the leap and indulge in your
                            lifetime-best experience with fbsub.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            const form = document.getElementById('profileSearchForm');
            const submitBtn = document.getElementById('submitBtn');

            if (!form || !submitBtn) return;

            const spinner = submitBtn.querySelector('.spinner-border');
            const text = submitBtn.querySelector('.btn-text');
            const defaultText = text ? text.textContent : 'Search Profile';

            function setLoading(isLoading) {
                submitBtn.disabled = isLoading;
                if (spinner) spinner.classList.toggle('d-none', !isLoading);
                if (text) text.textContent = isLoading ? 'Searching...' : defaultText;
            }

            form.addEventListener('submit', function (event) {
                form.classList.add('was-validated');

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    setLoading(false);
                    return;
                }

                if (submitBtn.disabled) {
                    event.preventDefault();
                    return;
                }

                setLoading(true);
            });

            window.addEventListener('pageshow', function () {
                setLoading(false);
            });
        })();
    </script>
@stop
