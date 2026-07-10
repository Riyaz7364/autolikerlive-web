@extends('layouts.master')

@section('title', 'Boost your profile')
@section('description', 'Boost your profile - Start promotion here')

@section('javascripts')
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
     crossorigin="anonymous"></script>
@endsection

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

            <!-- Moved larger square ad up for better above-the-fold visibility -->
            <div class="text-center mb-3">
                <ins class="adsbygoogle"
                    style="display:inline-block;width:250px;height:250px"
                    data-ad-client="ca-pub-8426510303593933"
                    data-ad-slot="7719729414"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

            <!-- Promo Modal (auto show with countdown; localStorage prevents repeats) -->
            <div id="promo-modal-root" class="hidden" aria-hidden="true">
                <style>
                    .promo-modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.45); display:flex; align-items:center; justify-content:center; z-index:9999; animation: fadeInBackdrop 320ms ease; }
                    .promo-modal { background:white; width:100%; max-width:520px; border-radius:12px; padding:20px; box-shadow:0 12px 40px rgba(0,0,0,0.3); text-align:center; font-family:inherit; transform:translateY(12px); animation: slideUp 360ms cubic-bezier(.2,.9,.3,1); }
                    @keyframes slideUp { from { opacity:0; transform:translateY(18px) scale(.99); } to { opacity:1; transform:translateY(0) scale(1); } }
                    @keyframes fadeInBackdrop { from { opacity:0 } to { opacity:1 } }
                    .promo-title { font-size:1.25rem; font-weight:700; margin-bottom:8px; }
                    .promo-body { margin:12px 0; color:#333; }
                    .promo-cta { display:flex; gap:10px; justify-content:center; margin-top:14px; flex-wrap:wrap; }
                    .promo-button { padding:10px 16px; border-radius:8px; border:0; cursor:pointer; font-weight:600; }
                    .promo-join { background:#0088cc; color:white; }
                    .promo-close { background:#eee; color:#222; }
                    .hidden { display:none !important; }
                    .small-muted { color:#666; font-size:0.9rem; margin-top:8px; }
                </style>

                <div class="promo-modal-backdrop" role="dialog" aria-modal="true" aria-label="Promotion">
                    <div class="promo-modal" role="document">
                        <div class="promo-title">Support this site — join our Telegram</div>
                        <div class="promo-body">We'll show helpful updates and giveaways in the group.<br>Join to stay connected and support our work.</div>
                        <div style="font-size:1.1rem; margin-top:6px;">Auto close in <strong id="promo-countdown">8</strong> seconds</div>
                        <div class="promo-cta">
                            <a id="promo-join" class="promo-button promo-join" href="https://t.me/autolikerlive" target="_blank" rel="noopener noreferrer">Join Telegram</a>
                            <button id="promo-close" class="promo-button promo-close" disabled>Close</button>
                        </div>
                        <div class="small-muted">Thanks — your visit helps us keep the site running.</div>
                    </div>
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
                        "Facebook Post Reaction [ Like 👍] [Time: 21 Mint]" => [
                            "id" => 3758,
                            "node" => "fbpost",
                            "type" => "reactions",
                        ],
                        "Facebook Post Reaction [ WOW 😮] [Time: 10 Mint]" => [
                            "id" => 164,
                            "node" => "fbpost",
                            "type" => "reactions",
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
                                <!-- Near Clock -->
                                <div style="max-height:100px;overflow:hidden;display:inline-block;">
                                    <ins class="adsbygoogle"
                                        style="display:inline-block;width:300px;height:100px;max-height:100px;"
                                        data-ad-client="ca-pub-8426510303593933"
                                        data-ad-slot="9426615212"></ins>
                                </div>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
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

        $('#boostForm').on('submit', function() {
            let btn = $('#submitBtn');
            btn.prop('disabled', true);
            btn.find('.spinner-border').removeClass('d-none');
            btn.find('.btn-text').text('Submitting...');
        });

        // Promo modal behavior: auto-show with countdown and localStorage suppression
        (function(){
            var modalDelayMs = 6000; // show after 6s to increase chance user engages with content first
            var countdownStart = 12; // give slightly longer countdown to encourage click-through
            var enableCloseAfter = 4; // allow users to close after this many seconds
            var modalShownKey = 'promo_modal_shown_v1';

            function showModal(){
                var root = document.getElementById('promo-modal-root');
                if(!root) return;
                root.classList.remove('hidden'); root.setAttribute('aria-hidden','false');
            }
            function hideModal(){
                var root = document.getElementById('promo-modal-root');
                if(!root) return;
                root.classList.add('hidden'); root.setAttribute('aria-hidden','true');
                try{ localStorage.setItem(modalShownKey, Date.now()); }catch(e){}
            }

            document.addEventListener('DOMContentLoaded', function(){
                try{ if(localStorage.getItem(modalShownKey)) return; }catch(e){}
                setTimeout(function(){
                    showModal();
                    var remaining = countdownStart;
                    var countdownEl = document.getElementById('promo-countdown');
                    var closeBtn = document.getElementById('promo-close');
                    var joinBtn = document.getElementById('promo-join');
                    if(countdownEl) countdownEl.textContent = remaining;

                    // Enable close after a short grace period so user can dismiss if they prefer
                    if(closeBtn) closeBtn.disabled = true;
                    setTimeout(function(){ if(closeBtn) closeBtn.disabled = false; }, enableCloseAfter * 1000);

                    var t = setInterval(function(){
                        remaining--; if(countdownEl) countdownEl.textContent = remaining;
                        if(remaining <= 0){ clearInterval(t); if(countdownEl) countdownEl.textContent = 0; }
                    },1000);

                    if(closeBtn) closeBtn.addEventListener('click', hideModal);
                    if(joinBtn) joinBtn.addEventListener('click', function(){ try{ localStorage.setItem(modalShownKey, Date.now()); }catch(e){} setTimeout(hideModal, 800); });
                }, modalDelayMs);
            });
        })();
    </script>
@endsection
