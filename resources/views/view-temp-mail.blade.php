@extends('layouts.master')

@section('title', 'Temp Mail - Read Message')
@section('description',
    'Get a temporary email address with ease using Temp Mail, your solution for disposable email
    needs. Protect your online privacy today.')

@section('favicons')
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/favicons/temp-mail/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/favicons/temp-mail/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicons/temp-mail/favicon-16x16.png') }}">
    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <meta name="robots" content="noindex">
@endsection
@section('ogimage',
    'https://www.autolikerlive.com/blog/wp-content/uploads/2025/05/ChatGPT-Image-May-1-2025-08_11_55-AM.webp')


@section('javascripts')

@endsection

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
            padding-top: 13px;
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
            height: 8px;
            width: 8px;
            background-color: green;
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

        .user-data-name figure {
            width: 50px;
            height: 50px;
            border: 2px solid #e5e5f0;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 0;
            top: 0;
            line-height: 50px;
            text-align: center;
            font-weight: 700;
            font-size: 16px;
            color: #00c497;
            border-radius: 50%;
            overflow: hidden;
        }

        .user-data-name {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 100%;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .user-data-name {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 70%;
            -ms-flex: 0 0 70%;
            flex: 0 0 70%;
            max-width: 70%;
            display: block;
            height: 60px;
            padding-left: 65px;
            position: relative;
        }

        .from-name {
            font-size: 14px;
            margin: 0;
            width: 100%;
            color: #22242b;
            font-weight: 500;
            font-family: Roboto, sans-serif !important;
            padding: 8px 0 0;
        }

        #messageList h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            color: black;
        }

        .ad-block-right-336X280 {
            margin-right: -50px;
        }

        .ad-block-336X280 {
            max-height: 247px;
            position: relative;
        }

        .ads-box {
            font-size: 0;
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
    @php

        function getInitials($name)
        {
            $nameArray = explode(' ', $name); // Split the name into an array of words
            $initials = '';

            foreach ($nameArray as $word) {
                $initials .= strtoupper(substr($word, 0, 1)); // Get the first character and convert it to uppercase
            }

            return $initials;
        }
    @endphp
    <div class="pageLoader"></div>
    <!-- Navigation-->
    <x-navbar></x-navbar>
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
                                <div class="col-4 text-white text-left font-weight-bold pl-2"></div>
                                <div class="col-4 text-white text-center font-weight-bold">INBOX</div>
                                <div class="col-4 text-white text-right font-weight-bold pr-2"></div>
                            </div>
                        </div>

                        <div class="card-body min-hv-18rem">
                            <div class="row">
                                <div class="col-box p-2 bg-light inboxWarpMain" id="messageList">


                                    <div class="inbox-data-content">
                                        <div class="inbox-data-content-header">
                                            <div class="user-data-name 0">

                                                <figure class="first-letters">
                                                    @php

                                                        if (is_array($email)) {
                                                            $from = isset($email['from']) ? $email['from'] : '';
                                                            $fromEmail = isset($email['from_email'])
                                                                ? $email['from_email']
                                                                : '';
                                                        } else {
                                                            $from = is_string($email) ? $email : '';
                                                            $fromEmail = '';
                                                        }
                                                    @endphp
                                                    {{ e(getInitials($from)) }}
                                                </figure>
                                                <p class="from-name">{{ $from }}</p>
                                                <p class="text-muted">{{ $fromEmail }}</p>
                                            </div>
                                            <div class="text-muted">
                                                <span class="date-time-text">Date: {{ is_array($email) && isset($email['receivedAt']) ? $email['receivedAt'] : 'N/A' }}</span>

                                            </div>

                                        </div>
                                        <div class="h5 text-dark">
                                            <small><span class="text-muted">Subject:</span>
                                                {{ is_array($email) && isset($email['subject']) ? $email['subject'] : 'No Subject' }}</small>
                                        </div>
                                        <div class="inbox-data-content-intro">
                                            @php
                                                $emailBody = '';
                                                if (is_array($email) && isset($email['content'])) {
                                                    $emailBody = $email['content'];
                                                } elseif (is_string($email)) {
                                                    $emailBody = $email;
                                                }

                                                $pattern =
                                                    '/Content-Type:\s*image\/[a-z]+;\s*name="([^"]+)"(.*?)Content-Disposition:\s*inline;\s*filename="([^"]+)"(.*?)Content-Transfer-Encoding:\s*base64\s*Content-ID:\s*<([^>]+)>(.*?)X-Attachment-Id: [^\s]+\s+([\s\S]+?)(?=\nContent-Type|\n*$)/s';
                                                if (preg_match_all($pattern, $emailBody, $matches, PREG_SET_ORDER)) {
                                                    foreach ($matches as $match) {
                                                        $cid = $match[5]; // Extract the Content-ID
                                                        $base64Content = trim($match[7]); // Extract Base64 content

                                                        // Create Base64 Data URI for the image
                                                        $mimeType = 'image/png'; // Default MIME type (you can extract it from `Content-Type`)
                                                        $dataUri = 'data:' . $mimeType . ';base64,' . $base64Content;
                                                        // Replace CID in the email body with the Base64 data URI
                                                        $emailBody = str_replace("cid:$cid", $dataUri, $emailBody);
                                                    }
                                                }
                                                // Remove unnecessary content (headers, etc.)
                                                $emailBody = preg_replace(
                                                    '/Content-Type:\s*image\/[a-z]+;\s*name="[^"]+"\s*Content-Disposition:\s*inline;\s*filename="[^"]+"\s*Content-Transfer-Encoding:\s*base64\s*Content-ID:\s*<[^>]+>\s*X-Attachment-Id:[^\n]+\s+[\s\S]+?(?=\nContent-Type|$)/',
                                                    '',
                                                    $emailBody,
                                                );

                                            @endphp
                                            {!! html_entity_decode($emailBody) !!}
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-2 col-lg-2">
                    <!-- temp-mail-buttom -->

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col-md-6 col-lg-8 col-sm-12 text-center mb-5">

                    <div class="mt-5">
                        <h2 class="text-muted">What is Disposable Temporary E-mail?</h2>
                        <div class="temp-emailbox-text text-center my-2">
                            <p>Disposable Email: This is a free email service that allows you to receive emails at a
                                temporary address that self-destructs after a period of time. Also known as: temporary
                                email, 10 minute email, 10 minute email, disposable email, fake email, fake email
                                generator,
                                email burner or spam. Many forums, Wi-Fi network owners, websites and blogs require
                                visitors
                                to register before they can view content, post comments or download anything. Temp-Mail
                                is
                                the most advanced email service that helps you avoid spam and stay safe.</p>
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
                <h2 class="text-muted">The Tech behind Disposable Email Addresses</h2>
                <p>
                    Everyone has an email address every hour, whether they're contacting potential clients at work or
                    using
                    their email address as an online passport to contact friends and colleagues.<br> Almost 99% of all
                    apps
                    and services we sign up for today require an email address, as do most customer loyalty cards,
                    contests,
                    offer flyers, etc. We all like to have an email address, but getting a lot of spam every day is
                    inconvenient.<br> It's also common for store databases to be hacked, putting your business email
                    address
                    at risk and making it more likely to end up on spam lists. However, nothing done online is 100%
                    private.
                    Therefore, you should protect the identity of your email contacts, preferably by using disposable
                    email
                    addresses.

                </p>
            </div>

            <div class="mt-5 temp-emailbox-text">
                <h2 class="text-muted">So, What Is A Disposable Email Address?</h2>
                <p>
                    Recently, I found a bounce rate complex than usual on my latest email blast! I later realized the
                    surge
                    of users (or bots) signing up for my services hiding their real identity using disposable mail
                    addresses. Disposable email address (DEA) technically means an approach where a user’s with a unique
                    email address gets a temporary email address for your current contact. The DEA allow the creation of
                    an
                    email address that passes validity need to sign-up for services and website without having to show
                    your
                    true identity.<br><br> Disposable emails address if compromised or used in connection with email
                    abuse
                    online, the owner can’t be tied to the abuse and quickly cancel its application without affecting
                    other
                    contacts.<br> With temporary mail, you can you receive your emails from the fake emails in your
                    genuine
                    emails address for a specified time set. A fake email address is just an intermediate email, a bunch
                    of
                    temporary emails, and a self-destructing email.


                </p>
            </div>

            <div class="mt-5 temp-emailbox-text mb-5">
                <h2 class="text-muted">To Conclude:</h2>
                <p>
                    Temp-mail provides a brilliantly designed disposable email address system that safeguards your true
                    identity from exposure and prevents any unauthorized sale of your information when engaging in
                    online
                    wikis, chat rooms, file sharing services, and bulletin board forums. This ensures a spam-free
                    mailbox.


                </p>
            </div>
        </div>
    </section>
@stop
