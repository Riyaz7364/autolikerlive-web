@extends('layouts.master')

@section('title', 'Dashboard '.$user['loginType'])
@section('description', '')


@push('styles')

@endpush

@section('content')
    <x-navbar></x-navbar>
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center">Dashboard <span class="border rounded text-danger">{{ $user['loginType'] }}</span>
                </h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                <x-instagram.credits :credits="$user['credits']"></x-instagram.credits>



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
            </div>
        </div>
    </main>
@endsection
