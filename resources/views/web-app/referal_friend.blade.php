@extends('web-app.master')
@section('title', 'FBSUB - Invite Frens')
@section('description', '')
@section('javascripts')
    <script src="https://telegram.org/js/telegram-web-app.js"></script>
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
    </style>
@stop
@section('content')


    <div class="container">
        <div class="emoji">👫👬</div>
        <div class="title">Invite Frens</div>

        <div class="claim-box">
            <div style="
            display: flex;
            justify-content: center;

        ">
                <img id="logo" style="width: 20px; height:20px"
                    src="https://www.autolikerlive.com/storage/autolikerlivetoken_own.webp" alt="Logo">
                &nbsp;{{ $refs['data']['claim'] }}
            </div>
            <form action="{{ route('referral_claim') }}" method="post">
                @csrf

                <button class="claim-btn" {{ $refs['data']['claim'] > 0 ? '' : 'disabled' }}>Claim</button>
            </form>
        </div>

        <p>Invite friend and get 30 Follow Credits from buddies from referrals<br>Get credits for each fren.</p>
        <button id="shareButton" class="invite-btn">Invite a fren</button>

        <div class="frens" style="margin-bottom: 80px">
            @foreach ($refs['data']['refs'] as $ref)
                <div class="fren-item">
                    <span>{{ $ref['name'] }}</span>

                </div>
            @endforeach

        </div>


    </div>

    @include('web-app.bottom_navbar')
    <script>
        document.getElementById("shareButton").addEventListener("click", function() {
            var referralLink =
                "https://t.me/autolikerlive_bot/Fbsub?start={{ $refs['data']['id'] }}"; // replace with your actual referral link

            // Define your message with special characters and line breaks
            var message = `
🚀 Boost Your Facebook Posts with Auto Likes! 👍
💬 Want more likes on your Facebook posts? Use the Facebook Auto Liker Bot to get instant likes! 💥 Follow these simple steps to start boosting your posts in seconds:\n

🔗 How it works:\n
🔑 Login with your Facebook Access Token.
📋 Send the Facebook post link you want to boost.
💡 Quick, Easy, and Safe – likes. Try it out today!
⚡️ Refer Friends and Earn Followers 🎁🎁🎁.
    `;

            // URL encode the message to make it safe for sharing via a link
            var encodedMessage = encodeURIComponent(message);

            // Construct the Telegram share link
            var telegramUrl = `https://t.me/share/url?url=${referralLink}&text=${encodedMessage}`;

            // Open the Telegram share link
            window.open(telegramUrl, "_blank");

        });
    </script>
@stop
