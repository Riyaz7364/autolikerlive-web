@extends('web-app.master')
@section('title', 'FBSUB - Time Bonus')

@section('javascripts')
    <script>
        (function(d, z, s) {
            s.src = 'https://' + d + '/400/' + z;
            try {
                (document.body || document.documentElement).appendChild(s)
            } catch (e) {}
        })('nunsourdaultozy.net', 6773791, document.createElement('script'))
    </script>



@stop

@section('content')

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            color: #444;
            background: #ecf0f1;
            font: 300 18px/18px Roboto, sans-serif;
        }

        *,
        :after,
        :before {
            box-sizing: border-box
        }

        .pull-left {
            float: left
        }

        .pull-right {
            float: right
        }

        .clearfix:after,
        .clearfix:before {
            content: '';
            display: table
        }

        .clearfix:after {
            clear: both;
            display: block
        }

        .clock:before,
        .count:after {
            content: '';
            position: absolute;
        }

        .clock-wrap {
            margin: auto;
            width: 240px;
            height: 140px;
            margin-top: 60px;
            position: relative;
            border-radius: 50px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, .15);
        }

        .clock {
            top: 50%;
            left: 50%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            position: absolute;
            margin-top: -90px;
            margin-left: -90px;
            background-color: #feeff4;

        }

        .clock:before {
            top: 50%;
            left: 50%;
            width: 120px;
            height: 120px;
            margin-top: -60px;
            margin-left: -60px;
            border-radius: inherit;
            background-color: #ec366b;
            box-shadow: 0 0 15px rgba(0, 0, 0, .15), 0 0 3px rgba(255, 255, 255, .75) inset;
            /*border:1px solid rgba(255,255,255,.1);*/
        }

        .count {
            width: 100%;
            color: #fff;
            height: 100%;
            padding: 50px;
            font-size: 32px;
            font-weight: 500;
            line-height: 50px;
            position: absolute;
            text-align: center;
            align-content: center;
        }

        .count:after {
            width: 100%;
            display: block;
            font-size: 18px;
            font-weight: 300;
            line-height: 18px;
            text-align: center;
            position: relative;
        }

        .count.sec:after {
            content: 'sec'
        }

        .count.min:after {
            content: 'min'
        }

        .action {
            margin: auto;
            max-width: 200px;
        }

        .action .input {
            margin-top: 30px;
            position: relative;
        }

        .action .input-num {
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 60px;
        }

        .action .input-btn {
            top: 0;
            right: 0;
            color: #fff;
            border: none;
            border: none;
            padding: 12px;

            border-radius: 60px;
            background-color: #ec366b;
            text-transform: uppercase;
        }

        .tbl {
            display: table;
            width: 100%
        }

        .tbl .col {
            display: table-cell
        }
    </style>



    <style>
        .ad_place {
            height: 60px;
        }

        .profile {
            width: 2.5rem;
            /* height: 3.5rem; */
            border-radius: 50%;
        }

        .heading-1 {
            font-size: 1.7rem;
        }

        .col-25 {
            flex: 0 0 auto;
            width: 19%
        }
    </style>


    <div class="content-wrapper">
        <div class="page-header mt-6">

            <div class="row ms-2" style="align-items: center;">
                <div class="col-25">
                    <img class="profile ms-2" src="{{ $user->image }}" alt="">
                </div>
                <div class="col mt-2">
                    <h3 class="page-title">
                        theRiyazSaifi
                    </h3>
                </div>
                <div class="col"></div>
            </div>
            <div class="row text-center">
                <div class="col-12">
                    <div class="ad_place"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">

                    <div class="col-12 d-flex justify-content-center me-4" style="align-items: center;">
                        <x-like-icon :size="64" style="width: 40px; vertical-align: top;" />
                        <span class="text-white heading-1"> &nbsp;{{ $user->credits->FB }}</span>
                    </div>

                </div>
            </div>
            <dic class="col-12">
                <div class="clock-wrap">
                    <div class="clock pro-0">
                        <span class="count" style="line-height: inherit;margin-top: 5px;"><svg class="ms-2"
                                xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                                class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                <path
                                    d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z" />
                            </svg></span>
                    </div>
                </div>
            </dic>
            <dic class="col-12">
                <div class="action">
                    <div class="input d-grid">
                        <input data-action="start" class="btn input-btn" type="button" value="Start">
                    </div>
                </div>
            </dic>

            <div class="admoloBanner"
                data-publisher="eyJpdiI6InBhSHlIeUJteUs0YWVVS1ZYMHNUTVE9PSIsInZhbHVlIjoieFdoN0VneWdHQURDaW9IWFVqQWcrUT09IiwibWFjIjoiMWE4NmY3YmVhOGUwNmUxNWM1NGVhN2FkOWE2Yjc1YzZmZTkzM2M4ZTVlMTAwNmZhMTU2Y2NkN2I4MTRkZWI5ZCIsInRhZyI6IiJ9"
                data-adsize="560x315"></div>

        </div>
    </div>


    @include('web-app.bottom_navbar')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        var $step = 1;
        var $loops = Math.round(100 / $step);
        var $increment = 360 / $loops;
        var $half = Math.round($loops / 2);
        var $barColor = '#ec366b';
        var $backColor = '#feeff4';
        var countdownActive = false; // Flag to track countdown status
        var remainingTime = 0;

        var clock = {
            interval: null,
            init: function() {
                $('.input-btn').click(function() {
                    switch ($(this).data('action')) {
                        case 'claim':
                            // Handle claim logic here (e.g., via AJAX)
                            claimBonus();
                            clock.stop();
                            clock.start(remainingTime);
                            countdownActive = true;
                            $('.input-btn').val('Running').prop('disabled', true);
                            break;
                    }
                });
            },
            start: function(sec) {
                console.log(t);
                var pie = 1;
                var num = 0;
                var t = sec / 60;
                var min = t ? t : 1;
                var lop = sec;
                console.log(sec);
                $('.count').text("🚀");
                $('.input-btn').val('Running').prop('disabled', true); // Change button to running state
                // pie = lop - 10;
                clock.interval = setInterval(function() {
                    sec = sec - 1;
                    if (sec <= 0) {
                        clearInterval(clock.interval);
                        $('.count').html(
                            "<span>{{ $timebonus['bonus'] }}</span><br><span style='font-size: small;'>Claim</span></span>"
                        );
                        $('.clock').removeAttr('style');
                        countdownActive = false;

                        // Show "Claim" button when countdown finishes
                        $('.input-btn').val('Claim').prop('disabled', false).data('action', 'claim');
                    } else {
                        var remainingMinutes = Math.floor(sec / 60);
                        var remainingSeconds = ((sec % 60).toString().length < 2) ? "0" + (sec % 60) : (
                            sec % 60);
                        $('.count').text(remainingMinutes + ':' + ('0' + remainingSeconds).slice(-2));

                        pie = pie + (100 / lop);
                        updateClockStyle(pie);
                    }
                }, 1000);
            },
            stop: function() {
                clearInterval(clock.interval);
                $('.count').text(0);
                $('.clock').removeAttr('style');
            }
        };

        function claimBonus() {
            $.ajax({
                type: 'GET',
                url: '{{ secure_url(route('claimTimeBonus', [], false)) }}',
                data: {
                    _token: '{{ csrf_token() }}',

                },
                success: function(response) {
                    if (response.success == true) {
                        $('.input-btn').val('Running').prop('disabled', true);
                        remainingTime = response.timer;
                        clock.start(remainingTime);
                        location.reload();
                    } else {
                        alert("Something is wrong!");

                    }
                },
                error: function(xhr, status, error) {
                    alert("Something is wrong!");
                }
            });
        }

        $(function() {
            if ({{ $timebonus['timer'] <= 0 ? 'true' : 'false' }}) {
                $('.input-btn').val('Running').prop('disabled', true);
                remainingTime = "{{ $timebonus['timer'] }}";
                clearInterval(clock.interval);
                $('.count').html(
                    "<span>{{ $timebonus['bonus'] }}</span><br><span style='font-size: small;'>Claim</span></span>"
                );
                $('.clock').removeAttr('style');
                countdownActive = false;
                $('.input-btn').val('Claim').prop('disabled', false).data('action', 'claim');
            } else {
                $('.input-btn').val('Running').prop('disabled', true);
                remainingTime = {{ $timebonus['timer'] }};

                clock.start(remainingTime);
            }

            clock.init();
        });

        function updateClockStyle(pie) {
            var $i = (pie.toFixed(2).slice(0, -3)) - 1;
            if ($i < $half) {
                var $nextdeg = (90 + ($increment * $i)) + 'deg';
                $('.clock').css({
                    'background-image': 'linear-gradient(90deg,' + $backColor +
                        ' 50%,transparent 50%,transparent),linear-gradient(' + $nextdeg +
                        ',' + $barColor + ' 50%,' + $backColor + ' 50%,' + $backColor + ')'
                });
            } else {
                var $nextdeg = (-90 + ($increment * ($i - $half))) + 'deg';
                $('.clock').css({
                    'background-image': 'linear-gradient(' + $nextdeg + ',' + $barColor +
                        ' 50%,transparent 50%,transparent),linear-gradient(270deg,' +
                        $barColor + ' 50%,' + $backColor + ' 50%,' + $backColor + ')'
                });
            }
        }
    </script>


@stop
