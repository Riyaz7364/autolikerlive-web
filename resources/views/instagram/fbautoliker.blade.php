@extends('layouts.master')

@section('title', 'Facebook Auto Liker 1000 Likes | Autolikerlive.com')
@section('description',
    'Instantly boost your Facebook posts with up to 1000 real likes using Autolikerlive.com. Fast,
    safe, and free Facebook Auto Liker service. No login required!')

@section('javascripts')
    <style>
        body {
            font-family: 'Poppins', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)),
                        url('https://images.unsplash.com/photo-1611224923853-80b023f02d71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center/cover;
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
    </style>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stop

@section('content')
    <x-navbar></x-navbar>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center hero-content">
                    <h1 class="display-4 fw-bold mb-4">Facebook Auto Liker 1000 Likes</h1>
                    <p class="lead mb-4">Instantly boost your Facebook posts with up to 1000 real likes. Fast, safe, and free Facebook Auto Liker service. No login required.</p>

                    <!-- Play Store Button - Repositioned -->
                    <div class="d-flex justify-content-center mb-4">
                        <a href="https://play.google.com/store/apps/details?id=com.rajeliker" target="_blank" class="play-store-btn">
                            <svg class="play-store-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.61 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.53 20.75,12C20.75,12.47 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
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
                <p class="lead text-muted">Facebook Auto Liker 1000 Likes is a simple and efficient tool designed to help you increase engagement on your Facebook posts effortlessly.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">01</div>
                        <h5 class="fw-bold mb-3">Open Auto FB Liker</h5>
                        <p class="text-muted">Visit our platform from your preferred device. Get free Facebook Followers, Likes, and Views! Visit www.autolikerlive.com</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">02</div>
                        <h5 class="fw-bold mb-3">Log in Securely</h5>
                        <p class="text-muted">Unlike other platforms that ask for sensitive data, our login process is 100% safe. No tokens, cookies, or personal details required.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">03</div>
                        <h5 class="fw-bold mb-3">Earn Credits (Easy & Free)</h5>
                        <p class="text-muted">Earn credits by completing simple tasks like liking posts, following users, or watching short videos. No hidden charges!</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="feature-card text-center">
                        <div class="step-icon">04</div>
                        <h5 class="fw-bold mb-3">Get Free Likes & Engagement</h5>
                        <p class="text-muted">Use your earned credits to increase likes, followers, and views on your Facebook posts. Real interactions, no bots!</p>
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
                            <p class="mb-0">No Token, No Cookies Required – 100% Safe and Secure! Are you searching for a trustworthy Auto Liker for Facebook? Through our platform, you can enhance your Facebook engagement without jeopardizing your account.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="card-header">
                            <h3 class="mb-0">💝 Free Facebook Likes</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">Getting free Facebook likes is easy! You get credits every few minutes and can use them to boost your posts. No credit card required, just follow simple steps to earn and use your credits.</p>
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
            <p class="lead mb-4">Join thousands of users who are already increasing their social media presence with our safe and effective tools.</p>
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
