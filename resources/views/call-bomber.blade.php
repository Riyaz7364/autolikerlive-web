@extends('layouts.master')

@section('title', __('messages.bomber.meta_title', ['type' => 'Call']))
@section('description', __('messages.bomber.meta_desc', ['type' => 'Call']))
@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb" async defer>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

@stop

@push('styles')
    <style>
        .codeType {
            height: 53.5px;
            width: 120px;
            margin-right: -4px;
            border: 0px;
            padding-left: 15px;
        }

        .telegramIcon {
            height: 20px;
            width: 20px;
        }
    </style>
@endpush

@section('content')
    <main class="flex-shrink-0">
        <!-- Navigation -->
        <x-navbar></x-navbar>

        <!-- Header -->
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-8 col-xxl-8">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">
                                {{ __('messages.bomber.title', ['type' => 'Call']) }}</h1>
                            <p class="lead fw-normal text-white-50 mb-4">
                                {{ __('messages.bomber.subtitle', ['type' => 'Call']) }}</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <p>
                                    {{ __('messages.bomber.p1', ['type' => 'Call']) }}
                                </p>

                            </div>
                            <a href="https://telegram.me/Call_sender_live_bot" class="btn"
                                style="background-color: #0088cc; color: white; border-radius: 5px; padding: 10px 20px; text-decoration: none; display: inline-block; font-weight: bold;">
                                {!! getIcon('telegram', 'telegramIcon') !!} {{ __('messages.bomber.openTelegram', ['type' => 'Call']) }}
                            </a>

                        </div>

                    </div>
                    <div class="col-xl-4 col-xxl-4 d-none d-xl-block text-center">
                        <img height="256px" width="256px" class="img-fluid rounded-3 my-5"
                            src="{{ asset('images/Callbomberiocn.webp') }}" alt="Call bomber Live graphics">
                    </div>
                </div>
            </div>
        </header>

        <section class="py-5 bg-light">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="alert alert-danger">
                        {!! __('messages.bomber.notice') !!}
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div id="stop-Call" class="d-none p-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <span class="sr-only">Sending Call...</span>
                        <button class="btn btn-danger ml-5">Stop Call</button>
                    </div>

                    <div class="card-body">
                        <h2 class="text-center text-dark"><strong>More Tools</strong></h2>
                        <div class="row justify-content-center">
                            <a href="{{ route('sms-bomber') }}" class="col btn btn-warning btn-lg mt-2 m-2"
                                style="font-size: 15px;">SMS BOMBER</a>
                        </div>
                    </div>

                    <form id="Call-bomber-form" class="form-inline col-12 p-3">
                        <div class="form-group">
                            <b>Mobile No:</b>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <select id="code" name="code" class="codeType">
                                            <option value="91" selected>India (+91)</option>

                                            <!-- Add more country codes here -->
                                        </select>
                                    </div>
                                </div>
                                <input type = "hidden" id = "call" name = "call" value = "1">
                                <input id="number" name="number" type="number" style="margin-top:1px;"
                                    class="form-control Call-input" placeholder="Friend Mobile No." required>
                            </div>
                        </div>
                        <input type="hidden" id="recaptcha-token" name="recaptcha-token">
                        <button id="submit-button" class="btn btn-primary">Send Call</button>
                    </form>

                    <!-- Banner Ads adsbygoogle -->


                    <div class="panel panel-danger">
                        <div class="panel-heading"><b><i class="fa fa-bomb" aria-hidden="true"></i>&nbsp;What Is Call
                                Bomber?</b></div>
                        <div class="panel-body">
                            <p>
                                {!! __('messages.bomber.p2', ['type' => 'Call']) !!}
                            </p>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><b>
                                {{ __('messages.bomber.howToUse', ['type' => 'Call']) }}</b></div>
                        <div class="panel-body">
                            <b>Step 1:</b> {{ __('messages.bomber.howToUse_step1') }}<br>
                            <b>Step 2:</b> {{ __('messages.bomber.howToUse_step2') }}
                        </div>
                    </div>

                    <form action="{{ route('save-bomber') }}" method="post" class="form-inline col-12 p-3">
                        @csrf
                        <div class="col-sm-12 col-md-4">
                            <p class="text-success">{{ __('messages.bomber.p3') }}</p>
                            <label class="sr-only" for="inlineFormInputGroupUsername2">Protect My Mobile Number</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="number"
                                    placeholder="Mobile Number without country code">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </section>

        <section>
            <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                <div class="panel-heading text-warning">
                    <strong>{{ __('messages.bomber.whatIsBomber', ['type' => 'Call']) }}</strong>
                </div>
                <div class="panel-body">
                    <p>
                        {{ __('messages.bomber.whatIsBomber_p1', ['type' => 'Call']) }}
                    </p>
                </div>
            </aside>

            <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                <div class="panel-heading text-warning"><b><i class="fa fa-bomb"
                            aria-hidden="true"></i>{{ __('messages.bomber.howToStop', ['type' => 'Call']) }}</b></div>
                <div class="panel-body">
                    <p>
                        {{ __('messages.bomber.howToStop_p1', ['type' => 'Call']) }}
                    </p>
                </div>
            </aside>

            <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                <div class="panel-heading text-warning"><b><i class="fa fa-bomb"
                            aria-hidden="true"></i>{{ __('messages.bomber.whatIsBomber2', ['type' => 'Call']) }}</b></div>
                <div class="panel-body">
                    <p>
                        {!! __('messages.bomber.whatIsBomber2_p1', ['type' => 'Call']) !!}
                    </p>
                </div>
            </aside>

            <div class="bg-white p-3">
                <h2 class="text-dark">{{ __('messages.bomber.safetyGuide', ['type' => 'Call']) }}</h2>
                <p class="text-dark">
                    {{ __('messages.bomber.safetyGuide_p1', ['type' => 'Call']) }}
                </p>
                <h2 class="text-dark">{{ __('messages.bomber.usage') }}</h2>
                <ol>
                    {!! __('messages.bomber.usage_list', ['type' => 'Call']) !!}
                </ol>
                <h2 class="text-dark">{{ __('messages.bomber.safety') }}</h2>
                <ol>
                    {!! __('messages.bomber.safety_list') !!}
                </ol>
                <p class="text-dark">
                    {{ __('messages.bomber.p4', ['type' => 'Call']) }}
                </p>
            </div>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            const $form = $('#Call-bomber-form');
            const $recaptchaTokenInput = $('#recaptcha-token');
            const $submitButton = $('#submit-button');
            const $stopCall = $('#stop-Call');
            let xhr = null; // Variable to store the XMLHttpRequest

            $form.on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Disable the submit button and show/hide elements
                $stopCall.removeClass('d-none');
                $form.addClass('d-none');

                // Get the reCAPTCHA token
                grecaptcha.ready(function() {
                    grecaptcha.execute('6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb', {
                        action: 'submit'
                    }).then(function(token) {
                        $recaptchaTokenInput.val(token);

                        // Create an AJAX request with CSRF token in headers
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            }
                        });

                        // Send the AJAX request
                        xhr = $.ajax({
                            type: 'POST',
                            url: `{{ route('send-bomber') }}`,
                            data: $form.serialize(),
                            success: function(response) {
                                if (response.success) {
                                    console.log('Success');
                                    console.log(response);
                                } else {
                                    console.log(response);
                                    $stopCall.addClass('d-none');
                                    $form.removeClass('d-none');
                                    if (xhr) xhr.abort();
                                }
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                // Handle AJAX error
                                console.error('Error:', textStatus,
                                    errorThrown);
                            }
                        });
                    });
                });

                return false; // Prevent the default form submission
            });

            $stopCall.on('click', function() {
                if (xhr) xhr.abort();
                $stopCall.addClass('d-none');
                $form.removeClass('d-none');
                location.reload();
            });
        });
    </script>

    <x-ads></x-ads>
@stop
