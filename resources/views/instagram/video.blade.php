@extends('layouts.master')

@section('title', 'Download instagram videos | View Instagram video in Full HD')
@section('description',
    'Empower your creativity with our free Instagram video downloader. Easily download videos from
    Instagram to your device for editing, without any restrictions. Take control of your content today')



@section('javascripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .downloader-img-holder {
            margin: 40px 0;
            overflow: visible;
            position: relative;
            text-align: center;
        }

        .downloader-img-block {
            background-color: #fafafa;
            border: 1px solid #efefef;
            height: 100%;
        }

        .downloader-img-holder .img_box {
            display: grid;
            float: left;
            overflow: hidden;
            padding: 5px;
            position: relative;
        }

        /* Full-screen loader styles */
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
            /* Hide loader by default */
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .insta {
            background: radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%);
            color: white;
            width: 1.6rem;
            height: 1.2rem;
            font-size: x-large;
            scale: 2;
            margin-top: 3px;
        }

        @media only screen and (max-width: 600px) {
            .font-small {
                font-size: x-small;
            }
        }

        @media only screen and (min-width: 601px) {
            .font-small {
                font-size: medium;
            }
        }
    </style>
@stop
@section('content')
    <div class="loader-overlay" id="loader">
        <div class="loader"></div>
    </div>
    <main class="flex-shrink-0">
        <x-navbar></x-navbar>
        <section class="bg-dark container">

            <div class="row">
                <div class="col"></div>
                <div class="col-sm-12 col-md-8 col-lg-8 mt-5">
                    <x-insta_navbar></x-insta_navbar>
                    <h1>INSTAGRAM VIDEO DOWNLOAD</h1>
                    <p class="lead">
                        Empower your creativity with our free Instagram video downloader. Easily download videos from
                        Instagram to your device for editing, without any restrictions. Take control of your content today
                        <br>
                        Enter your <b>Instagram Video URL</b> below:
                    </p>
                    <form id="searchform">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> {!! getIcon('instagram', 'insta') !!}</span>
                            </div>
                            <input name="url" type="text" placeholder="e.g. https://www.instagram.com/p/xx1vkqavx_x/"
                                class="input-lg form-control">
                            <div class="input-group-append">

                            </div>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6LdsafIpAAAAAOgUpSrqpB785DTkN23zATU0qQ2M"></div>
                        <button type="submit" class="btn btn-primary mt-2">Search Video →</button>
                    </form>



                    <div class="text-center">
                        <div class="p-2 text-center">
                            @if (\Session::has('success'))
                                <span class="bg-danger rounded px-5 py-2 h1">{{ Session::get('success') }}</span>
                                <p class="position-relative bg-success rounded p-1 h6">FB Numberic ID</p>
                            @endif
                            @if (\Session::has('error'))
                                <p class="h2"><strong class="text-danger">Invalid Username</strong> or Allow search
                                    engines outside of Facebook to link to your <a target="_blank" rel="nofollow nooper"
                                        href="https://www.facebook.com/settings/?tab=how_people_find_and_contact_you">profile
                                        settings</a> </p>
                            @endif
                        </div>
                    </div>
                    <section>
                        <!-- Downloader Tools -->

                        {!! toolbanner() !!}
                    </section>

                    <!-- Find my fb In feed -->
                    <div class="card mb-3 d-none" id="result">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="w-100" id="image_thumbnail"
                                    src="https://cdn.inflact.com/media/376241386_608368548160384_5146734793294602405_n.jpg?url=https%3A%2F%2Fscontent.cdninstagram.com%2Fv%2Ft51.2885-19%2F376241386_608368548160384_5146734793294602405_n.jpg%3Fstp%3Ddst-jpg_s320x320%26_nc_ht%3Dinstagram.fbdo9-1.fna.fbcdn.net%26_nc_cat%3D104%26_nc_ohc%3DKXqH0qG0FzoQ7kNvgH3P8pS%26edm%3DAOQ1c0wBAAAA%26ccb%3D7-5%26oh%3D00_AYBKMz12aidjofYwAhE4zYY4DlxcLysiJqqWyztPK1tknw%26oe%3D666731A5%26_nc_sid%3D8b3546&amp;time=1717650000&amp;key=e627d2580513daca2ed0e2be224195f3"
                                    class="img-fluid rounded-start" alt="theriyazsaifi1">
                                <a id="download" href="#" target="_blank" class="btn btn-primary w-100">Download</a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-dark" id="shortcode">theriyazsaifi</h5>
                                    <p class="card-text text-dark">Post ID: <code id="post_id">11796325697</code></p>
                                    <p class="card-text text-dark">Comments: <code id="comments">149898</code> -
                                        Likes:
                                        <code id="likes">293</code>
                                    </p>
                                    <p class="card-text text-dark" id="caption">Available pictures and videos: <code
                                            id="total_posts">18</code></p>
                                    <p class="card-text text-dark"><small class="text-muted">View Image in full size</small>
                                        <a id="second_link" target="_blank" href="#"> View </a>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>


                    <h2>What is an Instagram Video Downloader for Editing?</h2>
                    <p>
                        An <strong>Instagram Video Downloader</strong> for Editing is an online service that allows users to
                        download their
                        own video content from Instagram to their PC or mobile phone for further editing. This tool provides
                        an easy way for users who struggle with Instagram’s in-app editing tools to enhance their videos
                        using more advanced editing software and then re-upload them to Instagram. There are no limits on
                        the number of videos you can download, making it convenient for continuous content creation and
                        improvement.
                    </p>

                    <h2>Key Features:</h2>
                    <ul class="text-white">
                        <li><strong>Free and Unlimited Downloads</strong>: Download as many Instagram videos as you want,
                            without any restrictions or limitations.

                        </li>
                        <li><strong>High-Quality Downloads</strong>: Download Instagram videos in their original quality,
                            ensuring your
                            edited content looks professional.</li>
                        <li><strong>No Watermarks</strong>: Download videos without any watermarks, preserving the original
                            content for seamless editing.</li>
                    </ul>

                    <h2>Please Note:</h2>

                    <ul class="text-white">
                        <li>This tool only supports public videos in accordance with Instagram’s terms of
                            service.</li>
                        <li>We do not support viewing or downloading other prople videos without permission or accounts that
                            have
                            blocked you.</li>
                        <li>Always respect the privacy and intellectual property rights of others.</li>
                    </ul>

                    <p></p>
                    <div class="container">


                        <h3>FAQs </h3>
                        <ul class="examples good">
                            <li><code>What Devices are Compatible with the Downloader?</code></li>
                            <p>This downloader supports video downloads from Instagram on any operating system and device
                                type. Users can save videos to their iPhone, Android, and computer. The tool is compatible
                                with popular operating systems like macOS, Windows, and Linux. Being an online service, it
                                is accessible from any device around the globe, provided the user has sufficient memory
                                available on their device.
                            </p>
                            <li><code>Is the Instagram Video Downloader Free?</code></li>
                            <p>Indeed, the Instagram Video Downloader is entirely free for downloading individual videos.
                                Enjoy unlimited access without any cost. Whether you're downloading a single video or
                                multiple videos, there are no charges or premium packages. Download as many videos as you
                                like, completely free of charge.</p>

                            <li><code>Is it Legal to Download Videos via this Tool?</code></li>
                            <p>Yes, it is legal to download videos from Instagram for personal use, especially if you are
                                downloading your own content to edit and re-upload. When downloading videos uploaded by
                                other users, it is important to remember that these should only be used for personal viewing
                                offline. To reuse someone else's content, you must obtain permission from the original
                                creator and credit them appropriately.</p>

                            <li><code>Are There Any Limits on the Number of Videos I Can Download?</code></li>
                            <p>No, there are no limits on the number of videos you can download. You can copy and paste
                                links continuously to download Instagram videos. However, if you want to save time by
                                downloading all videos from a profile at once, you can subscribe to a Premium Package, which
                                offers various plans depending on the number of profiles you wish to download from.</p>

                            <li><code>Can I Save Other Types of Content with this Tool?</code></li>
                            <p>Yes, this downloader also allows you to save images, IGTV videos, and Stories from Instagram.
                                The process is similar; you simply need to insert the link to the content you wish to
                                download. This makes it a versatile tool for managing and editing various types of Instagram
                                content.</p>


                        </ul>
                    </div>
                </div>
                <div class="col"></div>
            </div>

        </section>

        <script>
            document.getElementById('searchform').addEventListener('submit', function(event) {
                event.preventDefault();

                // Show the loader
                document.getElementById('loader').style.display = 'flex';

                let form = event.target;
                let formData = new FormData(form);
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                axios.post('https://www.autolikerlive.com/downloader/instagram/get_video', formData, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(function(response) {
                        console.log(response.data);
                        data = response.data;
                        $('#image_thumbnail').attr('src', data['profile_image'])
                        $('#download').attr('href', data['video_url'])
                        $('#second_link').attr('href', data['video_url'])
                        $('#shortcode').html(data['shortcode'])
                        $('#post_id').html(data['id'])
                        $('#comments').html(data['comments'])
                        $('#caption').html(data['caption'])
                        $('#likes').html(data['likes'])
                        $('#result').removeClass('d-none');
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#result").offset().top
                        }, 1000);
                    })
                    .catch(function(error) {
                        // console.error(error);
                        console.log(error.response.data.message);
                        if (error.response.data.message === "Please verify human test") {

                            if (!alert(error.response.data.message)) {
                                window.location.reload();
                            }
                        } else {
                            alert(error.response.data.message)
                        }

                    })
                    .finally(function() {
                        // Hide the loader
                        document.getElementById('loader').style.display = 'none';
                    });
            });
        </script>

    </main>
    <x-ads></x-ads>
@stop
