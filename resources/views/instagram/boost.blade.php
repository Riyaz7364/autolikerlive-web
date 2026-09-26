@extends('layouts.master')

@section('title', 'Boost your profile')
@section('description', 'Boost your profile - Start promotion here')

{{-- Auto ads are loaded once via layouts.master (<x-auto-ads />) --}}

@section('content')
    <main class="bg-light">
        <div class="container mt-5">

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

            <!-- Big Counter UI (prominent to reduce bounce & increase engagement) -->
            <div id="view-counter" class="mb-4">
                <style>
                    #view-counter { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:18px; border-radius:12px; background: linear-gradient(135deg,#6dd5ed 0%,#2193b0 100%); color:white; width:100%; max-width:520px; margin:6px auto 22px; box-shadow:0 8px 24px rgba(0,0,0,0.12); text-align:center; }
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
                <div class="card mt-4 mb-4 shadow border-0 overflow-hidden">
                    <style>
                        .app-promo-hero { background: linear-gradient(135deg, #0f3460 0%, #1877f2 60%, #764ba2 100%); color: #fff; padding: 1.25rem 1.25rem 1rem; }
                        .app-promo-hero h4 { color: #fff; font-weight: 800; margin: 0 0 0.25rem; }
                        .app-promo-hero p { color: rgba(255,255,255,.85); margin: 0; font-size: 0.92rem; }
                        .app-promo-row { display: flex; gap: 0.9rem; align-items: center; padding: 0.9rem 1.25rem; border-top: 1px solid #eef1f6; }
                        .app-promo-row + .app-promo-row { border-top: 1px solid #eef1f6; }
                        .app-promo-icon { width: 52px; height: 52px; border-radius: 14px; object-fit: cover; flex-shrink: 0; background: #f1f4f9; }
                        .app-promo-icon-fallback { width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0; display: grid; place-items: center; font-size: 26px; background: linear-gradient(135deg, #667eea, #764ba2); }
                        .app-promo-info { flex: 1; min-width: 0; }
                        .app-promo-name { font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap; }
                        .app-promo-ver { font-size: 0.7rem; font-weight: 700; background: #e8f0fe; color: #1877f2; padding: 0.1rem 0.45rem; border-radius: 999px; }
                        .app-promo-tag { font-size: 0.85rem; color: #65676b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
                        .app-promo-dl { flex-shrink: 0; display: inline-block; background: #2fa84f; color: #fff !important; font-weight: 700; font-size: 0.85rem; padding: 0.55rem 1rem; border-radius: 10px; text-decoration: none; }
                        .app-promo-dl:hover { background: #258a40; text-decoration: none; }
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
                            <a href="{{ route('apk.download.app', ['appName' => $promoApp->app_name]) }}" class="app-promo-dl">⬇ Download APK</a>
                        </div>
                    @endforeach
                </div>
                @endif

            <!-- Telegram community banner (inline + dismissible; never auto-pops, AdSense-safe) -->
            <div id="tg-banner" class="mb-3" style="display:none;">
                <div style="display:flex; gap:10px; align-items:center; background:#e8f4fd; border:1px solid #b6dcf7; border-radius:12px; padding:10px 12px;">
                    <span style="font-size:1.4rem;">✈️</span>
                    <div style="flex:1; font-size:0.9rem; color:#0b3d62;"><strong>Join our Telegram</strong> for updates &amp; giveaways.</div>
                    <a href="https://t.me/autolikerlive" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background:#0088cc; color:#fff; font-weight:600;">Join</a>
                    <button type="button" id="tg-dismiss" aria-label="Dismiss" style="background:none; border:0; font-size:1.1rem; cursor:pointer; color:#0b3d62;">✕</button>
                </div>
            </div>

            <div class="row">
                <h1 class="text-center text-dark">Boost Profile</h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>

                @php
                    $service = [
                        "Facebook Followers [ALL PROFILE] [Time: 3 Mint]" => [
                            "id" => 4825,
                            "node" => "fbuser",
                            "type" => "followers",
                        ],
                     
                        // "Facebook Post Reaction [ Love ❤️] [Time: 8 Mint]" => 5341,
                        // "Facebook Post Reaction [ Care 🤗] [Time: 13 Mint]" => 5342,
                        // "Facebook Post Reaction [ Haha 😂] [Time: 53 Mint]" => 5343,
                        // "Facebook Post Reaction [ Wow 😮] [Time: 11 Mint]" => 5344,
                        // "Facebook Post Reaction [ Sad 😢] [Time: NoData]" => 5345,
                        // "Facebook Post Reaction [ Angry 😡] [Time: NoData]" => 5346,
                    ];
                @endphp

                <div class="card mb-3 mainb">
                    <div class="card-body row">

                        <div class="container">
                            <form id="boostForm" action="{{ route('autoliker.boost.submit2') }}" method="post">
                                @csrf

                                <label for="service" class="form-label">Reaction Type (Facebook):</label>
                                <select id="service" name="type" class="form-select">
                                    <option value="" disabled selected>Select a reaction type</option>
                                    @foreach ($service as $name => $details)
                                        <option value="{{ $details['id'] }}" data-cost="10" data-type="{{ $details['type'] }}" data-node="{{ $details['node'] }}">{{ $name }}</option>
                                    @endforeach
                                </select>

                                <input type="hidden" id="service_type" name="service_type" value="">
                                <input type="hidden" id="service_node" name="service_node" value="">

                                <div id="inputs" class="mt-3">
                                    <label class="form-label">Number of Quantity (fixed):</label>
                                    <div class="mb-2"><strong>10</strong></div>
                                    <p class="small text-muted">Average: 10 Quantity in 10 minutes</p>
                                </div>

                                <div id="linkInput" class="my-2">
                                    <label for="link" class="form-label">Enter Post Link:</label>
                                    <input type="text" id="link" name="link" class="form-control" placeholder="https://www.facebook.com/yourpost" required>
                                    <div id="linkExample" class="form-text"></div>
                                </div>

                                <!-- Temp Mail Center -->
                                    <ins class="adsbygoogle"
                                        style="display:block"
                                        data-ad-client="ca-pub-8426510303593933"
                                        data-ad-slot="5208281991"
                                        data-ad-format="auto"
                                        data-full-width-responsive="true"></ins>
                                    <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                    </script>


                                <div class="cf-turnstile mb-2" data-sitekey="0x4AAAAAABUvrkxDbOApMo7H"></div>

                                <p class="fw-bold">After submission you must wait 10 minutes before submitting again.</p>
                                <div id="countdown" class="btn btn-outline-info mb-3" style="font-size:1.2rem;">Ready</div>
                                <br>

                                <button id="submitBtn" type="submit" class="btn btn-primary w-100 mb-3">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <span class="btn-text text-white">Send Reaction</span>
                                </button>
                                <!-- (250x250 ad moved above counter for better visibility) -->
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Back-to-back repeat modal: same link can't be submitted twice in a row -->
                <div id="repeatModal" style="display:none; position:fixed; inset:0; z-index:2000; align-items:center; justify-content:center; padding:18px; background:rgba(10,25,47,.65);">
                    <style>
                        #repeatModal .repeat-card { background:#fff; border-radius:18px; max-width:440px; width:100%; padding:26px 22px 22px; text-align:center; box-shadow:0 24px 60px rgba(0,0,0,.35); position:relative; }
                        #repeatModal .repeat-icon { width:58px; height:58px; margin:0 auto 12px; border-radius:50%; display:grid; place-items:center; font-size:28px; background:#fff4e0; }
                        #repeatModal h4 { font-weight:800; font-size:19px; margin-bottom:8px; color:#1c1e21; }
                        #repeatModal .repeat-ok { display:inline-block; font-size:12px; font-weight:700; color:#2fa84f; background:#e9f8ee; border-radius:999px; padding:4px 12px; margin-bottom:12px; }
                        #repeatModal p { font-size:14px; color:#4b4f56; margin-bottom:10px; }
                        #repeatModal .repeat-share { display:flex; gap:10px; margin-top:14px; }
                        #repeatModal .repeat-btn { flex:1; border:0; border-radius:12px; padding:13px 10px; font-size:15px; font-weight:700; cursor:pointer; }
                        #repeatModal .repeat-btn-share { background:linear-gradient(120deg,#1877f2,#0d65d9); color:#fff; }
                        #repeatModal .repeat-btn-ok { background:#f0f2f5; color:#1c1e21; }
                    </style>
                    <div class="repeat-card" role="dialog" aria-modal="true" aria-labelledby="repeatModalTitle">
                        <div class="repeat-icon">⏳</div>
                        <h4 id="repeatModalTitle">Please wait your turn</h4>
                        <span class="repeat-ok">✔ This is not an error</span>
                        <p>This exact link was just submitted and is still the <strong>latest one in the queue</strong>.</p>
                        <p>Fair-use rule: the same link <strong>can't be added twice in a row</strong>. You can submit this link again <strong>after someone else adds their link</strong>.</p>
                        <p>💡 <strong>Tip:</strong> share this app with friends — more people joining means your turn comes faster.</p>
                        <div class="repeat-share">
                            <button type="button" id="repeatShareBtn" class="repeat-btn repeat-btn-share">📤 Share this app</button>
                            <button type="button" id="repeatOkBtn" class="repeat-btn repeat-btn-ok">Got it</button>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 mb-4 shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4 class="mb-0 text-primary"><i class="bi bi-info-circle me-2"></i> How to Use the Boost Feature</h4>
                    </div>
                    <div class="card-body text-secondary">
                        <p>Welcome to the Boost Profile page! Here, you can send reactions directly to your Facebook posts.</p>
                        <ul class="list-group list-group-flush mb-3 rounded">
                            <li class="list-group-item bg-light border-0 mb-1"><strong>Reaction Type:</strong> Choose the type of reaction you want (Like, Love, Care, Haha, Wow, Sad, Angry). Each reaction type takes a different amount of time to process.</li>
                            <li class="list-group-item bg-light border-0 mb-1"><strong>Quantity:</strong> Currently, the system sends a fixed amount of 10 likes per submission to ensure a steady and safe delivery.</li>
                            <li class="list-group-item bg-light border-0 mb-1"><strong>Post Link:</strong> Paste the full URL of your public Facebook post (e.g., <code>https://www.facebook.com/yourpost</code>). Ensure the post privacy is set to Public so the system can access it.</li>
                            <li class="list-group-item bg-light border-0"><strong>Cooldown Timer:</strong> After successfully submitting a request, you must wait 10 minutes before you can submit another one. The timer will indicate when you are ready again.</li>
                        </ul>
                        <div class="alert alert-info mb-0 border-0">
                            <strong>Note:</strong> Make sure your account and post are set to public before submitting, otherwise the promotion will fail to start.
                        </div>
                    </div>
                </div>

                <!-- Below-content responsive ad (high viewability, clear of CTA buttons) -->
                <div class="text-center my-4">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-8426510303593933"
                         data-ad-slot="5208281991"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
        </div>
    </main>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let userCredits = {{ $user['credits'] }}; // Example credit balance
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
                $('#link').val('https://www.facebook.com/{{ $user['username'] }}');
                $('#link').attr('placeholder', 'https://www.facebook.com/{{ $user['username'] }}');
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

        // ---- Fair-queue: same link can't be submitted twice in a row ----
        var lastBoostLink = @json($lastBoostLink ?? null);
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
            // Instant check: same link as the latest in the queue -> stop, show modal
            var current = normalizeBoostLink($('#link').val());
            if (current && lastBoostLink && current === normalizeBoostLink(lastBoostLink)) {
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
