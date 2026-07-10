@php
    $infoPath = public_path('info.json');
    $json = json_decode(file_get_contents($infoPath));
@endphp
@extends('layouts.master')

@section('title', 'Download APP')
@section('description',
    'Download autoliker live app from this page. This app has perfect tool for Facebook auto
    followers.')

    @push('styles')
        <style>
            .download-hero {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 25px;
                overflow: hidden;
                position: relative;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            .download-hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                opacity: 0.1;
                pointer-events: none;
                z-index: 0;
            }

            .download-hero::after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: conic-gradient(from 0deg, transparent, rgba(255, 255, 255, 0.1), transparent);
                animation: rotate 20s linear infinite;
                pointer-events: none;
            }

            @keyframes rotate {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .app-info-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 20px;
                transition: all 0.4s ease;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
            }

            .app-info-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.6s;
            }

            .app-info-card:hover::before {
                left: 100%;
            }

            .app-info-card:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            }

            .service-card {
                background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                border: none;
                border-radius: 15px;
                transition: all 0.4s ease;
                text-decoration: none;
                display: block;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                position: relative;
                overflow: hidden;
            }

            .service-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, #667eea, #764ba2);
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }

            .service-card:hover::before {
                transform: scaleX(1);
            }

            .service-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
                text-decoration: none;
            }

            .download-btn {
                background: linear-gradient(45deg, #28a745, #20c997, #17a2b8);
                background-size: 200% 200%;
                border: none;
                border-radius: 50px;
                padding: 15px 15px;
                font-weight: bold;
                font-size: 1.2rem;
                transition: all 0.4s ease;
                box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
                cursor: pointer !important;
                pointer-events: auto !important;
                position: relative;
                z-index: 10;
                animation: pulse-glow 2s ease-in-out infinite alternate;
            }

            .download-btn-subtitle {
                position: absolute;
                font-size: small;
                display: block;
                margin-left: 3rem;
                bottom: 0px;
            }

            @keyframes pulse-glow {
                0% {
                    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
                    background-position: 0% 50%;
                }

                100% {
                    box-shadow: 0 12px 35px rgba(40, 167, 69, 0.6);
                    background-position: 100% 50%;
                }
            }

            .download-btn:hover {
                transform: scale(1.08) translateY(-2px);
                box-shadow: 0 15px 40px rgba(40, 167, 69, 0.5);
                animation: none;
                background-position: 100% 50%;
            }

            .feature-icon {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                position: relative;
                animation: float 3s ease-in-out infinite;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            .social-link {
                display: inline-block;
                margin: 0 10px;
                transition: all 0.3s ease;
                position: relative;
            }

            .social-link:hover {
                transform: scale(1.2) rotate(5deg);
            }

            .social-link::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #667eea, #764ba2);
                transition: all 0.3s ease;
                transform: translateX(-50%);
            }

            .social-link:hover::after {
                width: 100%;
            }

            .stats-card {
                background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
            }

            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            }

            .animated-bg {
                background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }

            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .section-divider {
                height: 2px;
                background: linear-gradient(90deg, transparent, #667eea, #764ba2, transparent);
                margin: 3rem 0;
                border-radius: 1px;
            }

            .contact-card {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.95) 100%);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            }

            .contact-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            }

            .btn-modern {
                border-radius: 25px;
                padding: 12px 25px;
                font-weight: 600;
                transition: all 0.3s ease;
                border: none;
                position: relative;
                overflow: hidden;
            }

            .btn-modern::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.5s;
            }

            .btn-modern:hover::before {
                left: 100%;
            }

            .text-gradient {
                background: linear-gradient(45deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .market-btn {
                display: inline-block;
                padding: 0.3125rem 0.875rem;
                padding-left: 2.8125rem;
                -webkit-transition: border-color 0.25s ease-in-out, background-color 0.25s ease-in-out;
                transition: border-color 0.25s ease-in-out, background-color 0.25s ease-in-out;
                border: 1px solid #e7e7e7;
                background-position: center left 0.75rem;
                background-color: #fff;
                background-size: 1.5rem 1.5rem;
                background-repeat: no-repeat;
                text-decoration: none;
            }

            .market-btn .market-button-title {
                display: block;
                color: #222;
                font-size: 1.125rem;
            }

            .market-btn .market-button-subtitle {
                display: block;
                margin-bottom: -0.25rem;
                color: #888;
                font-size: 0.75rem;
            }

            .market-btn:hover {
                background-color: #f7f7f7;
                text-decoration: none;
            }

            .google-btn {
                background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPHBvbHlnb24gc3R5bGU9ImZpbGw6IzVDREFERDsiIHBvaW50cz0iMjkuNTMsMCAyOS41MywyNTEuNTA5IDI5LjUzLDUxMiAyOTkuMDA0LDI1MS41MDkgIi8+Cjxwb2x5Z29uIHN0eWxlPSJmaWxsOiNCREVDQzQ7IiBwb2ludHM9IjM2OS4wNjcsMTgwLjU0NyAyNjIuMTc1LDExOS40NjcgMjkuNTMsMCAyOTkuMDA0LDI1MS41MDkgIi8+Cjxwb2x5Z29uIHN0eWxlPSJmaWxsOiNEQzY4QTE7IiBwb2ludHM9IjI5LjUzLDUxMiAyOS41Myw1MTIgMjYyLjE3NSwzODMuNTUxIDM2OS4wNjcsMzIyLjQ3IDI5OS4wMDQsMjUxLjUwOSAiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQ0E5NjsiIGQ9Ik0zNjkuMDY3LDE4MC41NDdsLTcwLjA2Myw3MC45NjFsNzAuMDYzLDcwLjk2MWwxMDguNjg4LTYyLjg3N2M2LjI4OC0zLjU5Myw2LjI4OC0xMS42NzcsMC0xNS4yNyAgTDM2OS4wNjcsMTgwLjU0N3oiLz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==);
                border-radius: 10px;
            }


            .market-btn-light {
                border-color: rgba(255, 255, 255, 0.14);
                background-color: rgba(0, 0, 0, 0);
            }

            .market-btn-light .market-button-title {
                color: #fff;
            }

            .market-btn-light .market-button-subtitle {
                color: rgba(255, 255, 255, 0.6);
            }

            .market-btn-light:hover {
                background-color: rgba(255, 255, 255, 0.06);
            }
        </style>
    @endpush
@section('content')


    <main class="flex-shrink-0">
        <!-- Navigation-->
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Download Hero Section -->
                <div class="download-hero py-5 px-4 px-md-5 mb-5 text-white position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="text-center text-lg-start">
                                <div class="feature-icon bg-white bg-opacity-20 mb-4 mx-auto mx-lg-0">
                                    <i class="bi bi-download fs-1"></i>
                                </div>
                                <h1 class="fw-bolder display-4 mb-3 text-gradient-white">{{ __('messages.download.title') }}
                                </h1>
                                <p class="lead mb-4 fs-5">{{ __('messages.download.useLatest') }}</p>
                                <div
                                    class="d-flex flex-column flex-sm-row gap-3 flex-wrap align-items-center justify-content-center justify-content-lg-start">


                                    <!-- Google Play button -->
                                    <a href="https://play.google.com/store/apps/details?id=com.rajeliker" target="_blank"
                                        class="market-btn google-btn" role="button">
                                        <span class="market-button-subtitle">Download on the</span>
                                        <span class="market-button-title">Google Play</span>
                                    </a>





                                    <button type="button" data-timer="5" id="download-btn" class="download-btn text-white">
                                        <span>Direct {{ str_replace('.apk', '', $json->link) }}</span>

                                        <span class="download-btn-subtitle">Facebook & Instagram</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center d-none d-lg-block">
                            <div class="position-relative">
                                <div class="feature-icon bg-white bg-opacity-10 mb-0" style="width: 150px; height: 150px;">
                                    <i class="bi bi-phone fs-1"></i>
                                </div>
                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <div class="spinner-border text-white-50"
                                        style="width: 200px; height: 200px; animation-duration: 3s;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App Information Cards -->
                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="app-info-card p-4 text-center h-100">
                            <div class="feature-icon bg-primary bg-opacity-20 mb-3">
                                <i class="bi bi-tag text-primary fs-2"></i>
                            </div>
                            <h5 class="text-dark fw-bold mb-2">Version</h5>
                            <p class="text-muted mb-0 fs-4 fw-bold text-gradient">{{ $json->version }}</p>
                            <small class="text-muted">Latest Release</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="app-info-card p-4 text-center h-100">
                            <div class="feature-icon bg-success bg-opacity-20 mb-3">
                                <i class="bi bi-gear text-success fs-2"></i>
                            </div>
                            <h5 class="text-dark fw-bold mb-2">Build</h5>
                            <p class="text-muted mb-0 fs-4 fw-bold text-gradient">{{ $json->build }}</p>
                            <small class="text-muted">Stable Build</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="app-info-card p-4 text-center h-100">
                            <div class="feature-icon bg-info bg-opacity-20 mb-3">
                                <i class="bi bi-calendar-check text-info fs-2"></i>
                            </div>
                            <h5 class="text-dark fw-bold mb-2">Last Update</h5>
                            <p class="text-muted mb-0 fs-6 fw-bold">{{ $json->update }}</p>
                            <small class="text-muted">Recently Updated</small>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="stats-card mb-5">
                    <div class="row g-4 text-center">
                        <div class="col-md-3">
                            <div class="feature-icon bg-primary bg-opacity-10 mb-3 mx-auto">
                                <i class="bi bi-download text-primary fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-gradient">1M+</h4>
                            <p class="text-muted mb-0">Downloads</p>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-icon bg-success bg-opacity-10 mb-3 mx-auto">
                                <i class="bi bi-star-fill text-warning fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-gradient">4.8</h4>
                            <p class="text-muted mb-0">Rating</p>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-icon bg-info bg-opacity-10 mb-3 mx-auto">
                                <i class="bi bi-people text-info fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-gradient">500K+</h4>
                            <p class="text-muted mb-0">Users</p>
                        </div>
                        <div class="col-md-3">
                            <div class="feature-icon bg-warning bg-opacity-10 mb-3 mx-auto">
                                <i class="bi bi-shield-check text-success fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-gradient">100%</h4>
                            <p class="text-muted mb-0">Safe</p>
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>
                <!-- Services & Tools Section -->
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark mb-4">Other Services & Tools</h2>
                    <p class="text-muted lead">Explore our additional tools and services</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6 col-lg-3">
                        <a class="service-card p-4 text-center text-decoration-none"
                            href="{{ route('autoliker.instagram') }}">
                            <div class="feature-icon"
                                style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);">
                                <i class="bi bi-heart-fill text-white fs-4"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-2">IG Auto Liker</h6>
                            <p class="text-muted small mb-0">Automate your Instagram engagement</p>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <a class="service-card p-4 text-center text-decoration-none"
                            href="{{ route('free-tiktok-views') }}" target="_blank">
                            <div class="feature-icon"
                                style="background: linear-gradient(45deg, #000000 0%, #ffffff 100%);">
                                <i class="bi bi-play-circle-fill text-white fs-4"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-2">TikTok Views</h6>
                            <p class="text-muted small mb-0">Free TikTok video views</p>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <a class="service-card p-4 text-center text-decoration-none"
                            href="{{ route('free-instagram-likes') }}" target="_blank">
                            <div class="feature-icon"
                                style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);">
                                <i class="bi bi-heart text-danger fs-4"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-2">Instagram Likes</h6>
                            <p class="text-muted small mb-0">Free Instagram likes</p>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <a class="service-card p-4 text-center text-decoration-none" href="{{ route('sms-bomber') }}">
                            <div class="feature-icon bg-warning">
                                <i class="bi bi-telephone text-white fs-4"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-2">SMS Bomber</h6>
                            <p class="text-muted small mb-0">300 free SMS prank tool</p>
                        </a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <a class="service-card p-4 text-center text-decoration-none" href="{{ route('temp-mail') }}">
                            <div class="feature-icon bg-success">
                                <i class="bi bi-envelope text-white fs-4"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-2">Temp Mail</h6>
                            <p class="text-muted small mb-0">Temporary email service</p>
                        </a>
                    </div>
                </div>
                <!-- Contact Section -->
                <div class="animated-bg rounded-4 p-1 mb-5">
                    <div class="contact-card p-5 rounded-4">
                        <div class="text-center mb-5">
                            <h2 class="fw-bold text-gradient mb-3">Stay Connected</h2>
                            <p class="text-muted lead">Join our community and get the latest updates</p>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="contact-card p-4 text-center h-100">
                                    <div class="feature-icon bg-gradient-primary mb-4 mx-auto"
                                        style="background: linear-gradient(45deg, #667eea, #764ba2);">
                                        <i class="bi bi-share text-white fs-2"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-3">Follow Us</h5>
                                    <p class="text-muted mb-4">Stay connected and get the latest updates on social media
                                    </p>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="https://www.facebook.com/autolikerLIVE" class="social-link">
                                            <div class="rounded-full p-3 w-12 h-12 flex items-center justify-center bg-[var(--fb-blue)] text-white">
                                                    <i class="bi bi-facebook"></i>
                                                </div>
                                        </a>
                                        <a href="https://twitter.com/theRiyazSaifi" class="social-link">
                                            <div class="rounded-full p-3 w-12 h-12 flex items-center justify-center bg-sky-500 text-white">
                                                <i class="bi bi-twitter"></i>
                                            </div>
                                        </a>
                                        <a href="https://www.instagram.com/theriyazsaifi1/" class="social-link">
                                            <div class="rounded-full p-3 w-12 h-12 flex items-center justify-center bg-pink-600 text-white">
                                                <i class="bi bi-instagram"></i>
                                            </div>
                                        </a>
                                        <a href="https://t.me/+1NDLe3FAY3dlN2M1" class="social-link">
                                            <div class="rounded-full p-3 w-12 h-12 flex items-center justify-center bg-[var(--fb-blue)] text-white">
                                                <i class="bi bi-telegram"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-card p-4 text-center h-100">
                                    <div class="feature-icon bg-gradient-success mb-4 mx-auto"
                                        style="background: linear-gradient(45deg, #28a745, #20c997);">
                                        <i class="bi bi-envelope text-white fs-2"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-3">Email Support</h5>
                                    <p class="text-muted mb-4">Send us an email and we'll get back to you within 24 hours
                                    </p>
                                    <a href="mailto:contact@autolikerlive.com"
                                        class="btn-modern bg-green-600 text-white px-4 py-3 rounded-lg inline-flex items-center gap-2">
                                        <i class="bi bi-envelope"></i>Send Email
                                    </a>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>Average response: 2-4 hours
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Newsletter Signup -->
                        <div class="contact-card p-4 mt-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="fw-bold text-dark mb-2">
                                        <i class="bi bi-bell text-primary me-2"></i>Get notified about updates
                                    </h6>
                                    <p class="text-muted mb-0 small">Subscribe to receive notifications about new features
                                        and updates</p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <button class="btn-modern border border-[rgba(24,119,242,0.12)] text-[var(--fb-blue)] px-4 py-3 rounded-lg inline-flex items-center gap-2">
                                        <i class="bi bi-bell"></i>Notify Me
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>



    <a id="download-link" href="{{ route('apk.download') }}" class="d-none"></a>

    <script>
        console.log("Download page JavaScript loaded");
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM Content Loaded");
            const downloadBtn = document.getElementById('download-btn');
            console.log("Download button found:", downloadBtn);
            const fileLink = '{{ url('') }}/Download/{{ $json->link }}';
            console.log("File link:", fileLink);

            if (downloadBtn) {
                const initTimer = () => {
                    if (downloadBtn.classList.contains("disable-timer")) {
                        return location.href = fileLink;
                    }
                    let timer = downloadBtn.dataset.timer;
                    downloadBtn.classList.add("timer");
                    downloadBtn.innerHTML = `Your download will begin in <b>${timer}</b> seconds`;
                    const initCounter = setInterval(() => {
                        if (timer > 0) {
                            timer--;
                            return downloadBtn.innerHTML = `Download start in <b>${timer}</b> seconds`;
                        }
                        clearInterval(initCounter);

                        downloadBtn.parentNode.innerHTML =
                            `Download not starting? <a href="{{ route('apk.download') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Click here</a>`;
                        setTimeout(() => {
                            const hiddenLink = document.getElementById('download-link');
                            if (hiddenLink) {
                                hiddenLink.click();
                            }
                        }, 1000);

                        return;
                    }, 1000);
                }

                downloadBtn.addEventListener("click", function(e) {
                    console.log("Download button clicked!");
                    e.preventDefault();
                    initTimer();
                });
            }
        });
    </script>
    <x-ads></x-ads>
    <x-bottom-ad></x-bottom-ad>
@stop
{{-- <a href="mailto:rajeliker+subscribe@googlegroups.com?Subject=Subscription Request">Subscribe</a> --}}
