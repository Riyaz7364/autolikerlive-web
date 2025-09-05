<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5DF95BC');
    </script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8" />
    <meta name="propeller" content="81f11f1890e242b2ffa603ee1a3d9453">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <meta name=description content="@yield('description')">
    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('images/favicons/apple-touch-icon.webp') }}">
    <link rel="icon" type="image/webp" sizes="32x32"
        href="{{ secure_asset('images/favicons/favicon-32x32.webp') }}">
    <link rel="icon" type="image/webp" sizes="16x16"
        href="{{ secure_asset('images/favicons/favicon-16x16.webp') }}">
    <link rel="manifest" href="{{ secure_asset('images/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ secure_asset('images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Social Media Meta tags -->
    <meta property="og:url" content="{{ secure_url('') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content="{{ secure_asset('images/graphic.webp') }}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ secure_asset('css/styles.css') }}" rel="stylesheet" />

</head>

<body class="d-flex flex-column bg-dark">



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
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="js/app.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
