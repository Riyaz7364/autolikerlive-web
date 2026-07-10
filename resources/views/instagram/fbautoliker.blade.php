@extends('layouts.master')

@section('title', 'Facebook Auto Liker 1000 Likes | Autolikerlive.com')
@section('description',
    'Instantly boost your Facebook posts with up to 1000 real likes using Autolikerlive.com. Fast,
    safe, and free Facebook Auto Liker service. No login required!')

@section('ogimage', url('/images/fb-liker-1000-likes.webp'))


@section('javascripts')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
        crossorigin="anonymous"></script>

    <style>
        body {
            font-family: 'Poppins', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        @media screen and (max-width: 768px) {
            input {
                width: 100% !important;
            }

            .input-group {

                position: relative;
                display: inline-block !important;
                flex-wrap: wrap;
                align-items: stretch;
                width: 100%;

            }

            .search-btn {
                margin-top: 10px;
            }
        }

        .hero-section {
background-color: #49539c;
background-image: url("data:image/svg+xml,%3Csvg width='42' height='44' viewBox='0 0 42 44' xmlns='http://www.w3.org/2000/svg'%3E%3Cg id='Page-1' fill='none' fill-rule='evenodd'%3E%3Cg id='brick-wall' fill='%23573f75' fill-opacity='1'%3E%3Cpath d='M0 0h42v44H0V0zm1 1h40v20H1V1zM0 23h20v20H0V23zm22 0h20v20H22V23z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            color: white;
            padding: 80px 0;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .play-store-btn {
            background: #fff;
            color: #333;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin: 20px 0;
        }

        .play-store-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: #333;
        }

        .play-store-icon {
            width: 24px;
            height: 24px;
        }

        .features-section {
            background: #fff;
            padding: 80px 0;
            margin-top: -50px;
            border-radius: 20px 20px 0 0;
            position: relative;
            z-index: 3;
        }

        .feature-card {
            background: #f8f9fa;
            border: none;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-number {
            font-size: 48px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 20px;
        }

        .step-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .info-cards {
            margin-top: 60px;
        }

        .info-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 30px;
            height: 100%;
        }

        .info-card .card-header {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .emoji-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin: 30px 0;
        }

        .emoji-item {
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .emoji-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .emoji-size {
            width: 40px;
            height: 40px;
        }

        .cta-section {
            background: linear-gradient(135deg, #764ba2, #667eea);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .btn-modern {
            border-radius: 25px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            background: #fff;
            color: #667eea;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }

            .feature-card {
                margin-bottom: 20px;
            }

            .emoji-grid {
                gap: 15px;
            }

            .emoji-size {
                width: 35px;
                height: 35px;
            }
        }
                                        
                                        
.title {
  font-size: 48px;
  font-weight: 800;
  line-height: 1.2;
  color: #fffff;
  font-family: Arial, sans-serif;
}

/* pink highlight effect */
.title {
  display: inline;
  background: linear-gradient(
    transparent 55%,
    #ff4fa3 55%
  );
  padding: 0 6px;
  box-decoration-break: clone;
  -webkit-box-decoration-break: clone;
}
                                        
.subheading {
    font-size: 28px;
    font-weight: 600;
    line-height: 1.3;
    color: #ffffff;
    font-family: Arial, sans-serif;
    display: inline;
    background: linear-gradient(#3951ff80 60%, #505ec7 60%);
    padding: 0 4px;
    box-decoration-break: clone;
    -webkit-box-decoration-break: clone;
}
    </style>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
@stop

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center hero-content">
                   <h1 class="title mb-2">Facebook Auto Liker 1000 Likes</h1>
                    <p class="lead my-4">Instantly boost your Facebook posts with up to 1000 real likes. Fast, safe, and free
                        Facebook Auto Liker service. No login required.</p>


                    <div class="mail-wrapper">


                        <div class="mail-selection mb-3">
                            <div class="card text-center fw-bold">
                                <div class="card-header facebook-btn subheading">
                                    Login with Facebook Profile Link
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
                                        <div class="col-12 mb-3">
                                            <div class="form-group">
                                                <label for="username" class="form-label text-white mb-2">
                                                    <strong>Facebook Profile URL</strong>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-field" id="username"
                                                        name="username" placeholder="Enter full Facebook profile URL"
                                                        required autocomplete="off">
                                                    <button type="submit" class="btn search-btn"
                                                        style="background-color: #1877F2; color: white; border: none; font-weight: 600; padding: 10px 30px; font-size: 16px;">
                                                        🔍︎ Search Profile
                                                    </button>
                                                </div>
                                                <small class="text-muted d-block mt-2 text-start">
                                                    Example: https://facebook.com/zuck or
                                                    https://www.facebook.com/profile.php?id=123456789
                                                </small>
                                            </div>
                                        </div>

                                        <div class="cf-turnstile mb-2" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>


                                        @if (session('fail'))
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
                                                    <source
                                                        src="https://www.autolikerlive.com/assets/videos/facebook_setting.mp4"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @endif

                                        <div class="col-12 mt-4">
                                            <div class="text-center">
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
                                        </div>

                                        <!-- Temp Mail Center adsbygoogle -->

                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>

                    <!-- Play Store Button - Repositioned -->
                    <div class="d-flex justify-content-center mb-4">
                        <a href="https://play.google.com/store/apps/details?id=com.rajeliker" target="_blank"
                            class="play-store-btn">
                            <svg class="play-store-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.61 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.53 20.75,12C20.75,12.47 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z" />
                            </svg>
                            <div>
                                <div class="small text-muted">Download</div>
                                <div class="fw-bold">Google Play</div>
                            </div>
                        </a>
                    </div>

                    <!-- Reaction Emojis -->
                    <div class="emoji-grid">
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/like.png" alt="Like">
                        </div>
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/love.png" alt="Love">
                        </div>
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/care.png" alt="Care">
                        </div>
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/haha.png" alt="Haha">
                        </div>
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/wow.png" alt="Wow">
                        </div>
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/sad.png" alt="Sad">
                        </div>
                        <div class="emoji-item">
                            <img class="emoji-size" src="https://www.autolikerlive.com/reaction/engry.png" alt="Angry">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-gradient mb-3">How It Works</h2>
                <p class="lead text-muted">Facebook Auto Liker 1000 Likes is a simple and efficient tool designed to help
                    you increase engagement on your Facebook posts effortlessly.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">01</div>
                        <h5 class="fw-bold mb-3">Open Auto FB Liker</h5>
                        <p class="text-muted">Visit our platform from your preferred device. Get free Facebook Followers,
                            Likes, and Views! Visit www.autolikerlive.com</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">02</div>
                        <h5 class="fw-bold mb-3">Log in Securely</h5>
                        <p class="text-muted">Unlike other platforms that ask for sensitive data, our login process is 100%
                            safe. No tokens, cookies, or personal details required.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">03</div>
                        <h5 class="fw-bold mb-3">Earn Credits (Easy & Free)</h5>
                        <p class="text-muted">Earn credits by completing simple tasks like liking posts, following users,
                            or watching short videos. No hidden charges!</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">04</div>
                        <h5 class="fw-bold mb-3">Get Free Likes & Engagement</h5>
                        <p class="text-muted">Use your earned credits to increase likes, followers, and views on your
                            Facebook posts. Real interactions, no bots!</p>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="row info-cards g-4">
                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="mb-0">🚀 Auto Liker Facebook</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">No Token, No Cookies Required – 100% Safe and Secure! Are you searching for a
                                trustworthy Auto Liker for Facebook? Through our platform, you can enhance your Facebook
                                engagement without jeopardizing your account.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="mb-0">💝 Free Facebook Likes</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">Getting free Facebook likes is easy and instant! Just share your profile link and start getting reactions from real users. No credit card required, no payment needed, completely free.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What This Service Is -->
            <div class="text-center p-5 mt-5">
                <h2 class="fw-bold mb-4" style="color: #333;">What Is Facebook Auto Liker?</h2>
                <p class="lead text-muted" style="max-width: 700px; margin: 0 auto;">
                    AutolikerLive's Facebook Auto Liker is a <strong>free, community-based engagement tool</strong> that lets you get reactions (likes, loves, etc.) from real Facebook users. It's designed for fun, to boost visibility on your posts, and to help you engage with the community in return.
                </p>
                <p class="text-muted" style="max-width: 700px; margin: 20px auto;">
                    This is <strong>not a bot service</strong>. Real people participate by sharing their engagement for credits. In exchange, they receive reactions on their posts too. It's a fair, community-based system.
                </p>
            </div>

            <!-- Important Information -->
            <div class="row mt-5">
                <div class="col-md-6 mb-4">
                    <div class="feature-card">
                        <h5 class="fw-bold mb-3" style="color: #667eea;">✓ Real Reactions from Real Users</h5>
                        <p class="text-muted">
                            All reactions come from real, active Facebook users—not automated bots or fake accounts. This is why results may vary, and reactions depend on user participation.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="feature-card">
                        <h5 class="fw-bold mb-3" style="color: #667eea;">⏱️ 10-Minute Cooldown</h5>
                        <p class="text-muted">
                            There's a 10-minute cooldown between requests. This is to keep the system fair and prevent abuse.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="feature-card">
                        <h5 class="fw-bold mb-3" style="color: #667eea;">🔒 No Account Login Required</h5>
                        <p class="text-muted">
                            You don't need to give us your Facebook password, tokens, or authentication. Just share your public profile link. Your account stays completely safe.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="feature-card">
                        <h5 class="fw-bold mb-3" style="color: #667eea;">⚠️ No Guaranteed Results</h5>
                        <p class="text-muted">
                            This is a fun engagement tool, not a guarantee. Results depend on community participation. Use it for fun and to engage with others, not as the only way to grow.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-5 pt-5" style="border-top: 2px solid #eee;">
                <h2 class="fw-bold text-center mb-5" style="color: #333;">Frequently Asked Questions</h2>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Is this safe for my Facebook account?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, it is safe. We never ask for your password or login credentials. We only need your public profile link. All reactions come from real users, not bots, so your account stays in good standing with Facebook.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        How long does it take to get likes?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Reactions are delivered based on community participation. Since real users provide the reactions, it depends on how many users are active and available. Results vary.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        What is the cooldown?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        There is a 10-minute cooldown between requests. This means you can request reactions once every 10 minutes. This helps keep the system fair and prevents abuse.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        Is this against Facebook's rules?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        We follow a community engagement model where real users help each other. However, we recommend using this as one of many ways to grow engagement—not as your only method. Always follow Facebook's Community Guidelines.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                        Do I need to buy anything?
                                    </button>
                                </h2>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        No. The service is completely free. Just enter your Facebook profile link and get reactions. No payment, no credit card, no hidden charges.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips for Better Facebook Engagement -->
            <div class="mt-5 pt-5" style="border-top: 2px solid #eee;">
                <h2 class="fw-bold text-center mb-5" style="color: #333;">Tips for Better Facebook Engagement (Beyond Tools)</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-3">1. Post Quality Content</h5>
                            <p class="text-muted">Focus on posts that matter to your audience. Whether it's updates, photos, videos, or stories, quality always beats quantity. Engagement tools work best when you have good content to back them up.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-3">2. Post at the Right Time</h5>
                            <p class="text-muted">Timing matters. Post when your audience is most active. Different times work for different audiences, so test and learn what works best for your followers.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-3">3. Use Captions & Calls to Action</h5>
                            <p class="text-muted">A good caption encourages interaction. Ask questions, tell stories, or ask your followers to share their thoughts. This naturally boosts engagement without any tools.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-3">4. Engage with Your Community</h5>
                            <p class="text-muted">Don't just ask for engagement—give it too. Like, comment, and share posts from others in your niche. This builds real relationships and gets your profile noticed.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">Ready to Boost Your Facebook Engagement?</h2>
            <p class="lead mb-4">Join thousands of users who are already increasing their social media presence with our
                safe and effective tools.</p>
            <a href="{{ route('app.index') }}" class="btn btn-modern">Get Started Now</a>
        </div>
    </section>

    <script>
        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate feature cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.feature-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@endsection
