@extends('layouts.master-test')

@section('title', 'Yolikers | Facebook Auto Liker | Auto Reactions | Auto Like FB')
@section('description',
    'Get Instant and Free Fb Auto Likes, Auto Reactions, Auto Comments, Fanpage Likes and Auto
    Followers. Get Likes Upto 100k Per Day. Best and working Auto Liker 2018')
@section('body-class', 'bg-light')
@section('keywords', 'auto liker, auto like, auto liker app, auto liker apk, auto reactions, facebook auto liker')

@section('javascripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        {
        color: black;
        font-family: 'Raleway', sans-serif;
        font-weight: 700;
        }

        p {
            color: black;
            font-family: 'Lato', sans-serif;
            font-weight: 400;
        }

        body {
            background: #ffffff;
            margin: 0;
            height: 100%;
            color: #384452;
            font-family: 'Lato', sans-serif;
            font-weight: 400;
        }

        .jumbotron {
            padding: 30px;
            margin-bottom: 30px;
            color: inherit;
            background-color: #eee;
        }

        .jumbotron h1,
        .jumbotron .h1 {
            color: inherit;
        }

        .jumbotron p {
            margin-bottom: 15px;
            font-size: 21px;
            font-weight: 200;
        }

        @media screen and (min-width: 768px) {

            .jumbotron h1,
            .jumbotron .h1 {
                font-size: 63px;
            }
        }

        .jumbotron h1,
        .jumbotron .h1 {
            color: inherit;
        }

        .label-primary {
            background-color: #428bca;
        }

        .label-warning {
            background-color: #f0ad4e;
        }

        .label-success {
            background-color: #5cb85c;
        }

        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: bold;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }

        #service i {
            color: #00b3fe;
            font-size: 60px;
            padding: 15px;
        }

        #twrap i {
            font-size: 50px;
            color: white;
            margin-bottom: 25px;
        }

        #twrap {
            background: url(https://yolikers.com/assets/img/t-back.jpg) no-repeat center top;
            margin-top: 0px;
            padding-top: 60px;
            text-align: center;
            background-attachment: relative;
            background-position: center center;
            min-height: 450px;
            width: 100%;
            -webkit-background-size: 100%;
            -moz-background-size: 100%;
            -o-background-size: 100%;
            background-size: 100%;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        a {
            padding: 0;
            margin: 0;
            text-decoration: none;
            -webkit-transition: background-color .4s linear, color .4s linear;
            -moz-transition: background-color .4s linear, color .4s linear;
            -o-transition: background-color .4s linear, color .4s linear;
            -ms-transition: background-color .4s linear, color .4s linear;
            transition: background-color .4s linear, color .4s linear;
        }

        .btn-xs,
        .btn-group-xs>.btn {
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }

        .hline-w {
            border-bottom: 2px solid #ffffff;
            margin-bottom: 25px;
        }

        body a {
            color: #008aff;
            text-decoration: none;
        }

        a {
            font-size: 110%;
            text-decoration: none;
        }
    </style>
@endsection
@section('content')
    <x-navbar title="Yolikers"></x-navbar>
    <div class="jumbotron">
        <h1>Welcome to Yolikers</h1>
        <p>Yolikers is a complimentary Facebook exchange platform that operates on the <code class="code code-md">Facebook
                Graph API</code>.
            Our Auto Liker offers endless Facebook Auto likes on your Posts/Photos/Videos. We also provide free Auto
            Reactions.
            Get Instant <span class="label label-primary label-md">Likes</span><span
                class="label label-warning label-md">Reactions</span><span
                class="label label-success label-md">Followers</span> at free of Cost.<br />Download Our App For Faster and
            Easy Access. Now Compatible with Android 12 and Crash Issues Resolved.</p>
        <center><a class="btn btn-primary btn-lg" href="#twrap">Download APP (v3.8)</a></p>
        </center><br />
    </div>
    <div id="service">
        <div class="container">
            <div class="row centered">
                <div class="col-md-4">
                    <i class="fa fa-heart"></i>
                    <h4>Active Users</h4>
                    <p>Our Tool delivers 200 active likes for each submission and up to 10k Likes in a single day. Users
                        adore our Auto Liker. We have users from across the globe, particularly from the USA, UK, and India.
                    </p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-unlock"></i>
                    <h4>NO SPAM</h4>
                    <p>We detest Spam. Our Autoliker is completely Safe and Reliable. We do not Auto Post using users'
                        Access Tokens. We do not sell Likes or trade Tokens. Feel Secure when using Us.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-trophy"></i>
                    <h4>Working Tools</h4>
                    <p>Our Site features 100% functional tools that deliver the Instant service you select. View our
                        Tutorial if you encounter any issues while using our site.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-dismissable alert-success">
        <button type="button" class="close" data-dismiss="alert"> &times; </button>
        <strong>Recent News:</strong> Liker is Fixed Now and is Working Fine (Limit set upto 100 likes per Submit.).
    </div>
    <div id="twrap" class="bg-dark">
        <div class="container centered">
            <div class="row py-5 text-center">
                <div class="col-lg-12 col-lg-offset-2">

                    <i class="fa fa-download"></i><br />
                    <p>
                        <a class="btn btn-success btn-lg" href="{{ route('download.page') }}">Download (PlayStore)</a>
                        <!--<a class="btn btn-success btn-lg" href="https://github.com/yolikers/yo/raw/main/Yolikers_v3.9.apk">Download APK (Direct)</a> <!--<a class="btn btn-primary btn-lg" target="_blank" href="https://drive.google.com/file/d/12oY2jXsXeJ1hWsMCGuTH_CQqGi5MW-5Z/view?usp=drive_link">Download APK (Gdrive)</a></p><br/>-->
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="footerwrap" class="bg-secondary">
        <div class="container pt-3">
            <div class="row">
                <div class="col-lg-4">
                    <h4>About</h4>
                    <div class="hline-w"></div>
                    <p>Yolikers is a leading Facebook Auto liker that offers Free and Instant Auto Likes. Auto Reactions,
                        Auto Followers, and Fan Page Likes Immediately. Our Tools are Completely Operational and
                        Functioning. Boost <a rel="nofollow" href="">Facebook likes</a>.</p>
                </div>
                <div class="col-lg-4">
                    <h4>Frequently Asked</h4>
                    <div class="hline-w"></div>
                    <p><a href="{{ route('faq') }}">What is an Yoliker?</a></p>
                    <p><a href="{{ route('faq') }}">What is an Access Token?</a></p>
                    <p><a href="{{ route('faq') }}">Is Auto Liker Auto Liker is SAFE?</a></p>
                </div>
                <div class="col-lg-4">
                    <h4>Tags</h4>
                    <div class="hline-w"></div>
                    <p>
                        <a href="#" class="btn btn-danger btn-xs">Auto liker</a>
                        <a href="#" class="btn btn-danger btn-xs">Facebook Auto Liker</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Reactions</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Likes</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Liker Fb</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Comment</a>
                        <a href="#" class="btn btn-danger btn-xs">Page Auto Liker</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Followers</a>
                        <a href="#" class="btn btn-danger btn-xs">Fanpage Liker</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Fb Likes</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Liker App</a>
                        <a href="#" class="btn btn-danger btn-xs">Best FB Auto Liker</a>
                        <a href="#" class="btn btn-danger btn-xs">Auto Like Biz</a>
                        <a href="#" class="btn btn-danger btn-xs">Fb liker App</a>
                        <a href="#" class="btn btn-danger btn-xs">Dj liker app</a>
                        <a href="#" class="btn btn-danger btn-xs">Facebook Page Auto Liker</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div id="finish"
        style="display:none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: #f4f4f4;z-index: 99;">
        <div class="text"
            style="position: absolute;top: 45%;left: 0;height: 100%;width: 100%;font-size: 18px;text-align: center;">
            <center><img src="assets/img/load.gif"></center> <br>
            <div id="result">Processing Your Request!!! <br> Please Do Not Hit Browsers Back Button Or Refresh, This
                Might Take A Few Minutes
                <br><b style="color: red;">BE ONLINE ON Yoliker</b>
            </div>
        </div>
    </div>
@endsection
