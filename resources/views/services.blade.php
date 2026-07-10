@extends('layouts.master')

@section('title', 'Custom Web & App Development Services | Hire Expert Developers')
@section('description',
    'Transform your business with our expert web and mobile app development services. Get a custom
    solution tailored to your needs with transparent pricing and fast delivery.')

@section('styles')
    <style>
        /* Hero Section Styling */
        .hero-section {
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            padding: 100px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDQwIiBoZWlnaHQ9Ijc3NiIgZmlsbD0ibm9uZSIgdmlld0JveD0iMCAwIDE0NDAgNzc2Ij48ZyBvcGFjaXR5PSIuMSI+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTAgNzc2VjBIMTQ0MHY3NzZIMFptNzIwLTc3NmMtMTM4LjA3IDAtMjUwIDExMS45My0yNTAgMjUwUzU4MS45MyA1MDAgNzIwIDUwMHMyNTAtMTExLjkzIDI1MC0yNTAtMTExLjkzLTI1MC0yNTAtMjUwWk01NDAgNTAwYy0xMzguMDcgMC0yNTAgMTExLjkzLTI1MCAyNTBzMTExLjkzIDI1MCAyNTAgMjUwIDI1MC0xMTEuOTMgMjUwLTI1MC0xMTEuOTMtMjUwLTI1MC0yNTBaTTkwMCA1MDBjLTEzOC4wNyAwLTI1MCAxMTEuOTMtMjUwIDI1MHMxMTEuOTMgMjUwIDI1MCAyNTAgMjUwLTExMS45MyAyNTAtMjUwLTExMS45My0yNTAtMjUwLTI1MFptMTgwLTIzMGE1MCA1MCAwIDEgMCAwLTEwMCA1MCA1MCAwIDAgMCAwIDEwMFpNMzEwIDQwNmE0MCA0MCAwIDEgMCAwLTgwIDQwIDQwIDAgMCAwIDAgODBabTExMzAtMTA2YTMwIDMwIDAgMSAwIDAtNjAgMzAgMzAgMCAwIDAgMCA2MFptLTY3MCA3MGE0MCA0MCAwIDEgMCAwLTgwIDQwIDQwIDAgMCAwIDAgODBaTTI0MCAxMzZhNDAgNDAgMCAxIDAgMC04MCA0MCA0MCAwIDAgMCAwIDgwWm05NDAgNDQwYTQwIDQwIDAgMSAwIDAtODAgNDAgNDAgMCAwIDAgMCA4MFoiLz48L2c+PC9zdmc+');
            opacity: 0.2;
        }

        .hero-text h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .hero-text p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* Services Styling */
        .service-card {
            border: none;
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            color: white;
        }

        .feature-item {
            display: flex;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            margin-right: 1rem;
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 50%;
            background-color: rgba(0, 159, 253, 0.1);
            color: #009ffd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Testimonial Section */
        .testimonial-card {
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            position: relative;
        }

        .testimonial-card:before {
            content: "" ";
     position: absolute;
            top: 0;
            left: 20px;
            font-size: 5rem;
            color: rgba(0, 159, 253, 0.1);
            line-height: 1;
        }

        .client-info {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
        }

        .client-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }

        /* Process Section */
        .process-item {
            text-align: center;
            position: relative;
        }

        .process-number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0 auto 1.5rem;
        }

        .process-connector {
            position: absolute;
            top: 30px;
            right: -50%;
            width: 100%;
            height: 2px;
            background-color: #e9ecef;
            z-index: -1;
        }

        .process-item:last-child .process-connector {
            display: none;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            padding: 5rem 0;
            color: white;
            text-align: center;
            border-radius: 10px;
            margin: 3rem 0;
        }

        /* Contact Form */
        .contact-form-wrapper {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
        }

        .contact-info-item {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 50%;
            background-color: rgba(0, 159, 253, 0.1);
            color: #009ffd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        /* FAQ Section */
        .faq-section {
            padding: 5rem 0;
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(0, 159, 253, 0.1);
            color: #009ffd;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0, 159, 253, 0.1);
        }

        /* Project Counter */
        .counter-box {
            text-align: center;
            padding: 2rem 1rem;
        }

        .counter-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #009ffd;
            margin-bottom: 0.5rem;
        }

        .counter-text {
            font-size: 1rem;
            color: #6c757d;
        }

        /* Lead Form */
        .lead-form {
            background-color: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .lead-form h3 {
            margin-bottom: 1.5rem;
        }

        .service-checkbox-group {
            margin: 1.5rem 0;
        }

        .service-checkbox {
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2a2a72 0%, #009ffd 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 159, 253, 0.2);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2.5rem;
            }

            .process-connector {
                display: none;
            }

            .process-item {
                margin-bottom: 2rem;
            }
        }
    </style>
