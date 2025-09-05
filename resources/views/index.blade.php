@extends('layouts.master')
@php
    $title = 'Autoliker Live';
    $title2 = 'FB Autoliker';
    if (isset($keyword)) {
        $title = str_replace('-', ' ', $keyword);
    }
    $title3 = isset($keyword) ? $title2 : 'Facebook Auto Follow';
@endphp

@section('title', __('messages.index.meta_title', ['title' => Str::ucfirst($title)]))
@section('description',
    __('messages.index.meta_desc', [
    'title' =>
    'Participate in our community exchange program to build
    genuine engagement ' . $title,
    ]))

@section('javascripts')

    <style>
        .section {
            padding: 50px 0;
            position: relative;
        }

        .gray-bg {
            background-color: #ebf4fa;
        }

        /* Blog
                                                                                                                                                                                                                                                                                                                                                                                                                ---------------------*/
        .blog-grid {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .blog-grid .blog-img {
            position: relative;
            border-radius: 5px;
            overflow: hidden;
        }

        .blog-grid .blog-img .date {
            position: absolute;
            background: #3a3973;
            color: #ffffff;
            padding: 8px 15px;
            left: 0;
            top: 10px;
            font-size: 14px;
        }

        .blog-grid .blog-info {
            box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
            border-radius: 5px;
            background: #ffffff;
            padding: 20px;
            margin: -30px 20px 0;
            position: relative;
        }

        .blog-grid .blog-info h5 {
            font-size: 22px;
            font-weight: 500;
            margin: 0 0 10px;
        }

        .blog-grid .blog-info h5 a {
            color: #3a3973;
        }

        .blog-grid .blog-info p {
            margin: 0;
        }

        .blog-grid .blog-info .btn-bar {
            margin-top: 20px;
        }

        .px-btn-arrow {
            padding: 0 50px 0 0;
            line-height: 20px;
            position: relative;
            display: inline-block;
            color: #fe4f6c;
            -moz-transition: ease all 0.3s;
            -o-transition: ease all 0.3s;
            -webkit-transition: ease all 0.3s;
            transition: ease all 0.3s;
        }


        .px-btn-arrow .arrow {
            width: 13px;
            height: 2px;
            background: currentColor;
            display: inline-block;
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            right: 25px;
            -moz-transition: ease right 0.3s;
            -o-transition: ease right 0.3s;
            -webkit-transition: ease right 0.3s;
            transition: ease right 0.3s;
        }

        .px-btn-arrow .arrow:after {
            width: 8px;
            height: 8px;
            border-right: 2px solid currentColor;
            border-top: 2px solid currentColor;
            content: "";
            position: absolute;
            top: -3px;
            right: 0;
            display: inline-block;
            -moz-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .fading-hr {
            width: 80%;
            /* Adjust the width of the HR line */
            height: 2px;
            /* Adjust the thickness of the HR line */
            background: linear-gradient(to right, transparent, white, transparent);
            border: none;
        }

        @media only screen and (min-width: 600px) {
            .wp-image-125 {
                width: revert-layer !important;
                height: revert !important;
            }

            .wp-block-media-text__media {
                text-align: center !important;
            }
        }

        .wp-image-125 {
            width: -webkit-fill-available;
            height: auto;
        }

        #blog a {
            color: #ebf4fa;
        }

        #blog-posts a {
            color: #3a3973;
            text-decoration: none;
        }
    </style>

@section('footer')

@endsection


