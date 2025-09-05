@extends('layouts.master')

@section('title', 'Privacy Policy - AutolikerLive')
@section('description', 'Our privacy policy details how we collect, use, and protect your information when using
    AutolikerLive services.')

@section('content')

    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-navbar></x-navbar>

        <!-- Header-->
        <header class="py-5">
            <div class="container px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="text-center my-5">
                            <h1 class="fw-bolder mb-3">Privacy Policy</h1>
                            <p class="lead fw-normal text-muted mb-4">Last updated: August 31, 2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Privacy Policy Content -->
        <section class="py-5">
            <div class="container px-5">
                <div class="row gx-5">
                    <div class="col-lg-10 mx-auto">
                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Introduction</h2>
                            <p>Welcome to AutolikerLive. We respect your privacy and are committed to protecting your
                                personal data. This privacy policy will inform you about how we look after your personal
                                data when you visit our website and tell you about your privacy rights and how the law
                                protects you.</p>
                            <p>Please read this privacy policy carefully before using our Service.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Information We Collect</h2>
                            <p>We collect several different types of information for various purposes to provide and improve
                                our Service to you.</p>

                            <h4 class="mt-4">Personal Data</h4>
                            <p>While using our Service, we may ask you to provide us with certain personally identifiable
                                information that can be used to contact or identify you ("Personal Data"). This may include,
                                but is not limited to:</p>
                            <ul>
                                <li>Email address</li>
                                <li>First name and last name</li>
                                <li>Public social media profile information</li>
                                <li>Usage Data</li>
                            </ul>

                            <h4 class="mt-4">Usage Data</h4>
                            <p>We may also collect information on how the Service is accessed and used ("Usage Data"). This
                                Usage Data may include information such as your computer's Internet Protocol address (e.g.
                                IP address), browser type, browser version, the pages of our Service that you visit, the
                                time and date of your visit, the time spent on those pages, unique device identifiers and
                                other diagnostic data.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">How We Use Your Information</h2>
                            <p>AutolikerLive uses the collected data for various purposes:</p>
                            <ul>
                                <li>To provide and maintain our Service</li>
                                <li>To notify you about changes to our Service</li>
                                <li>To allow you to participate in interactive features of our Service when you choose to do
                                    so</li>
                                <li>To provide customer support</li>
                                <li>To gather analysis or valuable information so that we can improve our Service</li>
                                <li>To monitor the usage of our Service</li>
                                <li>To detect, prevent and address technical issues</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Security of Data</h2>
                            <p>The security of your data is important to us, but remember that no method of transmission
                                over the Internet or method of electronic storage is 100% secure. While we strive to use
                                commercially acceptable means to protect your Personal Data, we cannot guarantee its
                                absolute security.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Your Data Protection Rights</h2>
                            <p>We would like to make sure you are fully aware of all of your data protection rights. Every
                                user is entitled to the following:</p>
                            <ul>
                                <li><strong>The right to access</strong> – You have the right to request copies of your
                                    personal data.</li>
                                <li><strong>The right to rectification</strong> – You have the right to request that we
                                    correct any information you believe is inaccurate. You also have the right to request
                                    that we complete information you believe is incomplete.</li>
                                <li><strong>The right to erasure</strong> – You have the right to request that we erase your
                                    personal data, under certain conditions.</li>
                                <li><strong>The right to restrict processing</strong> – You have the right to request that
                                    we restrict the processing of your personal data, under certain conditions.</li>
                                <li><strong>The right to object to processing</strong> – You have the right to object to our
                                    processing of your personal data, under certain conditions.</li>
                                <li><strong>The right to data portability</strong> – You have the right to request that we
                                    transfer the data that we have collected to another organization, or directly to you,
                                    under certain conditions.</li>
                            </ul>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Children's Privacy</h2>
                            <p>Our Service does not address anyone under the age of 13. We do not knowingly collect
                                personally identifiable information from anyone under the age of 13. If you are a parent or
                                guardian and you are aware that your child has provided us with Personal Data, please
                                contact us. If we become aware that we have collected Personal Data from children without
                                verification of parental consent, we take steps to remove that information from our servers.
                            </p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Changes to This Privacy Policy</h2>
                            <p>We may update our Privacy Policy from time to time. We will notify you of any changes by
                                posting the new Privacy Policy on this page and updating the "Last updated" date at the top
                                of this Privacy Policy.</p>
                            <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this
                                Privacy Policy are effective when they are posted on this page.</p>
                        </div>

                        <div class="mb-5">
                            <h2 class="fw-bold mb-3">Contact Us</h2>
                            <p>If you have any questions about this Privacy Policy, please contact us:</p>
                            <ul>
                                <li>By email: contact@autolikerlive.com</li>
                                <li>By visiting the contact page on our website: <a href="{{ route('contact') }}">Contact
                                        Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
