<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>

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
    <!-- End Google Tag Manager -->
    <script>
        (function(d, z, s) {
            s.src = 'https://' + d + '/400/' + z;
            try {
                (document.body || document.documentElement).appendChild(s)
            } catch (e) {}
        })('outsliggooa.com', 6773791, document.createElement('script'))
    </script>
    <script src="https://tobaltoyon.com/pfe/current/tag.min.js?z=5337106" data-cfasync="false" async></script>
    <script>
        (function(d, z, s) {
            s.src = 'https://' + d + '/401/' + z;
            try {
                (document.body || document.documentElement).appendChild(s)
            } catch (e) {}
        })('ofleafeona.com', 6412739, document.createElement('script'))
    </script>


    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <!-- theme meta -->
    <meta name="theme-name" content="reporter" />

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="/wordpress/plugins/bootstrap/bootstrap.min.css">

    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="/wordpress/css/style.css">
    <script src="/wordpress/plugins/jquery/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    @yield('javascripts')
</head>

<body>

    @yield('content')


    <footer class="bg-dark mt-5">
        <div class="container section">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <ul class="p-0 d-flex navbar-footer mb-0 list-unstyled">
                        <li class="nav-item my-0"> <a class="nav-link" href="{{ url('privacy') }}">Privacy Policy</a>
                        </li>
                        <li class="nav-item my-0"> <a class="nav-link" href="{{ url('terms') }}">Terms Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </footer>


    <!-- # JS Plugins -->
    <script src="/wordpress/plugins/bootstrap/bootstrap.min.js"></script>

    <!-- Main Script -->
    <script src="/wordpress/js/script.js"></script>
    <script data-cfasync="false" type="text/javascript" id="clever-core">
        /* <![CDATA[ */
        (function(document, window) {
            var a, c = document.createElement("script"),
                f = window.frameElement;

            c.id = "CleverCoreLoader83571";
            c.src = "https://scripts.cleverwebserver.com/773e4bd3ebb5faa0a558dd77bec24eea.js";

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
    </script>


</body>

</html>
