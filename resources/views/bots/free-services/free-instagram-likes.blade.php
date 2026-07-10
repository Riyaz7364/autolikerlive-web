@extends('bots.free-services.master')
@section('title', 'Free TikTok Likes - BOT')
@section('description', 'Get free TikTok likes from us and the user-friendly TikTok likes service we provide. We are the
    best TikTok likes service provider on the internet.')

@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style type="text/css">
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

        @media only screen and (min-width: 601px) {
            .max-width {
                width: 512px
            }
        }

        .app-bar {
            display: flex;
            align-items: center;
            background-color: #0088cc;
            /* Telegram Blue */
            color: white;
            padding: 12px 16px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Back Button */
        .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .back-button img {
            width: 24px;
            height: 24px;
        }

        /* Profile Section */
        .profile {
            text-align: center;
            margin-top: 20px;
        }

        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #0088cc;
        }
    </style>

@stop

@section('content')

    <main class="flex-shrink-0">
        <section class="bg-dark">
            <div class="container pxc-5">
                <div class="row">

                    <div class="col-12">
                        <!-- Profile Section -->
                        <div class="profile">
                            <img id="telegram-photo" src="https://cdn-icons-png.flaticon.com/512/3273/3273898.png"
                                alt="Profile Picture">
                            <h3 id="telegram-name" class="pt-2">Loading...</h3>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col">
                        <div class="row py-3 px-3 text-center">
                            <div class="col-12 pb-3">
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}
                                {!! getIcon('instagram', 'feature p-3 tiktokIcon') !!}
                            </div>
                            <div class="col-12">
                                <div id="countdown" class="col text-white border h5 rounded btn text-uppercase">Ready
                                </div>

                            </div>



                        </div>
                    </div>
                    <div class="col-md-10 col-lg-6 col-sm-12 pxc-5">
                        <h1 class="h5 text-center">Get 10 free Instagram likes every 5 minutes.</h1>
                        <div class="border-dashes p-3 justify-content-center">
                            <h2 class="text-center text-white justify-content-center p-3 h6">Boost Your
                                <strong>Instagram</strong> Likes: Enjoy 10 Free Auto Likes Every 5 Minutes!
                            </h2>
                            <form method="post" action="{{ route('free-tiktok-views-post') }}" id="form">
                                @csrf
                                <input type="hidden" name="type" value="INSTA_LIKES">
                                <input type="hidden" name="telegram_user_id" id="telegram_user_id" value="">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>{{ $errors->first() }}</li>
                                        </ul>
                                    </div>
                                @endif
                                <div class="input-group mb-3">
                                    <input type="text" name="link" class="form-control"
                                        placeholder="Paste your video link" aria-label="Paste your video link"
                                        aria-describedby="basic-addon2">

                                    <div class="input-group-append">
                                        <button class="g-recaptcha btn btn-primary"
                                            data-sitekey="6LcMdZwpAAAAADRSp8xPjwzKPzAGKT6qkL17Ybdu" data-callback='onSubmit'
                                            data-action='submit' id="sendViewsBtn" type="submit" disabled>Send
                                            Likes</button>
                                    </div>
                                </div>

                            </form>


                            @if (Session::has('sucess'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{{ Session::get('sucess') }}</li>
                                    </ul>
                                </div>
                                <!-- Share Modal -->
                                <div class="modal fade show" id="shareModal" tabindex="-1"
                                    aria-labelledby="shareModalLabel" style="display: block;" aria-modal="true"
                                    role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-dark">Thank You for Your Support! ❤️</h5>
                                                <button type="button" class="btn-close"
                                                    onclick="document.querySelector('#shareModal').classList.add('d-none')"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p>We appreciate you using our service! Please share and help us grow. 🙏
                                                </p>
                                                <p class="h4 text-danger">(っ◔◡◔)っ ♥ share ♥</p>
                                                <!-- Social Share Buttons -->
                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                    <a href="#" target="_blank" id="facebookShare"
                                                        class="btn btn-primary">Facebook</a>
                                                    <a href="#" target="_blank" id="twitterShare"
                                                        class="btn btn-info text-white">Twitter</a>
                                                    <a href="#" target="_blank" id="whatsappShare"
                                                        class="btn btn-success">WhatsApp</a>
                                                    <a href="#" target="_blank" id="telegramShare"
                                                        class="btn btn-secondary">Telegram</a>
                                                    <a href="#" target="_blank" id="pinterestShare"
                                                        class="btn btn-danger">Pinterest</a>
                                                    <a href="#" target="_blank" id="redditShare"
                                                        class="btn btn-warning">Reddit</a>
                                                    <a href="#" target="_blank" id="snapchatShare"
                                                        class="btn btn-dark">Snapchat</a>
                                                </div>
                                                <a href="https://t.me/autolikerlive" class="btn mt-5"
                                                    style="background-color: #0088cc; color: white; border-radius: 5px; padding: 10px 20px; text-decoration: none; display: inline-block; font-weight: bold;">
                                                    {!! getIcon('telegram', 'telegramIcon') !!} Join Telegram Channel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="temp-emailbox-text text-center my-2">
                            <p class="text-dark pt-2 text-white">I Understand and Agree with <a class="link"
                                    href="{{ url('privacy') }}">Privacy Policy</a> and <a class="link"
                                    href="{{ url('terms') }}">Terms of Uses</a></p>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <section class="bg-light" id="no-ads-in-steps">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                    <div class="card-body m-3">
                        <h1 class="card-title"
                            style="
                                color: #DADADA;
                                font-family: Helvetica, Sans-serif;
                                font-size: 30px;
                                font-weight: 600;">
                            01.</h1>
                        <h6 class="card-subtitle mb-2"
                            style="
                  color: #000000;
                  font-family: Roboto, Sans-serif;
                  font-size: 18px;
                  font-weight: 700;
                  line-height: 20px;">
                            Enter Your Video URL</h6>
                        <p class="card-text">Enter your tiktok video url in the URL field and press send button</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                    <div class="card-body m-3">
                        <h1 class="card-title"
                            style="
                                color: #DADADA;
                                font-family: Helvetica, Sans-serif;
                                font-size: 30px;
                                font-weight: 600;">
                            02.</h1>
                        <h6 class="card-subtitle mb-2"
                            style="
                  color: #000000;
                  font-family: Roboto, Sans-serif;
                  font-size: 18px;
                  font-weight: 700;
                  line-height: 20px;">
                            Wait for Your Turn</h6>
                        <p class="card-text">After submitting your video URL, you have to wait for few seconds to start
                            getting
                            likes. </p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 card border border-white" style="background:#F5F2F2">
                    <div class="card-body m-3">
                        <h1 class="card-title"
                            style="
                                color: #DADADA;
                                font-family: Helvetica, Sans-serif;
                                font-size: 30px;
                                font-weight: 600;">
                            03.</h1>
                        <h6 class="card-subtitle mb-2"
                            style="
                  color: #000000;
                  font-family: Roboto, Sans-serif;
                  font-size: 18px;
                  font-weight: 700;
                  line-height: 20px;">
                            Start Getting Likes 🎉</h6>
                        <p class="card-text">Once the request is processed, you’ll start getting likes on the submitted
                            video!
                        </p>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <script data-cfasync="false">
        // Assuming $timeLeft is the total seconds
        var timeLeft = {{ $timeLeft }};
        var sendViewsBtn = document.getElementById('sendViewsBtn');

        function updateTimer() {
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('countdown').innerHTML = formattedTime;

            if (timeLeft <= 0) {
                document.getElementById('countdown').innerHTML = 'Ready'; //'Ready';
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                timeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(updateTimer, 1000);
            }
        }

        var mytimeLeft = 30;

        function successMsg() {
            var minutes = Math.floor(mytimeLeft / 60);
            var seconds = mytimeLeft % 60;

            var formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);

            document.getElementById('sendViewsBtn').innerHTML = formattedTime;

            if (mytimeLeft <= 0) {
                document.getElementById('sendViewsBtn').innerHTML = `Send Likes`;
                sendViewsBtn.disabled = false; // Enable the button when the timer is finished
            } else {
                mytimeLeft--;
                sendViewsBtn.disabled = true; // Disable the button while the timer is running
                setTimeout(successMsg, 1000);
            }
        }

        function onSubmit(token) {


            show_8641818().then(() => {
                document.getElementById("form").submit();
            }).catch(e => {
                console.error(e);
                alert("Please try again after few minuts!");
            })



        }
        successMsg();
        updateTimer();

        if (window.Telegram && Telegram.WebApp.initDataUnsafe) {
            Telegram.WebApp.BackButton.show();

            Telegram.WebApp.BackButton.onClick(function() {
                window.history.back(); // Go back to the previous page
            });
            const user = Telegram.WebApp.initDataUnsafe.user;

            if (user) {
                const cacheKey = `telegram_user_${user.id}`;
                document.getElementById("telegram_user_id").value = user.id;
                const cachedData = localStorage.getItem(cacheKey);

                if (cachedData) {
                    // Load cached data
                    const userData = JSON.parse(cachedData);
                    updateProfile(userData.name, userData.photo);
                } else {
                    // Get user details from Telegram Mini App API
                    const userName = user.first_name + (user.last_name ? " " + user.last_name : "");
                    console.log(user);

                    const userPhoto = user.photo_url.replace('t.me', 'telegram.me') ||
                        "https://cdn-icons-png.flaticon.com/512/3273/3273898.png"; // Default photo

                    // Cache user data
                    const userData = {
                        name: userName,
                        photo: userPhoto
                    };
                    localStorage.setItem(cacheKey, JSON.stringify(userData));

                    updateProfile(userName, userPhoto, user.id);
                }
            }
        } else {
            console.warn("Telegram WebApp API not available!");
        }


        // Update HTML elements with user info
        function updateProfile(name, photo, user_id) {
            document.getElementById("telegram-name").textContent = name;
            document.getElementById("telegram-photo").src = photo;


        }


        const pageUrl = encodeURIComponent(window.location.href);
        const message = encodeURIComponent("TikTok Auto Views - Get Unlimited Free TikTok Views every 15 minutes 🚀🔥");
        const hashtags = encodeURIComponent("autolikerlive,freetiktokviews");
        const imageUrl = encodeURIComponent("https://example.com/images/tiktok_views.png"); // Change to your image

        // Set Share URLs
        document.getElementById("facebookShare").href = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
        document.getElementById("twitterShare").href =
            `https://twitter.com/intent/tweet?url=${pageUrl}&text=${message}&hashtags=${hashtags}`;
        document.getElementById("whatsappShare").href = `https://api.whatsapp.com/send?text=${message} ${pageUrl}`;
        document.getElementById("telegramShare").href = `https://t.me/share/url?url=${pageUrl}&text=${message}`;
        document.getElementById("pinterestShare").href =
            `https://pinterest.com/pin/create/button/?url=${pageUrl}&media=${imageUrl}&description=${message}`;
        document.getElementById("redditShare").href = `https://www.reddit.com/submit?url=${pageUrl}&title=${message}`;
        document.getElementById("snapchatShare").href = `https://www.snapchat.com/scan?attachmentUrl=${pageUrl}`;
    </script>
@stop
