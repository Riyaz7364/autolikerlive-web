@extends('web-app.master')
@section('title', 'FBSUB - Login')
@section('description', '')
@section('javascripts')

    <script>
        function openPopup(login) {
            var url = "https://mbasic.facebook.com";
            if (login) {
                var url =
                    "https://href.li/?https://m.facebook.com/dialog/oauth?client_id=124024574287414&locale=en_GB&redirect_uri=https%3A%2F%2Fwww.instagram.com%2Faccounts%2Fsignup%2F.&response_type=token";
            }
            window.open(url, 'popupWindow', 'width=420,height=640,scrollbars=yes,resizable=yes');

        }
    </script>


@stop
@section('content')

    <style type="text/css">
        .input-group-text-custom {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 2.1;
            color: #212529;
            text-align: center;
            white-space: nowrap;
            background-color: rgba(var(--bs-white-rgb), var(--bs-bg-opacity)) !important;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        .font-weight-bold {
            font-weight: 700;
        }

        .spinner-10x {
            width: 10rem;
            height: 10rem;
        }

        .pageLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 3px;
            /* Adjust the height as needed */
            background: rgb(242, 99, 38);
            background: linear-gradient(90deg, rgba(242, 99, 38, 1) 0%, rgba(223, 39, 39, 1) 50%, rgba(255, 0, 206, 1) 100%);
            transition: width 0.3s linear;
            z-index: 9999;
        }
    </style>
    <div class="pageLoader"></div>
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-WebAppNavbar title="Login With Facebook Token"></x-WebAppNavbar>
        <!-- Header-->
        <header class="bg-light py-5">
            <div class="container px-2">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-sm-12 col-md-8 col-lg-8">
                        <div class="text-center d-none" id="spinner">
                            <div class="spinner-border m-5 spinner-10x" role="status">
                                <span class="sr-only "></span>
                            </div>
                        </div>
                        <div class="" id="loginBody">
                            <form action="{{ route('checkTokenLink') }}" method="post">
                                @csrf
                                <div class="input-group input-group-lg mb-3">
                                    <input type="text" class="form-control input-lg" placeholder="Paste URL Here"
                                        aria-label="Paste URL Here" aria-describedby="basic-addon2" name="link">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary text-white btn-outline-secondary btn-lg"
                                            type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <div class="alert alert-info " role="alert">
                                0 ➜ <a href="#" onclick="openPopup(false)" class="btn btn-primary"
                                    rel="nofollow noopener">
                                    Login Facebook
                                </a> For Telegram users.
                            </div>
                            <div class="alert alert-info" role="alert">
                                1 ➜ <a href="#" onclick="openPopup(true)" class="btn btn-primary"
                                    rel="nofollow noopener">
                                    Get Token
                                </a> Allow Instagram app.
                            </div>
                            <div class="alert alert-info " role="alert">
                                2 ➜ After see "page isn't available." copy all URL.
                            </div>
                            <div class="alert alert-info " role="alert">
                                3 ➜ Come back to this page and paste URL to the box.
                            </div>
                        </div>

                    </div>
                    <div class="col"></div>
                </div>
            </div>
            <div class="bg-light" id="no-ads-here">
                <div class="container ">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-7">
                            <div class="text-center">
                                <label class="p-2 font-weight-bold">Watch - How to use Login</label>
                                <div class="video-container">

                                    <iframe width="100%" height="250"
                                        srcdoc="
                                                <style>
                                                    body, .full {
                                                        width: 100%;
                                                        height: 100%;
                                                        margin: 0;
                                                        position: absolute;
                                                        display: flex;
                                                        justify-content: center;
                                                        object-fit: cover;
                                                    }
                                                </style>
                                                <a
                                                    href='https://www.youtube.com/embed/V7uWfT3-tUo?autoplay=0'
                                                    class='full'
                                                >
                                                    <img
                                                        src='https://vumbnail.com/V7uWfT3-tUo.jpg'
                                                        class='full'
                                                    />
                                                    <svg
                                                        version='1.1'
                                                        viewBox='0 0 68 48'
                                                        width='68px'
                                                        style='position: relative;'
                                                    >
                                                        <path d='M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z' fill='#f00'></path>
                                                        <path d='M 45,24 27,14 27,34' fill='#fff'></path>
                                                    </svg>
                                                </a>
                                            "
                                        title="YouTube video player" frameborder="0" loading="lazy"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture"
                                        allowfullscreen></iframe>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </header>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var code = "";

            // $(document).ready(function() {
            //     axios.get('https://www.autolikerlive.com/web-app/getDevideCode')
            //         .then(function(response) {
            //             // Update the content with the generated email
            //             $('#code').html(response.data.userCode);
            //             code = response.data.code;
            //             $('#loginBody').removeClass('d-none');
            //             $('#spinner').addClass('d-none');

            //         })
            //         .catch(function(error) {
            //             console.error(error);
            //         });
            // });



            function showLoader() {
                const loader = document.querySelector('.pageLoader');
                loader.style.height = '4px'
                loader.style.width = '100%';

            }

            function hideLoader() {
                const loader = document.querySelector('.pageLoader');
                loader.style.width = '0';
                loader.style.height = '0px'
            }

            // function checkLogin() {
            //     axios.post('https://www.autolikerlive.com/web-app/checkLogin', {
            //             code: code // Assuming 'code' is defined somewhere in your code
            //         })
            //         .then(function(response) {
            //             if (response.data.login === true) {
            //                 window.location = "/web-app/dashboard";
            //             }
            //             showLoader();
            //             setTimeout(function() {
            //                 hideLoader();
            //             }, 1000);
            //         })
            //         .catch(function(error) {
            //             console.error(error);
            //         });
            // }



            // checkLogin();
            // setInterval(function() {}, 5000);

            function pasteText() {
                try {
                    // Get text from the clipboard
                    const text = await navigator.clipboard.readText();
                    // Set the text into the textarea
                    document.getElementById("tokne_input").value = text;
                } catch (err) {
                    alert('Failed to read clipboard contents: ' + err);
                }
            }
        </script>
    @stop
