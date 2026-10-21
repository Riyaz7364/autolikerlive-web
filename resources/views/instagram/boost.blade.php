@extends('layouts.autoliker')

@section('title', 'Boost your profile')
@section('description', 'Boost your profile - Start promotion here')

@section('content')

    @php
        $viewsFile = storage_path('app/boost_views.json');
        $views = 0;
        if (file_exists($viewsFile)) {
            $json = @file_get_contents($viewsFile);
            $data = @json_decode($json, true) ?: ['count' => 0];
            $views = isset($data['count']) ? (int)$data['count'] : 0;
        }
        $views++;
        @file_put_contents($viewsFile, json_encode(['count' => $views]));
    @endphp

    <h1 class="alk-page-title">Boost Profile</h1>

    <!-- Big Counter UI (prominent to reduce bounce & increase engagement) -->
    <div id="view-counter" class="mb-4">
        <style>
            #view-counter { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:18px; border-radius:16px; background: linear-gradient(135deg,#6dd5ed 0%,#2193b0 100%); color:white; width:100%; margin:0 auto 14px; box-shadow:0 8px 24px rgba(0,0,0,0.12); text-align:center; }
            #counter-number { font-size:3.75rem; font-weight:800; line-height:1; letter-spacing:-1px; }
            #counter-label { font-size:1rem; opacity:0.95; margin-top:6px; }
            @media (max-width:420px) { #counter-number { font-size:2.6rem; } }
        </style>
        <div id="counter-number">{{ $views }}</div>
        <div id="counter-label">Total Page Views</div>
    </div>

        @php
            try {
                $promoApps = \App\Models\AppRelease::where('is_active', true)->orderBy('id')->get();
            } catch (\Throwable $e) {
                $promoApps = collect();
            }
        @endphp
        @if ($promoApps->count())
        <div class="alk-card" style="padding:0; overflow:hidden;">
            <style>
                .app-promo-hero { background: linear-gradient(135deg, #0f3460 0%, #1877f2 60%, #764ba2 100%); color: #fff; padding: 1.1rem 1.1rem .9rem; }
                .app-promo-hero h4 { color: #fff; font-weight: 800; margin: 0 0 0.25rem; font-size: 1.05rem; }
                .app-promo-hero p { color: rgba(255,255,255,.85); margin: 0; font-size: 0.88rem; }
                .app-promo-row { display: flex; gap: 0.75rem; align-items: center; padding: 0.85rem 1rem; border-top: 1px solid #eef1f6; }
                .app-promo-icon { width: 52px; height: 52px; border-radius: 14px; object-fit: cover; flex-shrink: 0; background: #f1f4f9; }
                .app-promo-icon-fallback { width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0; display: grid; place-items: center; font-size: 26px; background: linear-gradient(135deg, #667eea, #764ba2); }
                .app-promo-info { flex: 1; min-width: 0; }
                .app-promo-name { font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap; font-size: .95rem; }
                .app-promo-ver { font-size: 0.7rem; font-weight: 700; background: #e8f0fe; color: #1877f2; padding: 0.1rem 0.45rem; border-radius: 999px; }
                .app-promo-tag { font-size: 0.82rem; color: #65676b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
                .app-promo-dl { flex-shrink: 0; display: inline-block; background: #2fa84f; color: #fff !important; font-weight: 700; font-size: 0.85rem; padding: 0.65rem .9rem; border-radius: 10px; text-decoration: none; min-height: 44px; }
                .app-promo-dl:hover { background: #258a40; text-decoration: none; }
                @media (max-width:420px) { .app-promo-tag { display:none; } }
            </style>
            <div class="app-promo-hero">
                <h4>📱 Get our free apps — boost faster on mobile</h4>
                <p>Official AutoLikerLive Android apps. Free download, no Play Store needed.</p>
            </div>
            @foreach ($promoApps as $promoApp)
                <div class="app-promo-row">
                    @if ($promoApp->icon_url)
                        <img src="{{ $promoApp->icon_url }}" alt="{{ $promoApp->name }} app icon" class="app-promo-icon" loading="lazy" width="52" height="52">
                    @else
                        <span class="app-promo-icon-fallback">📱</span>
                    @endif
                    <div class="app-promo-info">
                        <div class="app-promo-name">{{ $promoApp->name }} <span class="app-promo-ver">v{{ $promoApp->version }}</span></div>
                        @if ($promoApp->tagline)
                            <div class="app-promo-tag">{{ $promoApp->tagline }}</div>
                        @endif
                    </div>
                    <a href="{{ route('apk.download.app', ['appName' => $promoApp->app_name]) }}" class="app-promo-dl">⬇ APK</a>
                </div>
            @endforeach
        </div>
        @endif

    <!-- Telegram community banner (inline + dismissible; never auto-pops, AdSense-safe) -->
    <div id="tg-banner" class="mb-3" style="display:none;">
        <div style="display:flex; gap:10px; align-items:center; background:#e8f4fd; border:1px solid #b6dcf7; border-radius:12px; padding:10px 12px;">
            <span style="font-size:1.4rem;">✈️</span>
            <div style="flex:1; font-size:0.9rem; color:#0b3d62;"><strong>Join our Telegram</strong> for updates &amp; giveaways.</div>
            <a href="https://t.me/autolikerlive" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background:#0088cc; color:#fff; font-weight:600; min-height:44px; display:inline-flex; align-items:center;">Join</a>
            <button type="button" id="tg-dismiss" aria-label="Dismiss" style="background:none; border:0; font-size:1.1rem; cursor:pointer; color:#0b3d62; min-width:44px; min-height:44px;">✕</button>
        </div>
    </div>

        @php
            $service = [
                "Facebook Followers [ALL PROFILE] [Time: 3 Mint]" => [
                    "id" => 4825,
                    "node" => "fbuser",
                    "type" => "followers",
                ],
            ];
        @endphp

        <section class="alk-card" aria-label="Boost form">
            <div class="alk-card-title"><i class="bi bi-rocket-takeoff-fill"></i> New boost</div>
            <div class="container" style="padding:0;">
                <form id="boostForm" action="{{ route('autoliker.boost.submit2') }}" method="post">
                    @csrf

                    <label for="service" class="alk-form-label">Reaction Type (Facebook):</label>
                    <select id="service" name="type" class="alk-select">
                        <option value="" disabled selected>Select a reaction type</option>
                        @foreach ($service as $name => $details)
                            <option value="{{ $details['id'] }}" data-cost="10" data-type="{{ $details['type'] }}" data-node="{{ $details['node'] }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    <input type="hidden" id="service_type" name="service_type" value="">
                    <input type="hidden" id="service_node" name="service_node" value="">

                    <div id="inputs" class="mt-3">
                        <label class="alk-form-label">Quantity (fixed): <strong>10</strong></label>
                        <p class="alk-hint" style="margin-top:0;">Average: 10 Quantity in 10 minutes</p>
                    </div>

                    <div id="linkInput" class="my-2">
                        <label for="link" class="alk-form-label">Enter Post Link:</label>
                        <input type="text" id="link" name="link" class="alk-input" placeholder="https://www.facebook.com/yourpost" required
                            inputmode="url" autocomplete="off">
                        <div id="linkExample" class="alk-hint"></div>
                    </div>

                    <div class="alk-turnstile">
                        <div class="cf-turnstile" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>
                    </div>

                    <p class="fw-bold" style="font-size:14px;">After submission you must wait 10 minutes before submitting again.</p>
                    <div class="mb-3"><span id="countdown" class="alk-countdown">Ready</span></div>

                    <button id="submitBtn" type="submit" class="alk-btn alk-btn-primary mb-2">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="btn-text text-white">Send Follow</span>
                    </button>
                </form>
            </div>
        </section>


        <!-- Back-to-back repeat modal: same link can't be submitted twice in a row -->
        <div id="repeatModal" style="display:none; position:fixed; inset:0; z-index:2000; align-items:center; justify-content:center; padding:18px; background:rgba(10,25,47,.65);">
            <style>
                #repeatModal .repeat-card { background:#fff; border-radius:18px; max-width:440px; width:100%; padding:26px 22px 22px; text-align:center; box-shadow:0 24px 60px rgba(0,0,0,.35); position:relative; }
                #repeatModal .repeat-icon { width:58px; height:58px; margin:0 auto 12px; border-radius:50%; display:grid; place-items:center; font-size:28px; background:#fff4e0; }
                #repeatModal h4 { font-weight:800; font-size:19px; margin-bottom:8px; color:#1c1e21; }
                #repeatModal .repeat-ok { display:inline-block; font-size:12px; font-weight:700; color:#2fa84f; background:#e9f8ee; border-radius:999px; padding:4px 12px; margin-bottom:12px; }
                #repeatModal p { font-size:14px; color:#4b4f56; margin-bottom:10px; }
                #repeatModal .repeat-share { display:flex; gap:10px; margin-top:14px; }
                #repeatModal .repeat-btn { flex:1; border:0; border-radius:12px; padding:13px 10px; font-size:15px; font-weight:700; cursor:pointer; min-height:52px; }
                #repeatModal .repeat-btn-share { background:linear-gradient(120deg,#1877f2,#0d65d9); color:#fff; }
                #repeatModal .repeat-btn-ok { background:#f0f2f5; color:#1c1e21; }
            </style>
            <div class="repeat-card" role="dialog" aria-modal="true" aria-labelledby="repeatModalTitle">
                <div class="repeat-icon">⏳</div>
                <h4 id="repeatModalTitle">Please wait your turn</h4>
                <span class="repeat-ok">✔ This is not an error</span>
                <p>This exact link was just submitted and is still the <strong>latest one in the queue</strong>.</p>
                <p>Fair-use rule: the same link <strong>can't be added twice in a row for the same service</strong>. You can submit this link again <strong>after someone else adds their link</strong>.</p>
                <p>💡 <strong>Tip:</strong> share this app with friends — more people joining means your turn comes faster.</p>
                <div class="repeat-share">
                    <button type="button" id="repeatShareBtn" class="repeat-btn repeat-btn-share">📤 Share this app</button>
                    <button type="button" id="repeatOkBtn" class="repeat-btn repeat-btn-ok">Got it</button>
                </div>
            </div>
        </div>

        <section class="alk-card" aria-label="How to use the boost feature">
            <div class="alk-card-title"><i class="bi bi-info-circle"></i> How boosting works</div>
            <ol class="alk-steps">
                <li><div><strong>Reaction type:</strong> choose what to send (Like, Love, Haha, Wow…). Each takes a different time to process.</div></li>
                <li><div><strong>Quantity:</strong> fixed at 10 per submission for steady, safe delivery.</div></li>
                <li><div><strong>Post link:</strong> paste the full URL of a <strong>Public</strong> Facebook post.</div></li>
                <li><div><strong>Cooldown:</strong> wait 10 minutes between submissions — the timer above shows when you're ready.</div></li>
            </ol>
        </section>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let userCredits = {{ data_get($user, 'credits', 0) }}; // Example credit balance
        let timeLeft = {{ $timeLeft ?? 0 }};

        function updateForm() {
            let service = $('#service').val();
            let selectedType = $('#service').find(':selected').data('type');
            let selectedNode = $('#service').find(':selected').data('node');
            let num = parseInt($('#number').val()) || 1;
            let costPerUnit = $('#service').find(':selected').data('cost');
            let totalCost = num * costPerUnit;

            $('#selected_service_id').val(service || '');
            $('#service_type').val(selectedType || '');
            $('#service_node').val(selectedNode || '');

            $('#totalCost').text(totalCost);
            $('#inputs label').text('Quantity (fixed):');

            if (selectedNode === 'fbuser') {
                $('#link').val('https://www.facebook.com/{{ data_get($user, 'username') }}');
                $('#link').attr('placeholder', 'https://www.facebook.com/{{ data_get($user, 'username') }}');
                $('#link').prop('readonly', true);
                $('#linkInput label').text('Your Facebook Profile Link:');
                $('#linkExample').text('This service boosts your own Facebook profile. The profile link is fixed to your login username.');
            } else if (selectedNode === 'fbpost') {
                $('#link').val('');
                $('#link').attr('placeholder', 'https://www.facebook.com/yourpost');
                $('#link').prop('readonly', false);
                $('#linkInput label').text('Enter Post Link:');
                $('#linkExample').text('Enter the full URL of the Facebook post you want to boost. Example: https://www.facebook.com/yourpost');
            } else {
                $('#link').prop('readonly', false);
                $('#linkInput label').text('Enter Post Link:');
                $('#linkExample').text('');
            }

            let isTimerRunning = timeLeft > 0;
            $('#submitBtn').prop('disabled', totalCost > userCredits || isTimerRunning);
            $('#creditWarning').toggle(totalCost > userCredits);
            // Button label follows the selected service type (skip while submitting).
            var btnText = $('#submitBtn').find('.btn-text');
            if (btnText.length && !$('#submitBtn').find('.spinner-border:not(.d-none)').length) {
                btnText.text(selectedType === 'followers' ? 'Send Follow' : 'Send Reaction');
            }
        }

        $('#service, #number').on('input change', updateForm);
        $(document).ready(updateForm);

        function updateTimer() {
            let countdownEl = document.getElementById('countdown');
            if (timeLeft <= 0) {
                if (countdownEl) countdownEl.innerHTML = 'Ready';
                updateForm(); // Enables the button based on cost checking
            } else {
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                let formattedTime = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
                if (countdownEl) countdownEl.innerHTML = formattedTime;
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }
        updateTimer();

        // ---- Fair-queue per service type: same link can't go twice in a row ----
        var lastBoostLinksByType = @json($lastBoostLinksByType ?? []);
        var repeatBlockedFromServer = @json(session('boost_repeat_blocked', false));

        function normalizeBoostLink(u) {
            u = (u || '').trim();
            if (!u) return '';
            var h = u.indexOf('#');
            if (h !== -1) u = u.slice(0, h);
            try {
                var p = new URL(u, window.location.origin);
                var host = p.protocol + '//' + p.hostname.toLowerCase();
                var port = p.port;
                if (port && !((p.protocol === 'http:' && port === '80') || (p.protocol === 'https:' && port === '443'))) {
                    host += ':' + port;
                }
                return (host + p.pathname + p.search).replace(/\/+$/, '');
            } catch (e) {
                return u.replace(/\/+$/, '');
            }
        }

        function openRepeatModal() {
            var m = document.getElementById('repeatModal');
            if (m) { m.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
        }
        function closeRepeatModal() {
            var m = document.getElementById('repeatModal');
            if (m) { m.style.display = 'none'; document.body.style.overflow = ''; }
        }

        function shareBoostApp() {
            var data = {
                title: document.title,
                text: 'Boost your Facebook profile free — join me here:',
                url: window.location.href
            };
            if (navigator.share) {
                navigator.share(data).catch(function () {});
            } else if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(data.url).then(function () {
                    alert('Link copied! Share it with your friends.');
                }).catch(function () {
                    prompt('Copy and share this link:', data.url);
                });
            } else {
                prompt('Copy and share this link:', data.url);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var ok = document.getElementById('repeatOkBtn');
            if (ok) ok.addEventListener('click', closeRepeatModal);
            var share = document.getElementById('repeatShareBtn');
            if (share) share.addEventListener('click', shareBoostApp);
            var modal = document.getElementById('repeatModal');
            if (modal) modal.addEventListener('click', function (e) {
                if (e.target === modal) closeRepeatModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeRepeatModal();
            });
            // Server blocked the repeat (redirect back) -> show modal, not just a toast
            if (repeatBlockedFromServer) openRepeatModal();
        });

        $('#boostForm').on('submit', function(e) {
            // Instant check: same link as the latest in the queue FOR THIS TYPE -> stop, show modal
            var selType = $('#service').find(':selected').data('type') || '';
            var lastForType = lastBoostLinksByType[selType] || null;
            var current = normalizeBoostLink($('#link').val());
            if (current && lastForType && current === normalizeBoostLink(lastForType)) {
                e.preventDefault();
                openRepeatModal();
                return false;
            }
            let btn = $('#submitBtn');
            btn.prop('disabled', true);
            btn.find('.spinner-border').removeClass('d-none');
            btn.find('.btn-text').text('Submitting...');
        });

        // Telegram banner: inline only, shown on load unless dismissed (no auto-popup)
        (function(){
            var key = 'tg_banner_dismissed_v1';
            document.addEventListener('DOMContentLoaded', function(){
                var banner = document.getElementById('tg-banner');
                if (!banner) return;
                try { if (localStorage.getItem(key)) return; } catch (e) {}
                banner.style.display = 'block';
                var dismiss = document.getElementById('tg-dismiss');
                if (dismiss) dismiss.addEventListener('click', function(){
                    banner.style.display = 'none';
                    try { localStorage.setItem(key, Date.now()); } catch (e) {}
                });
            });
        })();
    </script>
@endsection
