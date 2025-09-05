@extends('layouts.master')

@section('title', 'Dashboard ' . $user['loginType'])
@section('description', '')


@push('styles')
@endpush

@section('content')
    <x-navbar></x-navbar>
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center">Settings <span class="border rounded text-danger">{{ $user['loginType'] }}</span>
                </h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                <x-instagram.credits :credits="$user['credits']"></x-instagram.credits>



                <div class="card mb-3 mainb">
                    <div class="card-body row">

                        <form method="post" action="{{ route('autoliker.settings.update') }}">
                            @csrf
                            <h3>Select Earn Credits Source:</h3>

                            <label>
                                <input type="radio" name="earn_source" value="FB"
                                    {{ $user['earnType'] == 'FB' ? 'checked' : '' }}>
                                Facebook
                            </label><br>

                            <label>
                                <input type="radio" name="earn_source" value="IG"
                                    {{ $user['earnType'] == 'IG' ? 'checked' : '' }}>
                                Instagram
                            </label><br><br>

                            <button class="btn btn-danger" type="submit">Save Settings</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
