@extends('layouts.master-test')

@section('title', __('messages.tempMail.meta_title'))
@section('description', __('messages.tempMail.meta_desc'))
@section('keywords', 'free, temporary, email, disposable, mail, email address')
@section('javascripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        (function(d, z, s) {
            s.src = 'https://' + d + '/401/' + z;
            try {
                (document.body || document.documentElement).appendChild(s)
            } catch (e) {}
        })('gizokraijaw.net', 5865357, document.createElement('script'))
    </script>

    <script>
        function timeAgo(timestamp) {
            // Convert input timestamp (UTC) to a Date object
            let timeUtc = new Date(timestamp + "Z"); // Ensure it's treated as UTC

            // Get user's local timezone offset in minutes (negative means ahead of UTC)
            let offsetMinutes = new Date().getTimezoneOffset();

            // Adjust the time to user's local timezone
            let localTime = new Date(timeUtc.getTime() - offsetMinutes * 60000);

            // Get the current local time
            let now = new Date();

            // Calculate the difference in seconds
            let diff = Math.floor((now - localTime) / 1000);

            if (diff < 0) {
                return "Just now"; // Handle future timestamps
            } else if (diff < 60) {
                return `${diff} seconds ago`;
            } else if (diff < 3600) {
                return `${Math.floor(diff / 60)} minutes ago`;
            } else if (diff < 86400) {
                return `${Math.floor(diff / 3600)} hours ago`;
            } else if (diff < 2592000) { // 30 days
                return `${Math.floor(diff / 86400)} days ago`;
            } else if (diff < 31536000) { // 12 months
                return `${Math.floor(diff / 2592000)} months ago`;
            } else {
                return `${Math.floor(diff / 31536000)} years ago`;
            }
        }
    </script>

