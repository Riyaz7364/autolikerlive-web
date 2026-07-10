<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account Request - AutoLiker Live</title>
    {{-- Bootstrap CSS removed for Tailwind migration --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .delete-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .delete-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .delete-body {
            padding: 40px;
        }

        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #c82333, #a71e2a);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-back {
            background: #6c757d;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
            text-decoration: none;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .text-danger {
            font-size: 0.875em;
            margin-top: 5px;
        }

        .confirmation-checkbox {
            margin: 20px 0;
        }

        .confirmation-checkbox input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 10px;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="delete-container">
            <div class="delete-header">
                <i class="fas fa-user-times fa-3x mb-3"></i>
                <h2 class="mb-0">Delete Account Request</h2>
                <p class="mb-0 mt-2">We're sorry to see you go</p>
            </div>

            <div class="delete-body">
                <!-- Success Message -->
                <div id="success-message" class="alert alert-success d-none">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="success-text"></span>
                </div>

                <!-- Error Message -->
                <div id="error-message" class="alert alert-danger d-none">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="error-text"></span>
                </div>

                <!-- Warning Box -->
                <div class="warning-box">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notice</h6>
                    <ul class="mb-0 mt-2">
                        <li>Account deletion is permanent and cannot be undone</li>
                        <li>All your data, likes, and activity will be permanently removed</li>
                        <li>You will lose access to all premium features</li>
                        <li>Processing may take up to 48 hours</li>
                    </ul>
                </div>

                <form id="deleteAccountForm" method="POST" action="{{ route('delete-account-request') }}">
                    @csrf

                    <!-- Facebook Username -->
                    <div class="mb-3">
                        <label for="facebook_username" class="form-label">
                            <i class="fab fa-facebook me-2"></i>Facebook Username *
                        </label>
                        <input type="text" class="form-control @error('facebook_username') is-invalid @enderror"
                            id="facebook_username" name="facebook_username" value="{{ old('facebook_username') }}"
                            placeholder="Enter your Facebook username" required>
                        @error('facebook_username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Enter the exact Facebook username associated with your account</small>
                    </div>

                    <!-- Reason -->
                    <div class="mb-3">
                        <label for="reason" class="form-label">
                            <i class="fas fa-comment me-2"></i>Reason for Deletion *
                        </label>
                        <select class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason"
                            required>
                            <option value="">Select a reason...</option>
                            <option value="Privacy concerns"
                                {{ old('reason') == 'Privacy concerns' ? 'selected' : '' }}>Privacy concerns</option>
                            <option value="No longer need the service"
                                {{ old('reason') == 'No longer need the service' ? 'selected' : '' }}>No longer need the
                                service</option>
                            <option value="Found alternative solution"
                                {{ old('reason') == 'Found alternative solution' ? 'selected' : '' }}>Found alternative
                                solution</option>
                            <option value="Account security issues"
                                {{ old('reason') == 'Account security issues' ? 'selected' : '' }}>Account security
                                issues</option>
                            <option value="Technical problems"
                                {{ old('reason') == 'Technical problems' ? 'selected' : '' }}>Technical problems
                            </option>
                            <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('reason')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Comments -->
                    <div class="mb-3">
                        <label for="additional_comments" class="form-label">
                            <i class="fas fa-edit me-2"></i>Additional Comments (Optional)
                        </label>
                        <textarea class="form-control @error('additional_comments') is-invalid @enderror" id="additional_comments"
                            name="additional_comments" rows="3" placeholder="Any additional information you'd like to share...">{{ old('additional_comments') }}</textarea>
                        @error('additional_comments')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation Checkbox -->
                    <div class="confirmation-checkbox">
                        <div class="form-check">
                            <input class="form-check-input @error('confirm_deletion') is-invalid @enderror"
                                type="checkbox" id="confirm_deletion" name="confirm_deletion" value="1"
                                {{ old('confirm_deletion') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="confirm_deletion">
                                <strong>I understand that this action is permanent and cannot be undone. I want to
                                    delete my account.</strong>
                            </label>
                        </div>
                        @error('confirm_deletion')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </a>

                        <button type="submit" class="btn btn-delete" id="submitBtn">
                            <span id="submit-text">
                                <i class="fas fa-trash me-2"></i>Submit Delete Request
                            </span>
                            <span id="loading-text" class="d-none">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#deleteAccountForm').on('submit', function(e) {
                e.preventDefault();

                // Show loading state
                $('#submitBtn').prop('disabled', true);
                $('#submit-text').addClass('d-none');
                $('#loading-text').removeClass('d-none');

                // Hide previous messages
                $('#success-message, #error-message').addClass('d-none');

                // Get form data
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#success-text').text(response.message);
                        $('#success-message').removeClass('d-none');

                        // Reset form
                        $('#deleteAccountForm')[0].reset();
                        $('#confirm_deletion').prop('checked', false);

                        // Reset reCAPTCHA
                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.reset();
                        }

                        // Scroll to top to show success message
                        $('.delete-container').animate({
                            scrollTop: 0
                        }, 500);
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors || {};
                        var message = xhr.responseJSON?.message ||
                            'An error occurred. Please try again.';

                        if (Object.keys(errors).length > 0) {
                            var errorList = Object.values(errors).flat().join('<br>');
                            $('#error-text').html(errorList);
                        } else {
                            $('#error-text').text(message);
                        }

                        $('#error-message').removeClass('d-none');

                        // Reset reCAPTCHA on error
                        if (typeof grecaptcha !== 'undefined') {
                            grecaptcha.reset();
                        }

                        // Scroll to top to show error message
                        $('.delete-container').animate({
                            scrollTop: 0
                        }, 500);
                    },
                    complete: function() {
                        // Reset button state
                        $('#submitBtn').prop('disabled', false);
                        $('#submit-text').removeClass('d-none');
                        $('#loading-text').addClass('d-none');
                    }
                });
            });
        });
    </script>
</body>

</html>
