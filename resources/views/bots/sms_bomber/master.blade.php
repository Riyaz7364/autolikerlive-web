<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L785B4T4H2"></script>
    <!-- Google Tag Manager -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-L785B4T4H2');
    </script>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
    <script src='//whephiwums.com/sdk.js' data-zone='9056915' data-sdk='show_9056915'></script>

    <meta charset="utf-8" />
    <meta name="propeller" content="81f11f1890e242b2ffa603ee1a3d9453">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="AutolikerLive" />
    <title>@yield('title')</title>
    <meta name=description content="@yield('description')">
    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.webp">
    <link rel="icon" type="image/webp" sizes="32x32" href="/images/favicons/favicon-32x32.webp">
    <link rel="icon" type="image/webp" sizes="16x16" href="/images/favicons/favicon-16x16.webp">
    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Social Media Meta tags -->
    <meta property="og:url" content="{{ url('') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="{{ asset('images/graphic.webp') }}" />

    @yield('javascripts')

</head>

<body class="d-flex flex-column bg-dark">



    @yield('content')


    <!-- Footer-->
    <footer class="bg-dark py-4 mt-auto d-none d-sm-block">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; autolikerlive.com 2024</div>
                </div>
                <div class="col-auto">
                    <a class="link-light small" href="{{ url('privacy') }}">Privacy</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="{{ url('terms') }}">Terms</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="{{ url('contact') }}">Contact</a>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
