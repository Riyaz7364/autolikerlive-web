@extends('layouts.master')

@section('title',  __('messages.yte.meta_title') )
@section('description', __('messages.yte.meta_desc') )

@section('javascripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        function extractVideoID(url) {
            const regex = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([^&]+)|youtu\.be\/([^?&]+)/;
            const matches = url.match(regex);
            return matches ? (matches[1] || matches[2]) : null;
        }

        function extractThumbnails() {
            const youtubeLink = document.getElementById('youtubeLink').value;
            const videoID = extractVideoID(youtubeLink);

            if (!videoID) {
                alert('Invalid YouTube link');
                return;
            }

            const thumbnailURLs = {
                "Default": `https://img.youtube.com/vi/${videoID}/default.jpg`,
                "Medium": `https://img.youtube.com/vi/${videoID}/mqdefault.jpg`,
                "High": `https://img.youtube.com/vi/${videoID}/hqdefault.jpg`,
                "Standard": `https://img.youtube.com/vi/${videoID}/sddefault.jpg`,
                "HD": `https://img.youtube.com/vi/${videoID}/maxresdefault.jpg`
            };

            const thumbnailsList = document.getElementById('thumbnailsList');
            thumbnailsList.innerHTML = ''; // Clear previous thumbnails

            for (const [label, url] of Object.entries(thumbnailURLs)) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.className = 'dropdown-item';
                a.href = url;
                a.target = '_blank'; // Open the thumbnail in a new tab
                a.textContent = label;
                li.appendChild(a);
                thumbnailsList.appendChild(li);
            }

            $('#preview-image').attr('src', thumbnailURLs.Medium);
            $('#download-link').attr('href', thumbnailURLs.HD);

            $('#download-area').removeClass('d-none');
        }
    </script>
@stop

@section('content')


    <main class="flex-shrink-0">
        <!-- Navigation-->
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-8 col-xxl-8">
                        <div class="my-5 text-center text-xl-start">
                            <h1 class="display-5 fw-bolder text-white mb-2">Youtube Thumbnail Extractor</h1>

                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <div class="input-group mb-3">
                                    <input id="youtubeLink" type="text" class="form-control"
                                        placeholder="Enter Video Link" aria-label="Enter Video Link"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button onclick="extractThumbnails()" class="btn btn-danger"
                                            type="button">Search</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-4 d-xl-block text-center">
                        <img height="256px" width="256px" class="img-fluid rounded-3 my-5" id="preview-image"
                            src="https://whiteeaglelabs.com/public/img/no-image-icon-23494.png"
                            alt="youtube thumbnail placeholder" />
                        <br>
                        <div class="btn-group d-none" id="download-area">
                            <a href="" class="btn btn-success" type="button" id="download-link">
                                Download
                            </a>
                            <button type="button"
                                style="color: #000;
                            background-color: #fff;
                            border-color: #fff;"
                                class="btn btn btn-white dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span>Default</span>
                            </button>
                            <ul class="dropdown-menu" id="thumbnailsList">

                            </ul>
                        </div>
                        <x-adsense-banner></x-adsense-banner>
                    </div>

                </div>
            </div>
        </header>


        <section class="p-5 bg-light text-dark">
            <p class="text-dark">{{ __('messages.yte.p1') }}
            </p>

            <h4 class="text-dark">{{ __('common.Features') }}:</h4>
            <ul>
                {!! __('messages.yte.features.list') !!}
            </ul>

            <h4 class="text-dark">{{ __('messages.yte.howToUse') }}:</h4>
            <ol>
                {!! __('messages.yte.howToUse.list') !!}
            </ol>

        </section>


        <section>

            <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                <div class="panel-body">
                    <p>
                        {{ __('messages.yte.p2') }}
                    </p>
                </div>
            </aside>

        </section>
    </main>



    <x-ads></x-ads>
    <x-bottom-ad></x-bottom-ad>
@stop
