@extends('layouts.master')


@section('title', 'Instagram Auto Liker & Engagement Tools | Autolikerlive.com')
@section('description', 'Enhance your Instagram presence with our community engagement tools. Connect with real users to build authentic engagement. Free Instagram auto liker and growth tools.')
@section('keywords', 'instagram auto liker, instagram auto like, instagram comment liker, instagram auto liker 1000 likes, instagram free auto liker, instagram auto liker apk, free instagram likes, instagram auto followers, instagram engagement tools')
@section('ogimage', asset('assets/instagram-autoliker-og.jpg'))

@section('javascripts')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>

    <style>
        body {
            font-family: 'Poppins', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f9ce34 0%, #ee2a7b 50%, #6228d7 100%) !important;
            min-height: 100vh;
        }

        .insta-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(98, 40, 215, 0.08);
            border: none;
        }

        .insta-header {
            background: linear-gradient(90deg, #f9ce34 0%, #ee2a7b 50%, #6228d7 100%);
            color: #fff;
            border-radius: 24px 24px 0 0;
            padding: 2rem 1rem 1rem 1rem;
            text-align: center;
        }

        .instgram-btn {
            background: linear-gradient(to right, #f9ce34, #ee2a7b, #6228d7);
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            box-shadow: 0 2px 8px rgba(98, 40, 215, 0.12);
            transition: box-shadow 0.2s;
        }

        .instgram-btn:hover {
            box-shadow: 0 4px 16px rgba(98, 40, 215, 0.18);
            color: #fff;
        }

        .insta-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            margin-top: 2rem;
            padding: 2rem 1rem;
        }

        .insta-step-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(98, 40, 215, 0.08);
            border: none;
            margin-bottom: 2rem;
        }

        .insta-step-card .card-title {
            color: #ee2a7b;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .insta-step-card .card-subtitle {
            color: #6228d7;
            font-weight: 600;
        }

        .temp-emailbox-text a.link {
            color: #ee2a7b;
            text-decoration: underline;
        }

        .temp-emailbox-text a.link:hover {
            color: #6228d7;
        }

        .border-dashes {
            border: 2px dashed #ee2a7b;
            border-radius: 18px;
            background: #fff;
        }
    </style>

    <x-mail-wrapper></x-mail-wrapper>
@stop

