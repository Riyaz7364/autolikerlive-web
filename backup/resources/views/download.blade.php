@extends('layouts.master')

@section('title', 'Download APP')
@section('description', 'Download autoliker live app from this page. This app has perfect tool for Facebook auto
    followers.')

@section('content')
    <script src="https://tobaltoyon.com/pfe/current/tag.min.js?z=5337106" data-cfasync="false" async></script>
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-navbar></x-navbar>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Contact form-->
                <div class="bg-dark rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i>
                        </div>
                        <h1 class="fw-bolder">Download Autoliker LIVE APK</h1>
                        <p class="lead fw-normal text-muted mb-0">Only use latest version</p>
                    </div>
                    @php
                        $json = json_decode(file_get_contents(secure_url('') . '/Download/info.json'));

                    @endphp
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <table class="table table-dark">
                                <tbody>
                                    <tr>
                                        <th scope="row">Version</th>
                                        <td>{{ $json->version }}</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Build</th>
                                        <td>{{ $json->build }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Last Update</th>
                                        <td>{{ $json->update }}</td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Direct Link</th>
                                        <td><button data-timer="15" class="btn btn-primary"
                                                id="download-btn">{{ $json->link }}</button> </td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Live Commenter APP</th>
                                        <td><a class="btn btn-danger"
                                                href="https://play.google.com/store/apps/details?id=com.trs.allcommenter"><i
                                                    class="bi bi-google-play"></i> Download Live Commenter</a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">YoSubs APK</th>
                                        <td><a class="btn btn-danger"
                                                href="https://play.google.com/store/apps/details?id=com.trs.yosubs"><i
                                                    class="bi bi-google-play"></i> Download YoSubs</a></td>
                                    </tr>


                                </tbody>
                            </table>

                            <!-- Download Page -->
                            <script type="text/javascript"
                                src="https://udbaa.com/bnr.php?section=download_pahe&pub=238898&format=300x50&ga=g&mbtodb=1"></script>
                            <noscript><a href="https://yllix.com/publishers/238898" target="_blank"><img
                                        src="//ylx-aff.advertica-cdn.com/pub_2hpya3.png"
                                        style="border:none;margin:0;padding:0;vertical-align:baseline;"
                                        alt="ylliX - Online Advertising Network" /></a></noscript>
                        </div>
                    </div>
                </div>
                <!-- Contact cards-->
                <div class="row gx-5 py-5">
                    <div class="col-md-4 col-sm-12">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-chat-dots"></i></div>
                        <div class="h5 mb-2">Chat with us</div>
                        <p class="text-muted mb-0">Chat live with one of our support specialists.</p>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-people"></i>
                        </div>
                        <div class="h5">Contact on Social Media</div>
                        <p class="text-muted mb-0">
                        <div class="input-group mb-2">
                            <a href="https://www.facebook.com/autolikerLIVE">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i
                                        class="bi bi-facebook"></i></div>
                            </a>
                            <a href="https://twitter.com/theRiyazSaifi">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i
                                        class="bi bi-twitter"></i></div>
                            </a>
                            <a href="https://www.instagram.com/theriyazsaifi1/">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i
                                        class="bi bi-instagram"></i></div>
                            </a>
                            <a href="https://t.me/+1NDLe3FAY3dlN2M1">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3 m-2"><i
                                        class="bi bi-telegram"></i></div>
                            </a>
                        </div>
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i>
                        </div>
                        <div class="h5">Mail us</div>
                        <p class="text-muted mb-0">support@trsapps.com</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <a id="download-link" href="{{ secure_url('') }}/Download/{{ $json->link }}" class="d-none"></a>
    <script>
        const downloadBtn = document.getElementById('download-btn');
        const fileLink = '{{ secure_url('') }}/Download/{{ $json->link }}';

        const initTimer = () => {
            if (downloadBtn.classList.contains("disable-timer")) {
                return location.href = fileLink;
            }
            let timer = downloadBtn.dataset.timer;
            downloadBtn.classList.add("timer");
            downloadBtn.innerHTML = `Your download will begin in <b>${timer}</b> seconds`;
            const initCounter = setInterval(() => {
                if (timer > 0) {
                    timer--;
                    return downloadBtn.innerHTML = `Download start in <b>${timer}</b> seconds`;
                }
                clearInterval(initCounter);

                downloadBtn.innerText = "Loading...";
                setTimeout(() => {
                    downloadBtn.classList.replace("timer", "disable-timer");
                    document.getElementById('download-link').click();
                }, 3000);

                return;
            }, 1000);
        }

        downloadBtn.addEventListener("click", initTimer);
    </script>
@stop
