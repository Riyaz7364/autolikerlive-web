@extends('layouts.master')

@section('title', 'View promotions')
@section('description', 'Boost your profile - Start promotion here')

@section('javascripts')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
        crossorigin="anonymous"></script>
@endsection

@push('styles')
    <style>
        .scaleX2 {
            scale: 2;
        }

        .promotion-url {
            max-width: 320px;
            display: inline-block;
            vertical-align: middle;
        }

        .ad-slot {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90px;
            margin: 1.25rem 0;
            padding: 1rem;
            color: #6c757d;
            background: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 8px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <main class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="text-center mb-4">Boost Profile</h1>

                    <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>
                    <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>

                    <div class="ad-slot" aria-label="Advertisement">
                        <!-- Google ad slot: paste adsbygoogle unit here -->
                    </div>

                    <div class="card mb-3 mainb">
                        <div class="card-body">
                            <!-- Table for large screens -->
                            <div class="d-none d-lg-block table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Id</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Promotion</th>
                                            <th class="text-center">Required</th>
                                            <th class="text-center">Delivered</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($links as $link)
                                            @php
                                                $loginType = data_get($user, 'loginType', data_get($user, 'login_type'));
                                                $instagramUrl = $loginType === 'IG'
                                                    ? 'https://www.instagram.com/'
                                                    : 'https://www.facebook.com/';

                                                if ($loginType === 'IG') {
                                                    switch ($link->service) {
                                                        case 'reels_likes':
                                                            $instagramUrl .= 'reels/';
                                                            break;
                                                        case 'likes':
                                                            $instagramUrl .= 'p/';
                                                            break;
                                                    }
                                                }

                                                $instagramUrl .= ltrim($link->link, '/');

                                                switch ($link->status) {
                                                    case 'paused':
                                                        $status_class = 'btn-warning';
                                                        break;
                                                    case 'running':
                                                        $status_class = 'btn-info';
                                                        break;
                                                    case 'deleted':
                                                        $status_class = 'btn-danger';
                                                        break;
                                                    default:
                                                        $status_class = 'btn-success';
                                                        break;
                                                }
                                            @endphp
                                            <tr data-row-id="{{ $link->id }}">
                                                <td class="text-center">#{{ $link->id }}</td>
                                                <td class="text-center">{{ $link->service }}</td>
                                                <td class="text-center">
                                                    <span class="promotion-url text-truncate">{{ $instagramUrl }}</span>
                                                    <a class="inline-flex items-center gap-2 px-2 py-1 rounded btn btn-sm" href="{{ $instagramUrl }}" target="_blank"
                                                        rel="noopener noreferrer" aria-label="Open promotion link">
                                                        {!! getIcon('bi-link-45deg', 'text-success scaleX2') !!}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $link->limit }}</td>
                                                <td class="text-center">{{ $link->count }}</td>
                                                <td class="text-center">
                                                    <span class="status-badge inline-flex px-3 py-1 rounded font-semibold btn {{ $status_class }} text-light"
                                                        data-id="{{ $link->id }}">{{ ucfirst($link->status) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group" aria-label="Promotion actions">
                                                        @if ($link->status == 'paused')
                                                            <button type="button" class="inline-flex items-center px-3 py-1 rounded btn btn-success btn-sm action"
                                                                onclick="startLink({{ $link->id }})"
                                                                data-id="{{ $link->id }}">Start</button>
                                                        @else
                                                            <button type="button" class="inline-flex items-center px-3 py-1 rounded btn btn-warning btn-sm action"
                                                                onclick="pauseLink({{ $link->id }})"
                                                                data-id="{{ $link->id }}">Pause</button>
                                                        @endif

                                                        <button type="button" class="inline-flex items-center px-3 py-1 rounded btn btn-danger btn-sm delete"
                                                            onclick="deleteLink({{ $link->id }})"
                                                            data-id="{{ $link->id }}">Delete</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    No promotions found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Collapsible rows for mobile screens -->
                            <div class="accordion d-block d-lg-none" id="accordionExample">
                                @forelse ($links as $link)
                                    @php
                                        $loginType = data_get($user, 'loginType', data_get($user, 'login_type'));
                                        $instagramUrl = $loginType === 'IG'
                                            ? 'https://www.instagram.com/'
                                            : 'https://www.facebook.com/';

                                        if ($loginType === 'IG') {
                                            switch ($link->service) {
                                                case 'reels_likes':
                                                    $instagramUrl .= 'reels/';
                                                    break;
                                                case 'likes':
                                                    $instagramUrl .= 'p/';
                                                    break;
                                            }
                                        }

                                        $instagramUrl .= ltrim($link->link, '/');
                                    @endphp
                                    <div class="accordion-item" data-row-id="{{ $link->id }}">
                                        <h3 class="accordion-header" id="heading{{ $link->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $link->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $link->id }}">
                                                #{{ $link->id }} - {{ $link->service }}
                                            </button>
                                        </h3>
                                        <div class="accordion-collapse collapse" id="collapse{{ $link->id }}"
                                            aria-labelledby="heading{{ $link->id }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <strong>Promotion URL:</strong>
                                                <a href="{{ $instagramUrl }}" target="_blank"
                                                    rel="noopener noreferrer">{{ $instagramUrl }}</a>
                                                <br>
                                                <strong>Required:</strong> {{ $link->limit }}
                                                <br>
                                                <strong>Delivered:</strong> {{ $link->count }}
                                                <br>
                                                <strong>Status:</strong>
                                                <span class="status-badge" data-id="{{ $link->id }}">
                                                    {{ ucfirst($link->status) }}
                                                </span>
                                                <br>
                                                <div class="btn-group mt-3" role="group" aria-label="Promotion actions">
                                                    @if ($link->status == 'paused')
                                                        <button type="button" class="inline-flex items-center px-3 py-1 rounded btn btn-success btn-sm action"
                                                            onclick="startLink({{ $link->id }})"
                                                            data-id="{{ $link->id }}">Start</button>
                                                    @else
                                                        <button type="button" class="inline-flex items-center px-3 py-1 rounded btn btn-warning btn-sm action"
                                                            onclick="pauseLink({{ $link->id }})"
                                                            data-id="{{ $link->id }}">Pause</button>
                                                    @endif

                                                    <button type="button" class="inline-flex items-center px-3 py-1 rounded btn btn-danger btn-sm delete"
                                                        onclick="deleteLink({{ $link->id }})"
                                                        data-id="{{ $link->id }}">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted mb-0">No promotions found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4 mb-4 shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h4 class="mb-0 text-primary">
                                <i class="bi bi-info-circle me-2"></i> Understanding Your Promotions
                            </h4>
                        </div>
                        <div class="card-body text-secondary">
                            <p>This page displays all your active, paused, or completed promotional requests.</p>
                            <ul class="list-group list-group-flush mb-3 rounded">
                                <li class="list-group-item bg-light border-0 mb-1"><strong>Promotion Details:</strong> See the exact URL being promoted and the type of service requested.</li>
                                <li class="list-group-item bg-light border-0 mb-1"><strong>Required vs Delivered:</strong> Monitor your progress. 'Required' is the total amount requested, and 'Delivered' shows how many have been successfully sent so far.</li>
                                <li class="list-group-item bg-light border-0 mb-1"><strong>Status:</strong> Check if your promotion is currently <code>Running</code>, <code>Paused</code>, or <code>Deleted</code>.</li>
                                <li class="list-group-item bg-light border-0"><strong>Actions:</strong> You have full control! Use the buttons to pause a running promotion, resume a paused one, or delete it entirely if you no longer need it.</li>
                            </ul>
                            <div class="alert alert-info mb-0 border-0">
                                <strong>Tip:</strong> If a promotion seems stuck, check if your post or profile privacy settings are set to 'Public'.
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
                    url: `{{ route('autoliker.view.update') }}`,
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        id: linkId,
                        status: action
                    },
                    success: function(response) {
                        if (response.success) {
                            let statusBadge = $('.status-badge[data-id="' + linkId + '"]');
                            let actionBtn = $('.action[data-id="' + linkId + '"]');

                            statusBadge.text(action.charAt(0).toUpperCase() + action.slice(1));
                            statusBadge.removeClass('btn-info btn-warning btn-danger btn-success');

                            if (action === 'paused') {
                                actionBtn.removeClass('btn-warning').addClass('btn-success').text('Start');
                                actionBtn.attr('onclick', 'startLink(' + linkId + ')');
                                statusBadge.addClass('btn-warning');
                            } else if (action === 'running') {
                                actionBtn.removeClass('btn-success').addClass('btn-warning').text('Pause');
                                actionBtn.attr('onclick', 'pauseLink(' + linkId + ')');
                                statusBadge.addClass('btn-info');
                            } else if (action === 'deleted') {
                                statusBadge.addClass('btn-danger');
                                $('[data-row-id="' + linkId + '"]').fadeOut(200);
                            } else {
                                statusBadge.addClass('btn-success');
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
            };

            window.pauseLink = function(linkId) {
                updateStatus(linkId, 'paused');
            };

            window.deleteLink = function(linkId) {
                updateStatus(linkId, 'deleted');
            };
        });
    </script>
@endsection
