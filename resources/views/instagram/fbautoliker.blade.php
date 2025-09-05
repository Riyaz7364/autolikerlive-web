@extends('layouts.master')

@section('title', 'Facebook Auto Liker 1000 Likes | Autolikerlive.com')
@section('description',
    'Instantly boost your Facebook posts with up to 1000 real likes using Autolikerlive.com. Fast,
    safe, and free Facebook Auto Liker service. No login required!')

@section('javascripts')
    <style>
        body {
            font-family: 'Poppins', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
        }

        .bg-light p,
        h2 {
            color: black !important;
        }

        .emoji-size {
            width: 3rem;
        }
    </style>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>

    <x-mail-wrapper></x-mail-wrapper>
@stop

@section('content')
    <x-navbar></x-navbar>
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
    @endphp
    <header class="bg-dark py-5">
        <div class="container pxc-5">

            <h1 class="justify-content-center text-center ">Facebook Auto Liker 1000 Likes</h1>
            <h2 class="h6 text-center text-white justify-content-center text-muted">
                Instantly boost your Facebook posts with up to 1000 real likes. Fast, safe, and free Facebook Auto Liker
                service. No login required.</h2>
            <div class="mail-wrapper">


                <div class="mail-selection mb-3">
                    <div class="card text-center fw-bold">
                        <div class="card-header facebook-btn">
                            Login with Facebook Username/ID
                        </div>
                    </div>
                    <div class="border-dashes p-3 justify-content-center ">


                        <h5>Login Method</h5>
                        <p>
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
                                <div class="col-12">
                                    <input type="text" name="username" class="form-control" placeholder="Username Here"
                                        aria-label="Search your Facebook username" aria-describedby="basic-addon2">
                                </div>
                                <div class="cf-turnstile my-2" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>

                                <div class="col-12 text-center">
                                    <button class="btn btn-primary mb-2" id="submitBtn" type="submit">
                                        <span class="spinner-border spinner-border-sm text-light d-none"
                                            id="startsms_spinner" role="status" aria-hidden="true"></span>
                                        <span class="btn-text">Search Account</span></button>
                                </div>
                                <!-- Temp Mail Center adsbygoogle -->

                            </div>

                        </form>
                    </div>
                    <div class="row pt-4 px-5 text-center">
                        @foreach ($reactions as $key => $value)
                            <div class="col">
                                <img class="img-responsive emoji-size"
                                    src="https://www.autolikerlive.com/reaction/{{ $key }}.png">
                            </div>
                        @endforeach
                    </div>
                    <div class="temp-emailbox-text text-center my-2">
                        <p class="text-dark pt-2 text-white">I Understand and Agree with <a class="link"
                                href="{{ url('privacy') }}">Privacy Policy</a> and <a class="link"
                                href="{{ url('terms') }}">Terms of Uses</a></p>
                    </div>

                </div>


            </div>
        </div>
    </header>

    <section class="bg-light" data-ad-ignore="true">
        <div class="border rounded border-primary">
            {!! toolbanner('text-dark') !!}
        </div>

        <div class="container">

            <div class="text-center p-5">
                <h2 class="text-dark">{{ __('messages.freeService.howItsWork') }}</h2>
                <p><strong>Facebook Auto Liker 1000 Likes</strong> is a simple and efficient tool designed to help you
                    increase
                    engagement on your Facebook posts effortlessly. Unlike other tools, it does not require any tokens or
                    cookies, ensuring a safer and more secure experience.
                </p>
                <h2>How to Use Auto FB Liker?</h2>
                <p>Follow these easy steps to get started:</p>
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
                            Open Auto FB Liker</h6>
                        <p class="card-text">
                            Visit our platform from your preferred device. Get free Facebook Followers, Likes, and Views!
                            Visit www.autolikerlive.com
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
                            Log in Securely</h6>
                        <p class="card-text">Unlike other platforms that ask for sensitive data, our login process is 100%
                            safe. You can log in using a secure method without providing tokens, cookies, or personal
                            details. This ensures your Facebook account remains safe from bans or unauthorized access.</p>
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
                            Earn Credits (Easy & Free)</h6>
                        <p class="card-text">
                            Once logged in, you can earn credits by completing simple tasks like:
                        <ul>
                            <li>Liking other posts</li>
                            <li>Following users</li>
                            <li>Watching short videos</li>
                        </ul>
                        The more credits you earn, the more engagement you can get! No hidden charges, just a fair exchange
                        system.

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
                            04.</h1>
                        <h6 class="card-subtitle mb-2"
                            style="
              color: #000000;
              font-family: Roboto, Sans-serif;
              font-size: 18px;
              font-weight: 700;
              line-height: 20px;">
                            Get Free Likes, Followers & Views</h6>
                        <p class="card-text">
                            Use your earned credits to increase likes, followers, and views on your Facebook posts or
                            profile. Our system delivers engagement organically and instantly, ensuring real interactions
                            with no bots or fake accounts.
                        </p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">

                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary">
                            <h2 class="text-white">Auto Liker Facebook</h2>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                (No Token, No Cookies Required – 100% Safe and Secure) ! Are you searching for a trustworthy
                                Auto Liker for Facebook? Through our platform, you can enhance your Facebook engagement
                                without jeopardizing your account. In contrast to other tools, we do not ask for any tokens,
                                passwords, or cookies. We provide a safe and secure experience.
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">

                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary">
                            <h2 class="text-white">Free Facebook Likes</h2>
                        </div>
                        <div class="card-body">
                            <p class="card-text fs15">
                                Getting free Facebook Views is easy, specially from free Facebook Views. You get 100 free
                                Facebook Views every 5 mins through.
                                You have to visit our page
                                {{-- <a href="{{ route('free-Facebook-views') }}"> --}}
                                Free
                                Facebook Likes</a> and follow 4 simple steps to earn it.
                                Getting free Facebook likes on that page, You don't need any credit or token. It has a cool
                                down timer, So you have to wait for the cooldown the page to submit your link again.
                            </p>
                        </div>
                    </div>

                </div>
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


@endsection
