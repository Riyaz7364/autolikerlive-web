@extends('web-app.master')
@section('title', 'FBSUB - Quick Send')
@section('description', '')
@section('javascripts')

@stop
@section('content')

    <style type="text/css">
        .font-weight-bold {
            font-weight: 700;
        }

        .container p,
        h5 {
            color: black;
        }

        .nopad {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /*image gallery*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 4px solid transparent;
            margin-bottom: 0;
            outline: 0;
        }

        .image-checkbox input[type="checkbox"] {
            display: none;
        }

        .image-checkbox-checked {
            border-color: #4783B0;
            border-radius: 50%;
        }

        .image-checkbox .fa {
            position: absolute;
            color: #4A79A3;
            background-color: #fff;
            padding: 10px;
            top: 0;
            right: 0;
        }

        .image-checkbox-checked .fa {
            display: block !important;
        }

        .emoji-size {
            width: 3rem;
            height: 3rem;
        }

        .emoji-row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));

        }

        .spinner-10x {
            width: 10rem;
            height: 10rem;
        }
    </style>

    @php
        $reactions = [
            'like' => 1,
            // 'love' => 2,
            // 'care' => 16,
            // 'haha' => 4,
            // 'wow' => 3,
            // 'sad' => 7,
            // 'engry' => 8,
        ];
    @endphp
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

        .screen {
            place-content: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: tomato;
            display: flex;
            align-items: center;
            z-index: 9999;
        }

        .loader {

            /* width: 100%; */
            height: 15px;
            text-align: center;
        }

        .dot {
            position: relative;
            width: 15px;
            height: 15px;
            margin: 0 2px;
            display: inline-block;
        }

        .dot:first-child:before {
            animation-delay: 0ms;
        }

        .dot:first-child:after {
            animation-delay: 0ms;
        }

        .dot:last-child:before {
            animation-delay: 200ms;
        }

        .dot:last-child:after {
            animation-delay: 200ms;
        }

        .dot:before {
            content: "";
            position: absolute;
            left: 0;
            width: 15px;
            height: 15px;
            background-color: blue;
            animation-name: dotHover;
            animation-duration: 900ms;
            animation-timing-function: cubic-bezier(.82, 0, .26, 1);
            animation-iteration-count: infinite;
            animation-delay: 100ms;
            background: white;
            border-radius: 100%;
        }

        .dot:after {
            content: "";
            position: absolute;
            z-index: -1;
            background: black;
            box-shadow: 0px 0px 1px black;
            opacity: .20;
            width: 100%;
            height: 3px;
            left: 0;
            bottom: -2px;
            border-radius: 100%;
            animation-name: dotShadow;
            animation-duration: 900ms;
            animation-timing-function: cubic-bezier(.82, 0, .26, 1);
            animation-iteration-count: infinite;
            animation-delay: 100ms;
        }

        @keyframes dotShadow {
            0% {
                transform: scaleX(1);
            }

            50% {
                opacity: 0;
                transform: scaleX(.6);
            }

            100% {
                transform: scaleX(1);
            }
        }

        @keyframes dotHover {
            0% {
                top: 0px;
            }

            50% {
                top: -50px;
                transform: scale(1.1);
            }

            100% {
                top: 0;
            }
        }

        .snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #fff;
            color: #333;
            text-align: center;
            border-radius: 2px;
            padding: 10px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 10%;
            font-size: 17px;
            border-radius: 10px
        }

        .snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>
    <div class="screen text-center d-none" id="screen_loader">
        <h1 style="text-shadow: 3px 5px #626262;">Sending Please Wait &nbsp;</h1>
        <div class="loader">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>

    </div>
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-WebAppNavbar like="{{ $user->credits->FB }}" follow="{{ $user->credits->IG }}"></x-WebAppNavbar>
        <!-- Header-->
        <section class="bg-light">
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">link</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts['links'] as $post)
                            <tr>
                                <th scope="row"
                                    style="
                                text-overflow: ellipsis;
                                overflow: hidden;
                                white-space: nowrap;
                                max-width: 194px;
                            ">
                                    {{ json_decode('"' . $post['name'] . '"') }}
                                    <br />
                                    <div class="row">
                                        @if ($post['type'] == 'story_like')
                                            @foreach (explode(',', $post['reactions']) as $key)
                                                <div class="col-1">
                                                    <label class="image-checkbox">
                                                        <span class="img-responsive"
                                                            style="width: 25px">{{ $key }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </th>
                                {{-- <td>{{ $post['start_count'] == 0 ? 'Not found!' : $post['start_count'] }}</td> --}}
                                <td>
                                    @php
                                        $base = base64_decode($post['link']);

                                        $x = explode(':', $base);
                                        $link = $x[1];
                                    @endphp
                                    <a href="https://www.facebook.com/{{ $link }}" target="_blank"><i
                                            class="bi bi-link-45deg"></i></a>
                                </td>
                                <td style="width: 30%;">
                                    <button data-lid="{{ $post['id'] }}" class="btn btn-primary send_btn send_likes"
                                        data-toggle="dropdown">
                                        <span id="add-spninner" class="spinner-border spinner-border-sm d-none"
                                            role="status" aria-hidden="true"></span> Send Likes</button>


                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </section>
        <div id="snackbar" class="snackbar"></div>
        @include('web-app.bottom_navbar')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>


        <script type="text/javascript">
            $(document).ready(function() {

                $('.send_likes').click(function() {
                    var lid = $(this).data('lid');

                    showLoader();
                    $.ajax({
                        type: 'POST',
                        url: '{{ secure_url(route('send_likes_post', [], false)) }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            lid: lid,
                        },
                        success: function(response) {

                            hideLoader();
                            var x = $("#snackbar").html(response.count + " Likes Send...");
                            x.addClass("show");
                            setTimeout(function() {
                                x.removeClass("show");
                            }, 3000);
                            setTimeout(function() {
                                location.reload();
                            }, 3200);


                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            hideLoader();
                        }
                    });
                });




                function showLoader() {

                    const buttons = document.querySelectorAll('button');
                    buttons.forEach(btn => {
                        btn.style.pointerEvents = "none"; // Disable click events
                        btn.disabled = true; // Disable button element (visually changes)

                    });
                    $('#screen_loader').removeClass('d-none');

                }

                function hideLoader() {
                    const buttons = document.querySelectorAll('button');
                    buttons.forEach(btn => {
                        btn.style.pointerEvents = "auto";
                        btn.disabled = false;

                    });
                    $('#screen_loader').addClass('d-none');

                }
            });
        </script>

    @stop
