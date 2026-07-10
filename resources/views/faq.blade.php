@extends('layouts.master')

@section('title', 'Frequently Asked Questions - AutolikerLive')
@section('description', 'Find answers to common questions about AutolikerLive\'s social media engagement tools,
    community features, and how our platform helps you grow your online presence responsibly.')

@section('content')
    @php
        $arrFaqs = [
            [
                'name' => 'Where is my token stored?',
                'content' =>
                    'We do not store your token on our servers. Instead, it is stored in your app memory to enhance security and prevent spam.',
            ],
            [
                'name' => 'Is it safe to use with my real account?',
                'content' =>
                    'For security reasons, we recommend using a secondary or test account instead of your main account.',
            ],
            [
                'name' => 'Why does Facebook sometimes ask for identity confirmation?',
                'content' => '
            <p class="text-dark">Facebook may request identity confirmation when unusual login activity is detected. This is part of their security measures to protect user accounts.</p>
            <h3 class="text-dark">Possible Reasons:</h3>
            <ul>
                <li><strong>Unrecognized Login:</strong> If your account is accessed from a different location or device, Facebook may require verification.</li>
                <li><strong>Security Checks:</strong> Facebook uses security algorithms to prevent unauthorized access.</li>
            </ul>
            <h3 class="text-dark">How to Resolve:</h3>
            <ul>
                <li>Log into Facebook and follow the verification steps.</li>
                <li>Ensure you always log in from trusted devices.</li>
            </ul>
            <p class="text-dark">Understanding these security checks helps protect your account and ensures smooth access.</p>
        ',
            ],
        ];

        $generalFaqs = [
            [
                'name' => 'How does the community engagement system work?',
                'content' =>
                    'Our platform works on a simple principle of mutual support. Users participate in our community by engaging with other members\' content - viewing posts, showing appreciation through likes, and following accounts they find interesting. This creates a reciprocal environment where everyone benefits from increased visibility and engagement from real people with similar interests.',
            ],
            [
                'name' => 'How do you ensure authentic engagement?',
                'content' =>
                    'Our platform is built around a community of real users with genuine interest in mutual growth. We focus on connecting people with similar interests who can provide meaningful engagement to each other\'s content. This community-based approach ensures that interactions come from actual people who are actively participating in the platform.',
            ],
            [
                'name' => 'Is using your service safe for my social media accounts?',
                'content' =>
                    'We prioritize account safety by designing our tools to work within platform guidelines. We never request passwords or access tokens, and our community-based approach focuses on connecting real users who engage with each other\'s content in a natural way. We recommend always using social media services responsibly and in accordance with each platform\'s terms of service.',
            ],
            [
                'name' => 'How long does it take to see increased engagement?',
                'content' =>
                    'When you participate in our community, you can typically begin to see increased engagement on your content within a short period. The timing varies based on community activity and your level of participation, but many users notice improvements in their visibility soon after joining our platform.',
            ],
            [
                'name' => 'Is there a limit to how much I can participate in the community?',
                'content' =>
                    'There are no strict limits on community participation. The more actively you engage with others in our community, the more opportunities you create for reciprocal engagement. We encourage balanced, consistent participation that builds genuine connections over time.',
            ],
            [
                'name' => 'Can I use the service for multiple social media platforms?',
                'content' =>
                    'Yes! Our platform supports Instagram, TikTok, Facebook, and YouTube. You can use your earned credits across all supported platforms to grow your presence wherever you\'re most active.',
            ],
        ];

        $technicalFaqs = [
            [
                'name' => 'Do I need to download an app?',
                'content' =>
                    'While we offer both web and mobile app versions, downloading our app provides the best experience with faster processing, push notifications, and easier credit earning through mobile-optimized tasks.',
            ],
            [
                'name' => 'What devices are supported?',
                'content' =>
                    'Our service works on all devices - smartphones, tablets, laptops, and desktop computers. Our responsive web platform adapts to any screen size, and our mobile app is available for both Android and iOS devices.',
            ],
            [
                'name' => 'What if I encounter technical issues?',
                'content' =>
                    'Our technical support team is available 24/7 to help resolve any issues. You can contact us through our support email, live chat, or submit a ticket through our help center. Most issues are resolved within a few hours.',
            ],
            [
                'name' => 'How do I track my credit balance and order history?',
                'content' =>
                    'Your dashboard provides real-time tracking of your credit balance, earning history, and all your orders. You can see pending orders, completed deliveries, and detailed analytics of your account growth.',
            ],
        ];

    @endphp
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <!-- Page Content-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder display-4 mb-3">Frequently Asked Questions</h1>
                    <p class="lead fw-normal text-muted mb-0">Find comprehensive answers to all your questions about our
                        services</p>
                </div>
                <div class="row gx-5">
                    <div class="col-xl-8">
                        <!-- Security FAQ Section -->
                        <h2 class="fw-bolder mb-3 text-primary">🔒 Security & Account Safety</h2>
                        <div class="accordion mb-5" id="securityAccordion">
                            @for ($i = 0; $i < count($arrFaqs); $i++)
                                <div class="accordion-item border-0 shadow-sm mb-3">
                                    <h3 class="accordion-header" id="securityHeading{{ $i }}">
                                        <button class="accordion-button collapsed fw-semibold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#securityCollapse{{ $i }}"
                                            aria-expanded="false" aria-controls="securityCollapse{{ $i }}">
                                            {{ $arrFaqs[$i]['name'] }}
                                        </button>
                                    </h3>
                                    <div class="accordion-collapse collapse" id="securityCollapse{{ $i }}"
                                        aria-labelledby="securityHeading{{ $i }}"
                                        data-bs-parent="#securityAccordion">
                                        <div class="accordion-body">
                                            {!! $arrFaqs[$i]['content'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- General Questions Section -->
                        <h2 class="fw-bolder mb-3 text-primary">💡 General Questions</h2>
                        <div class="accordion mb-5" id="generalAccordion">
                            @for ($i = 0; $i < count($generalFaqs); $i++)
                                <div class="accordion-item border-0 shadow-sm mb-3">
                                    <h3 class="accordion-header" id="generalHeading{{ $i }}">
                                        <button class="accordion-button collapsed fw-semibold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#generalCollapse{{ $i }}"
                                            aria-expanded="false" aria-controls="generalCollapse{{ $i }}">
                                            {{ $generalFaqs[$i]['name'] }}
                                        </button>
                                    </h3>
                                    <div class="accordion-collapse collapse" id="generalCollapse{{ $i }}"
                                        aria-labelledby="generalHeading{{ $i }}"
                                        data-bs-parent="#generalAccordion">
                                        <div class="accordion-body">
                                            {!! $generalFaqs[$i]['content'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Technical Support Section -->
                        <h2 class="fw-bolder mb-3 text-primary">🛠️ Technical Support</h2>
                        <div class="accordion mb-5" id="technicalAccordion">
                            @for ($i = 0; $i < count($technicalFaqs); $i++)
                                <div class="accordion-item border-0 shadow-sm mb-3">
                                    <h3 class="accordion-header" id="technicalHeading{{ $i }}">
                                        <button class="accordion-button collapsed fw-semibold" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#technicalCollapse{{ $i }}" aria-expanded="false"
                                            aria-controls="technicalCollapse{{ $i }}">
                                            {{ $technicalFaqs[$i]['name'] }}
                                        </button>
                                    </h3>
                                    <div class="accordion-collapse collapse" id="technicalCollapse{{ $i }}"
                                        aria-labelledby="technicalHeading{{ $i }}"
                                        data-bs-parent="#technicalAccordion">
                                        <div class="accordion-body">
                                            {!! $technicalFaqs[$i]['content'] !!}
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- How It Works Section -->
                        <div class="card bg-light border-0 p-4 mb-5">
                            <div class="card-body">
                                <h3 class="card-title text-primary mb-3">How Our Platform Works</h3>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="fw-bold">1</span>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h4 class="h6 fw-bold">Earn Credits</h4>
                                                <p class="text-muted small mb-0">Complete simple tasks like liking posts and
                                                    following accounts to earn credits</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="fw-bold">2</span>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h4 class="h6 fw-bold">Use Credits</h4>
                                                <p class="text-muted small mb-0">Spend your earned credits to get likes,
                                                    followers, and views for your content</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="fw-bold">3</span>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h4 class="h6 fw-bold">Grow Audience</h4>
                                                <p class="text-muted small mb-0">Watch your social media presence grow with
                                                    real engagement from active users</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="fw-bold">4</span>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h4 class="h6 fw-bold">Track Progress</h4>
                                                <p class="text-muted small mb-0">Monitor your growth with detailed analytics
                                                    and progress tracking tools</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card border-0 bg-primary text-white mt-xl-5">
                            <div class="card-body p-4 py-lg-5">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <div class="h6 fw-bolder mb-3">Have more questions?</div>
                                        <p class="mb-4">
                                            Our support team is available 24/7 to help you succeed. Contact us for
                                            personalized assistance.
                                        </p>
                                        <a href="{{ route('contact') }}" class="btn btn-light btn-lg mb-3">
                                            {!! getIcon('envelope', 'me-2') !!}Contact Support
                                        </a>
                                        <div class="mt-4">
                                            <p class="small mb-2">Email us directly at:</p>
                                            <a href="mailto:support@autolikerlive.com"
                                                class="text-white text-decoration-none fw-bold">support@autolikerlive.com</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Tips Card -->
                        <div class="card border-0 bg-light mt-4">
                            <div class="card-body p-4">
                                <h5 class="card-title text-primary mb-3">💡 Quick Tips for Success</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        {!! getIcon('check', 'text-success me-2') !!}
                                        <small>Use high-quality images for better engagement</small>
                                    </li>
                                    <li class="mb-2">
                                        {!! getIcon('check', 'text-success me-2') !!}
                                        <small>Post consistently to maintain audience interest</small>
                                    </li>
                                    <li class="mb-2">
                                        {!! getIcon('check', 'text-success me-2') !!}
                                        <small>Engage with your followers to build community</small>
                                    </li>
                                    <li class="mb-2">
                                        {!! getIcon('check', 'text-success me-2') !!}
                                        <small>Use relevant hashtags to increase discoverability</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer-->
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; Your Website 2022</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    </body>

    </html>
@stop
