@extends('layouts.master')

@section('title', __('messages.about.meta_title'))
@section('description', __('messages.about.meta_desc'))

@section('content')


    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-navbar></x-navbar>
        <!-- Header-->
        <header class="py-5">
            <div class="container px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center my-5">
                            <h1 class="fw-bolder mb-3">{{ __('messages.about.ourMission') }}</h1>
                            <p class="lead fw-normal text-muted mb-4">{{ __('messages.about.ourMission_p1') }}</p>
                            <p class="lead fw-normal text-muted mb-4">{{ __('messages.about.ourMission_p2') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- About section two-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <h3>{{ __('messages.about.howToUse') }}</h3>
                    <table class="table table-dark">
                        <thead>
                            <tr>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">First</th>
                                <td>{{ __('messages.about.step_first') }}</td>

                            </tr>
                            <tr>
                                <th scope="row">Step 1</th>
                                <td>{{ __('messages.about.step1') }}</td>

                            <tr>
                                <th scope="row">Step 2</th>
                                <td>{{ __('messages.about.step2') }}</td>

                            </tr>
                            <tr>
                                <th scope="row">Step 3</th>
                                <td>{{ __('messages.about.step3') }}</td>

                            </tr>
                            <tr>
                                <th scope="row">Add Profile</th>
                                <td>{{ __('messages.about.step4') }}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Company Values Section -->
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bolder">Our Core Values</h2>
                    <p class="lead fw-normal text-muted">What drives us to provide the best social media tools</p>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3 class="h4 fw-bolder">Security First</h3>
                            <p>We prioritize user safety above everything else. Our platform never requires passwords or
                                sensitive information, ensuring your accounts remain secure while you grow your social media
                                presence.</p>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3 class="h4 fw-bolder">Real Community</h3>
                            <p>Our services connect real users who genuinely want to engage with content. We strictly
                                prohibit bots and fake accounts, creating an authentic environment for sustainable growth.
                            </p>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h3 class="h4 fw-bolder">Free Access</h3>
                            <p>We believe everyone deserves the opportunity to grow their social media presence. Our
                                platform offers free services through a fair credit system, making growth accessible to all
                                users.</p>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-lightning"></i>
                            </div>
                            <h3 class="h4 fw-bolder">Fast Results</h3>
                            <p>Time is valuable in the fast-paced world of social media. Our optimized platform delivers
                                results quickly, helping you see immediate improvements in your engagement rates.</p>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-award"></i>
                            </div>
                            <h3 class="h4 fw-bolder">Quality Service</h3>
                            <p>We continuously improve our platform based on user feedback and industry best practices. Our
                                commitment to quality ensures reliable, effective services for all users.</p>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="text-center">
                            <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                <i class="bi bi-globe"></i>
                            </div>
                            <h3 class="h4 fw-bolder">Global Reach</h3>
                            <p>Our platform serves users worldwide, connecting people across different cultures and regions
                                through authentic social media engagement and community building.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">Our Story</h2>
                        <p class="lead fw-normal text-muted mb-4">
                            AutolikerLive was created with a simple mission: to make social media engagement accessible to
                            everyone. We recognized that many talented creators and businesses were struggling to gain
                            visibility despite producing excellent content.
                        </p>
                        <p class="lead fw-normal text-muted mb-4">
                            What began as a simple tool has evolved into a platform focused on ethical growth strategies
                            that comply with platform guidelines. Our community-based approach connects users who support
                            each other's content, creating genuine engagement that helps everyone grow together.
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <h3 class="fw-bolder">Why We Do This</h3>
                        <p class="lead fw-normal text-muted mb-4">
                            Social media algorithms favor content that already has engagement, creating a "cold start"
                            problem for new creators. Our tools help users overcome this initial hurdle by connecting them
                            with others who are also looking to grow their presence responsibly.
                        </p>
                        <p class="lead fw-normal text-muted">
                            We believe in building sustainable growth that complies with platform guidelines. Our approach
                            emphasizes quality content, authentic engagement, and community participation rather than
                            artificial metrics that can harm account health in the long term.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team members section-->
        <section class="py-5 bg-dark">
            <div class="container px-5 my-5">
                <div class="text-center">
                    <h2 class="fw-bolder">Our team</h2>
                    <p class="lead fw-normal text-muted mb-5">Dedicated to quality and your success</p>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4" src="{{ asset('images/admin.webp') }}"
                                alt="..." />
                            <h5 class="fw-bolder">theRiyazSaifi</h5>
                            <div class="fst-italic text-muted">Developer &amp; Admin</div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4" src="{{ asset('images/trsApps.webp') }}"
                                alt="..." />
                            <h5 class="fw-bolder">Company</h5>
                            <div class="fst-italic text-muted">tRS Apps</div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </main>
@stop
