@extends('layouts.master-iframe')

@section('title', 'TikTok Auto Views - Get Unlimited Free Tiktok Views every 15 minutes')
@section('description', 'Boost your TikTok visibility effortlessly with TikTok Auto Views! Enjoy unlimited free views
    every 15 minutes for enhanced engagement and reach.')
@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>



@stop
@section('content')
    <style type="text/css">
        .login-with-google-btn {
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 42px;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 14px 15px;
        }

        .login-with-google-btn:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .login-with-google-btn:active {
            background-color: #eeeeee;
        }

        .login-with-google-btn:focus {
            outline: none;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
        }

        .login-with-google-btn:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            cursor: not-allowed;
        }

        .temp-emailbox-text p {
            color: #7a7c80;
            font-size: 14px !important;
            font-family: 'Roboto Mono', monospace !important;
            font-weight: 500 !important;
            padding: 0;
            margin: 0;
        }

        .border-dashes {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='10' ry='10' stroke='%2365656557' stroke-width='3' stroke-dasharray='10' stroke-dashoffset='0' stroke-linecap='round'/%3e%3c/svg%3e");
            border-radius: 10px;
        }

        .bg-light h4,
        p {
            color: black
        }

        .infoicon {
            color: #00b3fe;
            font-size: 60px;
            padding: 15px;
        }

        .tiktokIcon {
            color: white;
        }

        .emoji-size {
            width: 3rem;
        }

        @media only screen and (max-width: 600px) {
            .max-width {
                width: 100%
            }
        }
    </style>
    @php
        $reactions = [
            'like' => 1,
            'love' => 2,
            'care' => 16,
            'haha' => 4,
            'wow' => 3,
            'sad' => 7,
            'engry' => 8,
        ];
    @endphp

    <header class="bg-dark py-5">
        <div class="container pxc-5">
            <div class="row gx-5 align-items-center justify-content-center">

                <div class="col-md-10 col-lg-6 col-sm-12 pxc-5">
                    <h1 class="h5 text-center">Get 100 free TikTok views every 15 minutes.</h1>
                    <div class="border-dashes p-3 justify-content-center">
                        <h2 class="text-center text-white justify-content-center p-3 h6">Boost Your <strong>TikTok</strong>
                            Presence: Enjoy 100 Free Auto Views Every 15 Minutes!</h2>
                        <form method="post" action="{{ route('free-tiktok-views-post-iframe') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>{{ $errors->first() }}</li>
                                    </ul>
                                </div>
                            @endif
                            <div class="input-group mb-3">
                                <input type="text" name="video_id" class="form-control"
                                    placeholder="Paste your video link" aria-label="Paste your video link"
                                    aria-describedby="basic-addon2">

                                <div class="input-group-append">
                                    <button id="sendViewsBtn" class="btn btn-primary" type="submit">Send Views</button>
                                </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LeBNncpAAAAAG1pYjOKMDCSTQBJY40kxObBFX_o"></div>
                        </form>
                        <div class="row pt-4 px-5 text-center">
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <div id="countdown" class="col text-white border h5 rounded p-1 px-2">Ready</div>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>
                            <span class="col mt-1"><i class="bi bi-tiktok tiktokIcon"></i></span>

                        </div>
                        <div id="success_msg"></div>

                    </div>

                    <div class="temp-emailbox-text text-center my-2">
                        <p class="text-dark pt-2 text-white">I Understand and Agree with <a class="link"
                                href="https://freetiktokviews.com/privacy-policy/">Privacy Policy</a> and <a class="link"
                                href="https://freetiktokviews.com/terms-and-conditions/">Terms of Uses</a></p>
                    </div>

                </div>
            </div>


        </div>


    </header>

    <script>
        // Assuming $timeLeft is the total seconds
        var timeLeft = {{ $timeLeft }};
        var sendViewsBtn = document.getElementById('sendViewsBtn');

        function updateTimer() {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('countdown').innerHTML = formattedTime;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = `Ready`;
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                timeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(updateTimer, 1000);
            }
        }


        var mytimeLeft = 60;
        $(document).ready(function() {
            var msg = "{{ Session::has('sucess') }}";
            if (msg) {
                successMsg();
            }

        });

        function successMsg() {
            var minutes = Math.floor(mytimeLeft / 60);
            var seconds = mytimeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('success_msg').innerHTML = '<p class="text-center text-white">Please wait: ' +
                formattedTime + '</p>';

            if (mytimeLeft <= 0) {
                document.getElementById('success_msg').innerHTML = `<div class="alert alert-success">
                                                                        <ul>
                                                                            <li>{{ Session::get('sucess') }}</li>
                                                                        </ul>
                                                                    </div>`;
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                mytimeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(successMsg, 1000);
            }
        }

        updateTimer();
    </script>
@stop
