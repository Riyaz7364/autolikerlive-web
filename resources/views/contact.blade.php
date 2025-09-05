@extends('layouts.master')

@section('title', __('messages.contact.meta_title'))
@section('description', __('messages.contact.meta_desc'))

@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@stop

@section('content')

    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-navbar></x-navbar>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Hero Section -->
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-primary mb-3">Contact Us</h1>
                    <p class="lead text-muted mb-0">We're here to help you succeed with your social media growth</p>
                </div>

                <!-- Contact form-->
                <div class="bg-dark rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">

                        <h2 class="fw-bolder text-white">Get in touch</h2>
                        <p class="lead fw-normal text-muted mb-0">We'd love to hear from you and help with any questions</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <form method="POST" action="{{ route('sendMessage') }}">
                                @csrf
                                <!-- Name input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="name" type="text"
                                        placeholder="Enter your name..." required />
                                    <label for="name">Full name</label>
                                    <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                                </div>
                                <!-- Email address input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="email" type="email" placeholder="name@example.com"
                                        required />
                                    <label for="email">Email address</label>
                                    <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.
                                    </div>
                                    <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                                </div>
                                <!-- Subject input-->
                                <div class="form-floating mb-3">
                                    <select class="form-control form-select" name="subject" required>
                                        <option value="">Choose a topic...</option>
                                        <option value="general">General Inquiry</option>
                                        <option value="technical">Technical Support</option>
                                        <option value="billing">Billing Question</option>
                                        <option value="feature">Feature Request</option>
                                        <option value="partnership">Partnership Opportunity</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <label for="subject">Subject</label>
                                </div>
                                <!-- Message input-->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="message" type="text" placeholder="Enter your message here..."
                                        style="height: 10rem" required></textarea>
                                    <label for="message">Message</label>
                                    <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.
                                    </div>
                                </div>
                                <!-- Submit Button-->
                                <div class="g-recaptcha" data-sitekey="6LdMKyQrAAAAAOPzmrMHE5WvkXll1A_LkYYAklcl"></div>
                                <div class="d-grid"><button class="btn btn-primary btn-lg" id="submitButton"
                                        type="submit">Send Message</button></div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Support Options -->
                <div class="row gx-5 py-5 mb-5">
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 mx-auto"
                                    style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    {!! getIcon('chat-dots', 'feature') !!}
                                </div>
                                <h3 class="h5 mb-3">Live Chat Support</h3>
                                <p class="text-muted mb-3">Get instant help from our support team through live chat.
                                    Available 24/7 for all your questions.</p>
                                <a href="#" class="btn btn-outline-primary">Start Chat</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 mx-auto"
                                    style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    {!! getIcon('envelope', 'feature') !!}
                                </div>
                                <h3 class="h5 mb-3">Email Support</h3>
                                <p class="text-muted mb-3">Send us an email and we'll respond within 24 hours. Perfect for
                                    detailed questions and feedback.</p>
                                <a href="mailto:support@autolikerlive.com" class="btn btn-outline-primary">Send Email</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 mx-auto"
                                    style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    {!! getIcon('question-circle', 'feature') !!}
                                </div>
                                <h3 class="h5 mb-3">Help Center</h3>
                                <p class="text-muted mb-3">Browse our comprehensive FAQ section and find answers to common
                                    questions instantly.</p>
                                <a href="{{ route('faq') }}" class="btn btn-outline-primary">View FAQ</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Contact Us Section -->
                <div class="bg-light rounded-3 p-5 mb-5">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="fw-bold text-primary mb-4">Why Contact Our Support Team?</h2>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            {!! getIcon('clock', 'text-primary fs-4 me-3') !!}
                                        </div>
                                        <div>
                                            <h4 class="h6 fw-bold mb-1">24/7 Availability</h4>
                                            <p class="text-muted small mb-0">Our support team is available around the clock
                                                to help you succeed</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            {!! getIcon('user-graduate', 'text-primary fs-4 me-3') !!}
                                        </div>
                                        <div>
                                            <h4 class="h6 fw-bold mb-1">Expert Guidance</h4>
                                            <p class="text-muted small mb-0">Get personalized advice from social media
                                                growth experts</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            {!! getIcon('rocket', 'text-primary fs-4 me-3') !!}
                                        </div>
                                        <div>
                                            <h4 class="h6 fw-bold mb-1">Growth Strategies</h4>
                                            <p class="text-muted small mb-0">Learn proven strategies to maximize your
                                                social media growth</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <img src="/images/support-team.svg" alt="Support Team" class="img-fluid"
                                    style="max-height: 300px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response Time Guarantee -->
                <div class="card border-primary mb-5">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="card-title text-primary mb-2">Our Response Time Guarantee</h3>
                                <p class="card-text mb-0">We're committed to providing fast, helpful support. Here's what
                                    you can expect:</p>
                                <ul class="list-unstyled mt-3 mb-0">
                                    <li>{!! getIcon('check', 'text-success me-2') !!}<strong>Live Chat:</strong> Instant
                                        response during business hours</li>
                                    <li>{!! getIcon('check', 'text-success me-2') !!}<strong>Email:</strong> Response
                                        within 24 hours</li>
                                    <li>{!! getIcon('check', 'text-success me-2') !!}<strong>Critical Issues:</strong>
                                        Priority handling within 2 hours</li>
                                </ul>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    {!! getIcon('stopwatch', 'fs-2') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Social/Contact section moved inside main container, not duplicated -->
    @stop
