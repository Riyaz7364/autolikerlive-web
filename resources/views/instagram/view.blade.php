@extends('layouts.autoliker')

@section('title', 'View promotions')
@section('description', 'Boost your profile - Start promotion here')

{{-- Auto ads are loaded via layouts.autoliker (top + anchor units) --}}

@section('content')
    <h1 class="alk-page-title">My Orders</h1>

    <section class="alk-card" aria-label="Your promotions">
        <div class="alk-card-title"><i class="bi bi-list-check"></i> Promotions</div>

        @forelse ($links as $link)
            @php
                $loginType = data_get($user, 'loginType', data_get($user, 'login_type'));
                $baseUrl = $loginType === 'IG' ? 'https://www.instagram.com/' : 'https://www.facebook.com/';

                if ($loginType === 'IG') {
                    switch ($link->service) {
                        case 'reels_likes':
                            $baseUrl .= 'reels/';
                            break;
                        case 'likes':
                            $baseUrl .= 'p/';
                            break;
                    }
                }

                $promoUrl = $baseUrl . ltrim($link->link, '/');

                switch ($link->status) {
                    case 'paused':
                        $status_class = 'is-paused';
                        $status_label = 'Paused';
                        break;
                    case 'running':
                        $status_class = 'is-running';
                        $status_label = 'Running';
                        break;
                    case 'deleted':
                        $status_class = 'is-deleted';
                        $status_label = 'Deleted';
                        break;
                    default:
                        $status_class = 'is-done';
                        $status_label = ucfirst($link->status);
                        break;
                }
            @endphp
            {{-- Card layout on mobile, table row look on desktop via the same hooks the JS uses --}}
            <article class="alk-promo" data-row-id="{{ $link->id }}">
                <div class="alk-promo-top">
                    <span class="alk-promo-id">#{{ $link->id }}</span>
                    <span class="alk-promo-service">{{ $link->service }}</span>
                </div>
                <div class="alk-promo-url">
                    <a href="{{ $promoUrl }}" target="_blank" rel="noopener noreferrer">{{ $promoUrl }} ↗</a>
                </div>
                <div class="alk-promo-meta">
                    <span>Required<br><b>{{ $link->limit }}</b></span>
                    <span>Delivered<br><b>{{ $link->count }}</b></span>
                </div>
                <div class="alk-promo-foot">
                    <span class="alk-status status-badge {{ $status_class }}" data-id="{{ $link->id }}">{{ $status_label }}</span>
                    <span style="flex:1;"></span>
                    @if ($link->status == 'paused')
                        <button type="button" class="alk-mini-btn is-start action"
                            onclick="startLink({{ $link->id }})"
                            data-id="{{ $link->id }}">Start</button>
                    @else
                        <button type="button" class="alk-mini-btn is-pause action"
                            onclick="pauseLink({{ $link->id }})"
                            data-id="{{ $link->id }}">Pause</button>
                    @endif
                    <button type="button" class="alk-mini-btn is-delete delete"
                        onclick="deleteLink({{ $link->id }})"
                        data-id="{{ $link->id }}">Delete</button>
                </div>
            </article>
        @empty
            <div class="alk-empty">
                <span class="alk-empty-icon">📭</span>
                <strong>No promotions yet.</strong><br>
                Boost your profile to see live orders here.
                <div class="mt-3">
                    <a href="{{ route('autoliker.boost') }}" class="alk-btn alk-btn-primary" style="width:auto; padding-left:34px; padding-right:34px;">Boost now</a>
                </div>
            </div>
        @endforelse
    </section>

    <div class="alk-ad" aria-label="Advertisement">
        <x-ads.in-article />
    </div>

    <section class="alk-card" aria-label="Understanding your promotions">
        <div class="alk-card-title"><i class="bi bi-info-circle"></i> Understanding your orders</div>
        <ol class="alk-steps">
            <li><div><strong>Required vs delivered</strong> — how many you asked for vs how many arrived so far.</div></li>
            <li><div><strong>Status</strong> — Running, Paused or Deleted. You control each order.</div></li>
            <li><div><strong>Stuck order?</strong> Make sure the post or profile is set to Public.</div></li>
        </ol>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            function statusClass(action) {
                if (action === 'paused') return 'is-paused';
                if (action === 'running') return 'is-running';
                if (action === 'deleted') return 'is-deleted';
                return 'is-done';
            }

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
                            statusBadge.removeClass('is-running is-paused is-deleted is-done');
                            statusBadge.addClass(statusClass(action));

                            if (action === 'paused') {
                                actionBtn.removeClass('is-pause').addClass('is-start').text('Start');
                                actionBtn.attr('onclick', 'startLink(' + linkId + ')');
                            } else if (action === 'running') {
                                actionBtn.removeClass('is-start').addClass('is-pause').text('Pause');
                                actionBtn.attr('onclick', 'pauseLink(' + linkId + ')');
                            } else if (action === 'deleted') {
                                $('[data-row-id="' + linkId + '"]').fadeOut(200);
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
