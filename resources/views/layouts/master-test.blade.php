<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8" />
    <meta name="propeller" content="81f11f1890e242b2ffa603ee1a3d9453">
    <meta name="purpleads-verification" content="7d856f2ed0c693714381eb05" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    {{-- <meta name="verification" content="SQC28OJAEMDKT2496ZK2HUYNHAKM7E4H"> --}}
    <meta name="author" content="AutolikerLive" />
    <title>@yield('title')</title>
    <meta name=description content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="180x180"
        href="@hasSection('apple-icon')
{{ url('') }}@yield('apple-icon')
@else
/images/favicons/apple-touch-icon.webp
@endif">
    <link rel="icon" type="image/webp" sizes="32x32"
        href="@hasSection('32-icon')
{{ url('') }}@yield('32-icon')
@else
/images/favicons/favicon-32x32.webp
@endif">
    <link rel="icon" type="image/webp" sizes="16x16"
        href="@hasSection('16-icon')
{{ url('') }}@yield('16-icon')
@else
/images/favicons/favicon-16x16.webp
@endif">
    <link rel="manifest" href="/images/favicons/site.webmanifest">
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
    <!-- Bootstrap icons-->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet" /> --}}
    <!-- Core theme CSS (includes Bootstrap)-->
    @vite(['resources/js/app.js'])
    @stack('styles')

    @yield('javascripts')
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
    @yield('javascripts-bottom')
    <script>
        function setLanguage(lang) {
            let url = new URL(window.location.href);
            let pathSegments = url.pathname.split('/').filter(segment => segment !== ""); // Remove empty segments

            if (pathSegments[0] === "bn" || pathSegments[0] === "en") {
                pathSegments[0] = lang; // Replace existing language segment
            } else if (lang !== "en") {
                pathSegments.unshift(lang); // Add lang segment if not English
            }

            let newPath = "/" + pathSegments.join("/").toLowerCase();;
            url.pathname = newPath;
            window.location.href = url.href; // Reload with new language URL
        }

        // Detect and set current language in button
        let pathLang = window.location.pathname.split('/')[1].toLowerCase();
        if (pathLang === "bn") {
            document.getElementById('selectedLang').innerText = 'BN';
        } else {
            document.getElementById('selectedLang').innerText = 'EN';
        }
    </script>

    @yield('footer')
</body>

</html>
