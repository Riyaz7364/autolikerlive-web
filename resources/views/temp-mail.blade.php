@extends('layouts.master')

@section('title', __('messages.tempMail.meta_title'))
@section('description', __('messages.tempMail.meta_desc'))
@section('keywords', 'free, temporary, email, disposable, mail, email address')
@section('favicons')
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/favicons/temp-mail/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/favicons/temp-mail/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicons/temp-mail/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ url('images/favicons/temp-mail/site.webmanifest') }}">
@endsection
@section('ogimage',
    'https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp')


@section('javascripts')
<script async src="https://js.onclckmn.com/static/onclicka.js" data-admpid="415541"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script></script>
    <style type="text/css">
        .border-dashes {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' rx='10' ry='10' stroke='%2365656557' stroke-width='3' stroke-dasharray='10' stroke-dashoffset='0' stroke-linecap='round'/%3e%3c/svg%3e");
            border-radius: 10px;
        }

        .input-box {
            height: 50px;
            background: #656565b5;
            color: white;
            font-weight: bold;
            border-radius: 20px 0px 0px 20px;
            border-color: #9f9d9d;
        }

        .input-box-email {
            height: 55px;
            background: #6565652b;
            color: white;
            font-weight: 600;
            border-radius: 30px !important;
            border-color: transparent;
            overflow: hidden;
        }

        .select-box {
            height: 50px;
            border-radius: 0px 20px 20px 0px;
            font-family: monospace;
            font-size: larger;

        }

        .max-50 {
            max-width: 40%;
        }

        .he-1 {
            height: 1.5rem !important;
        }

        .he-2 {
            height: 2.5rem !important;
        }

        .text-secondary2 {
            background: #656565b5;
        }

        .text-larger {
            font-size: larger !important;
        }

        .temp-emailbox-text p {
            color: #7a7c80;
            font-size: 14px !important;
            font-family: Roboto Mono, monospace !important;
            font-weight: 500 !important;
            padding: 0;
            margin: 0;
        }

        @media (min-width: 600px) {
            .copy-svg {
                height: 3.5rem;
                width: 3.5rem;
                background: #656565b5;
                padding: 14px;
                margin-left: 10px !important;
                border: 1px solid #343333;
            }

            .pxc-5 {
                padding-right: 3rem !important;
                padding-left: 3rem !important;
            }

            .desktop-d-none {
                display: none;
            }
        }

        @media (max-width: 601px) {
            .mobile-d-none {
                display: none;
            }
        }




        .section-btn-header .tm-btn,
        #tm-body .section-btn-header button {
            -webkit-box-shadow: 0 2px 4px rgba(34, 36, 43, .16);
            box-shadow: 0 2px 4px rgba(34, 36, 43, .16);
            margin: 15px 9px !important;
            padding: 13px 38px !important;
            position: relative !important;
            min-width: 160px !important;
            font-weight: 500 !important;
            font-size: 16px !important;
            text-decoration: none !important;
            text-align: left !important;
        }

        .btn-gray {
            background-color: #f6f7f9;
            color: #22242b !important;
        }

        .tm-btn {
            display: inline-block;
            font-weight: 500;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #f6f7f9;
            border: 1px solid transparent;
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 25px;
            -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            -o-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .card-header-radius {
            border-radius: 1rem 1rem 0rem 0rem !important;
            height: 52px;
            padding-top: 15px;

        }

        .border-r-1 {
            border-radius: 1rem !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .text-right {

            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        .is-active {
            height: 6px;
            width: 6px;
            background-color: green;
            border-radius: 50%;
        }

        .is-not-active {
            height: 6px;
            width: 6px;
            background-color: black;
            border-radius: 50%;
        }

        .px-2-2 {
            padding-right: 0.8rem !important;
            padding-left: 0.8rem !important;
        }

        .viewLink {
            text-decoration: none
        }

        .viewLink:hover {
            text-decoration: underline
        }

        i {
            -webkit-text-stroke: 1px;
        }

        i:hover {
            color: red;
        }

        .min-hv-18rem {
            min-height: 18rem;
        }

        #tooltip {
            position: absolute;
            background-color: #333;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            top: 4rem;
            right: 0rem;
            display: none;
        }

        .fixedToast {
            position: fixed;
            right: 1rem;
            top: 1rem;
            width: auto !important;
        }


        .inbox-empty {
            height: 335px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            text-align: center;
        }

        .inboxWarpMain svg .emptyInboxRotation {
            -webkit-animation: rotation 2s linear infinite;
            -o-animation: rotation 2s infinite linear;
            /* animation:rotation 2s linear infinite; */
            -o-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
            -webkit-transform-origin: 50% 50%;
            -moz-transform-origin: 50% 50%
        }

        @-webkit-keyframes rotation {
            0% {
                -webkit-transform: rotate(0deg)
            }

            to {
                -webkit-transform: rotate(359deg)
            }
        }

        @-o-keyframes rotation {
            0% {
                -o-transform: rotate(0deg)
            }

            to {
                -o-transform: rotate(359deg)
            }
        }

        @keyframes rotation {
            0% {
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg)
            }

            to {
                -webkit-transform: rotate(359deg);
                -o-transform: rotate(359deg);
                transform: rotate(359deg)
            }
        }

        .inboxWarpMain .inbox-empty .inbox-empty-msg p.emptyInboxTitle {
            color: #585d6a;
            font-size: 20px;
            font-family: Roboto Mono, monospace !important;
            font-weight: 400;
            font-style: normal;
            margin-bottom: 5px
        }


        /* Style for the loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: none;
            /* Initially hidden */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

    <x-mail-wrapper></x-mail-wrapper>

@stop <!-- End Javascript -->

@section('content')



    <div class="pageLoader"></div>
    <!-- Navigation-->
    <x-navbar></x-navbar>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container pxc-5">
            <div class="mail-wrapper">
                <div class="ad ad-250x250">
                   <div class="admoloBanner" data-publisher="eyJpdiI6IjB0TlRYb0I4ekQxR2pHYzJjSEM5K2c9PSIsInZhbHVlIjoiR1p1MXh5NEhna2s4Wkk0UkJvditpQT09IiwibWFjIjoiMWVkMzNiMTA1ZTFhNTFhNDg5NjNiMDgzOTQ2NjQxNTRlNGUzYzMzOGJmMjYxY2ZiMTE0OGE0MjVkYmVmZWZiOSIsInRhZyI6IiJ9" data-adsize="320x50"></div>

                </div>

                <div class="mail-selection mb-3">
                    <div class="border-dashes p-3 justify-content-center">
                        <h1 class="h5 justify-content-center text-center">Welcome to <strong class="text-success">Temp
                                Mail</strong></h1>
                        <h2 class="h6 text-center text-white justify-content-center p-3 text-muted">
                            {{ __('messages.tempMail.subTitle') }}</h2>
                        <div class="input-group px-2">
                            <input class="form-control input-box-email px-3" id="mailbox" value="Loading..."
                                disabled></input>

                            <button onclick="copyToClipboard()" class="rounded-circle copy-svg mobile-d-none"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g>
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M7 6V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-3v3c0 .552-.45 1-1.007 1H4.007A1.001 1.001 0 0 1 3 21l.003-14c0-.552.45-1 1.007-1H7zM5.003 8L5 20h10V8H5.003zM9 6h8v10h2V4H9v2z"
                                            fill="#ffffff" />
                                    </g>
                                </svg>

                            </button>

                        </div>

                    </div>

                    <div class="row m-2 desktop-d-none">
                        <button onclick="copyToClipboard()" class="tm-btn text-larger mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-copy" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V2Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H6ZM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1H2Z" />
                            </svg>
                            COPY
                            <div id="tooltip">Copied!</div>
                        </button>

                    </div>
                    <div class="temp-emailbox-text text-center my-2">
                        <p>{{ __('messages.tempMail.info') }}
                        </p>
                    </div>
                </div>
                <div class="ad ad-250x250">
                    <!-- Temp Mail Right adsbygoogle -->
                <div data-banner-id="6107284"></div>

            </div>
            </div>


        </div>


    </header>

    <section class="section-btn-header bg-white shadow-sm" style="position: relative; top: 0px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-auto justify-content-center my-3">
                    <button onclick="copyToClipboard()" data-clipboard-action="copy" data-clipboard-target="#mail"
                        class="no-ajaxy tm-btn btn-gray click-to-copy" data-original-title="" title="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-copy" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V2Zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H6ZM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1H2Z" />
                        </svg> Copy</button>



                    <a href="javascript:;" id="click-to-refresh" class="no-ajaxy tm-btn btn-gray click-to-refresh"
                        data-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                            <path
                                d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                        </svg> Refresh</a>


                    <form class="d-inline" action="{{ route('deleteMail') }}" method="post">
                        @csrf
                        <input type="hidden" name="email" id="email_id" value="" disabled="true">
                        <button class="no-ajaxy tm-btn btn-gray click-to-delete"> <svg xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" fill="currentColor" class="bi bi-trash"
                                viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg> Delete</button>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light">
        <div class="container">
            <!-- Horizontal banner ads -->


<div class="row">
                <div class="col-md-2 col-lg-2"></div>
                <div class="col-md-8 col-lg-8 col-xl-8 col-sm-12 p-1 my-3">
                    <div class="card border-r-1">
                        <div class="card-header bg-dark card-header-radius">
                            <div class="row">
                                <div class="col-4 text-white text-left font-weight-bold pl-2">SENDER</div>
                                <div class="col-4 text-white text-center font-weight-bold">SUBJECT</div>
                                <div class="col-4 text-white text-right font-weight-bold pr-2">VIEW</div>
                            </div>
                        </div>
                        <div class="card-body min-hv-18rem">
                            <div class="row">
                                <div class="col-box p-2 bg-light inboxWarpMain" id="messageList">
                                    @livewire('tempmail-inbox')
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12">

                    <!-- temp-mail-buttom -->


                </div>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col-md-6 col-lg-8 col-sm-12 text-center mb-5">
                    <div class="mt-5">
                        <h2 class="text-muted">{{ __('messages.tempMail.whatIsTempMail') }}</h2>
                        <div class="temp-emailbox-text text-center my-2">
                            <p>{{ __('messages.tempMail.whatIsTempMail_p1') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            </div>



        </div>
    </section>

    <section class="bg-light">
        <div class="container mt-5">


            <div class="mt-5 temp-emailbox-text">
                <h2 class="text-muted">{{ __('messages.tempMail.techBehind') }}</h2>
                <div>
                    <p>{{ __('messages.tempMail.techBehind_p1') }}</p>
                    <p>{{ __('messages.tempMail.techBehind_p2') }}</p>
                    <p>{{ __('messages.tempMail.techBehind_p3') }}</p>
                </div>
            </div>

            <div class="mt-5 temp-emailbox-text">
                <h2 class="text-muted">{{ __('messages.tempMail.whatIsTempMail2') }}</h2>
                <div>
                    <p>{{ __('messages.tempMail.whatIsTempMail2_p1') }}</p>
                    <p>{{ __('messages.tempMail.whatIsTempMail2_p2') }}</p>
                    <p>{{ __('messages.tempMail.whatIsTempMail2_p3') }}</p>
                </div>
            </div>

            <div class="mt-5 temp-emailbox-text mb-5">
                <h2 class="text-muted">{{ __('common.Conclusion') }}</h2>
                <p>
                    {{ __('messages.tempMail.conclusion') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Bootstrap Toast -->
    <div class="toast fixedToast" role="alert">
        <div class="toast-body">
            <strong class="mr-auto">Copied</strong>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="changeMailModal" tabindex="-1" aria-labelledby="changeMailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-dark" id="changeMailModalLabel">Change Email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email Alias</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-md" id="random_code_input">
                            <button type="button" id="random_code" class="btn btn-primary btn-md">Random Name</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Domain</label>
                        <select class="form-select form-select-md select-input" id="name_domain" tabindex="-1"
                            aria-hidden="true">
                        </select>
                    </div>
                    <button id="change_email" class="btn btn-primary kill btn-md w-100">Update Email Address</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            axios.get(`{{ route('mailbox') }}`)
                .then(function(response) {
                    // Update the content with the generated email
                    $('#mailbox').val(response.data.email);
                    $('#email_id').val(response.data.email);
                    $('#email_id').prop('disabled', false);

                    var emails = response.data.list;
                    emails.forEach(e => {
                        $('#name_domain').append(`
                        <option value="` + e.name + `" data-select2-id="select2-data-2-cbn5">
                            ` + e.name + `
                        </option>`);
                    });
                })
                .catch(function(error) {
                    console.error(error);
                });

            $('#random_code').on('click', function() {
                var name = generateRandomEmail();
                $('#random_code_input').val(name);
            });

            $('#change_email').on('click', function() {
                $('#email_id').prop('disabled', true);
                var name = $('#random_code_input').val();
                var domain = $('#name_domain').find(':selected').val();
                var email = name + '@' + domain;
                axios.post(`{{ route('updateEmail') }}`, {
                    email: email
                }).then(function(response) {
                    $('#email_id').prop('disabled', false);
                    if (response.status === 200) {
                        console.log(response);

                        $('#mailbox').val(response.data.email);
                        $('#email_id').val(response.data.email);

                    }
                });
            });
        });




        $('#click-to-refresh').click(function() {
            Livewire.dispatch('refreshInbox');
        });

        $('#click-to-change').click(function() {
            $(document).ready(function() {
                axios.post(`{{ route('mailbox') }}`, {
                        refresh: true
                    })
                    .then(function(response) {
                        // Update the content with the generated email

                        $('#mailbox').val(response.data.email);
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            });
        });


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


        function copyToClipboard() {
            // Select the text you want to copy
            const textToCopy = $('#mailbox').val();

            // Create a temporary textarea element to hold the text
            const textArea = document.createElement("textarea");
            textArea.value = textToCopy;

            // Append the textarea to the document
            document.body.appendChild(textArea);

            // Select the text within the textarea
            textArea.select();

            // Execute the copy command
            document.execCommand("copy");

            // Remove the temporary textarea
            document.body.removeChild(textArea);

            $('.toast').toast('show')
            // Set a timeout to hide the tooltip after a few seconds
            setTimeout(function() {
                $('.toast').toast('hide')
            }, 1000);
        }


        function generateRandomEmail() {
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-.";
            let name = "";
            const nameLength = Math.floor(Math.random() * 8) + 5; // Random length (5-12)

            for (let i = 0; i < nameLength; i++) {
                name += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            // Ensure the first and last character is a letter or number (not a special char)
            if (!/^[a-zA-Z0-9]/.test(name.charAt(0))) {
                name = "a" + name.substring(1);
            }
            if (!/[a-zA-Z0-9]$/.test(name.charAt(name.length - 1))) {
                name = name.substring(0, name.length - 1) + "z";
            }

            // Prevent consecutive dots
            name = name.replace(/\.\./g, ".");

            return name;
        }
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-loader', (event) => {
                showLoader();
                setTimeout(function() {
                    hideLoader();
                }, 1000);
            });
        });


    </script>
@stop
