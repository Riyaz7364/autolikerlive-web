@extends('layouts.master-test')

@section('title', 'DJ Liker | Best Facebook Auto Liker App | Auto Reactions | Auto Like FB | Auto Followers')
@section('description', 'DJ Liker is the best facebook auto liker app. Get Free Auto Likes, Auto Reactions, Auto
    Followers Instantly in one click. We are Only working Auto Like App in Market and Provide Unlimited Services Free of
    Cost')
@section('keywords', 'auto liker, auto like, auto liker app, auto liker apk, auto reactions, facebook auto liker')
@section('body-class', 'bg-light')

@section('javascripts')
    <link href="{{ asset('assets/pages/djstyle.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet">


    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        {
        color: black;
        font-family: 'Raleway', sans-serif;
        font-weight: 700;
        }

        h3 {
            color: black !important;
        }

        p,
        span {
            color: black;
            font-family: 'Lato', sans-serif;
            font-weight: 400;
        }

        .btn {
            display: inline-block;
            vertical-align: middle;
            -webkit-transform: perspective(1px) translateZ(0);
            transform: perspective(1px) translateZ(0);
            box-shadow: 0 0 1px rgba(0, 0, 0, 0);
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
            -webkit-transition-property: transform;
            transition-property: transform;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }

        .btn:hover,
        .btn:focus,
        .btn:active {
            -webkit-transform: translateY(-8px);
            transform: translateY(-8px);
        }

        .navbar {
            padding-left: 0;
            padding-right: 0;
            padding-top: 10px !important;
        }

        .rem5 {
            width: 5rem;
        }

        .rem15 {
            width: 14rem;
        }
    </style>
    {{-- Bootstrap CSS removed for Tailwind migration --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

@endsection

@section('javascripts-bottom')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/jquery.magnific-popup.js"
        integrity="sha512-tOyzsVuGuz0il5EcXFi/qA5DI4BNLna4gHbWn+HbQBP0jmRhyqMKup24fzyKnxSX0jBxt2+qStqwwHDIh5TaGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/pages/aos.js') }}"></script>
    <script src="{{ asset('assets/pages/djscript.js') }}"></script>
    <script>
        function ShowLoading(e) {
            $("#preloader").show();
        }
    </script>
@stop

@section('content')
    <div class="page_wrapper">
        <div id="preloader">
            <div id="loader"></div>
        </div>
        <section class="banner_section">
            <div class="container">
                <div class="anim_line">
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12" data-aos="fade-right" data-aos-duration="1500">
                        <div class="banner_text">
                            <h1><span>DJ Liker!</span></h1>
                            <h3>Best Facebook Auto Liker App.</h3>
                            <p>Download our FB Auto Likes App and Start Exchanging Free Auto Likes, Auto Reactions, Auto
                                Followers and Much More...</p>
                        </div>
                        <ul class="app_btn">
                            <li>
                                <a href="{{ route('download.page') }}">
                                    <img class="blue_img" src="https://i.postimg.cc/V06GCB3X/googleplay-blue.png"
                                        alt="Download From Play Store">
                                    <img class="white_img" src="https://i.postimg.cc/9zFNKCrz/googleplay-white.png"
                                        alt="Download From Play Store">
                                </a>
                            </li>
                    </div>
                    <div class="col-lg-6 col-md-12" data-aos="fade-in" data-aos-duration="1500">
                        <img height="400px" width="600px" class="img-fluid rounded-3 my-5" src="/images/graphic.webp"
                            alt="autoliker Live graphics">
                    </div>
                </div>
            </div>
        </section>
        <section class="features_section" id="features">
            <div class="container">
                <div class="text-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <h2><span>Features</span> that make this app different!</h2>
                </div>

                <div class="row align-items-center">
                    <!-- Left Features -->
                    <div class="col-lg-4 col-md-6">
                        <div class="feature_box">
                            <div class="data_block d-flex align-items-center" data-aos="fade-right"
                                data-aos-duration="1500">
                                <div class="icon me-3">
                                    <img class="rem5" src="https://i.postimg.cc/bdCFjWtg/secure-data.png"
                                        alt="Secure Data">
                                </div>
                                <div class="text">
                                    <h4>Secure Data</h4>
                                    <p>Your information is safe, encrypted, and never shared.</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature_box">
                            <div class="data_block d-flex align-items-center" data-aos="fade-right"
                                data-aos-duration="1500">
                                <div class="icon me-3">
                                    <img class="rem5" src="https://i.postimg.cc/crP9v3T8/functional.png" alt="Automated">
                                </div>
                                <div class="text">
                                    <h4>Everything is Automated</h4>
                                    <p>Our app automates tasks using Facebook Graph API.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Center Image -->
                    <div class="col-lg-4 d-flex justify-content-center my-4" data-aos="fade-up" data-aos-duration="1500">
                        <img src="{{ asset('images/screen.png') }}" class="feature_img rem15" alt="Feature Image">
                    </div>

                    <!-- Right Features -->
                    <div class="col-lg-4 col-md-6">
                        <div class="feature_box">
                            <div class="data_block d-flex align-items-center" data-aos="fade-left" data-aos-duration="1500">
                                <div class="icon me-3">
                                    <img class="rem5" src="https://i.postimg.cc/PCZ6YqFV/live-chat.png"
                                        alt="Active Users">
                                </div>
                                <div class="text">
                                    <h4>Active Users</h4>
                                    <p>Instant likes, reactions, and more from engaged users.</p>
                                </div>
                            </div>
                        </div>
                        <div class="feature_box">
                            <div class="data_block d-flex align-items-center" data-aos="fade-left" data-aos-duration="1500">
                                <div class="icon me-3">
                                    <img class="rem5" src="https://i.postimg.cc/7CkKVyFH/support.png" alt="Support">
                                </div>
                                <div class="text">
                                    <h4>24/7 Support</h4>
                                    <p>Need help? Contact us anytime for support.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row_am about_app_section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about_img" data-aos="fade-in" data-aos-duration="1500">
                            <div class="frame_img">
                                <img class="moving_position_animatin" src="{{ asset('images/screen.png') }}"
                                    alt="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about_text">
                            <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                                <h2>Some awesome words about <span>DJ Liker App.</span></h2>
                            </div>
                            <ul class="app_statstic" id="counter" data-aos="fade-in" data-aos-duration="1500">
                                <li>
                                    <div class="icon">
                                        <img class="rem5" src="https://i.postimg.cc/TyJCN4xr/download.png"
                                            alt="image">
                                    </div>
                                    <div class="text">
                                        <p><span class="counter-value" data-count="100">0</span><span>K+</span></p>
                                        <p>Download</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <img class="rem5" src="https://i.postimg.cc/9RX16YXs/followers.png"
                                            alt="image">
                                    </div>
                                    <div class="text">
                                        <p><span class="counter-value" data-count="08">0 </span><span>M+</span></p>
                                        <p>Followers Delivered</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <img class="rem5" src="https://i.postimg.cc/R6PG4JNh/reviews.png"
                                            alt="image">
                                    </div>
                                    <div class="text">
                                        <p><span class="counter-value" data-count="12">1</span><span>M+</span></p>
                                        <p>Likes Delivered</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <img class="rem5" src="https://i.postimg.cc/gLnsJcZD/countries.png"
                                            alt="image">
                                    </div>
                                    <div class="text">
                                        <p><span class="counter-value" data-count="90">0</span><span>K+</span></p>
                                        <p>Active Users</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row_am how_it_works" id="how_it_work">
            <div class="container">
                <div class="how_it_inner">
                    <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                        <h2><span>How it works</span> - 3 easy steps</h2>
                        <p>Simply Install The App, Login with Facebook and You Are Done.</p>
                    </div>
                    <div class="step_block">
                        <ul>
                            <li>
                                <div class="step_text" data-aos="fade-right" data-aos-duration="1500">
                                    <h4>Download app</h4>
                                    <div class="app_icon">
                                        <a href="{{ route('download.page') }}"><i
                                                class="icofont-brand-android-robot"></i></a>
                                        <!--<a href="https://github.com/djlikernet/djliker/releases/download/v1.1/djliker_installer.apk"><i class="icofont-file-zip"></i></a>-->
                                    </div>
                                    <p>Download App from Playstore, or Directly download and Install APK File</p>
                                </div>
                                <div class="step_number">
                                    <h3>01</h3>
                                </div>
                                <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                                    <img src="https://www.autolikerlive.com/blog/wp-content/uploads/2025/03/download_app.jpg"
                                        alt="image">
                                </div>
                            </li>
                            <li>
                                <div class="step_text" data-aos="fade-left" data-aos-duration="1500">
                                    <h4>Login</h4>
                                    <p>Simply click Login with Facebook button, Allow the App to Access your Account and
                                        Done.</p>
                                </div>
                                <div class="step_number">
                                    <h3>02</h3>
                                </div>
                                <div class="step_img" data-aos="fade-right" data-aos-duration="1500">
                                    <img src="https://www.autolikerlive.com/blog/wp-content/uploads/2025/03/create_account.jpg"
                                        alt="image">
                                </div>
                            </li>
                            <li>
                                <div class="step_text" data-aos="fade-right" data-aos-duration="1500">
                                    <h4>Enjoy the app</h4>
                                    <p>Now start Gaining free Auto Likes, Auto Reactions, Auto Followers and much more!!!
                                    </p>
                                </div>
                                <div class="step_number">
                                    <h3>03</h3>
                                </div>
                                <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                                    <img src="https://www.autolikerlive.com/blog/wp-content/uploads/2025/03/enjoy_app.jpg"
                                        alt="image">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="row_am faq_section">
            <div class="container">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                    <h2><span>FAQ</span> - Frequently Asked Questions</h2>
                </div>
                <div class="faq_panel">
                    <div class="accordion" id="accordionExample">
                        <div class="card" data-aos="fade-up" data-aos-duration="1500">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link active" data-toggle="collapse"
                                        data-target="#collapseOne">
                                        <i class="icon_faq icofont-plus"></i></i> How to Download?</button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p>You can download our Auto Liker App straight from the Play Store and Mirror links.
                                        Our app is only available for Android devices only.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-duration="1500">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseTwo"><i class="icon_faq icofont-plus"></i></i> How to Login
                                        ?</button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p>You may log in using your Facebook Account by allowing all permissions. After login
                                        is complete, you will redirected to our Tool Page where you can use any tool you
                                        prefer.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-duration="1500">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseThree"><i class="icon_faq icofont-plus"></i></i>Can I Trust
                                        DJ Auto Liker App?</button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p>Yes, definitely!!! You can rely on our app more than your girlfriend, LOL! Our
                                        exchange system operates automat through the Facebook Graph API! and your access
                                        token will kept in an encrypted format. We do not access your account or share your
                                        information with any third-party websites or apps.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-duration="1500">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                        data-target="#collapseFour"><i class="icon_faq icofont-plus"></i></i>Will My FB
                                        Account get Blocked or Suspended?</button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p>This doesn't occur usually. In some cases, Facebook may ask for verification of your
                                        account and may ask you to change the password.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--<section class="newsletter_section">
                <div class="container">
                   <div class="newsletter_box">
                      <div class="section_title" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
                         <h2>Subscribe newsletter</h2>
                         <p>Be the first to recieve all latest post in your inbox</p>
                      </div>
                      <form action="" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
                         <div class="form-group">
                            <input type="email" class="form-control" placeholder="Enter your email">
                         </div>
                         <div class="form-group">
                            <button class="btn">SUBMIT</button>
                         </div>
                      </form>
                   </div>
                </div>
             </section>-->
        <footer>
            <div class="top_footer" id="contact">
                <div class="anim_line dark_bg">
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/pages/anim_line.png') }}" alt="anim_line"></span>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="abt_side">
                                <div class="logo"> <img src="https://www.autolikerlive.com/images/icon.webp"
                                        alt="image"></div>
                                <ul>
                                    <li><a href="#"><span class="__cf_email__"
                                                data-cfemail="760503060619040236121c1a1f1d130458181302">[email&#160;protected]</span></a>
                                    </li>
                                    <li><a href="#">+91-000000000</a></li>
                                </ul>
                                <ul class="social_media">
                                    <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="#"><i class="icofont-twitter"></i></a></li>
                                    <li><a href="#"><i class="icofont-instagram"></i></a></li>
                                    <li><a href="#"><i class="icofont-pinterest"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="links">
                                <h3>Useful Links</h3>
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/about.html">About us</a></li>
                                    <li><a href="/privacy.html">Privacy Policy</a></li>
                                    <li><a href="/terms.html">Terms Of Use</a></li>
                                    <li><a href="/contact.html">Contact us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="links">
                                <h3>Help & Suport</h3>
                                <ul>
                                    <li><a href="#">FAQs</a></li>
                                    <li><a href="#">Support</a></li>
                                    <li><a href="#">How it works</a></li>
                                    <li><a href="#">Terms & conditions</a></li>
                                    <li><a href="#">Privacy policy</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-12">
                            <div class="try_out">
                                <h3>Let’s Try Out</h3>
                                <ul class="app_btn">
                                    <li>
                                        <a href="{{ route('download.page') }}">
                                            <img class="w-100" src="https://i.postimg.cc/V06GCB3X/googleplay-blue.png"
                                                alt="image">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



    </div>

@stop
