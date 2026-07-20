@extends('layouts.master')

@section('title', __('messages.findmyfbid.meta_title'))
@section('description', __('messages.findmyfbid.meta_desc'))



@section('javascripts')
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
     crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@stop
@section('content')

    <main class="flex-shrink-0">
        <section class="bg-dark container">
            <div class="row">
                <div class="col"></div>
                <div class="col-sm-12 col-md-8 col-lg-8 mt-5">
                    <h1>{{ __('messages.findmyfbid.title') }}</h1>
                    <p class="lead">
                        {{ __('messages.findmyfbid.subTitle') }}
                        <br>
                        {!! __('messages.findmyfbid.input.name') !!}
                    </p>
                    <form method="POST" id="findmyfbid" action="{{ route('searchFBID') }}">
                        @csrf
                        <div class="form-group">
                            <input name="fburl" type="text" placeholder="https://www.facebook.com/YourProfileName"
                                class="input-lg form-control">

                        </div>
                        <div class="g-recaptcha" data-sitekey="6LdbfxIpAAAAAMOXiTKag0ZwQp1T0HSfj4hiLJ-E"></div>
                        <button type="submit" class="btn btn-primary mt-2">Find Facebook ID →</button>
                    </form>

                    <x-ads.leaderboard />
                    <x-ads.mobile-banner />

                    {{-- <a class="btn btn-danger mt-5" href="{{ route('instagram.findInstaId') }}">{!! getIcon('photo', 'text-white mb-1') !!}
                        FIND INSTAGRAM ID</a> --}}
                    <div class="text-center">
                        <div class="p-2 text-center">
                            @if (\Session::has('message'))
                                <span class="bg-danger rounded px-5 py-2 h1">{{ Session::get('message') }}</span>
                                <p class="position-relative bg-success rounded p-1 h6">FB Numberic ID</p>
                            @endif
                            @if (\Session::has('fail'))
                                                <div class="col-12 mt-3 text-center">

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
                        </div>
                    </div>
                    <section>

                        <!-- Find My ID -->
                        <x-ads.leaderboard></x-ads.leaderboard>
                        {!! toolbanner() !!}
                    </section>

                    <br>
                    <h2>{{ __('messages.findmyfbid.findIdIn2Steps') }}</h2>
                    <ul class="examples good">
                        {!! __('messages.findIdIn2Steps_list') !!}
                    </ul>
                    <p></p>
                    <h3>{{ __('messages.findmyfbid.whatIsFbProfile') }}</h3>
                    <p>
                        {{ __('messages.findmyfbid.whatIsFbProfile_p1') }}
                    </p>
                    <ul class="examples good">
                        <li><code>https://facebook.com/zuck</code></li>
                        <li><code>https://www.facebook.com/profile.php?id=100001533612613</code></li>
                        <li><code>https://m.facebook.com/ChrisHughes</code></li>
                    </ul>
                    <p></p>

                    <p>
                        {{ __('messages.findmyfbid.whatIsFbProfile_p2') }}
                    </p>
                    <ul class="invalid">
                        <li><code>Mark Zukerburg</code></li>
                        <li><code>mark@fb.com</code></li>
                    </ul>
                    <p>
                    </p>
                    <h2>{{ __('messages.findmyfbid.findFBPage') }}</h2>
                    <p class="text-light">{{ __('messages.findmyfbid.findFBPage_p1') }}</p>
                    <ul class="examples good">
                        <li><code>https://facebook.com/9gag</code></li>
                    </ul>

                    <p></p>
                    <div class="container">


                        <h3>FAQs </h3>
                        <ul class="examples good">
                            <li><code>{{ __('messages.findmyfbid.faq_q1') }}</code></li>
                            <p>{{ __('messages.findmyfbid.faq_q1_p1') }}
                            </p>
                            <p>
                                {{ __('messages.findmyfbid.faq_q1_p2') }}
                            </p>
                            <p>
                                {{ __('messages.findmyfbid.faq_q1_p3') }}
                            </p>
                            <li><code>{{ __('messages.findmyfbid.faq_q2') }}</code></li>
                            <p>{{ __('messages.findmyfbid.faq_q2_p1') }}</p>
                            <li><code>{{ __('messages.findmyfbid.faq_q3') }}</code></li>
                            <p>{{ __('messages.findmyfbid.faq_q3_p1') }}</p>
                            <code>Page URL: https://www.facebook.com/FacebookIndia/ </code>
                            <code>Group URL: https://www.facebook.com/groups/NationalGeographicPhotoofTheDay/</code>
                            <p>{{ __('messages.findmyfbid.faq_q3_p2') }}</p>

                            <p>{{ __('messages.findmyfbid.faq_q3_p3') }}</p>

                            <!-- Replace "your_facebook_username_or_id" with the actual username or ID -->
                            <a href="https://www.facebook.com/your_facebook_username_or_id" target="_blank">Visit Facebook
                                Profile</a>

                            <li><code>{{ __('messages.findmyfbid.faq_q4') }}</code></li>
                            <p>{{ __('messages.findmyfbid.faq_q4_p1') }}</p>
                        </ul>


                        <p class="small credits">
                            {{ __('messages.findmyfbid.conc') }}
                        </p>
                    </div>
                </div>
                <div class="col"></div>
            </div>

        </section>



    </main>
    <x-ads></x-ads>
@stop
