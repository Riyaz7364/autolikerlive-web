@extends('layouts.master')

@section('title', 'View promotions')
@section('description', 'Boost your profile - Start promotion here')


@section('javascripts')
@endsection

@push('styles')
    <style>
        .scaleX2 {
            scale: 2;
        }
    </style>
@endpush

@section('content')
    <x-navbar></x-navbar>
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center">Boost Profile</h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                <x-instagram.credits :credits="$user['credits']"></x-instagram.credits>



                <div class="card mb-3 mainb">
                    <div class="card-body row">
                        <div class="container-fluid">
                            <!-- Table for large screens -->
                            <div class="d-none d-lg-block">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Promotion</th>
                                            <th class="text-center">Required</th>
                                            <th class="text-center">Delivered</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Boost</th>
                                            <th class="text-center">Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($links as $link)
                                            @php
                                                // Construct the Instagram URL
                                                if ($user->loginType == 'IG') {
                                                    $instagramUrl = 'https://www.instagram.com/';
                                                    switch ($link->service) {
                                                        case 'reels_likes':
                                                            $instagramUrl .= 'reels/';
                                                            break;
                                                        case 'likes':
                                                            $instagramUrl .= 'p/';
                                                            break;
                                                        default:
                                                            $instagramUrl .= '';
                                                    }
                                                } else {
                                                    $instagramUrl = 'https://www.facebook.com/';
                                                }
                                                $instagramUrl .= $link->link;
                                            @endphp
                                            <tr>
                                                <td class="text-center">#{{ $link->id }}</td>
                                                <td class="text-center">{{ $link->service }}</td>
                                                <td class="text-center">
                                                    <span>{{ Str::substr($instagramUrl, 0, 40) }}...</span>
                                                    <div class="btn">
                                                        <a href="{{ $instagramUrl }}" target="_blank"
                                                            rel="noopener noreferrer">
                                                            {!! getIcon('bi-link-45deg', 'text-success scaleX2') !!}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $link->limit }}</td>
                                                <td class="text-center">{{ $link->count }}</td>
                                                @switch($link->status)
                                                    @case('paused')
                                                        {{ $status_class = 'btn-warning' }}
                                                    @break

                                                    @case('running')
                                                        {{ $status_class = 'btn-info' }}
                                                    @break

                                                    @default
                                                        {{ $status_class = 'btn-success' }}
                                                @endswitch
                                                <td class="text-center"><span
                                                        class="status-badge btn {{ $status_class }} text-light fw-bold"
                                                        data-id="{{ $link->id }}">{{ ucfirst($link->status) }}</span>
                                                </td>
                                                <td class="text-center text-muted">Soon</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        @if ($link->status == 'paused')
                                                            <button class="btn btn-success btn-sm action"
                                                                data-id="{{ $link->id }}"
                                                                onclick="startLink({{ $link->id }})">Start</button>
                                                        @else
                                                            <button class="btn btn-warning btn-sm action"
                                                                data-id="{{ $link->id }}"
                                                                onclick="pauseLink({{ $link->id }})">Pause</button>
                                                        @endif
                                                        @if ($link->status == 'completed')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="deleteLink({{ $link->id }})">Delete</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Collapsible rows for mobile screens -->
                            <div class="d-block d-lg-none">
                                @foreach ($links as $link)
                                    @php
                                        if ($user->loginType == 'IG') {
                                            $instagramUrl = 'https://www.instagram.com/';
                                            switch ($link->service) {
                                                case 'reels_likes':
                                                    $instagramUrl .= 'reels/';
                                                    break;
                                                case 'likes':
                                                    $instagramUrl .= 'p/';
                                                    break;
                                                default:
                                                    $instagramUrl .= '';
                                            }
                                        } else {
                                            $instagramUrl = 'https://www.facebook.com/';
                                        }
                                        $instagramUrl .= $link->link;
                                    @endphp
                                    <div class="accordion-item">
                                        <h3 class="accordion-header" id="heading{{ $link->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $link->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $link->id }}">#{{ $link->id }} -
                                                {{ $link->service }}</button>
                                        </h3>
                                        <div class="accordion-collapse collapse show" id="collapse{{ $link->id }}"
                                            aria-labelledby="heading{{ $link->id }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="card-body">
                                                    <strong>Promotion URL:</strong>
                                                    <a href="{{ $instagramUrl }}" target="_blank"
                                                        rel="noopener noreferrer">{{ $instagramUrl }}</a>
                                                    <br>
                                                    <strong>Required:</strong> {{ $link->limit }}
                                                    <br>
                                                    <strong>Delivered:</strong> {{ $link->count }}
                                                    <br>
                                                    <strong>Status:</strong> <span class="status-badge"
                                                        data-id="{{ $link->id }}">
                                                        {{ ucfirst($link->status) }}</span>
                                                    <br>
                                                    <div class="btn-group">
                                                        @if ($link->status == 'paused')
                                                            <button class="btn btn-success btn-sm action"
                                                                onclick="startLink({{ $link->id }})"
                                                                data-id="{{ $link->id }}">Start</button>
                                                        @else
                                                            <button class="btn btn-warning btn-sm action"
                                                                onclick="pauseLink({{ $link->id }})"
                                                                data-id="{{ $link->id }}">Pause</button>
                                                        @endif



                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="deleteLink({{ $link->id }})" class="delete"
                                                            data-id="{{ $link->id }}">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            function updateStatus(linkId, action) {
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: `{{ route('autoliker.view.update') }}`, // Update with your actual route
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        id: linkId,
                        status: action
                    },
                    success: function(response) {
                        console.log(response);

                        if (response.success) {

                            let statusBadge = $('.status-badge[data-id="' + linkId + '"]');
                            statusBadge.text(action.charAt(0).toUpperCase() + action.slice(1));
                            statusBadge.removeClass('btn-info btn-warning btn-danger');
                            let actionBtn = $('.action[data-id="' + linkId + '"]');
                            if (action === 'paused') {
                                actionBtn.removeClass('btn-warning');
                                actionBtn.addClass('btn-success');
                                actionBtn.text('Start');
                                statusBadge.addClass('btn-warning');
                            } else if (action === 'running') {
                                actionBtn.removeClass('btn-success');
                                actionBtn.addClass('btn-warning');
                                actionBtn.text('Pause');
                                statusBadge.addClass('btn-info');
                            } else if (action === 'deleted') {
                                statusBadge.addClass('btn-danger');
                            } else {
                                statusBadge.addClass('btn-info');
                            }
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            }

            window.startLink = function(linkId) {
                updateStatus(linkId, 'running');
            }

            window.pauseLink = function(linkId) {
                updateStatus(linkId, 'paused');
            }

            window.deleteLink = function(linkId) {
                updateStatus(linkId, 'deleted');
            }
        });
    </script>
@endsection
