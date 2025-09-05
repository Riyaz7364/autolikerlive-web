<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://telegram.org/js/telegram-web-app.js"></script>

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

    @vite(['resources/js/app.js'])

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name=description content="@yield('description')">

    @yield('javascripts')


    <script></script>
</head>

<body>
    @yield('content')
</body>

</html>
