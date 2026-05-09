<!DOCTYPE html>
<html lang="en">

<head>
{{-- <script async src="https://js.onclckmn.com/static/onclicka.js" data-admpid="415541"></script> --}}

    <link rel="canonical" href="{{ url()->current() }}" />

    @php
        $routes = [
            'autoliker.dashboard',
            'autoliker.boost',
            'autoliker.view',
            'autoliker.earn',
            'autoliker.settings',
            'autoliker.free.likes',
            'autoliker.free.views',
            'autoliker.free.ig.views',
            'temp-mail',
            'messageView',
            'free-tiktok-views',
            'free-tiktok-likes',
        ];

    @endphp

    <meta charset="utf-8" />
    <meta name="monetag" content="81f11f1890e242b2ffa603ee1a3d9453">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="revisit-after" content="1 days" />
    <meta name="googlebot" content="index, follow" />
    <meta name="robots" content="all" />
    <meta name="author" content="AutolikerLive" />
    <title>@yield('title')</title>
    <meta name=description content="@yield('description')">
    <meta name="keywords"
        content="@hasSection('keywords')
@yield('keywords')
@else
auto liker, auto like, auto liker app, auto liker apk, auto reactions, facebook auto liker
@endif">
    <!-- Favicon-->

    @hasSection('favicons')
        @yield('favicons')
    @else
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.webp">
        <link rel="icon" type="image/webp" sizes="32x32" href="/images/favicons/favicon-32x32.webp">
        <link rel="icon" type="image/webp" sizes="16x16" href="/images/favicons/favicon-16x16.webp">
        <link rel="manifest" href="/images/favicons/site.webmanifest">
    @endif

    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Social Media Meta tags -->
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />


    <meta property="og:image"
        content="@hasSection('ogimage')
@yield('ogimage')@else{{ asset('images/graphic.webp') }}
@endif" />
    @vite(['resources/js/app.js'])

    @stack('styles')

    @yield('javascripts')
{{-- <script>(function(s){s.dataset.zone='10482447',s.src='https://gizokraijaw.net/vignette.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script> --}}

{{-- <script data-cfasync="false" type="text/javascript" id="clever-core">
/* <![CDATA[ */
    (function (document, window) {
        var a, c = document.createElement("script"), f = window.frameElement;

        c.id = "CleverCoreLoader99494";
        c.src = "https://scripts.cleverwebserver.com/ac8966c4ae58297b6e4841e100b070ca.js";

        c.async = !0;
        c.type = "text/javascript";
        c.setAttribute("data-target", window.name || (f && f.getAttribute("id")));
        c.setAttribute("data-callback", "put-your-callback-function-here");
        c.setAttribute("data-callback-url-click", "put-your-click-macro-here");
        c.setAttribute("data-callback-url-view", "put-your-view-macro-here");

        try {
            a = parent.document.getElementsByTagName("script")[0] || document.getElementsByTagName("script")[0];
        } catch (e) {
            a = !1;
        }

        a || (a = document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]);
        a.parentNode.insertBefore(c, a);
    })(document, window);
/* ]]> */
</script> --}}



</head>

<body class="d-flex flex-column
@hasSection('body-class')
@yield('body-class')
@else
bg-dark
@endif
">
    @yield('content')


    <!-- Footer-->
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; autolikerlive.com 2022</div>

                </div>
                <div class="col-auto">
                    <a class="link-light small" href="{{ url('privacy') }}">Privacy</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="{{ url('terms') }}">Terms</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="{{ url('contact') }}">Contact</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="{{ url('faq') }}">Faq</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // document.querySelectorAll('a').forEach(link => {
        //     link.addEventListener('click', (e) => {
        //         e.stopImmediatePropagation();
        //     }, true);
        // });
    </script>
    @yield('footer')
</body>

</html>
