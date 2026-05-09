@extends('layouts.master')
@section('title', __('messages.igCommentLiker.meta_title'))
@section('description', __('messages.igCommentLiker.meta_desc'))
@section('keywords', 'Instagram comment liker, Increase Instagram comment likes, Best Instagram comment liker 2025, Auto comment liker for Instagram, Get more Instagram comment likes, How to increase Instagram comment likes fast, Best tools to get Instagram comment likes in 2025, Instagram auto comment liker without login, Free Instagram comment liker tool, How to boost Instagram engagement with comment likes, Instagram engagement booster, Social media auto liker 2025, How to get organic Instagram comment likes, Instagram growth hacks 2025, Boost Instagram comments and likes')

@section('javascripts')
    <x-mail-wrapper></x-mail-wrapper>

    <style>
        .instgram-btn {
            background: linear-gradient(to right, #f9ce34, #ee2a7b, #6228d7);
            font-size: 15px;
            color: white;
            font-weight: bold;
            letter-spacing: 1px
        }
        .wordpress > p,
        .wordpress > h1,
        .wordpress > h2,
        .wordpress > h3,
        .wordpress > li {
            color: black !important; /* Change to your desired color */
        }
    </style>

@endsection

@section('content')

    <x-navbar></x-navbar>
    <!-- Header-->

        <div class="container">
            <div class="mail-wrapper">
                <div class="ad ad-250xNull">
                    <!-- Temp Mail Left -->

                </div>

                <div class="mail-selection mb-3">
                    <div class="row">
                        <div class="col-sm-12 col-md-2 d-block d-sm-none text-center mb-2   ">
                            <img class="rounded-circle"
                                src="https://www.autolikerlive.com/blog/wp-content/uploads/2025/03/DALL·E-2025-03-24-14.03.15-A-2D-flat-round-logo-with-the-text-Instagram-Comment-Liker-FB-Autoliker.-The-design-should-be-simple-without-any-background.-Use-modern-bold-an-e1742808016348.webp"
                                alt="Instagram Comment Liker Logo">
                        </div>
                        <div class="col-sm-12 col-md-10">
                            <h1>{{ __('messages.igCommentLiker.title') }}</h1>
                            <h2 class="h5 text-white text-muted">
                                {{ __('messages.igCommentLiker.subtitle') }}</h2>
                        </div>
                        <div class="col-sm-12 col-md-2 d-none d-xl-block">
                            <img class="rounded-circle"
                                src="https://www.autolikerlive.com/blog/wp-content/uploads/2025/03/DALL·E-2025-03-24-14.03.15-A-2D-flat-round-logo-with-the-text-Instagram-Comment-Liker-FB-Autoliker.-The-design-should-be-simple-without-any-background.-Use-modern-bold-an-e1742808016348.webp"
                                alt="Instagram Comment Liker Logo">
                        </div>
                        <div class="col-sm-8 my-5">
                            <a href="{{ url('download') }}" class="w-100 btn  mt-2 m-2 instgram-btn">Dwonload Comment Liker APK</a>
                        </div>

                        <div class="col-12 mt-2">
                            <p>{{ __('messages.igCommentLiker.p1') }}</p>
                            <p>This Instagram automation will help you to:</p>
                            <ul>
                                {!! __('messages.igCommentLiker.list') !!}
                            </ul>

                            <p>{{ __('messages.igCommentLiker.p2') }} </p>
                        </div>
                    </div>
                    <div class="ad ad-250xNull">
                        <!-- Temp Mail Right -->

                    </div>
                </div>
            </div>


        </div>

        <section class="bg-white">
            <div class="mail-wrapper">
                <div class="ad ad-250xNull">
                    <!-- Temp Mail Left -->

                </div>

                <div class="mail-selection mb-3">
                    <div class="row">
                        <h2 class="card-title mb-3 text-dark">{{ isset($posts->title) ? $posts->title : '' }}</h2>
                        <div class="col-12 mb-5 wordpress">{!! isset($posts->content) ? $posts->content : '' !!}</div>
                    </div>
                    <div class="ad ad-250xNull">
                        <!-- Temp Mail Right -->

                    </div>
                </div>
            </div>


        </section>




@endsection
