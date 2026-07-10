@extends('bots.sms_bomber.master')
@section('title', 'SMS BOMBER - BOT')
@section('description', '')
@section('javascripts')

    <script src="https://www.google.com/recaptcha/api.js?render=6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb" async defer>
    </script>
    {{-- Removed bootstrap stylesheet reference for Tailwind migration --}}
@stop
@section('content')

    <style type="text/css">
        .input-group-text-custom {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 2.1;
            color: #212529;
            text-align: center;
            white-space: nowrap;
            background-color: rgba(var(--bs-white-rgb), var(--bs-bg-opacity)) !important;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .font-weight-bold {
            font-weight: 700;
        }

        .spinner-10x {
            width: 10rem;
            height: 10rem;
        }

        .pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 3px;
            /* Adjust the height as needed */
            background: rgb(242, 99, 38);
            background: linear-gradient(90deg, rgba(242, 99, 38, 1) 0%, rgba(223, 39, 39, 1) 50%, rgba(255, 0, 206, 1) 100%);
            transition: width 0.3s linear;
            z-index: 9999;
        }

        .btn-xs {
            padding: 1px 5px;
            font-size: 9px;
            line-height: 1;
            border-radius: 3px;
        }

        .alert-own {
            position: relative;
            padding: 0.25rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }
    </style>
    <main class="flex-shrink-0">
        <!-- Header-->
        <header class="bg-light">
            <div class="container px-2">
                <div class="row">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <div id="bestsmsbomber" class="card text-black bg-white mb-3 border-primary"
                            style="border-width:3px;">
                            <div class="card-header bg-primary text-white border-primary">
                                <center>
                                    <h4>SMS BOMBER</h4>
                                </center>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-6">

                                        <div class="col-sm-4 d-none" id="send-success" style="text-align-last: center">
                                            <img src="https://mytoolstown.com/images/smsbomber/success.png"
                                                style="width:50%;height:auto;pointer-events: none;"><br>
                                            <br>
                                            <h4>SMS BOMB SUCCESSFUL</h4>
                                            <br>
                                            <button type="button" class="btn btn-success"
                                                onclick="window.location.reload()">OPEN SMS BOMBER</button>
                                            <br><br>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="alert-own alert-primary" id="showerror" role="alert">
                                                <b style="font-size: 8px; color: white">Tested:</b>
                                                <span>
                                                    @foreach ($status as $item)
                                                        <a href="#"
                                                            class="btn btn-success btn-xs">{{ $item->name }}</a>
                                                    @endforeach
                                                </span>
                                            </div>
                                            <form id="sms-bomber-form">
                                                <div class="form-group">
                                                    <b>Mobile No:</b>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <select name="code" id="code"
                                                                    style="margin-top:-14px;height:53.5px;width:135px;margin-right:-4px;border:0px;padding-left:15px;">
                                                                    @foreach ($status as $item)
                                                                        <option value="{{ $item->code }}"
                                                                            data-item="{{ json_encode($item) }}">
                                                                            {{ $item->name }}
                                                                            (+{{ $item->code }})
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input id="number" type="number" name="number"
                                                            style=" margin-top:1px;" class="form-control sms-input"
                                                            placeholder="Friend Mobile No." required="">
                                                        <input type="hidden" id="recaptcha-token" name="recaptcha-token">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="call"
                                                            id="inlineRadio1" value="0" @checked(true)>
                                                        <label class="form-check-label" for="inlineRadio1">SMS
                                                            BOMBER</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="call"
                                                            id="inlineRadio2" value="1">
                                                        <label class="form-check-label" for="inlineRadio2">CALL
                                                            BOMBER</label>
                                                    </div>

                                                </div>
                                                <div class="form-group"><b>Count SMS: </b>
                                                    <input id="count" type="number" class="form-control sms-input"
                                                        placeholder="Number of SMS" max="30" required="">
                                                </div>
                                                <div class="form-group">
                                                    <b>Choose Bomb Speed:</b>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="speedLow" name="speed"
                                                                    value="slow" class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                    for="speedLow">Slow</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="speedMedium" name="speed"
                                                                    value="medium" class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                    for="speedMedium">Medium</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="speedFast" name="speed"
                                                                    value="fast" class="custom-control-input"
                                                                    checked="">
                                                                <label class="custom-control-label"
                                                                    for="speedFast">Fast</label>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <center>
                                                        <div class="alert alert-success d-none" style=""
                                                            id="showsuccess" role="alert"><b>SMS SENT</b></div>
                                                        <div class="progress d-none" style="height: 1.375rem !important"
                                                            id="progress-container">
                                                            <div class="progress-bar progress-bar-striped"
                                                                role="progressbar" id="progress-bar" style="width: 10%;"
                                                                aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <p class="lead fs-13 py-1">
                                                            When you use this tool, You agree that you are only using this
                                                            tool
                                                            only for pranking
                                                            purpose on friends or family and with their consent and not for
                                                            harassment.
                                                        </p>


                                                        <button class="btn btn-success" type="submit"
                                                            id="submit-button">
                                                            <span
                                                                class="spinner-border spinner-border-sm text-light d-none"
                                                                id="startsms_spinner" role="status"
                                                                aria-hidden="true"></span> &nbsp;
                                                            <span id="submitBtnText">START</span>
                                                        </button>
                                                        <a class="btn btn-danger text-white d-none"
                                                            id="stop-sms">STOP</a>


                                                        {{-- <a href="https://mytoolstown.com/smsbomber/success"
                                                        style="display: none;" id="stopBtn"><button type="button"
                                                            class="btn btn-warning">STOP</button></a> --}}

                                                        <noscript>
                                                            <br><br>
                                                            <div class="alert alert-danger">
                                                                <h4>PLEASE ENABLE JAVASCRIPT IN YOUR BROWSER OTHERWISE
                                                                    WEBSITE
                                                                    WILL NOT WORK PROPERLY.
                                                                </h4>
                                                            </div>
                                                        </noscript>

                                                        <br><br>Stay Online On This Page To Send SMS.<br>
                                                        <div class="alert alert-warning text-center">Important: Please do
                                                            not
                                                            use this website for
                                                            revenge or harassment. You can only use this website to prank
                                                            your
                                                            friends. Developer is
                                                            not responsible for your actions.</div>

                                                    </center>



                                                </div>
                                            </form>

                                            <form action="{{ route('save-bomber') }}" method="post"
                                                class="form-inline col-12 p-3">
                                                @csrf
                                                <div class="col-sm-12 col-md-4">
                                                    <p>If you want to secure your mobile number from this prank,
                                                        just enter your number and save. All done.</p>
                                                    <label class="sr-only" for="inlineFormInputGroupUsername2">Protect My
                                                        Mobile
                                                        Number</label>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" name="number"
                                                            placeholder="Mobile Number without country code">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                </div>
        </header>





        <script>
            $(document).ready(function() {

                $("#count").on("input", function() {
                    if (parseInt($(this).val()) > 50) {
                        $(this).val(50);
                    }
                });

                $('#code').on('change', function() {
                    const selectedOption = $(this).find(':selected');
                    const fullData = selectedOption.data('item'); // Get the full data

                    if (fullData.calls == 0) {
                        $('#inlineRadio1').prop('checked', true);
                        $('#inlineRadio2').prop('disabled', true).prop('checked', false);
                    } else {
                        $('#inlineRadio2').prop('disabled', false);
                    }
                });


                const $form = $('#sms-bomber-form');
                const $recaptchaTokenInput = $('#recaptcha-token');
                const $submitButton = $('#submit-button');
                const $submitButtonText = $('#submitBtnText');
                const $showSuccess = $('#showsuccess');
                const $stopSMS = $('#stop-sms');
                const $startSpinner = $('#startsms_spinner');
                const $progressBar = $('#progress-bar');
                const $progressContainer = $('#progress-container');
                const speed = $('input[name="speed"]:checked').val();

                let xhr = null;
                let totalRequests = 0;
                let completedRequests = 0;
                let stopRequested = false;

                $form.on('submit', function(event) {

                    switch (speed) {
                        case 'slow':
                            var timeout = 4000;
                            break;
                        case 'medium':
                            var timeout = 2000;
                            break;
                        case 'fast':
                            var timeout = 1000;
                            break;
                    }

                    event.preventDefault();
                    $stopSMS.removeClass('d-none');

                    $submitButton.attr('disabled', 'disabled');
                    $submitButtonText.html('Sending...');
                    $startSpinner.removeClass('d-none');
                    $progressContainer.removeClass('d-none');
                    $showSuccess.removeClass('d-none');
                    stopRequested = false;

                    totalRequests = parseInt($('#count').val()) || 5; // Get count from user input
                    completedRequests = 0;
                    updateProgress(0);

                    function sendRequest() {
                        if (stopRequested || completedRequests >= totalRequests) return;

                        grecaptcha.ready(function() {
                            grecaptcha.execute('6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb', {
                                action: 'submit'
                            }).then(function(token) {
                                $recaptchaTokenInput.val(token);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    }
                                });
                                xhr = $.ajax({
                                    type: 'POST',
                                    url: `{{ route('send-bomber') }}`,
                                    data: $form.serialize(),
                                    success: function(response) {
                                        completedRequests++;
                                        updateProgress(completedRequests);
                                        if (completedRequests < totalRequests &&
                                            completedRequests < 30) {
                                            setTimeout(() => {
                                                sendRequest();
                                            }, timeout);
                                        } else {
                                            $('#send-success').removeClass(
                                                'd-none');
                                            $form.addClass('d-none');
                                            // show_9056915('pop').then(() => {})
                                            //     .catch(e => {});
                                        }
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        console.error('Error:', textStatus,
                                            errorThrown);
                                    }
                                });
                            });
                        });
                    }

                    // Rewarded interstitial

                    show_9056915().then(() => {});


                    sendRequest();
                    // Start the first request

                });

                $stopSMS.on('click', function() {
                    stopRequested = true;
                    if (xhr) xhr.abort();
                    $stopSMS.addClass('d-none');
                    $form.removeClass('d-none');
                    $progressContainer.addClass('d-none');
                    location.reload();
                });

                function updateProgress(count) {
                    var percentage = (count /
                        totalRequests) * 100
                    $showSuccess.removeClass('d-none');
                    $showSuccess.html(count + ' SMS SENT</b>');
                    $progressBar.css('width', percentage + '%').attr('aria-valuenow', percentage);
                }
            });
        </script>
    @stop
