<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RajeLiker - Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .header {
            background: #4267B2;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header h1 {
            font-size: 20px;
            font-weight: 600;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .welcome-section {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 2px;
        }

        .welcome-section.success {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-info {
            background: white;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #eee;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #4267B2;
        }

        .user-details h3 {
            color: #333;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .user-details p {
            color: #666;
            font-size: 14px;
            margin: 2px 0;
        }

        .pro-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .liker-panel {
            background: white;
            margin: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .panel-header {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .panel-header h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .panel-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .form-section {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .url-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }

        .url-input:focus {
            outline: none;
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.2);
        }

        .url-input::placeholder {
            color: #999;
        }

        .reaction-options {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 25px;
        }

        .reaction-item {
            background: white;
            border: 2px solid #e0e0e0;
            padding: 10px 5px;
            border-radius: 10px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
            font-size: 20px;
            position: relative;
        }

        .reaction-item.selected {
            border-color: #4CAF50;
            background: rgba(76, 175, 80, 0.1);
            transform: scale(1.05);
        }

        .reaction-item:hover {
            border-color: #4CAF50;
            transform: scale(1.02);
        }

        .reaction-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            font-weight: 600;
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #FF6B35, #F7931E);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .stats-section {
            background: white;
            margin: 20px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .stats-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #333;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .stat-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .loading i {
            font-size: 2em;
            margin-bottom: 10px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
            animation: slideIn 0.5s ease-out;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #dc3545;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .note {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-size: 14px;
            border-left: 4px solid #ffc107;
        }
        .info {
            background: #0085ad;
            color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-size: 14px;
            border-left: 4px solid #ffc107;
        }

        .recent-activity {
            background: white;
            margin: 20px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-text {
            color: #333;
            font-size: 14px;
        }

        .activity-time {
            color: #666;
            font-size: 12px;
        }

        .floating-action {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 4px 20px rgba(76, 175, 80, 0.4);
            cursor: pointer;
            transition: all 0.3s;
        }

        .floating-action:hover {
            transform: scale(1.1);
        }
        .row {
            display: flex;
            justify-content: space-between; /* adds space between items */
            padding: 10px;
        }
          .item {
            flex: 1; /* optional: makes items take equal width */
            margin: 0 10px; /* optional: adds margin between items */
            align-content: center;
        }

        /* SHow Model */
          /* Overlay background */
            .modal-overlay {
                display: none; /* hidden by default */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1000;
            }

            /* Modal box */
            .modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                padding: 20px 30px;
                border-radius: 8px;
                min-width: 300px;
                max-width: 90%;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 1001;
            }
/* Close button */
.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}
/* Header */
.modal-header {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 15px;
}

/* Body */
.modal-body {
  margin-bottom: 20px;
  font-size: 16px;
}

/* Timer & Credits */
.timer {
  font-size: 28px;
  font-weight: bold;
  color: #333;
  margin-bottom: 10px;
}

.credits-info {
  font-size: 16px;
  color: #555;
  margin-bottom: 20px;
}

/* Buttons */
button {
  padding: 10px 18px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s ease;
}

.btn-primary {
  background-color: #4CAF50;
  color: white;
}


.btn-primary:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.btn-gold {
  background-color: #dfaf2b;
  color: white;
}

    </style>
</head>

<body>
<!-- Modal structure -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <span class="close-btn" id="closeModalBtn">&times;</span>
    <div class="modal-header">Store Credits</div>
    <div class="modal-body">
      <div class="timer countdown" data-timer="{{ $credits['remainingTime'] }}">00:10</div>
      <div class="credits-info" id="creditsInfo">
        Total Credits: <span id="totalCredits">{{ $credits['storage'] }}</span> / <span id="maxCredits">{{ $credits['limit'] }}</span>
      </div>
      <form action="{{ route('app.autoliker.saveCredits') }}" method="POST">
        @csrf
        <button type="submit" id="storeCreditsBtn" class="btn-primary">Store Credits</button>
      </form>
      <p style="margin-top:10px; font-size:12px; color:#888;">Note: Timer converts to credits when ready.</p>
    </div>
  </div>
</div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img width="32px" src="{{ url('images/rajeliker_app_logo.webp') }}" alt="raje liker app logo">
                <h1>
                    RajeLiker</h1>
            </div>

            <button class="logout-btn" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section success">
            <div><i class="fas fa-check-circle"></i> Login Successful</div>
            <div style="margin-top: 5px; font-size: 16px;">Welcome back!</div>
        </div>

        <!-- User Info -->
        <div class="user-info">
            <img id="userAvatar" class="user-avatar" src="{{ $user['avatar'] ?? '/assets/default-avatar.png' }}"
                alt="User Avatar">
            <div class="user-details">
                <h3>{{ $user['name'] }}</h3>
                <p><i class="fas fa-envelope"></i> {{ $user['email'] ?? 'No email provided' }}</p>
                <p><span class="pro-badge"><i class="fas fa-crown"></i> AutoLiker Pro</span></p>
            </div>
        </div>

        <div class="info row">
           <div class="item">
            <i class="fa-solid fa-warehouse"></i> <strong>Store Credits: {{ $credits['storage'] }}</strong>
           </div>
        <div class="item">
                <button id="openModalBtn" class="btn-primary"> <i class="fa-solid fa-warehouse"></i> Open Storage</button>
           </div>
        </div>

        <div class="info row">
           <div class="item">
            <i class="fa-solid fa-gift fa-beat"></i> <strong>Watch ads and earn storage credits</strong>
           </div>
        <div class="item">
                <button id="watchRewardedAd" class="btn-gold"> <i class="fa-solid fa-play"></i> Watch Ad</button>
           </div>
        </div>


        <!-- Liker Panel -->
        <div class="liker-panel">
            <div class="panel-header">
                <h2><i class="fas fa-magic"></i> Liker Panel</h2>
                <p>Enter public post link to add reactions</p>
            </div>

            <div class="form-section">
                <div class="note">
                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> Make sure the post you are submitting must
                    be "Public" else likes will be failed!
                </div>

                <form id="reactionForm">
                    <div class="form-group">
                        <label for="postUrl">
                            <i class="fas fa-link"></i> Enter Public Post Link!
                        </label>
                        <input type="text" id="postUrl" class="url-input" placeholder="Your Public Post Link Or ID"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Choose Reaction:</label>
                        <div class="reaction-options">
                            <div class="reaction-item reaction-btn selected" data-reaction="1">
                                <div>👍</div>
                                <div class="reaction-label">LIKE</div>
                            </div>
                            <div class="reaction-item reaction-btn" data-reaction="2">
                                <div>❤️</div>
                                <div class="reaction-label">LOVE</div>
                            </div>
                            {{-- <div class="reaction-item" data-reaction="16">
                                <div>🤗</div>
                                <div class="reaction-label">CARE</div>
                            </div> --}}
                            <div class="reaction-item reaction-btn" data-reaction="4">
                                <div>😂</div>
                                <div class="reaction-label">HAHA</div>
                            </div>
                            <div class="reaction-item reaction-btn" data-reaction="3">
                                <div>😮</div>
                                <div class="reaction-label">WOW</div>
                            </div>
                            <div class="reaction-item reaction-btn" data-reaction="7">
                                <div>😢</div>
                                <div class="reaction-label">SAD</div>
                            </div>
                            <div class="reaction-item reaction-btn" data-reaction="8">
                                <div>😡</div>
                                <div class="reaction-label">ANGRY</div>
                            </div>
                        </div>
                    </div>
                  <div class="form-group">
                        <label>Choose Method:</label>
                        <div class="reaction-options">
                            <div class="reaction-item send-method selected" data-reaction="timer">
                                <div><i class="fa-solid fa-clock fa-spin"></i></div>
                                <div class="reaction-label">TIMER <strong class="countdown" data-timer="{{ $credits['remainingTime'] }}"></strong></div>
                            </div>
                            <div class="reaction-item send-method" data-reaction="storage">
                                <div><i class="fa-solid fa-warehouse"></i></div>
                                <div class="reaction-label">STORAGE Credits {{ $credits['storage'] }}</div>
                            </div>

                        </div>
                    </div>



                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fa-solid fa-paper-plane fa-shake"></i> Send
                    </button>
                </form>

                <div id="responseMessage"></div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-header">
                <i class="fas fa-chart-bar"></i>
                <h3>Your Statistics</h3>
            </div>
            <div id="statsContent">
                <div class="loading">
                    <i class="fas fa-spinner"></i>
                    <p>Loading your stats...</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <div class="stats-header">
                <i class="fas fa-history"></i>
                <h3>Recent Activity</h3>
            </div>
            <div id="recentActivity">
                <div class="loading">
                    <i class="fas fa-spinner"></i>
                    <p>Loading activity...</p>
                </div>
            </div>
        </div>

        <!-- Floating Action Button -->
        <div class="floating-action" onclick="scrollToTop()">
            <i class="fas fa-chevron-up"></i>
        </div>
    </div>

    <script>
        let selectedReaction = 1;
        let selectedMethod = 'timer';
        let userStats = {};

        $(document).ready(function() {
            loadUserStats();
            setupReactionHandlers();
            setupMethodHandlers();
            updateTimer();
        });

        $('#watchRewardedAd').on('click', function(e) {
            if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                window.flutter_inappwebview.callHandler('watchRewardedAd');
            }
        })


        const timerEl = document.querySelector(".timer");
        const sendButtonEL = document.getElementById('submitBtn');
        const storeButtonEL = document.getElementById('storeCreditsBtn');

        const countdownEls = document.querySelectorAll("[data-timer]");
        let timeLeft = parseInt(countdownEls[0].getAttribute('data-timer')) || 0;

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;


            countdownEls.forEach((countdown) => {
                countdown.textContent = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
            });

            if (timeLeft <= 0) {
                sendButtonEL.disabled = false;
                storeButtonEL.disabled = false;
                timerEl.innerHTML = '⸜(｡˃ ᵕ ˂ )⸝♡';
            } else {
                if(selectedMethod !="storage"){
                    sendButtonEL.disabled = true;
                }
                storeButtonEL.disabled = true;
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }


        function setupReactionHandlers() {
            // Reaction selection
            $('.reaction-btn').click(function() {
                $('.reaction-btn').removeClass('selected');
                $(this).addClass('selected');
                selectedReaction = $(this).data('reaction');
            });
        }

        function setupMethodHandlers() {
            // Reaction selection
            $('.send-method').click(function() {

          if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                window.flutter_inappwebview.callHandler('showInterstitialAd');
            }

                $('.send-method').removeClass('selected');
                $(this).addClass('selected');
                selectedMethod = $(this).data('reaction');
                if(selectedMethod == "storage"){
                    sendButtonEL.disabled = false;
                    sendButtonEL.innerHTML = `<i class="fa-solid fa-warehouse fa-shake"></i> Send`;
                }else if(timeLeft > 0){
                    sendButtonEL.disabled = true;
                    sendButtonEL.innerHTML = `<i class="fa-solid fa-paper-plane fa-shake"></i> Send`;
                }else{
                    sendButtonEL.disabled = false;
                    sendButtonEL.innerHTML = `<i class="fa-solid fa-paper-plane fa-shake"></i> Send`;
                }
            });
        }

        $('#submitBtn').on('click', async function(e) {
            e.preventDefault();


            if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                window.flutter_inappwebview.callHandler('showInterstitialAd');
            }

            sendButtonEL.disabled = true;
            const postId = $('#postUrl').val();
            const ws = new WebSocket("wss://www.autolikerlive.com/api/v1/send", ['{{$session}}'], {
            headers: {
                "Authorization": "{{$session}}",
            }
            });

            ws.onopen = () => {

                ws.send(JSON.stringify({
                    "link": postId,
                    "reaction": selectedReaction,
                    "method": selectedMethod,
                }));
            };

            ws.onmessage = (event) => {
                try {
                    data = typeof event.data === "string" ? JSON.parse(event.data) : event.data;
                    if(data.success != null){
                        if(data.success){
                            console.log("Task Completed");
                                 setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                        }else{
                            alert(data.message)
                        }
                        sendButtonEL.disabled = false;

                    }else{
                        showReactionResult(data.reaction, data.totalSuccess);
                    }
                    console.log(data);

                } catch (err) {
                    console.error('Invalid JSON:', event.data);
                }
            };

            ws.onclose = () => {
                sendButtonEL.disabled = false;
                     console.log("Task Completed");
                                 setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
            }
        });