@endsection

@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://kit.fontawesome.com/3b4d3127f4.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('sendMessage') }}"]');
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Reset previous states
                clearValidationErrors();
                successMessage.classList.add('d-none');
                errorMessage.classList.add('d-none');

                // Show loading state
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
                submitBtn.disabled = true;

                // Client-side validation
                if (!validateForm()) {
                    resetSubmitButton(originalText);
                    return;
                }

                // Prepare form data
                const formData = new FormData(form);

                // Add selected services as a single string
                const selectedServices = [];
                document.querySelectorAll('input[name="services[]"]:checked').forEach(checkbox => {
                    selectedServices.push(checkbox.value);
                });

                // If services are selected, add them to the message
                let message = formData.get('message');
                if (selectedServices.length > 0) {
                    message += '\n\nInterested Services: ' + selectedServices.join(', ');
                    formData.set('message', message);
                }

                // Submit form via AJAX
                fetch('{{ route('sendMessage') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else if (response.status === 422) {
                            return response.json().then(data => {
                                throw new Error(JSON.stringify(data.errors));
                            });
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .then(data => {
                        // Success
                        successMessage.classList.remove('d-none');
                        form.reset();
                        grecaptcha.reset();

                        // Scroll to success message
                        successMessage.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        try {
                            const errors = JSON.parse(error.message);
                            displayValidationErrors(errors);
                        } catch (e) {
                            errorText.textContent = 'Something went wrong. Please try again.';
                            errorMessage.classList.remove('d-none');
                        }
                    })
                    .finally(() => {
                        resetSubmitButton(originalText);
                    });
            });

            function validateForm() {
                let isValid = true;

                // Basic validation for required fields
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Email validation
                const emailField = form.querySelector('input[name="email"]');
                if (emailField.value.trim() && !validateEmail(emailField.value.trim())) {
                    emailField.classList.add('is-invalid');
                    isValid = false;
                }

                // Check recaptcha
                const recaptchaResponse = grecaptcha.getResponse();
                if (recaptchaResponse.length === 0) {
                    showRecaptchaError();
                    isValid = false;
                } else {
                    hideRecaptchaError();
                }

                if (!isValid) {
                    // Scroll to the first error
                    const firstError = document.querySelector('.is-invalid, .border-danger');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }

                return isValid;
            }

            function displayValidationErrors(errors) {
                Object.keys(errors).forEach(fieldName => {
                    const field = form.querySelector(`[name="${fieldName}"]`);
                    if (field) {
                        field.classList.add('is-invalid');

                        // Find or create invalid feedback element
                        let feedback = field.parentNode.querySelector('.invalid-feedback');
                        if (!feedback) {
                            feedback = document.createElement('div');
                            feedback.classList.add('invalid-feedback');
                            field.parentNode.appendChild(feedback);
                        }
                        feedback.textContent = errors[fieldName][0];
                    }
                });

                // Show general error message
                errorText.textContent = 'Please correct the errors below.';
                errorMessage.classList.remove('d-none');
            }

            function clearValidationErrors() {
                // Remove all validation error classes
                form.querySelectorAll('.is-invalid').forEach(field => {
                    field.classList.remove('is-invalid');
                });

                // Hide custom error messages
                form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                    feedback.textContent = '';
                });

                hideRecaptchaError();
            }

            function showRecaptchaError() {
                const recaptchaWrapper = document.querySelector('.g-recaptcha');
                recaptchaWrapper.classList.add('is-invalid');

                let recaptchaError = document.querySelector('.recaptcha-error');
                if (!recaptchaError) {
                    recaptchaError = document.createElement('div');
                    recaptchaError.classList.add('text-danger', 'mt-2', 'recaptcha-error');
                    recaptchaWrapper.parentNode.appendChild(recaptchaError);
                }
                recaptchaError.textContent = 'Please complete the reCAPTCHA verification';
            }

            function hideRecaptchaError() {
                const recaptchaWrapper = document.querySelector('.g-recaptcha');
                recaptchaWrapper.classList.remove('is-invalid');

                const recaptchaError = document.querySelector('.recaptcha-error');
                if (recaptchaError) {
                    recaptchaError.remove();
                }
            }

            function resetSubmitButton(originalText) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }

            // Helper function for email validation
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });
    </script>
