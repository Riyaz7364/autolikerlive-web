@extends('layouts.master')

@section('title', 'Free Auto Liker, Facebook Tools & Social Media Services')
@section('description', 'Free Facebook auto liker, auto reactions, auto followers, page liker, Instagram comment liker, TikTok tools, SMS bomber, and more social media tools. Fast, safe, and free.')
@section('keywords', 'auto liker, facebook auto liker, free facebook liker, auto reactions, facebook auto followers, page liker, instagram comment liker, tiktok auto liker, sms bomber, social media tools')

@section('styles')
    <style>
        .tools-hero {
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            padding: 4rem 0;
            color: white;
            text-align: center;
            margin-bottom: 3rem;
        }
        .tools-hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .tools-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        .tool-category-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2a2a72;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #009ffd;
            display: inline-block;
        }
        .tool-card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }
        .tool-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            color: white;
        }
        .tool-card h5 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .tool-card p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .tool-card .btn {
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="tools-hero">
        <h1>Free Social Media Tools</h1>
        <p>Auto liker, auto followers, auto reactions, and more. All tools are free, safe, and work without survey.</p>
    </div>

    <div class="mb-5">
        <div class="tool-category-title">Facebook Tools</div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">👍</div>
                        <h5>Facebook Auto Liker</h5>
                        <p>Get up to 1000 likes on your Facebook posts instantly. Free and safe auto liker service.</p>
                        <a href="{{ url('auto-liker-1000-likes') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">⚡</div>
                        <h5>Facebook Auto Reactions</h5>
                        <p>Add custom reactions (love, wow, haha, etc.) to your Facebook posts automatically.</p>
                        <a href="{{ url('facebook-auto-reaction') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">📄</div>
                        <h5>Facebook Page Liker</h5>
                        <p>Boost your Facebook page likes with our free page liker tool. Grow your page audience.</p>
                        <a href="{{ url('facebook-page-liker') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">👥</div>
                        <h5>Facebook Auto Followers</h5>
                        <p>Get free Facebook followers instantly. Increase your profile followers with one click.</p>
                        <a href="{{ url('facebook-auto-followers') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">🤝</div>
                        <h5>Auto Friend Request</h5>
                        <p>Send automatic friend requests on Facebook. Grow your friend list quickly.</p>
                        <a href="{{ url('auto-friend-request') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-ads.leaderboard />
    <x-ads.mobile-banner />

    <div class="mb-5">
        <div class="tool-category-title">Instagram Tools</div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">📸</div>
                        <h5>Instagram Comment Liker</h5>
                        <p>Get free likes on your Instagram comments. Boost engagement on your posts.</p>
                        <a href="{{ url('instagram-comment-liker') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">❤️</div>
                        <h5>Free Instagram Likes</h5>
                        <p>Get free Instagram likes on your posts and photos. Fast delivery, no login required.</p>
                        <a href="{{ route('free-instagram-likes') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <div class="tool-category-title">TikTok Tools</div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">🎬</div>
                        <h5>Free TikTok Views</h5>
                        <p>Get free TikTok views on your videos. Boost your video views instantly.</p>
                        <a href="{{ route('free-tiktok-views') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">🎵</div>
                        <h5>Free TikTok Likes</h5>
                        <p>Get free TikTok likes on your videos. Increase engagement and visibility.</p>
                        <a href="{{ route('free-tiktok-likes') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <div class="tool-category-title">Utility Tools</div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">💬</div>
                        <h5>SMS Bomber</h5>
                        <p>Send multiple SMS messages at once. Useful for testing SMS delivery systems.</p>
                        <a href="{{ route('sms-bomber') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">📧</div>
                        <h5>Temp Mail</h5>
                        <p>Get a temporary email address. Protect your privacy with disposable email.</p>
                        <a href="{{ route('temp-mail') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">🆔</div>
                        <h5>Find My FB ID</h5>
                        <p>Find your Facebook profile ID quickly using your profile URL.</p>
                        <a href="{{ url('findmyfbid') }}" class="btn btn-primary">Use Tool →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <div class="tool-category-title">Games</div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="tool-card card">
                    <div class="card-body p-4">
                        <div class="tool-card-icon">🎮</div>
                        <h5>Facebook Image Games</h5>
                        <p>Create fun image games, profile picture frames & viral photo cards for Facebook. Play free!</p>
                        <a href="{{ url('/') }}" class="btn btn-primary">Play Games →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
