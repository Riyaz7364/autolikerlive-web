<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="{{ route('index') }}">{{ $title ?? 'Autoliker Live' }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Home</a></li>

                <li class="nav-item"><a class="nav-link" href="{{ route('download.page') }}">Download</a></li>

                <div class="btn-group">
                    <a type="button" role="button" aria-haspopup="true"
                        class="rounded border nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        More Tools
                    </a>
                    <ul class="dropdown-menu">
                        <li><strong class="dropdown-item text-muted">Main Tools</strong></li>
                        <li><a class="dropdown-item" href="{{ route('autoliker.facebook') }}">Auto Liker
                                Facebook</a></li>
                        <li><a class="dropdown-item" href="{{ route('autoliker.instagram') }}">Auto Liker
                                Instagram</a></li>

                        <li><a class="dropdown-item" href="{{ route('findmyfbid') }}">Find My FB ID</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('instagram.findInstaId') }}">Find Instagram user ID</a></li>
                        <li><a href="{{ route('instagram.photo') }}" class="dropdown-item">Find Insta Profile Pic</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('youtube_thumbnail_extractor') }}">Youtube
                                Thumbnail Extractor</a></li>
                        {{-- <li><a href="{{ route('get_token_cookie') }}" class="dropdown-item">Get FB Token Cookie APK</a></li> --}}

                        <li class="bg-success"><a href="https://www.autolikerlive.com/create-qr/"
                                class="dropdown-item text-white">Create QR Code</a></li>
                        <li class="bg-warning"><a class="dropdown-item" href="{{ route('temp-mail') }}">Temp
                                Mail</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li><strong class="dropdown-item text-muted">External Tools</strong></li>
                        <li><a class="dropdown-item" href="{{ route('free-tiktok-views') }}">Free TikTok Views</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('free-tiktok-likes') }}">Free TikTok Likes</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('free-instagram-likes') }}">Free Instagram
                                Likes</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('sms-bomber') }}">OTP SMS Bomber</a></li>
                        <li><a class="dropdown-item" href="{{ route('sms-bomber') }}">OTP CALL Bomber</a></li>
                    </ul>
                </div>


                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Legal
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/privacy-policy">Privacy Policy</a></li>
                        <li><a class="dropdown-item" href="/terms-of-service">Terms of Service</a></li>
                    </ul>
                </li>

                <div class="btn-group">
                    <a type="button" role="button" aria-haspopup="true"
                        class="rounded border nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Hire Me
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('services') }}">Services</a></li>
                        {{-- <li><a class="dropdown-item" rel="nofollow noopener"
                                href="https://www.freelancer.com/hireme/tRSstudios">Freelancer</a></li> --}}

                    </ul>
                </div>
                <li class="nav-item"><a class="nav-link text-info" href="https://www.autolikerlive.com/blog/">Blog</a>
                </li>

                {{-- <li class="nav-item"><a class="nav-link" target="_blank" href="https://raje-liker.com/">Cheap SMM Services</a></li> --}}

            </ul>

        </div>
    </div>
</nav>
