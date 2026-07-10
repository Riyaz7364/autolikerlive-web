<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no" />
    <meta name="revisit-after" content="1 days" />
    <meta name="googlebot" content="index, follow" />
    <meta name="robots" content="all" />
    <meta name="author" content="AutolikerLive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    <title>@yield('title') - Fun Facebook Image Games</title>
    <meta name="description" content="@yield('description', 'Create and share fun Facebook image games. Free entertainment games for Facebook users.')">
    <meta name="keywords" content="@hasSection('keywords')@yield('keywords')@else facebook games, fun games, image games, facebook photo maker, entertainment games @endif">

    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="@hasSection('ogimage')@yield('ogimage')@else{{ asset('images/graphic.webp') }}@endif" />

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.webp">
    <link rel="icon" type="image/webp" sizes="32x32" href="/images/favicons/favicon-32x32.webp">
    <link rel="icon" type="image/webp" sizes="16x16" href="/images/favicons/favicon-16x16.webp">

    @vite(['resources/js/game-app.js'])
    @stack('styles')
    @yield('javascripts')
</head>
    <body>
        <x-navbar />
        <main>
            <div class="container">
                <div class="blog-layout">
                    <div class="blog-main">
                        @yield('content')
                    </div>
                    <aside class="blog-sidebar">
                        @hasSection('sidebar')
                            @yield('sidebar')
                        @else
                            <div class="widget">
                                <h3>⚠️ Disclaimer</h3>
                                <p>These games are for <strong>entertainment purposes only</strong>. All images are auto-generated and do not reflect real traits, abilities, or facts.</p>
                            </div>

                            <div class="widget">
                                <h3>🔧 Free Tools</h3>
                                <div class="flex flex-col gap-8">
                                    <a href="{{ route('free-tiktok-views') }}">TikTok Views</a>
                                    <a href="{{ route('free-tiktok-likes') }}">TikTok Likes</a>
                                    <a href="{{ route('free-instagram-likes') }}">Instagram Likes</a>
                                    <a href="{{ route('sms-bomber') }}">SMS Bomber</a>
                                    <a href="{{ route('temp-mail') }}">Temp Mail</a>
                                    <a href="{{ url('services') }}">All Tools →</a>
                                </div>
                            </div>

                            <div class="widget">
                                <h3>🎮 Quick Links</h3>
                                <div class="flex flex-col gap-8">
                                    <a href="{{ url('/') }}">All Games</a>
                                    <a href="{{ url('/download') }}">⬇️ Download AutoLiker app</a>
                                    <a href="{{ url('privacy') }}">Privacy Policy</a>
                                    <a href="{{ url('terms') }}">Terms of Service</a>
                                    <a href="{{ url('contact') }}">Contact Us</a>
                                </div>
                            </div>

                            @if (isset($tags) && count($tags) > 0)
                                <div class="widget">
                                    <h3>🏷️ Tags</h3>
                                    <div class="flex flex-wrap gap-6">
                                        @foreach ($tags as $tag)
                                            @if ($tag->link != null)
                                                <a href="{{ url($tag->link) }}" class="tag-pill">{{ $tag->name }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </aside>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="footer-links">
                    <a href="{{ url('/') }}">Games</a>
                    <a href="{{ url('services') }}">Tools</a>
                    <a href="{{ url('privacy') }}">Privacy</a>
                    <a href="{{ url('contact') }}">Contact</a>
                    <a href="{{ url('terms') }}">Terms</a>
                </div>
                <div class="footer-copy">
                    &copy; autolikerlive.com &mdash; For entertainment purposes only.
                </div>
            </div>
        </footer>

        @stack('footer')
        @yield('footer')
    </body>
    </html>
