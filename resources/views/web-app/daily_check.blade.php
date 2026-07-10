@extends('web-app.master')
@section('title', 'FBSUB - Daily Check-In')
@section('description', '')
@section('javascripts')
    <script src='//niphaumeenses.net/vignette.min.js' data-zone='8447136' data-sdk='show_8447136'></script>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
            border-radius: 10px;
        }

        .title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .emoji {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .claim-box {
            background-color: #333;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .claim-btn {
            background-color: #28a4c7;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 18px;
            margin-top: 10px;
        }

        .claim-btn:disabled {
            background-color: #444;
            color: #aaa;
            opacity: 0.5;
        }

        .frens {
            margin: 20px 0;
        }

        .fren-item {
            display: flex;
            justify-content: space-between;
            background-color: #222;
            padding: 10px 15px;
            border-radius: 10px;
            margin: 10px 0;
        }

        .invite-btn {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .footer div {
            flex: 1;
            padding: 10px;
            background-color: #333;
            margin: 5px;
            border-radius: 10px;
            font-size: 14px;
        }

        .profile {
            width: 31px;
            display: inline-block;
            /* height: 3.5rem; */
            vertical-align: top;
            border-radius: 50%;
        }

        .locked {
            opacity: .25 !important;

        }

        .completed {
            color: lawngreen;
            background: lawngreen;
            padding-left: 2px;
            padding-right: 2px;
        }
    </style>
@stop
@section('content')
    <div id="applixir_vanishing_div" hidden>
        <iframe id="applixir_parent"></iframe>
    </div>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <p class="h3">Daily Check-in</p>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            @foreach ($rewards as $reward)
                <div id="reward-{{ $reward['day'] }}" class="reward {{ $reward['css'] }} {{ $reward['status'] }} my-3">

                    <div class="text-center">
                        <div class="card-header bg-secondary">
                            {{ $reward['text'] }}
                        </div>
                        <div class="">
                            <nav class=" navbar-dark bg-dark">
                                <div class="py-2">
                                    <span>
                                        <img src="https://www.autolikerlive.com/images/credits/like-32.webp"
                                            style="display: inline-block; width: 25px; vertical-align: top; vertical-align: text-bottom;"
                                            alt="like credit icon">
                                        <span class="navbar-brand">{{ $reward['like'] }}</span>
                                    </span>
                                    <span>
                                        <img class="profile ms-1"
                                            src="https://www.autolikerlive.com/storage/autolikerlivetoken_own.webp"
                                            alt="">
                                        <span class="navbar-brand">{{ $reward['follow'] }}</span>
                                    </span>
                                </div>
                            </nav>
                        </div>
                        <div class="card-footer text-white bg-secondary">
                            @if ($reward['status'] == 'locked')
                                🔒
                            @elseif($reward['status'] == 'enabled')
                                <button type="submit" class="btn btn-warning btn-fill"
                                    onclick="showAd('{{ $reward['day'] }}')">Claim
                                    Reward</button>
                            @elseif($reward['status'] == 'completed')
                                ✔️
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach


        </div>


    </div>

    <form action="{{ route('claim_daily_reward') }}" method="post" id="rewardForm" class="d-none">
        <input type="hidden" name="user_id" value="{{ $uuid }}">
        @csrf
    </form>


    @if (session('reload'))
        {{-- <script>
            window.location.reload();
        </script> --}}
    @endif
    @include('web-app.bottom_navbar')
    <script>
        function showAd(index) {
            var rewardDiv = document.getElementById("reward-" + index);
            rewardDiv.classList.add('disabled');
            show_8447136().then(() => {
                rewardDiv.classList.remove('disabled');
                rewardDiv.classList.add('completed');

                let footer = rewardDiv.querySelector('.card-footer');

                footer.innerHTML = '✔️';
                document.getElementById('rewardForm').submit();
            }).catch((error) => {
                rewardDiv.classList.add('disabled');
                alert('Ad failed or was skipped:', error);
            });

        }

        // Optional CSS to show disabled state
        const style = document.createElement('style');
        style.innerHTML = `
        .reward.disabled {
            pointer-events: none; /* Prevent interaction */
            opacity: 0.6; /* Visual cue that the div is disabled */
        }
        .reward.completed {
            background-color: lightgreen; /* Completed reward */
        }
    `;
        document.head.appendChild(style);
    </script>
@stop