@section('content')
    <header>
        <div class="container pxc-5">
            <div class="insta-header">
                <h1 class="justify-content-center text-center mb-2">Auto Liker Instagram, Auto Comments & Auto Followers
                </h1>
                <h2 class="h6 text-center text-white justify-content-center text-muted mb-0">
                    Enhancing your Instagram presence has never been more straightforward. Try this Auto Liker Instagram
                    tool and observe the magic happen.
                </h2>
            </div>
            <div class="mail-wrapper">
                <div class="mail-selection mb-3">
                    <div class="insta-card text-center fw-bold mb-3">
                        <div class="insta-header" style="padding: 1rem; border-radius: 24px 24px 0 0;">
                            <i class="bi bi-instagram" style="font-size:2rem;"></i> Download & Enjoy
                        </div>
                        <div class="border-dashes p-4 justify-content-center ">
                            <h5 class="mb-3" style="color:#ee2a7b; font-weight:700;">Get Started</h5>
                            <p class="mb-4">
                                {!! getIcon('bi-heart-pulse-fill', 'text-danger') !!} <span style="color:#ee2a7b;">HEARTS</span> &nbsp;
                                {!! getIcon('bi-play-fill', 'text-warning') !!} <span style="color:#f9ce34;">VIEWS</span> &nbsp;
                                {!! getIcon('instagram', 'text-primary') !!} <span style="color:#6228d7;">FOLLOWERS</span>
                            </p>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('apk.download') }}" class="btn instgram-btn btn-lg w-100 my-3">
                                        <i class="bi bi-instagram"></i> Download Instagram App
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="temp-emailbox-text text-center my-2">
                            <p class="text-dark pt-2">I Understand and Agree with <a class="link"
                                    href="{{ url('privacy') }}">Privacy Policy</a> and <a class="link"
                                    href="{{ url('terms') }}">Terms of Uses</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <x-ads.leaderboard />
    <x-ads.mobile-banner />

    <section class="insta-section">
        <div class="container" data-nosnippet="true">
            <div class="text-center p-4">
                <h2 class="mb-3" style="color:#ee2a7b; font-weight:700;">{{ __('messages.freeService.howItsWork') }}</h2>
                <p><strong>Auto Liker Instagram</strong> is a simple and efficient tool designed to help you increase
                    engagement on your Instagram posts effortlessly. Unlike other tools, it does not require any tokens or
                    cookies, ensuring a safer and more secure experience.</p>
                <h2 class="mb-2" style="color:#6228d7; font-weight:600;">How to Use Auto Liker Instagram?</h2>
                <p class="text-black">Follow these easy steps to get started:</p>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 insta-step-card">
                    <div class="card-body m-3">
                        <h1 class="card-title">01.</h1>
                        <h6 class="card-subtitle mb-2 text-black">Open Auto Liker Instagram</h6>
                        <p class="card-text text-black">
                            Visit our platform from your preferred device. Get free Instagram Followers, Likes, and Views!
                            Visit www.autolikerlive.com
                        </p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 insta-step-card">
                    <div class="card-body m-3">
                        <h1 class="card-title">02.</h1>
                        <h6 class="card-subtitle mb-2 text-black">Download the App</h6>
                        <p class="card-text text-black">Click the download button above to get the official Instagram
                            engagement app.
                            Fast, safe, and secure!</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 insta-step-card">
                    <div class="card-body m-3">
                        <h1 class="card-title">03.</h1>
                        <h6 class="card-subtitle mb-2 text-black">Earn Credits (Easy & Free)</h6>
                        <p class="card-text text-black">
                            Complete simple tasks like:
                        <ul>
                            <li>Liking other posts</li>
                            <li>Following users</li>
                            <li>Watching short videos</li>
                        </ul>
                        The more credits you earn, the more engagement you can get! No hidden charges, just a fair exchange
                        system.
                        </p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 insta-step-card">
                    <div class="card-body m-3">
                        <h1 class="card-title">04.</h1>
                        <h6 class="card-subtitle mb-2 text-black">Get Free Likes, Followers & Views</h6>
                        <p class="card-text text-black">
                            Use your earned credits to increase likes, followers, and views on your Instagram posts or
                            profile. Our system delivers engagement organically and instantly, ensuring real interactions
                            with no bots or fake accounts.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Content for AdSense Approval -->
            <div class="text-center p-4 mt-5">
                <h2 class="mb-3" style="color:#ee2a7b; font-weight:700;">Why Choose Auto Liker Instagram?</h2>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="insta-step-card">
                            <div class="card-body p-4">
                                <h3 class="h5 mb-3" style="color:#6228d7;">100% Safe & Secure</h3>
                                <p class="text-black">Your account safety is our top priority. We never ask for passwords,
                                    tokens, or any sensitive information. Our service operates through a secure credit-based
                                    system that keeps your Instagram account completely safe from bans or violations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="insta-step-card">
                            <div class="card-body p-4">
                                <h3 class="h5 mb-3" style="color:#6228d7;">Real Human Engagement</h3>
                                <p class="text-black">All likes, views, and followers come from real, active Instagram
                                    users. We strictly prohibit the use of bots or fake accounts, ensuring authentic
                                    engagement that helps boost your profile's credibility and visibility.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="insta-step-card">
                            <div class="card-body p-4">
                                <h3 class="h5 mb-3" style="color:#6228d7;">Free Credit System</h3>
                                <p class="text-black">Earn unlimited credits by participating in our community. Like posts,
                                    follow users, and watch content to earn credits that you can use to boost your own
                                    Instagram presence. No hidden fees or premium subscriptions required.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="insta-step-card">
                            <div class="card-body p-4">
                                <h3 class="h5 mb-3" style="color:#6228d7;">Instant Results</h3>
                                <p class="text-black">See immediate results after placing your order. Our optimized
                                    delivery system ensures fast processing, so you can watch your engagement grow in
                                    real-time and make an instant impact on your Instagram presence.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center p-4 mt-4">
                <h2 class="mb-4" style="color:#ee2a7b; font-weight:700;">Understanding Instagram Growth Strategy</h2>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <p class="text-black mb-4">In today's competitive social media landscape, building a strong
                            Instagram presence requires more than just posting great content. The Instagram algorithm favors
                            accounts with high engagement rates, making it essential to have a solid foundation of likes,
                            views, and followers.</p>

                        <h3 class="h5 mb-3" style="color:#6228d7;">The Importance of Social Proof</h3>
                        <p class="text-black mb-4">Social proof is a psychological phenomenon where people follow the
                            actions of others. On Instagram, posts with higher engagement rates appear more credible and
                            attractive to new viewers. This creates a snowball effect where increased engagement leads to
                            even more organic growth.</p>

                        <h3 class="h5 mb-3" style="color:#6228d7;">Algorithm Optimization</h3>
                        <p class="text-black mb-4">Instagram's algorithm considers engagement metrics when determining
                            which posts to show in users' feeds and on the explore page. Higher engagement rates signal to
                            the algorithm that your content is valuable, resulting in increased visibility and reach to
                            potential new followers.</p>

                        <h3 class="h5 mb-3" style="color:#6228d7;">Building Brand Authority</h3>
                        <p class="text-black">Whether you're an influencer, business owner, or content creator, a strong
                            Instagram presence establishes credibility in your niche. Higher follower counts and engagement
                            rates can lead to brand partnerships, collaboration opportunities, and increased sales
                            conversions.</p>
                    </div>
                </div>
            </div>

            <div class="text-center p-4 mt-4">
                <h2 class="mb-4" style="color:#ee2a7b; font-weight:700;">Frequently Asked Questions</h2>
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item insta-step-card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq1">
                                        Is Auto Liker Instagram safe to use?
                                    </button>
                                </h3>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-black">
                                        Absolutely! Our service is completely safe because we never require your password or
                                        any sensitive account information. We use a secure credit-based system that complies
                                        with Instagram's terms of service, ensuring your account remains protected.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item insta-step-card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq2">
                                        How quickly will I see results?
                                    </button>
                                </h3>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-black">
                                        Results are typically visible within minutes of placing your order. Our automated
                                        system processes requests quickly, and you'll start seeing increased likes, views,
                                        or followers almost immediately after using your credits.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item insta-step-card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq3">
                                        Are the followers and likes from real people?
                                    </button>
                                </h3>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-black">
                                        Yes, all engagement comes from real Instagram users who are part of our community
                                        network. We strictly prohibit the use of bots or fake accounts, ensuring that your
                                        engagement is authentic and valuable for long-term growth.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item insta-step-card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq4">
                                        How do I earn credits?
                                    </button>
                                </h3>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-black">
                                        Earning credits is simple and fun! You can like other users' posts, follow accounts,
                                        watch videos, and complete various engagement tasks. Each action earns you credits
                                        that you can then use to boost your own Instagram presence.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item insta-step-card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq5">
                                        Is there a limit to how many credits I can earn?
                                    </button>
                                </h3>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-black">
                                        No, there's no limit! You can earn as many credits as you want by actively
                                        participating in our community. The more you engage with other users' content, the
                                        more credits you'll accumulate to use for your own profile growth.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center p-4 mt-4">
                <h2 class="mb-4" style="color:#ee2a7b; font-weight:700;">Best Practices for Instagram Growth</h2>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h3 class="h5 mb-3" style="color:#6228d7;">Content Quality Matters</h3>
                        <p class="text-black mb-4">While our service helps boost your engagement, combining it with
                            high-quality, original content will maximize your results. Focus on creating visually appealing
                            posts that resonate with your target audience and encourage natural engagement.</p>

                        <h3 class="h5 mb-3" style="color:#6228d7;">Consistent Posting Schedule</h3>
                        <p class="text-black mb-4">Maintain a regular posting schedule to keep your audience engaged and
                            attract new followers. Use our service strategically on your best content to amplify its reach
                            and impact when you post.</p>

                        <h3 class="h5 mb-3" style="color:#6228d7;">Engage with Your Community</h3>
                        <p class="text-black mb-4">Beyond using our service, actively engage with your followers and other
                            accounts in your niche. Respond to comments, participate in conversations, and build genuine
                            relationships within your Instagram community.</p>

                        <h3 class="h5 mb-3" style="color:#6228d7;">Use Relevant Hashtags</h3>
                        <p class="text-black">Research and use relevant hashtags to increase your content's
                            discoverability. Combine our engagement boost with strategic hashtag use to maximize your posts'
                            reach and attract your ideal audience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            const form = document.getElementById('form');
            form.submit();
            const btn = this;
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Searching...';
        });
    </script>
@endsection
