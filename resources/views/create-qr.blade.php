@extends('layouts.master')
@section('title', 'Create QR Code')
@section('desctiption',
    'Create QR Code for free. Generate QR code for any URL, text, vCard, or other data types with
    our easy-to-use QR code generator tool.')
@section('keywords',
    'create qr code, generate qr code, free qr code generator, qr code maker, qr code online, qr code
    generator tool, create qr code for url, create qr')
    @push('styles')
        <style>
            html,
            body {
                height: 100%;
                /* Ensure body takes full height */
                margin: 0;
                padding: 0;
            }

            .iframe-container {
                width: 100%;
                height: 100vh;
                /* Full viewport height */
                overflow: hidden;
            }

            .iframe-container iframe {
                width: 100%;
                height: 100%;
                border: 0;
                display: block;
            }
        </style>
    @endpush
@section('content')

    <main class="flex-shrink-0">
        <!-- Navigation-->
        <!-- Page content-->
        <div class="iframe-container">
            <iframe src="https://www.autolikerlive.com/create-qr-code/" frameborder="0" allowfullscreen></iframe>
        </div>

    </main>


@stop