@stop
@section('content')
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

        .ad-block-right-336X280 {
            max-width: 300px;
            margin-right: -50px;
        }

        .ad-block-336X280 {
            max-height: 247px !important;
            position: relative;
        }


        .ads-box {
            font-size: 0;
        }

        .mail-wrapper {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: center;
            margin-top: 25px;
            flex-wrap: nowrap;
        }

        @media (max-width: 1200px) {
            .mail-wrapper {
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
            }
        }

        .mail-wrapper .ad {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        @media (max-width: 1200px) {
            .mail-wrapper .ad:first-child {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 1200px) {
            .mail-wrapper .ad:last-child {
                margin-top: 20px;
            }
        }

        .mail-wrapper .mail-selection {
            max-width: 750px;
            width: 100%;
            border-radius: 10px;
            padding: 40px 30px;
            /*margin-right: auto;
                                margin-left: auto;
                                */
            margin: 0 15px;
            -ms-flex-negative: 1;
            flex-shrink: 1;
        }

        .mail-wrapper .mail-selection .mail-select {
            position: relative;
            z-index: 50;
        }

        .mail-wrapper .mail-selection .mail-select .mail-input {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .mail-wrapper .mail-selection .mail-select .mail-input input {
            outline: 0;
            border: 0;
            border-radius: 8px;
            padding: 10px 80px 10px 20px;
            font-weight: 500;
            font-size: 18px;
            height: 70px;
            width: 100%;
            cursor: pointer;
            -webkit-transition: .3s;
            -o-transition: .3s;
            transition: .3s;
            background-color: #f8f9fa;
        }

        @media (max-width: 991.98px) {
            .mail-wrapper .mail-selection .mail-select .mail-input input {
                height: 55px;
            }
        }

        .mail-wrapper .mail-selection .mail-select .mail-input .mail-input-copy {
            position: absolute;
            right: 8px;
            height: 80%;
            width: 60px;
            font-size: 18px;
        }

        .mail-wrapper .mail-selection .mail-select .mail-input .mail-input-icon {
            position: absolute;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            right: 80px;
            font-size: 16px;
            color: var(--text_color);
            cursor: pointer;
            border: 2px solid var(--text_color);
            border-radius: 50%;
            width: 26px;
            height: 26px;
        }

        .mail-wrapper .mail-selection .mail-select .mail-results {
            visibility: hidden;
            position: absolute;
            width: 100%;
            background-color: #f6f6f6;
            border-radius: 0 0 8px 8px;
            opacity: 0;
            -webkit-transition: .3s;
            -o-transition: .3s;
            transition: .3s;
        }

        .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-item {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 10px 16px;
            color: var(--text_color);
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border-top: 1px solid #ddd;
            cursor: pointer;
        }

        .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-item label {
            cursor: pointer;
        }

        .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-info {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            color: var(--text_color);
            text-align: center;
            background-color: #e7e7e7;
            padding: 10px;
            border-radius: 0 0 8px 8px;
        }

        .mail-wrapper .mail-selection .mail-select .mail-results .mail-results-info .btn {
            font-size: 12px;
        }

        .mail-wrapper .mail-selection .mail-select.show .mail-input input {
            border-radius: 8px 8px 0 0;
        }

        .mail-wrapper .mail-selection .mail-select.show .mail-results {
            visibility: visible;
            opacity: 1;
        }

        .mail-wrapper .mail-selection .mail-actions {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-top: 25px;
        }

        @media (max-width: 991.98px) {
            .mail-wrapper .mail-selection .mail-actions {
                margin-top: 15px;
            }
        }

        .mail-wrapper .mail-selection .mail-actions .mail-action {
            width: 100%;
            color: var(--text_color);
            padding: 12px 8px;
            font-size: 15px;
            white-space: nowrap;
        }





        @media (max-width: 991.98px) {
            .mail-wrapper .mail-selection .mail-actions .mail-action {
                font-size: 12px;
            }
        }

        @media (max-width: 499.98px) {
            .mail-wrapper .mail-selection .mail-actions .mail-action {
                padding: 7px 5px;
            }
        }

        .mail-wrapper .mail-selection .mail-actions .mail-action:not(:last-child) {
            margin-right: 10px;
        }

        .mail-wrapper .mail-selection .mail-actions .mail-action .mail-action-text {
            margin-left: 5px;
        }

        @media (max-width: 991.98px) {
            .mail-wrapper .mail-selection .mail-actions .mail-action .mail-action-text {
                display: none;
            }
        }

        .ad.ad-v {
            width: 200px;
            height: 600px;
        }

        .ad.ad-h {
            max-width: 720px;
            width: 100%;
            height: 90px;
        }

        .ad.ad-350 {
            max-width: 350px;
            width: 100%;
            height: 250px;
        }

        .ad.ad-250x250 {
            max-width: 250px;
            width: 100%;
            max-height: 250px;
            display: block !important;
        }

        .ad.ad-box {
            max-width: 250px;
            width: 100%;
            height: 250px;
        }



        .ad img {
            width: 100%;
            height: 100%;
        }

        .mail-wrapper .ad {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .viewbox-container .ad {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .mailbox-container .ad {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #6565652b !important;
            opacity: 1;
        }


        .modal-header {
            border-bottom: 0px solid #dee2e6 !important;

        }

        .btn {
            border-radius: 8px !important;
            border-width: 2px !important;
            -webkit-transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            -o-transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
    <div class="pageLoader"></div>
    <!-- Navigation-->
    <x-navbar></x-navbar>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container pxc-5">
            <div class="mail-wrapper">
                <div class="ad ad-250x250">
                    <!-- Temp Mail Left adsbygoogle -->

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

                </div>
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

                    <button type="button" data-bs-toggle="modal" data-bs-target="#changeMailModal"
                        class="no-ajaxy tm-btn btn-gray" data-original-title="" title=""> <svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg> Edit</button>



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
    <section class="container text-center">
        <!-- Temp Mail Center adsbygoogle -->

    </section>
    <section class="bg-light">
        <div class="container">
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


                                    <div class="inbox-empty">
                                        <div class="inbox-empty-msg">
                                            <svg width="92" height="94" viewBox="0 0 92 87" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M26 54.37V38.9C26.003 37.125 26.9469 35.4846 28.48 34.59L43.48 25.84C45.027 24.9468 46.933 24.9468 48.48 25.84L63.48 34.59C65.0285 35.4745 65.9887 37.1167 66 38.9V54.37C66 57.1314 63.7614 59.37 61 59.37H31C28.2386 59.37 26 57.1314 26 54.37Z"
                                                    fill="#8C92A5"></path>
                                                <path
                                                    d="M46 47.7L26.68 36.39C26.2325 37.1579 25.9978 38.0312 26 38.92V54.37C26 57.1314 28.2386 59.37 31 59.37H61C63.7614 59.37 66 57.1314 66 54.37V38.9C66.0022 38.0112 65.7675 37.1379 65.32 36.37L46 47.7Z"
                                                    fill="#CDCDD8"></path>
                                                <path
                                                    d="M27.8999 58.27C28.7796 58.9758 29.8721 59.3634 30.9999 59.37H60.9999C63.7613 59.37 65.9999 57.1314 65.9999 54.37V38.9C65.9992 38.0287 65.768 37.1731 65.3299 36.42L27.8999 58.27Z"
                                                    fill="#E5E5F0"></path>
                                                <path class="emptyInboxRotation"
                                                    d="M77.8202 29.21L89.5402 25.21C89.9645 25.0678 90.4327 25.1942 90.7277 25.5307C91.0227 25.8673 91.0868 26.348 90.8902 26.75L87.0002 34.62C86.8709 34.8874 86.6407 35.0924 86.3602 35.19C86.0798 35.2806 85.7751 35.2591 85.5102 35.13L77.6502 31.26C77.2436 31.0643 76.9978 30.6401 77.0302 30.19C77.0677 29.7323 77.3808 29.3438 77.8202 29.21Z"
                                                    fill="#E5E5F0"></path>
                                                <path class="emptyInboxRotation"
                                                    d="M5.12012 40.75C6.36707 20.9791 21.5719 4.92744 41.2463 2.61179C60.9207 0.296147 79.4368 12.3789 85.2401 31.32"
                                                    stroke="#E5E5F0" stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path class="emptyInboxRotation"
                                                    d="M14.18 57.79L2.46001 61.79C2.03313 61.9358 1.56046 61.8088 1.2642 61.4686C0.967927 61.1284 0.906981 60.6428 1.11001 60.24L5.00001 52.38C5.12933 52.1127 5.35954 51.9076 5.64001 51.81C5.92044 51.7194 6.22508 51.7409 6.49001 51.87L14.35 55.74C14.7224 55.9522 14.9394 56.36 14.9073 56.7874C14.8753 57.2149 14.5999 57.5857 14.2 57.74L14.18 57.79Z"
                                                    fill="#E5E5F0"></path>
                                                <path class="emptyInboxRotation"
                                                    d="M86.9998 45.8C85.9593 65.5282 70.9982 81.709 51.4118 84.2894C31.8254 86.8697 13.1841 75.1156 7.06982 56.33"
                                                    stroke="#E5E5F0" stroke-width="3" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                            <p class="emptyInboxTitle">Your inbox is empty</p>
                                            <p class="text-muted">Waiting for incoming emails</p>
                                        </div>
                                    </div>


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
            axios.post(`{{ route('mailbox') }}`)
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


        function loadMessage() {
            var messagelistItem = "";
            var emailbox = $('#mailbox').val();
            axios.post(`{{ route('message') }}`, {
                    email: emailbox
                })
                .then(function(response) {
                    // Update the content with the generated email
                    const emailList = response.data.messages;
                    emailList.reverse();
                    if (emailList !== undefined) {
                        emailList.forEach(email => {
                            messagelistItem += `<a href="{{ url('') }}/message/view/${email.id}" class="viewLink d-flex mb-3">
	                <div class="col-1 ${email.is_seen == 1 ? 'is-active' : 'is-not-active'} "></div>
	                <div class="col-3 mx-2">
	                	  <span class="d-flex text-dark">` + email.from + `</span>

	                </div>
	  				<div class="col-6 mx-2">
	  					<small class="text-dark font-weight-bold">` + email.subject + `</small>
                        <span class="d-flex text-muted"
                        style="font-size: small;font-style: italic;"
                        >` + email.from_email + `</span>
	  				</div>
	  				<div class="col-2 text-right text-muted" style="
                        font-size: x-small;
                        font-style: italic;
                    ">
	  					` + timeAgo(email.receivedAt) + `
	  				</div>

	            </a>
		        	`
                        });
                    }
                    showLoader();
                    setTimeout(function() {
                        hideLoader();
                    }, 1000);
                    if (messagelistItem != "")
                        $('#messageList').html(messagelistItem)
                })
                .catch(function(error) {
                    console.error(error);
                });
        }


        $('#click-to-refresh').click(function() {
            $(document).ready(function() {
                loadMessage();
            });
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



        setInterval(function() {
            loadMessage();
        }, 5000);




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
    </script>
@stop