@endsection

@section('content')
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7 hero-text">
                        <span class="hero-badge"><i class="fas fa-check-circle me-2"></i>Professional Development
                            Services</span>
                        <h1>Transform Your Ideas into Digital Reality</h1>
                        <p>Expert web and mobile app development tailored to your business needs. From concept to launch –
                            we build solutions that drive results.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#get-quote" class="btn btn-light btn-lg px-4 py-3 fw-bold">
                                <i class="fas fa-paper-plane me-2"></i>Get Free Quote
                            </a>
                            <a href="#our-services" class="btn btn-outline-light btn-lg px-4 py-3">
                                <i class="fas fa-info-circle me-2"></i>Explore Services
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&h=600&q=80"
                            alt="Web and App Development" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Counter Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-3 col-6">
                        <div class="counter-box">
                            <div class="counter-number">120+</div>
                            <div class="counter-text">Projects Completed</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="counter-box">
                            <div class="counter-number">95%</div>
                            <div class="counter-text">Client Satisfaction</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="counter-box">
                            <div class="counter-number">15+</div>
                            <div class="counter-text">Industries Served</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="counter-box">
                            <div class="counter-number">5+</div>
                            <div class="counter-text">Years Experience</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="our-services" class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold">OUR SERVICES</h6>
                    <h2 class="fw-bold mb-3">Expert Development Solutions</h2>
                    <p class="text-muted">Comprehensive web and mobile app development services to elevate your business</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="service-card card h-100 shadow">
                            <div class="card-body p-4">
                                <div class="service-icon">
                                    <i class="fas fa-laptop-code"></i>
                                </div>
                                <h4 class="card-title text-center mb-4 text-dark">Website Development</h4>
                                <p class="card-text text-dark">Custom websites designed to impress visitors and convert them
                                    into
                                    customers. We build responsive, SEO-friendly sites that look great on all devices.</p>

                                <hr class="my-4">

                                <h5 class="fw-bold mb-3 text-dark">What we offer:</h5>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">E-Commerce Solutions</h6>
                                        <p class="mb-0 text-muted">Custom online stores with secure payment gateways</p>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">Business Websites</h6>
                                        <p class="mb-0 text-muted">Professional corporate sites that build credibility</p>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">Web Applications</h6>
                                        <p class="mb-0 text-muted">Custom web apps with advanced functionality</p>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="#get-quote" class="btn btn-primary px-4">Get a Quote</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="service-card card h-100 shadow">
                            <div class="card-body p-4">
                                <div class="service-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h4 class="card-title text-center mb-4 text-dark">Mobile App Development</h4>
                                <p class="card-text text-dark">Powerful, feature-rich Android apps that connect you with
                                    your audience
                                    on mobile. We create intuitive, high-performance apps that users love.</p>

                                <hr class="my-4">

                                <h5 class="fw-bold mb-3 text-dark">What we offer:</h5>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fab fa-android"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">Android Applications</h6>
                                        <p class="mb-0 text-muted">Native apps with smooth performance and rich features</p>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-sync"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">App Maintenance</h6>
                                        <p class="mb-0 text-muted">Regular updates and performance improvements</p>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-cloud"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">API Integration</h6>
                                        <p class="mb-0 text-muted">Connect your app with essential services and platforms
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="#get-quote" class="btn btn-primary px-4">Get a Quote</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold">OUR PROCESS</h6>
                    <h2 class="fw-bold mb-3">How We Work</h2>
                    <p class="text-muted">Our streamlined development process ensures quality and efficiency</p>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="process-item">
                            <div class="process-number">1</div>
                            <h5 class="fw-bold">Discovery</h5>
                            <p class="text-muted">We understand your requirements and business goals</p>
                            <div class="process-connector"></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="process-item">
                            <div class="process-number">2</div>
                            <h5 class="fw-bold">Planning</h5>
                            <p class="text-muted">We create a detailed roadmap and technical strategy</p>
                            <div class="process-connector"></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="process-item">
                            <div class="process-number">3</div>
                            <h5 class="fw-bold">Development</h5>
                            <p class="text-muted">We build your solution with regular updates and feedback</p>
                            <div class="process-connector"></div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="process-item">
                            <div class="process-number">4</div>
                            <h5 class="fw-bold">Launch</h5>
                            <p class="text-muted">We deploy your project and provide ongoing support</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold">FREQUENTLY ASKED QUESTIONS</h6>
                    <h2 class="fw-bold mb-3">Common Questions</h2>
                    <p class="text-muted">Find answers to the most frequently asked questions about our services</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        How long does it take to develop a website or app?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        The timeline depends on the complexity of your project. A simple website can be
                                        completed in 2-3 weeks, while a complex web application or mobile app might take 2-3
                                        months. During our initial consultation, we'll provide a detailed timeline based on
                                        your specific requirements.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How much does it cost to develop a website or app?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Our pricing is transparent and depends on project scope, features, and complexity.
                                        Basic websites start at $1,000, while mobile applications typically start at $5,000.
                                        We provide detailed quotes after understanding your requirements to ensure there are
                                        no surprises.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Do you provide ongoing support after launch?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, we offer various maintenance and support packages to keep your website or app
                                        running smoothly. These include regular updates, security patches, performance
                                        optimization, content updates, and technical support. We recommend these services to
                                        protect your investment and ensure optimal performance.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Will my website be mobile-friendly?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="faqFour"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Absolutely! All our websites are built with a mobile-first approach and are fully
                                        responsive, ensuring they look great and function perfectly on all devices including
                                        smartphones, tablets, laptops, and desktop computers. This is essential for SEO and
                                        providing the best user experience.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faqFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        What information do you need to get started?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="faqFive"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        To get started, we need to understand your business goals, target audience, project
                                        requirements, design preferences, and timeline. The more details you can provide,
                                        the better we can align our solutions with your vision. Don't worry if you don't
                                        have all the details figured out - our discovery process will help clarify your
                                        needs.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5">
            <div class="container text-center">
                <div class="cta-section">
                    <h2 class="fw-bold mb-3">Ready to Transform Your Business?</h2>
                    <p class="mb-4 fs-5">Let's discuss how our web and app development services can help you achieve your
                        goals.</p>
                    <a href="#get-quote" class="btn btn-light px-5 py-3 fw-bold">Get Started Today</a>
                </div>
            </div>
        </section>

        <!-- Lead Form Section -->
        <section id="get-quote" class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="lead-form">
                            <h3 class="text-center fw-bold mb-4">Request a Free Quote</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('sendMessage') }}">
                                @csrf
                                <!-- Name input -->
                                <div class="mb-3">
                                    <label class="form-label">Full Name*</label>
                                    <input class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        name="name" type="text" placeholder="Your name"
                                        value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email input -->
                                <div class="mb-3">
                                    <label class="form-label">Email Address*</label>
                                    <input class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        name="email" type="email" placeholder="Your email"
                                        value="{{ old('email') }}" required />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone input -->
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input class="form-control form-control-lg" name="phone" type="tel"
                                        placeholder="Your phone number" value="{{ old('phone') }}" />
                                </div>

                                <!-- Service Selection -->
                                <div class="mb-4">
                                    <label class="form-label">I'm interested in:*</label>
                                    <div class="service-checkbox-group">
                                        <div class="form-check service-checkbox">
                                            <input class="form-check-input" type="checkbox" name="services[]"
                                                value="Website Development" id="service1">
                                            <label class="form-check-label text-light" for="service1">
                                                Website Development
                                            </label>
                                        </div>
                                        <div class="form-check service-checkbox">
                                            <input class="form-check-input" type="checkbox" name="services[]"
                                                value="E-Commerce Website" id="service2">
                                            <label class="form-check-label text-light" for="service2">
                                                E-Commerce Website
                                            </label>
                                        </div>
                                        <div class="form-check service-checkbox">
                                            <input class="form-check-input" type="checkbox" name="services[]"
                                                value="Android App Development" id="service3">
                                            <label class="form-check-label text-light" for="service3">
                                                Android App Development
                                            </label>
                                        </div>
                                        <div class="form-check service-checkbox">
                                            <input class="form-check-input" type="checkbox" name="services[]"
                                                value="Website Redesign" id="service4">
                                            <label class="form-check-label text-light" for="service4">
                                                Website Redesign
                                            </label>
                                        </div>
                                        <div class="form-check service-checkbox">
                                            <input class="form-check-input" type="checkbox" name="services[]"
                                                value="Maintenance & Support" id="service5">
                                            <label class="form-check-label text-light" for="service5">
                                                Maintenance & Support
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Project Description -->
                                <div class="mb-4">
                                    <label class="form-label">Tell us about your project:*</label>
                                    <textarea class="form-control form-control-lg @error('message') is-invalid @enderror" name="message" rows="5"
                                        placeholder="Please describe your project needs, timeline, and any specific features you're looking for..."
                                        required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Budget Range -->
                                <div class="mb-4">
                                    <label class="form-label">Your Budget Range:</label>
                                    <select class="form-select form-select-lg" name="budget">
                                        <option value="">Select your budget range</option>
                                        <option value="$500 - $1,000"
                                            {{ old('budget') == '$500 - $1,000' ? 'selected' : '' }}>$500 - $1,000
                                        </option>
                                        <option value="$1,000 - $5,000"
                                            {{ old('budget') == '$1,000 - $5,000' ? 'selected' : '' }}>$1,000 - $5,000
                                        </option>
                                        <option value="$5,000 - $10,000"
                                            {{ old('budget') == '$5,000 - $10,000' ? 'selected' : '' }}>$5,000 -
                                            $10,000</option>
                                        <option value="$10,000+" {{ old('budget') == '$10,000+' ? 'selected' : '' }}>
                                            $10,000+</option>
                                    </select>
                                </div>

                                <!-- reCAPTCHA -->
                                <div class="mb-4">
                                    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
                                        data-sitekey="6LdMKyQrAAAAAOPzmrMHE5WvkXll1A_LkYYAklcl"></div>
                                    @error('g-recaptcha-response')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg py-3" type="submit" id="submitBtn">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Request
                                    </button>
                                </div>

                                <p class="text-center mt-3 text-muted">
                                    <small>* Required fields. We'll get back to you within 24 hours.</small>
                                </p>
                            </form>

                            <!-- Success Message -->
                            <div id="successMessage" class="alert alert-success d-none mt-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Thank you!</strong> Your message has been sent successfully. We'll get back to you
                                within 24 hours.
                            </div>

                            <!-- Error Message -->
                            <div id="errorMessage" class="alert alert-danger d-none mt-4" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Error!</strong> <span id="errorText">Something went wrong. Please try again.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Info Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h6 class="text-primary fw-bold">GET IN TOUCH</h6>
                    <h2 class="fw-bold mb-3">Contact Us</h2>
                    <p class="text-muted">Have questions? Reach out to us directly</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Email Us</h5>
                                <p class="mb-0">contact@autolikerlive.com</p>
                                <p class="mb-0 text-muted">We reply within 24 hours</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Call Us</h5>
                                <p class="mb-0">+91</p>
                                <p class="mb-0 text-muted">Mon-Fri, 9am-5pm</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold">Live Chat</h5>
                                <p class="mb-0">Available on our website</p>
                                <p class="mb-0 text-muted">24/7 Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
