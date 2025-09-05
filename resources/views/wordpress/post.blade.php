@extends('wordpress.master')
@section('title', $tech_post->title)
@section('description', $tech_post->description)

@section('content')
    <style>
        body {
            padding-bottom: 0px !important;
        }

        .d-none {
            display: none;
        }

        .progress-ring {

            display: block;
            margin: 0 auto;
        }

        .progress-ring-circle {
            fill: none;
            stroke: #3fd0c9;
            stroke-width: 10;
            stroke-dashoffset: 0;
            stroke-dasharray: 436;
            transition: stroke-dashoffset 1s ease-in-out;
            transform-origin: center;
            transform: rotate(-90deg);
        }

        .outer-red-rectangle {
            border: 4px solid red;
        }

        .progress-text {
            font-size: 24px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 22px;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>

    <header class="navigation">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light px-0">
                <a class="navbar-brand order-1 py-0" href="{{ url('tech') }}">
                    <h1>TikTok Money Counter</h1>
                </a>
                <div class="navbar-actions order-3 ml-0 ml-md-4">
                    <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
                        data-target="#navigation"> <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12 col-lg-8">
                <main class="container-fluid">
                    <div class="row justify-content-center"
                        style="margin-top:0;margin-bottom:0;padding-top:80px;padding-bottom:80px;">
                        <div class="col-md-10">
                            <h1 class="text-center">{{ $tech_post->title }}</h1>
                            <p class="text-muted text-center">{{ $tech_post->created_at }}</p>
                        </div>
                    </div>

                    <small class="text-muted">
                        @php
                            $tags = explode(',', $tech_post->tags);
                        @endphp
                        @foreach ($tags as $tag)
                            <span class="btn btn-sm btn-danger p-1"
                                style="font-size: 8px; margin-bottom: 5px;">{{ $tag }}</span>
                        @endforeach
                    </small>

                    {!! $tech_post->content !!}
                    <!-- Repeat similar structure for other sections -->

                    <div class="outer-red-rectangle text-center p-2 d-none" id="final_step">
                        <br>
                        <cl style="color: purple;font-size:24px;">
                            <b>Step: 1/1</b>
                            <br>
                            <b style="color: black;">Well done! You're ready to continue!</b>
                            <br>
                        </cl>
                        <form id="userForm" action="{{ route('submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="session" value="{{ $cookie }}">
                            <div class="g-recaptcha" data-sitekey="6LfGNKYpAAAAAN7u9dJAyXLSvIWgttSPNhep0Rpw"></div>
                            <button type="submit" class="btn btn-primary">Continue</button>
                        </form>

                    </div>

                </main>

            </div>
        </div>
    </div>
    <script>
        // Set the countdown time in seconds
        const countdownTime = {{ $timer }};

        // Initialize countdown variables
        let timeLeft = countdownTime;
        let timerInterval;

        // Calculate the total length of the circle\'s perimeter
        const perimeter = 2 * Math.PI * 55; // r="55"

        function updateCountdown() {
            const circle = document.querySelector(".progress-ring-circle");
            const text = document.querySelector(".progress-text");

            // Calculate the stroke dash offset based on time remaining
            const progress = (countdownTime - timeLeft) / countdownTime;
            const offset = perimeter * progress;

            // Update the stroke dash offset to animate the ring
            circle.style.strokeDashoffset = perimeter - offset;

            // Update the text content with the time left
            text.textContent = timeLeft;

            timeLeft--;

            // Check if countdown is complete
            if (timeLeft < 0) {
                clearInterval(timerInterval);
                // Optionally hide or change the appearance of the ring when the countdown is complete
                circle.style.display = "none";
                text.textContent = "Continue is on the bottom of the page!!";
                document.querySelector(".progress-ring").style.width = "100%";
                $("#final_step").removeClass("d-none");

                var element = document.getElementById("final_step");
                if (element) {
                    var offsetTop = element.offsetTop;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: "smooth"
                    });
                }
            }
        }

        $(document).ready(function() {
            var showAd = {{ $showAd }};
            if (showAd) {
                $('#step_one').removeClass('d-none');
                $('body').css('background', 'blue');
                $('main').css('background', 'white');
                $('header').css('display', 'none');
                // Start the countdown
                timerInterval = setInterval(updateCountdown, 1000);
                updateCountdown();

            }
        });
    </script>

    <div id="sfc57fl576te1n9pxcyubn1crb54xmuh828"></div>
    <script type="text/javascript"
        src="https://counter8.optistats.ovh/private/counter.js?c=57fl576te1n9pxcyubn1crb54xmuh828&down=async" async>
    </script><br><noscript><img
            src="https://counter8.optistats.ovh/private/freecounterstat.php?c=57fl576te1n9pxcyubn1crb54xmuh828"
            border="0" title="website hits counter" alt="website hits counter"></noscript>
@stop
