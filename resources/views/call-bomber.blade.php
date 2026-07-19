@extends('layouts.master')

@section('title', 'Auto Liker Live Call Bomber | SMS Bomber Tool')
@section('description',
    'Auto Liker Live Call Bomber - Professional Call Bomber and SMS Bomber tool for testing call service reliability and delivery rates.')
@section('keywords', 'auto liker live call bomber, call bomber, sms bomber, auto liker, facebook auto liker, free call bomber, bomb call service')
@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6Le7S7kqAAAAAMvSkxFhOxaTZMiosSLf4mHkpCtb" async defer>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@stop

@push('styles')
    <style>
        .tool-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .tool-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="circuit" width="100" height="100" patternUnits="userSpaceOnUse"><rect width="100" height="100" fill="none"/><circle cx="25" cy="25" r="2" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="2" fill="%23ffffff" opacity="0.1"/><path d="M25,25 L75,25 L75,75 L25,75 Z" stroke="%23ffffff" stroke-width="0.5" opacity="0.1" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23circuit)"/></svg>');
        }

        .tool-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .tool-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            position: relative;
            overflow: hidden;
        }

        .tool-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23ffffff" stroke-width="0.5" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .btn-tool {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-tool:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .btn-stop {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .status-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px;
            margin: 10px 0;
        }

        .progress-modern {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar-modern {
            background: linear-gradient(45deg, #28a745, #20c997);
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .warning-modern {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #f39c12;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-modern {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #17a2b8;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .btn-xs {
            padding: 4px 8px;
            font-size: 10px;
            line-height: 1;
            border-radius: 8px;
            margin: 2px;
        }

        .telegramIcon {
            height: 20px;
            width: 20px;
        }

        .tool-stats {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #4e73df;
        }

        .input-group-modern {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .call-progress-panel {
            display: none;
            margin-top: 1.5rem;
            padding: 1.25rem;
            border-radius: 18px;
            background: linear-gradient(135deg, #e8fff6 0%, #eef6ff 100%);
            border: 1px solid rgba(32, 201, 151, 0.25);
            box-shadow: 0 12px 30px rgba(34, 74, 190, 0.08);
        }

        .call-progress-panel.is-active {
            display: block;
        }

        .call-progress-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }

        .call-progress-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .call-progress-meta {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 0.75rem;
            color: #495057;
            font-size: 0.95rem;
        }

        .call-progress-note {
            margin-top: 0.75rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <main class="flex-shrink-0">
        <!-- Navigation -->
        <!-- Tool Hero Section -->
        <section class="py-5">
            <div class="container px-5">
                <div class="tool-hero py-5 px-4 px-md-5 mb-5 text-white position-relative row">
                    <div class="col align-items-center">
                        <h1 class="fw-bolder display-5 mb-3">Call Bomber Tool</h1>
                        <p class="lead mb-4 text-light">Professional Call Bomber and SMS Bomber tool for developers and
                            businesses</p>
                        <div class="warning-modern">
                            <h6 class="text-warning mb-2"><i class="bi bi-exclamation-triangle"></i> Professional Use
                                Only</h6>
                            <p class="mb-0 text-dark small">This tool is designed for legitimate Call service testing,
                                developer debugging, and delivery verification purposes only.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-none d-lg-block">
                        <img height="200px" width="200px" class="img-fluid rounded-3"
                            src="{{ asset('images/smsbomberiocn.webp') }}" alt="Call Testing Tool">
                    </div>

                </div>
            </div>
            </div>
        </section>

        <!-- Main Tool Section -->
        <section class="py-5 bg-light">
            <div class="container px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="tool-card">
                            <div class="tool-header p-4 text-white position-relative">
                                <div class="text-center">
                                    <h3 class="fw-bold mb-2 text-light"><i class="bi bi-tools me-2"></i>Call Service Tester
                                    </h3>
                                    <p class="mb-0 opacity-75 text-light">Test Call delivery rates and service reliability
                                    </p>
                                </div>
                            </div>

                            <div class="p-4">
                                <!-- Service Status Display -->
                                <div class="status-card mb-4">
                                    <h6 class="fw-bold text-muted mb-3"><i class="bi bi-server me-2"></i>Available Testing
                                        Services:</h6>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($status as $item)
                                            <span class="btn btn-success btn-xs">{{ $item->name }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Success Message -->
                                <div class="col-12 d-none" id="send-success" style="text-align: center">
                                    <div class="status-card">
                                        <div class="feature-icon bg-success bg-opacity-20 mb-3 mx-auto">
                                            <i class="bi bi-check-circle text-success fs-1"></i>
                                        </div>
                                        <h4 class="text-success mb-3">Testing Completed Successfully</h4>
                                        <p class="text-muted mb-3">Call service testing has been completed. Check your
                                            delivery reports.</p>
                                        <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                                            <i class="bi bi-arrow-clockwise me-2"></i>Run New Test
                                        </button>
                                    </div>
                                </div>

                                <!-- Testing Form -->
                                <form id="call-bomber-form">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark">
                                                <i class="bi bi-phone me-2"></i>Target Phone Number
                                            </label>
                                            <div class="input-group input-group-modern">
                                                <select name="code" id="code" class="form-select"
                                                    style="max-width: 150px;">
                                                    @foreach ($status as $item)
                                                        <option value="{{ $item->code }}"
                                                            data-item="{{ json_encode($item) }}">
                                                            {{ $item->name }} (+{{ $item->code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input id="number" type="number" name="number" class="form-control"
                                                    placeholder="Enter phone number" required>
                                                <input type="hidden" id="recaptcha-token" name="recaptcha-token">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark">
                                                <i class="bi bi-gear me-2"></i>Test Configuration
                                            </label>
                                            <div class="form-check form-check-inline d-block mb-2">
                                                <input class="form-check-input" type="radio" name="call"
                                                    id="inlineRadio1" value="0">
                                                <label class="form-check-label" for="inlineRadio1">SMS Testing</label>
                                            </div>
                                            <div class="form-check form-check-inline d-block">
                                                <input class="form-check-input" type="radio" name="call"
                                                    id="inlineRadio2" value="1" checked>
                                                <label class="form-check-label" for="inlineRadio2">Call Testing</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark">
                                                <i class="bi bi-123 me-2"></i>Test Count <small class="text-muted">(max
                                                    30)</small>
                                            </label>
                                            <input id="count" type="number" class="form-control"
                                                placeholder="Number of test messages" max="30" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark">
                                                <i class="bi bi-speedometer2 me-2"></i>Test Speed
                                            </label>
                                            <div class="form-check">
                                                <input type="radio" id="speedLow" name="speed" value="slow"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="speedLow">Slow (4s intervals)</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" id="speedMedium" name="speed" value="medium"
                                                    class="form-check-input">
                                                <label class="form-check-label" for="speedMedium">Medium (2s
                                                    intervals)</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" id="speedFast" name="speed" value="fast"
                                                    class="form-check-input" checked>
                                                <label class="form-check-label" for="speedFast">Fast (1s
                                                    intervals)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress and Status -->
                                    <div class="mt-4">
                                        <div class="alert alert-success d-none" id="showsuccess" role="alert">
                                            <i class="bi bi-check-circle me-2"></i><strong>Test Messages Sent</strong>
                                        </div>

                                        <div class="progress-modern d-none" id="progress-container">
                                            <div class="progress-bar-modern" id="progress-bar" style="width: 0%;"></div>
                                        </div>

                                        <div class="call-progress-panel" id="call-progress-panel">
                                            <div class="call-progress-header">
                                                <div>
                                                    <div class="call-progress-badge">
                                                        <i class="bi bi-telephone-outbound"></i>
                                                        <span>Call campaign running</span>
                                                    </div>
                                                    <h6 class="fw-bold text-dark mt-3 mb-1">Live call delivery status</h6>
                                                    <p class="mb-0 text-muted small">You can watch each request advance in real time.</p>
                                                </div>
                                                <div class="text-end">
                                                    <div class="fw-bold text-primary fs-4" id="progress-percentage">0%</div>
                                                    <div class="text-muted small">completed</div>
                                                </div>
                                            </div>

                                            <div class="call-progress-meta">
                                                <span><i class="bi bi-broadcast me-1"></i>Sent: <strong id="progress-count">0</strong></span>
                                                <span><i class="bi bi-bullseye me-1"></i>Target: <strong id="progress-total">0</strong></span>
                                            </div>

                                            <div class="call-progress-note" id="call-progress-note">
                                                Preparing secure request...
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Disclaimer -->
                                    <div class="info-modern mt-4">
                                        <h6 class="text-info mb-2"><i class="bi bi-info-circle"></i> Testing Guidelines
                                        </h6>
                                        <p class="mb-0 small text-dark">
                                            This tool is intended for legitimate Call service testing and debugging purposes
                                            only.
                                            Ensure you have proper authorization before testing any phone number. Use
                                            responsibly and in compliance with applicable laws.
                                        </p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="text-center mt-4">
                                        <button class="btn btn-tool text-white me-3" type="submit" id="submit-button">
                                            <span class="spinner-border spinner-border-sm d-none"
                                                id="startsms_spinner"></span>
                                            <i class="bi bi-play-circle me-2"></i>
                                            <span id="submitBtnText">Start</span>
                                        </button>
                                        <button class="btn btn-stop text-white d-none" id="stop-sms">
                                            <i class="bi bi-stop-circle me-2"></i>Stop
                                        </button>
                                    </div>

                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="bi bi-wifi me-1"></i>Stay online during testing for accurate results
                                        </small>
                                    </div>
                                </form>

                                <!-- Number Protection Section -->
                                <div class="status-card mt-4">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="bi bi-shield-check me-2"></i>Protect Your Number
                                    </h6>
                                    <p class="text-muted small mb-3">Add your number to our protection list to prevent
                                        testing on your device</p>
                                    <form action="{{ route('save-bomber') }}" method="post"
                                        class="row g-3 align-items-end">
                                        @csrf
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="number"
                                                placeholder="Enter your mobile number (without country code)">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="bi bi-shield-plus me-2"></i>Protect
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Educational Information Section -->
        <section class="py-5">
            <div class="container px-5">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="status-card h-100">
                            <div class="feature-icon bg-primary bg-opacity-20 mb-3">
                                <i class="bi bi-question-circle text-primary fs-2"></i>
                            </div>
                            <h5 class="text-primary fw-bold mb-3">What is Call Testing?</h5>
                            <p class="text-dark mb-0">
                                Call testing is a legitimate process used by developers and businesses to verify Call delivery
                                rates,
                                test notification systems, and ensure proper functionality of messaging services before
                                deployment.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="status-card h-100">
                            <div class="feature-icon bg-warning bg-opacity-20 mb-3">
                                <i class="bi bi-shield-exclamation text-warning fs-2"></i>
                            </div>
                            <h5 class="text-warning fw-bold mb-3">Responsible Testing</h5>
                            <p class="text-dark mb-0">
                                Always ensure you have proper authorization before testing any phone number. This tool
                                should only be used
                                for legitimate business purposes, development testing, or with explicit consent from the
                                number owner.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="status-card h-100">
                            <div class="feature-icon bg-success bg-opacity-20 mb-3">
                                <i class="bi bi-gear text-success fs-2"></i>
                            </div>
                            <h5 class="text-success fw-bold mb-3">How It Works</h5>
                            <p class="text-dark mb-0">
                                This tool connects to various Call gateway APIs to test message delivery. It helps identify
                                the most
                                reliable services for your specific region and use case, ensuring optimal performance for
                                your applications.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Best Practices Section -->
        <section class="py-5 bg-light">
            <div class="container px-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark mb-3">Call Testing Best Practices</h2>
                    <p class="text-muted lead">Professional guidelines for responsible Call testing</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-modern h-100">
                            <h5 class="text-info mb-3"><i class="bi bi-check-circle me-2"></i>Recommended Practices</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-arrow-right text-success me-2"></i>Always obtain proper
                                    consent before testing</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-success me-2"></i>Use test numbers or
                                    your own devices when possible</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-success me-2"></i>Limit test frequency
                                    to avoid service disruption</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-success me-2"></i>Document your
                                    testing procedures for compliance</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-success me-2"></i>Respect carrier
                                    guidelines and regulations</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="warning-modern h-100">
                            <h5 class="text-warning mb-3"><i class="bi bi-exclamation-triangle me-2"></i>Important
                                Considerations</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-arrow-right text-danger me-2"></i>Never use for
                                    harassment or spam</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-danger me-2"></i>Comply with local
                                    telecommunications laws</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-danger me-2"></i>Respect privacy and
                                    data protection regulations</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-danger me-2"></i>Monitor for any
                                    negative impact on recipients</li>
                                <li class="mb-2"><i class="bi bi-arrow-right text-danger me-2"></i>Maintain ethical
                                    testing standards</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <div class="info-modern d-inline-block">
                        <h6 class="text-info mb-2"><i class="bi bi-info-circle me-2"></i>Legal Compliance Notice</h6>
                        <p class="mb-0 small text-dark">
                            This tool is provided for legitimate Call testing and development purposes only. Users are
                            responsible for ensuring
                            compliance with all applicable laws, regulations, and terms of service. We do not condone or
                            support any misuse
                            of this tool for harassment, spam, or any other malicious activities.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        $(document).ready(function() {

            $("#count").on("input", function() {
                if (parseInt($(this).val()) > 30) {
                    $(this).val(30);
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


            const $form = $('#call-bomber-form');
            const $recaptchaTokenInput = $('#recaptcha-token');
            const $submitButton = $('#submit-button');
            const $submitButtonText = $('#submitBtnText');
            const $showSuccess = $('#showsuccess');
            const $stopSMS = $('#stop-sms');
            const $startSpinner = $('#startsms_spinner');
            const $progressBar = $('#progress-bar');
            const $progressContainer = $('#progress-container');
            const $progressPanel = $('#call-progress-panel');
            const $progressCount = $('#progress-count');
            const $progressTotal = $('#progress-total');
            const $progressPercentage = $('#progress-percentage');
            const $progressNote = $('#call-progress-note');

            let xhr = null;
            let totalRequests = 0;
            let completedRequests = 0;
            let stopRequested = false;

            $form.on('submit', function(event) {
                const speed = $('input[name="speed"]:checked').val();
                let timeout = 1000;

                switch (speed) {
                    case 'slow':
                        timeout = 4000;
                        break;
                    case 'medium':
                        timeout = 2000;
                        break;
                    case 'fast':
                        timeout = 1000;
                        break;
                }

                event.preventDefault();
                $stopSMS.removeClass('d-none');

                $submitButton.attr('disabled', 'disabled');
                $submitButtonText.html('Testing...');
                $startSpinner.removeClass('d-none');
                $progressContainer.removeClass('d-none');
                $progressPanel.addClass('is-active');
                $showSuccess.removeClass('d-none');
                stopRequested = false;

                totalRequests = parseInt($('#count').val()) || 5; // Get count from user input
                completedRequests = 0;
                $progressTotal.text(totalRequests);
                $progressCount.text(0);
                $progressPercentage.text('0%');
                $progressNote.text('Preparing secure request...');
                updateProgress(0);

                function sendRequest() {
                    if (stopRequested || completedRequests >= totalRequests) return;

                    $progressNote.text('Connecting to gateway ' + (completedRequests + 1) + ' of ' + totalRequests + '...');

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
                                    if (response && response.success === false) {
                                        handleFailure(response.message || 'Request failed. Please try again.');
                                        return;
                                    }

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
                                        $progressNote.text('Call testing completed successfully.');
                                        $stopSMS.addClass('d-none');
                                        $submitButton.removeAttr('disabled');
                                        $submitButtonText.html('Start Again');
                                        $startSpinner.addClass('d-none');
                                    }
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    if (textStatus === 'abort') {
                                        return;
                                    }

                                    console.error('Error:', textStatus,
                                        errorThrown);
                                    handleFailure('AJAX request failed. Please check the browser console or try again.');
                                }
                            });
                        });
                    });
                }

                // Rewarded interstitial




                sendRequest();
                // Start the first request

            });

            $stopSMS.on('click', function() {
                stopRequested = true;
                if (xhr) xhr.abort();
                $stopSMS.addClass('d-none');
                $form.removeClass('d-none');
                $progressContainer.addClass('d-none');
                $progressPanel.removeClass('is-active');
                location.reload();
            });

            function updateProgress(count) {
                var percentage = (count / totalRequests) * 100;
                $showSuccess.removeClass('d-none');
                $showSuccess.html('<i class="bi bi-check-circle me-2"></i><strong>' + count +
                    ' Call requests completed</strong>');
                $progressBar.css('width', percentage + '%').attr('aria-valuenow', percentage);
                $progressCount.text(count);
                $progressPercentage.text(Math.round(percentage) + '%');
                $progressNote.text(count < totalRequests ?
                    'Call attempts are being sent one by one.' :
                    'All call attempts have been finished.');
            }

            function handleFailure(message) {
                stopRequested = true;
                $submitButton.removeAttr('disabled');
                $submitButtonText.html('Start Again');
                $startSpinner.addClass('d-none');
                $stopSMS.addClass('d-none');
                $showSuccess.removeClass('d-none').removeClass('alert-success').addClass('alert-danger');
                $showSuccess.html('<i class="bi bi-exclamation-triangle me-2"></i><strong>' + message + '</strong>');
                $progressNote.text(message);
            }
        });
    </script>
@stop
