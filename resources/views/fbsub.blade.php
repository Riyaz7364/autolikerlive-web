@extends('layouts.master')

@section('title', 'FBsub - TikTok Auto liker and Auto Views')
@section('description',
    'Boost Tiktok engagement with our freer FBsub auto liker & views tool. Get likes,
    followers, views, shares, and comments hassle-free, no login required')

@section('javascripts')
    <x-mail-wrapper></x-mail-wrapper>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>


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
        p {
            color: black
        }

        .infoicon {
            color: #00b3fe;
            font-size: 60px;
            padding: 15px;
        }

        .emoji-size {
            width: 3rem;
        }
    </style>
@endpush

@section('content')
    <x-navbar></x-navbar>


    <header class="bg-dark py-5">
        <div class="container pxc-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col"></div>
                <div class="col-md-10 col-lg-6 col-sm-12 pxc-5">
                    <h1 class="h5 text-center">FBsub - Get Auto followers and Auto Reactions</h1>
                    <div class="border-dashes p-3 justify-content-center">
                        <h5 class="text-center text-white justify-content-center p-3">Autoliker<strong
                                class="text-danger">Live</strong> Services
                        </h5>

                        <div class="mail-wrapper">


                            <div class="mail-selection mb-3">
                                <div class="card text-center fw-bold">
                                    <div class="card-header facebook-btn">
                                        Login with Facebook Username/ID
                                    </div>
                                </div>
                                <div class="border-dashes p-3 justify-content-center ">


                                    <h5>Login Method</h5>
                                    <p class="text-white">
                                        {!! getIcon('bi-heart-pulse-fill', 'text-success') !!} Reactions &nbsp;
                                        {!! getIcon('bi-play-fill', 'text-success') !!} Views &nbsp;
                                        {!! getIcon('facebook', 'text-success') !!} Followers
                                    </p>
                                    <form method="post" action="{{ route('login.facebook') }}" id="form">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <li>{{ $errors->first() }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="row">

                                            <div class="card border-dark mb-3 text-center">
                                                <div class="card-header h4 p-0 text-primary">Facebook <span
                                                        class="text-dark">
                                                        Many Services</span>
                                                </div>
                                                <div class="card-body text-dark p-1 text-dark">Earn free credits.</div>
                                                <div class="card-footer bg-transparent border-success py-1"><a
                                                        href="{{ route('download.page') }}"
                                                        onclick="zxndnnndje('c872f424=account');"
                                                        class="btn btn-primary btn-lg btn-block">{!! getIcon('android2', '') !!}
                                                        Download</a></div>
                                            </div>

                                            <!-- Temp Mail Center adsbygoogle -->

                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="row">

                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="{{ route('autoliker.instagram') }}"
                                            class="w-100 btn  mt-2 m-2 instgram-btn">IG LIKER</a>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="{{ route('free-tiktok-views') }}"
                                            class="w-100 btn border  mt-2 m-2 tiktok-btn">Free TIKTOK Views</a>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="{{ route('download.page') }}"
                                            class="w-100 btn mt-2 m-2 facebook-btn">FBSUB</a>

                                    </div>
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="#" class="w-100 btn mt-2 m-2 moj-btn">MOJ Follow<br>(Coming Soon)</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- temp-mail-buttom -->


                </div>
                <div class="col d-none d-xl-block text-center">

                    <!-- Temp-mail-Side -->
                    {{-- <x-native-ads></x-native-ads> --}}
                </div>
            </div>


        </div>


    </header>
    <section class="bg-light" data-ad-ignore="true">
        <div class="row text-center p-5">
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
    </section>
    <section class="bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 col-lg-8 col-sm-12 mb-5"></div>
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
                <div class="col-md-3 col-lg-4 col-sm-2"></div>
            </div>
        </div>

    </section>

    <script>
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
    </script>
@stop
