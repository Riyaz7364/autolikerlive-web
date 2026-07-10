@extends('layouts.master')

@section('title', 'Dashboard '.$user['loginType'])
@section('description', '')

@section('javascripts')
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
     crossorigin="anonymous"></script>
@endsection

@section('content')
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center text-dark">Dashboard <span class="border rounded text-danger">{{ $user['loginType'] }}</span>
                </h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                {{-- <x-instagram.credits :credits="$user['credits']"></x-instagram.credits> --}}



                <div class="card mb-3 mainb">
                    <div class="card-body row">
                        <div class="col-sm-12 col-xm-12 col-sm-12 col-md-3 col-lg-2">
                            <img class="pic" src="{{ url('storage/profiles/profile_' . $user['uid']) }}.jpeg"
                                alt="user image"> <br>

                        </div>
                        <div class="col-sm-12 col-xm-12 col-sm-12 col-md-9 col-lg-10">
                            @if ($user['loginType'] == 'FB')
                            <div class="facebook-btn text-center">Facebook Auto Liker</div>
                        @else
                            <div class="instgram-btn text-center text-white">Instagram Auto Liker</div>
                        @endif
                            <table class="table border-0">

                                <tr>
                                    <td>Name:</td>
                                    <td>{{ $user['name'] }} | <span
                                            class="text-danger fw-bold">{{ '@' . $user['username'] }}</span></td>
                                </tr>
                                @if ($user['bio'])
                                    <tr>
                                        <td>Bio:</td>
                                        <td>{{ $user['bio'] }}</td>
                                    </tr>
                                @endif
                                @if ($user['followings'])
                                    <tr>
                                        <td>followings:</td>
                                        <td>{{ $user['followings'] }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>followers:</td>
                                    <td>{{ $user['followers'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="card border-primary mb-3">
                            <div class="card-body">
                                <p class="fs15">If you have any bugs to report or any suggestions, please let us know!</p>
                                <a href="/contact" class="btn btn-primary btn-sm fs15">SEND FEEDBACK</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card mt-4 mb-4 shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4 class="mb-0 text-primary"><i class="bi bi-info-circle me-2"></i> Welcome to Your Dashboard</h4>
                    </div>
                    <div class="card-body text-secondary">
                        <p>Your dashboard is the central hub for managing your account and activities on AutolikerLive.</p>
                        <ul class="list-group list-group-flush mb-3 rounded">
                            <li class="list-group-item bg-light border-0 mb-1"><strong>Profile Overview:</strong> View your connected account details, including your username, bio, followers, and followings.</li>
                            <li class="list-group-item bg-light border-0 mb-1"><strong>Navigation:</strong> Use the action buttons above to start a new promotion, view your existing orders, or log out of your current session.</li>
                            <li class="list-group-item bg-light border-0"><strong>Feedback & Support:</strong> We value your input! Use the 'Send Feedback' button if you encounter any issues or have suggestions to improve the platform.</li>
                        </ul>
                        <div class="alert alert-info mb-0 border-0">
                            <strong>Note:</strong> Always ensure you are logged into the correct account before starting any promotions to avoid sending reactions to the wrong profile.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
