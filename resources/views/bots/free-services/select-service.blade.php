@extends('bots.free-services.master')

@section('title', 'Select Service')
@section('description', 'Select the service you want to use for free.')

@section('javascripts')

    <script>
        $(document).ready(function() {
            if (window.Telegram && Telegram.WebApp.initDataUnsafe && Telegram.WebApp.initDataUnsafe.user) {
                Telegram.WebApp.BackButton.hide();
                const user = Telegram.WebApp.initDataUnsafe.user;
                const userId = user.id;
                const routes = {
                    '#free-tiktok-likes-bot': '{{ route('free-tiktok-likes-bot', ['user_id' => '__USER_ID__']) }}',
                    '#free-tiktok-views-bot': '{{ route('free-tiktok-views-bot', ['user_id' => '__USER_ID__']) }}',
                    '#free-instagram-likes-bot': '{{ route('free-instagram-likes-bot', ['user_id' => '__USER_ID__']) }}'
                };

                Object.entries(routes).forEach(([selector, url]) => {
                    $(selector).attr('href', url.replace('__USER_ID__', userId));
                });
            }
        });
    </script>

    <style>
        .instgram-btn {
            background: linear-gradient(to right, #f9ce34, #ee2a7b, #6228d7);
            font-size: 15px;
            color: white;
            font-weight: bold;
            letter-spacing: 1px
        }

        .tiktok-btn {
            background: black;
            font-size: 15px;
            color: white;
            font-weight: bold;
            letter-spacing: 1px;
            border: 2px solid white;
            display: inline-block;
            text-decoration: none;
            /* Ensures the link does not have an underline */
        }

        .tiktok-btn:hover {
            color: rgb(253, 253, 253);
            background: rgb(49, 49, 49);
            /* Optional: Change background on hover */
            border-color: black;
            /* Optional: Change border color on hover */
            transition: 0.3s ease-in-out;
            /* Smooth transition */
        }
    </style>

@endsection
@section('content')
    <main class="flex-shrink-0">

        <section class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col-sm-12 col-md-8 col-lg-8 mt-5 text-center">
                    <h1 class="text-dark">Select Service</h1>
                    <p class="lead text-dark">
                        Select the service you want to use for free.
                    </p>
                    <form method="POST" id="findmyfbid" action="{{ route('searchFBID') }}">
                        @csrf
                        <div class="row">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    {{-- <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="" id="free-instagram-likes-bot" class="w-100 btn  mt-2 m-2 instgram-btn"
                                        >Free Instagram Loves</a>
                                    </div> --}}
                                    {{-- <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="" id="free-tiktok-views-bot" class="w-100 btn border  mt-2 m-2 tiktok-btn"
                                        >Free TikTok Views</a>
                                    </div> --}}
                                    <div class="col-sm-12 col-lg-4 col-md-6">
                                        <a href="" id="free-tiktok-likes-bot"
                                            class="w-100 btn border  mt-2 m-2 tiktok-btn">Free TikTok Likes</a>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </main>

@endsection