@section('content')

    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-navbar></x-navbar>
        <!-- Header-->
        <header class="bg-dark py-5" id="no-ads-here">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">
                                {{ isset($keyword) == true ? ucfirst($title) : 'Autoliker Live' }}</h1>
                            <h2 class="text-white-50 h4">
                                Social Media Engagement Tools for Better Reach</h2>
                            <p class="text-white-50 lead mt-3">Enhance your social presence through our community-based
                                approach to engagement</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3 download" href="{{ route('download.page') }}">
                                    Download App</a>
                                {{-- <a class="btn btn-outline-light btn-lg px-4" href="{{ route('login') }}">Login</a> --}}
                            </div>

                        </div>

                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img height="400px" width="600px"
                            class="img-fluid rounded-3 my-5" src="/images/graphic.webp" alt="autoliker Live graphics" />
                    </div>
                </div>
            </div>
        </header>
        <hr class="hr fading-hr" />
        <!-- Features section-->
        <section class="py-5" id="features no-ads-here">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder display-6">Why Choose Autoliker Live?</h2>
                    <p class="lead text-muted">Discover the features that make us the trusted choice for social media
                        engagement</p>
                </div>
                <div class="col-lg-12">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                {!! getIcon('collection', 'feature p-2') !!}
                            </div>
                            <h2 class="h5">Social Media Enhancement Tools</h2>
                            <p class="mb-0">{{ __('messages.index.ServicesProvided_p1', ['title' => $title]) }}</p>
                            <p>Our tools help you increase engagement on your social media content through community
                                interaction. Connect with other users who share similar interests and goals for mutual
                                growth on major platforms.</p>
                        </div>
                        <div class="col mb-5 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                {!! getIcon('shield-check', 'feature p-2') !!}
                            </div>
                            <h2 class="h5">100% Safe & Secure</h2>
                            <p class="mb-0">Your account safety is our top priority. We never ask for passwords or
                                sensitive information.</p>
                            <p>Our privacy-focused approach ensures that your accounts remain completely protected while
                                you build engagement. All interactions are designed to comply with platform policies for
                                sustainable growth.</p>

                        </div>
                        <div class="col mb-5 mb-md-0 h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                {!! getIcon('bandaid', 'feature p-2') !!}
                            </div>
                            <h2 class="h5">Advanced Anti-Spam Protection</h2>
                            <p class="mb-0">{{ __('messages.index.anti-spam_p1') }}</p>
                            <p>Our system helps maintain healthy engagement patterns that appear natural and organic. This
                                approach helps you build a genuine presence while following best practices for social media
                                growth.</p>

                        </div>
                        <div class="col h-100">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                {!! getIcon('person-workspace', 'feature p-2') !!}
                            </div>
                            <h2 class="h5">24/7 Expert Support</h2>
                            <p class="mb-0">{{ __('messages.index.support_p1') }}</p>
                            <p>Our dedicated support team is available around the clock to help you achieve your social
                                media goals. Get personalized advice and instant assistance whenever you need it.</p>
                        </div>
                    </div>

                    <!-- Services Grid - Creative Listing Design -->
                    <div class="mt-4">
                        <h3 class="fw-bold text-center mb-4">Our Popular Services</h3>

                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            @foreach ($listings as $listing)
                                <div class="position-relative service-card">
                                    <a class="btn btn-primary px-3 py-2 position-relative"
                                        style="font-size: 0.85rem; white-space: nowrap;"
                                        href='{{ url($listing->link ?? url(strtolower(str_replace(' ', '-', $listing->name)))) }}'>
                                        {{ $listing->name }}
                                        <div class="service-tag">NEW</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <style>
                        .service-card {
                            transition: transform 0.3s ease;
                            overflow: hidden;
                        }

                        .service-card:hover {
                            transform: translateY(-3px);
                        }

                        .service-tag {
                            position: absolute;
                            top: -8px;
                            right: -8px;
                            background-color: #ff6b6b;
                            color: white;
                            font-size: 0.6rem;
                            padding: 2px 6px;
                            border-radius: 4px;
                            font-weight: bold;
                            z-index: 1;
                        }
                    </style>

                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder display-6">How It Works</h2>
                    <p class="lead text-muted">Simple steps to grow your social media presence</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <span class="h3 fw-bold mb-0 text-light">1</span>
                            </div>
                            <h3 class="h5 fw-bold">Download App</h3>
                            <p class="text-muted">Download our free app and create your account in seconds</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <span class="h3 fw-bold mb-0 text-light">2</span>
                            </div>
                            <h3 class="h5 fw-bold">Earn Credits</h3>
                            <p class="text-muted">Complete simple tasks like liking posts and following accounts to earn
                                credits</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <span class="h3 fw-bold mb-0 text-light">3</span>
                            </div>
                            <h3 class="h5 fw-bold">Exchange Engagement</h3>
                            <p class="text-muted">Receive authentic engagement from real users in our community network</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="text-center">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <span class="h3 fw-bold mb-0 text-light">4</span>
                            </div>
                            <h3 class="h5 fw-bold">Grow Organically</h3>
                            <p class="text-muted">Build your online presence steadily with sustainable engagement strategies
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder display-6">Growing Community</h2>
                    <p class="lead text-muted">Join thousands of users enhancing their social media engagement</p>
                </div>
                <div class="row g-4 text-center">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body p-4">
                                <div class="text-primary mb-2">
                                    {!! getIcon('users', 'fa-3x') !!}
                                </div>
                                <h3 class="h2 fw-bold text-primary">Growing</h3>
                                <p class="text-muted mb-0">User Community</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body p-4">
                                <div class="text-primary mb-2">
                                    {!! getIcon('heart', 'fa-3x') !!}
                                </div>
                                <h3 class="h2 fw-bold text-primary">Quality</h3>
                                <p class="text-muted mb-0">Engagement</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body p-4">
                                <div class="text-primary mb-2">
                                    {!! getIcon('eye', 'fa-3x') !!}
                                </div>
                                <h3 class="h2 fw-bold text-primary">Increased</h3>
                                <p class="text-muted mb-0">Visibility</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body p-4">
                                <div class="text-primary mb-2">
                                    {!! getIcon('user-plus', 'fa-3x') !!}
                                </div>
                                <h3 class="h2 fw-bold text-primary">Steady</h3>
                                <p class="text-muted mb-0">Growth</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial section-->
        <div class="py-5 bg-light" id="no-ads-here">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-lg-10 col-xl-7">
                        <div class="text-center">
                            <label
                                class="p-2">{{ __('messages.index.howToUse', ['title' => $title ? $title : 'Autoliker Live']) }}
                            </label>
                            <div class="video-container">

                                <iframe width="100%" height="250"
                                    srcdoc="
                                            <style>
                                                body, .full {
                                                    width: 100%;
                                                    height: 100%;
                                                    margin: 0;
                                                    position: absolute;
                                                    display: flex;
                                                    justify-content: center;
                                                    object-fit: cover;
                                                }
                                            </style>
                                            <a
                                                href='https://www.youtube.com/embed/WqePsGC0xx4?autoplay=0'
                                                class='full'
                                            >
                                                <img
                                                    src='https://www.autolikerlive.com/images/thumbnail.webp'
                                                    class='full' alt='video thumbnail'
                                                />
                                                <svg
                                                    version='1.1'
                                                    viewBox='0 0 68 48'
                                                    width='68px'
                                                    style='position: relative;'
                                                >
                                                    <path d='M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z' fill='#f00'></path>
                                                    <path d='M 45,24 27,14 27,34' fill='#fff'></path>
                                                </svg>
                                            </a>
                                        "
                                    title="YouTube video player" frameborder="0" loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="fs-4 mb-4 fst-italic p-2">{{ __('messages.index.faceing_problem') }}</div>
                            <div class="fs-4 mb-4 fst-italic p-2">{!! __('messages.index.faceing_problem_info') !!}</div>
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="rounded-circle me-3" src="{{ asset('images/favicons/favicon-32x32.webp') }}"
                                    alt="favicon" width="32px" height="32px" />
                                <div class="fw-bold">
                                    Admin theRiyazSaifi
                                    <span class="fw-bold text-primary mx-1">/</span>
                                    by tRS APPS
                                </div>
                            </div>
                            <div class="row">
                                <h2>What Information Do You Need to Provide to Use a Facebook Auto Liker?</h2>
                                <p>To effectively utilize a Facebook Auto Liker, you'll need to provide specific
                                    information. Here’s a breakdown of what’s typically required:</p>
                                <ol>
                                    <li></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @if (isset($posts) && is_array($posts))
            <section class="section gray-bg" id="blog-posts">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7 text-center">
                            <div class="section-title">
                                <h2 class="text-dark">From our blog</h2>
                                <p class="text-dark">Check our official blog for Tricks & Tips. We update Android,
                                    Desktop
                                    tricks & tips to
                                    make
                                    your internet experience enjoyable.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-lg-4">
                                <div class="blog-grid">
                                    <div class="blog-img">
                                        <div class="date">{{ $post->date }}</div>
                                        <a href="{{ url('') }}/blog/{{ $post->slug }}">
                                            <img loading="lazy" class="rounded mx-auto d-block"
                                                src="{{ $post->image }}" alt="{{ $post->cat_name }}">
                                        </a>
                                    </div>
                                    <div class="blog-info">
                                        <h5><a
                                                href="{{ url('') }}/blog/{{ $post->slug }}">{{ $post->title }}</a>
                                        </h5>
                                        <p class="text-dark">{{ substr_replace($post->content, '...', 200) }}</p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!-- Blog preview section-->
        <section class="py-5" id="blog">
            <div class="container my-5">
                <div class="row gx-5">
                    <div class="col-lg-12 mb-5">
                        <div class="card h-100 shadow border-0">
                            <div class="card-body p-4 bg-dark">
                                @php
                                    if (is_array($posts)) {
                                        $posts = $default_post;
                                    }
                                @endphp

                                <h2 class="card-title mb-3 text-white">{{ $posts->title }}</h2>

                                <!-- AdSense-Compliant Content -->
                                <div class="mb-5 text-white-75">
                                    {!! $posts->content !!}

                                    <div class="mt-4 p-3 bg-dark border border-light rounded">
                                        <h4 class="text-primary">Safe and Reliable Social Media Growth</h4>
                                        <p>AutolikerLive is committed to providing high-quality social media engagement
                                            tools that comply with platform policies. Our services help you grow your social
                                            presence through legitimate means, avoiding any practices that could harm your
                                            accounts or violate terms of service.</p>

                                        <h4 class="text-primary mt-4">How Our Tools Work</h4>
                                        <p>Our auto-liker and engagement tools connect real users who want to grow together.
                                            By participating in our network, you both give and receive authentic engagement
                                            from real people with real accounts. This creates sustainable growth that's
                                            recognized positively by social media algorithms.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="nextSection" class="d-none">
                        <a class="btn btn-danger" id="countdownButton2"><span id="button2value">Continue to
                                Download</span></a>
                    </div>
                </div>
                <!-- Call to action-->
                <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                    <div
                        class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                        <div class="mb-4 mb-xl-0">
                            <div class="fs-3 fw-bold text-white">New products, delivered to you.</div>
                            <div class="text-white-50">Keep connected with our apps.</div>
                        </div>
                        <div class="ms-xl-4">
                            <div class="input-group mb-2">
                                <a href="https://www.facebook.com/autolikerLIVE" aria-label="AutolikerLive Facebook Page">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2">
                                        {!! getIcon('facebook', 'feature p-2') !!}


                                    </div>
                                </a>
                                <a href="https://twitter.com/theRiyazSaifi" aria-label="AutolikerLive X Profile">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2">
                                        {!! getIcon('twitter-x', 'feature p-2') !!}
                                    </div>
                                </a>

                                <a href="https://www.instagram.com/theriyazsaifi1/"
                                    aria-label="AutolikerLive Instagram Profile">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2">
                                        {!! getIcon('instagram', 'feature p-2') !!}
                                    </div>
                                </a>

                                <a href="https://t.me/+1NDLe3FAY3dlN2M1" aria-label="AutolikerLive Telegram Channel">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2">
                                        {!! getIcon('telegram', 'feature p-2') !!}
                                    </div>
                                </a>

                            </div>
                            <div class="small text-white-50">We care about privacy, and will never share your data.
                            </div>
                        </div>
                    </div>
                </aside>
                <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                    <div
                        class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">

                        <div class="ms-xl-4">
                            <p>
                                @foreach ($tags as $tag)
                                    @if ($tag->link != null)
                                        <a class="btn btn-sm btn-danger text-capitalize m-1"
                                            href="{{ url($tag->link ?? url(strtolower(str_replace(' ', '-', $tag->name)))) }}">
                                            {{ $tag->name }}
                                        </a>
                                    @endif
                                @endforeach
                            </p>

                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </main>
@stop
