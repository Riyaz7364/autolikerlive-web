
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="./">{{ isset($title) ? $title : "Autoliker Live" }}</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="{{ url('') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('download') }}">Download</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('about') }}">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('contact') }}">Contact</a></li>
                            <!--li class="nav-item"><a class="nav-link" href="pricing">Pricing</a></li-->
                            <li class="nav-item"><a class="nav-link" href="{{ url('faq') }}">FAQ</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url('blog') }}">Blog</a></li>
                            {{-- <li class="nav-item"><a class="nav-link" href="https://raje-liker.com/">SMM PANEL</a></li> --}}
                            <li class="nav-item"><a class="nav-link" href="https://www.freelancer.in/u/tRSstudios?page=portfolio">Portfolio</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
