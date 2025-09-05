@php
$title='Autoliker Live';
$title2 = 'auto liker app';
if(isset($keyword)){
    $title = str_replace('-',' ',$keyword);
}
@endphp

@extends('layouts.master')
@section('title', $title.' - Facebook Auto Follow APP')

@section('description', 'Get Facebook auto followers with the top-rated '.$title.' app for Android. Get auto fb subs, auto liker and Facebook auto friend requests.')

@section('content')

        <main class="flex-shrink-0">
             <!-- Navigation-->
             <x-navbar></x-navbar>
            <!-- Header-->
            <header class="bg-dark py-5">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center justify-content-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <div class="my-5 text-center text-xl-start">
                                <h1 class="display-5 fw-bolder text-white mb-2">{{ $title ? $title : 'Autoliker Live' }}</h1>
                                <p class="lead fw-normal text-white-50 mb-4">Download {!! $title !!} & get Auto followers, Auto like etc. on FB account for free.</p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <img src="{{ secure_asset('images/icon.webp') }}" alt="autoliker Live icon" class="thumbnail-image-2" width="50px" height="50px">
                                    <a class="btn btn-primary btn-lg px-4 me-sm-3 download" href="{{ url('download') }}">
                                    <i class="bi bi-android"></i>
                                     Download APP</a>
                                    <a class="btn btn-outline-light btn-lg px-4" href="#features">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="{{ secure_asset('images/graphic.webp') }}" alt="autoliker Live graohics" /></div>
                    </div>
                </div>
            </header>
            <!-- Features section-->
            <section class="py-5" id="features">
                <div class="container px-5 my-5">
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">Few things to know about the app.</h2></div>
                        <div class="col-lg-8">
                            <div class="row gx-5 row-cols-1 row-cols-md-2">
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                    <h2 class="h5">Service Provide</h2>
                                    <p class="mb-0">App currently provides Facebook auto followers only. We will keep adding new services to the app. </p>
                                </div>
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-shield-check"></i></div>
                                    <h2 class="h5">Security</h2>
                                    <p class="mb-0">Autoliker app not save any king of Facebook account information to our servers. The FB login information like access token and cookies is store on your own device.</p>
                                </div>
                                <div class="col mb-5 mb-md-0 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-bandaid"></i></div>
                                    <h2 class="h5">Anti Spam</h2>
                                    <p class="mb-0">This app has 0% spam. This FB auto liker app is spam free. APP not send your FB private information like access token or cookie to our server. That means its not possible to spam with your account.</p>
                                </div>
                                <div class="col h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person-workspace"></i></div>
                                    <h2 class="h5">Support</h2>
                                    <p class="mb-0">We are open for any kind of support related to the app. Anyone can contact us by our social media pages.</p>
                                </div>
                            </div>
                        <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">

                            <div class="ms-xl-4 mt-5">
                                <div class="input-group">
                                   @foreach($listings as $listing)
                                   <div class="bg-primary bg-gradient text-white rounded-3 mb-3 m-2 p-2">
                                       <a class="text-white p-2 text-decoration-none" href='{{ url("") }}/{{ str_replace(" ", "-", $listing->name) }}'>{{ $listing->name }}</a>
                                   </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Testimonial section-->
            <div class="py-5 bg-light">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-10 col-xl-7">
                            <div class="text-center">
                                <label class="p-2">How to use {{ $title ? $title : 'Autoliker Live' }}</label>
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
                                                href='https://www.youtube.com/embed/fl6hmVbZUgs?autoplay=1'
                                                class='full'
                                            >
                                                <img
                                                    src='https://vumbnail.com/fl6hmVbZUgs.jpg'
                                                    class='full'
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

                                    title="YouTube video player" frameborder="0" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div class="fs-4 mb-4 fst-italic p-2">"Facing trouble in use?"</div>
                                <div class="fs-4 mb-4 fst-italic p-2">"Watch detailed video tutorial to understand how to use the <strong>Autoliker</strong> Live app. It has only views steps to follow. You have you spend 5 minutes to become a master of <strong>FB Auto Liker</strong> Live app  "</div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img class="rounded-circle me-3" src="{{ secure_asset('images/favicons/favicon-32x32.webp') }}" alt="favicon-32x32" />
                                    <div class="fw-bold">
                                        Admin theRiyazSaifi
                                        <span class="fw-bold text-primary mx-1">/</span>
                                       by tRS APPS
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Blog preview section-->
            <section class="py-5">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">From our blog</h2>
                                <p class="lead fw-normal text-muted mb-5"> Check our official blog for Tricks & Tips. We update Android, Desktop tricks & tips to make your internet experience enjoyable.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
                        @foreach($posts as $post)
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <amp-img class="card-img-top" src="{{ $post->jetpack_featured_media_url }}" alt="..." />
                                <div class="card-body p-4 bg-dark">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">latest Posts</div>
                                    <a class="text-decoration-none link-dark stretched-link text-dark" href="{{ $post->link }}"><h5 class="card-title mb-3">{{ $post->title->rendered }}</h5></a>
                                    <p class="card-text mb-0">{{ strip_tags(str_replace('read more&#8230;','',$post->excerpt->rendered)) }}</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0 mt-4">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="dummy image" />
                                            <div class="small">
                                                <div class="fw-bold">_admin</div>
                                                <div class="text-muted">{{ date('M d, Y',strtotime("$post->date_gmt")); }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Call to action-->

                </div>
            </section>

            <section class="bg-light">
                <div class="container">
                    <div class="row">
                        <h1 class="text-dark">Auto Liker & fbsub</h1>
                        <p class="text-dark">
                            Welcome to AutoLikerLive, your one-stop-shop for all your social media boosting needs. Our platform provides a wide range of <strong>fbsub</strong> and auto follower services to enhance your social media presence and engagement on popular platforms like Facebook, Instagram, TikTok, and more. We are an industry leader in providing reliable and efficient social media marketing services, including Facebook auto likes, auto followers, and auto comments.
                        </p>
                        <p class="text-dark">
                            Our team of experts has years of experience in the social media marketing industry and has designed our services to cater to your specific needs. Our services are fast, reliable, and secure, ensuring that you receive top-notch quality every time.
                        </p>
                        <p class="text-dark">
                            At AutoLikerLive, we understand the importance of having a strong social media presence. That's why we offer high-quality social media engagement services that can help you increase your online visibility and reach a wider audience.
                        </p>
                        <p class="text-dark">
                            Our services are designed to be safe, secure, and easy to use, making it simple for you to take your social media game to the next level.We understand that social media can be overwhelming at times, and that's why we have made our platform easy to use, so you can easily get started and boost your social media profile within minutes.
                        </p>
                        <p class="text-dark">
                            We use cutting-edge technology to deliver high-quality, organic social media engagement to our clients. Our auto like and auto follower services are 100% safe and secure, and we never use bots or fake accounts. We also offer fast and reliable delivery, so you can start seeing results in just a few minutes.
                        </p>
                        <p class="text-dark">
                            Our team of SEO experts and social media marketers are dedicated to ensuring that your online presence is maximized. We use top trending keywords and strategies to ensure your content is seen by as many people as possible. Our services are customizable, and we work with you to create a tailored marketing plan that suits your needs.
                        </p>
                        <p class="text-dark">
                            We offer a range of services, including auto likes, auto followers, and auto comments, all designed to help you increase your social media reach, engagement, and exposure. Our services are competitively priced, making it affordable for everyone to take advantage of our social media boosting services
                        </p>
                        <p class="text-dark">
                            With our <strong>Facebook auto liker</strong>, you can easily get more likes on your posts, photos, and videos. Our auto follower service can help you increase your Facebook followers, while our auto comment service can help you get more comments on your posts. All of our services are designed to help you increase your engagement and reach on Facebook, giving you the boost you need to succeed in the competitive world of social media marketing
                        </p>
                        <p class="text-dark">
                            At AutoLikerLive, we prioritize customer satisfaction, and we're committed to delivering exceptional customer support 24/7. If you have any questions or concerns, feel free to contact our customer support team at any time, and we'll be happy to assist you.
                        </p>
                        <p class="text-dark">
                            So, whether you're an individual looking to grow your social media presence or a business looking to increase your brand awareness, we've got you covered. Start using our services today and experience the power of social media marketing with AutoLikerLive.So why wait? Sign up for AutoLikerLive today and start boosting your social media presence with our reliable and effective services. Our top keywords include auto liker, auto followers, auto comments, Facebook auto liker, Facebook auto followers, Facebook auto comments, social media marketing, and more.
                        </p>
                        <p class="text-dark">
                            Some of our top keywords include "<strong>{{ $title }}</strong>","<strong>auto likes</strong>," "<strong>auto followers</strong>," "<strong>Facebook likes</strong>," "<strong>Instagram followers</strong>," and "<strong>social media marketing</strong>" These keywords reflect the services we offer and the industry we operate in. By using these keywords throughout our website and marketing materials, we ensure that our site ranks high in search engine results, making it easy for our clients to find us.
                        </p>
                        <p class="text-dark">

                            <strong>Auto Liker</strong>, Auto Follower, Social Media Boosting, Facebook, Instagram, TikTok, Social Media Marketing, Customer Satisfaction, Customer Support.
                        </p>
                    </div>
                </div>
            </section>

            <section class="py-5">
                <div class="container">
                                       <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                        <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                            <div class="mb-4 mb-xl-0">
                                <div class="fs-3 fw-bold text-white">New products, delivered to you.</div>
                                <div class="text-white-50">Keep connected with our apps.</div>
                            </div>
                            <div class="ms-xl-4">
                                <div class="input-group mb-2">
                                   <a href="https://www.facebook.com/autolikerLIVE">
                                   <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i class="bi bi-facebook"></i></div></a>
                                   <a href="https://twitter.com/theRiyazSaifi">
                                   <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i class="bi bi-twitter"></i></div></a>
                                   <a href="https://www.instagram.com/theriyazsaifi1/">
                                   <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i class="bi bi-instagram"></i></div></a>
                                   <a href="https://t.me/+1NDLe3FAY3dlN2M1">
                                   <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i class="bi bi-telegram"></i></div></a>
                                </div>
                                <div class="small text-white-50">We care about privacy, and will never share your data.</div>
                            </div>
                        </div>
                    </aside>
                    <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                        <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">

                            <div class="ms-xl-4">
                                <div class="input-group">
                                   @foreach($tags as $tag)
                                   <div class="bg-primary bg-gradient text-white rounded-3 mb-3 m-2 p-2">
                                       <a class="text-white p-2" href='{{ url('') }}/{{ str_replace(" ", "-", $tag->name) }}'>{{ $tag->name }}</a>
                                   </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </aside>
                </div>

            </section>

        </main>

@stop