function showReactionResult(reaction, success = 0) {
    const icons = {
        1: "👍",
        2: "❤️",
        4: "😂",
        3: "😮",
        7: "😢",
        8: "😡"
    };

const card = document.createElement("div");
card.innerHTML = `
    <div style="
        display: flex;
        align-items: center;
        gap: 10px;">
        <span style="font-size: 20px;">${icons[reaction] || "✨"}</span>
        <span><b>Success: ${success}</b></span>
    </div>
`;

// Create overlay to block clicks
const overlay = document.createElement("div");
Object.assign(overlay.style, {
    position: "fixed",
    top: 0,
    left: 0,
    width: "100%",
    height: "100%",
    background: "rgba(0,0,0,0)", // fully transparent
    zIndex: 9998,
    cursor: "not-allowed"
});
document.body.appendChild(overlay);

Object.assign(card.style, {
    position: "fixed",
    top: "50%",
    left: "50%",
    transform: "translate(-50%, -50%) scale(0.8)",
    background: success ? "#4CAF50" : "#E53935",
    color: "white",
    padding: "20px 30px",
    borderRadius: "12px",
    fontSize: "16px",
    fontWeight: "500",
    boxShadow: "0 4px 12px rgba(0,0,0,0.3)",
    zIndex: 9999,
    opacity: "0",
    transition: "opacity 0.4s ease, transform 0.4s ease"
});

document.body.appendChild(card);

// Animate in
requestAnimationFrame(() => {
    card.style.opacity = "1";
    card.style.transform = "translate(-50%, -50%) scale(1)";
});


    // Animate in
    setTimeout(() => {
        card.style.opacity = "1";
        card.style.transform = "translateY(0)";
    }, 50);

    // Auto hide
    setTimeout(() => {
        card.style.opacity = "0";
        card.style.transform = "translateY(-20px)";
        setTimeout(() => card.remove(), 400);
    }, 3000);
}

        function loadUserStats() {
            $.get('/app/autoliker/stats')
                .done(function(response) {
                    if (response.success) {
                        userStats = response.stats;
                        renderStats();
                        renderRecentActivity();
                    } else {
                        $('#statsContent').html('<p style="color: #e74c3c;">Failed to load stats</p>');
                    }
                })
                .fail(function() {
                    $('#statsContent').html('<p style="color: #e74c3c;">Error loading stats</p>');
                });
        }

        function renderStats() {
            const stats = userStats;
            const html = `
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">${stats.total_reactions}</div>
                        <div class="stat-label">Total Reactions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${stats.today_reactions}</div>
                        <div class="stat-label">Today</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${stats.week_reactions}</div>
                        <div class="stat-label">This Week</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${Math.max(...Object.values(stats.reaction_counts))}</div>
                        <div class="stat-label">Most Used</div>
                    </div>
                </div>
            `;
            $('#statsContent').html(html);
        }

        function renderRecentActivity() {
            // Simulate recent activity based on stats
            const activities = [{
                    text: `Added ${userStats.today_reactions} reactions today`,
                    time: 'Just now'
                },
                {
                    text: `Total ${userStats.total_reactions} reactions sent`,
                    time: '1 hour ago'
                },
                {
                    text: 'Logged in to AutoLiker Pro',
                    time: '2 hours ago'
                },
                {
                    text: 'Account verified successfully',
                    time: 'Today'
                }
            ];

            let html = '';
            activities.forEach(activity => {
                html += `
                    <div class="activity-item">
                        <span class="activity-text">${activity.text}</span>
                        <span class="activity-time">${activity.time}</span>
                    </div>
                `;
            });

            $('#recentActivity').html(html);
        }

        function showMessage(message, type) {
            const alertClass = type === 'success' ? 'success-message' : 'error-message';
            $('#responseMessage').html(`<div class="${alertClass}">${message}</div>`);

            // Auto hide after 5 seconds
            setTimeout(() => {
                $('#responseMessage').html('');
            }, 5000);
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = '/app/logout';
            }
        }

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }


        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const modalOverlay = document.getElementById('modalOverlay');
        const okBtn = document.getElementById('okBtn');

        // Open modal
        openBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'block';
        });

        // Close modal
        closeBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'none';
        });

        // Close modal on OK button
        okBtn.addEventListener('click', () => {
            modalOverlay.style.display = 'none';
        });

        // Close modal when clicking outside the modal box
        window.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
            modalOverlay.style.display = 'none';
            }
        });

        // Auto refresh stats every 30 seconds
        setInterval(loadUserStats, 30000);
    </script>
</body>

</html>
