<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
            position: relative;
        }

        .header {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #dadde1;
            background: white;
        }

        .fb-icon {
            width: 28px;
            height: 28px;
            background: #1877f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            margin-right: 8px;
        }

        .arrow-icon {
            width: 40px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #65676b;
        }

        .app-icon {
            width: 28px;
            height: 28px;
            background: #dc2626;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            margin-left: 8px;
        }

        .content {
            padding: 16px;
        }

        .title {
            font-size: 20px;
            font-weight: 600;
            color: #1c1e21;
            margin-bottom: 12px;
            line-height: 24px;
        }

        .subtitle {
            font-size: 16px;
            color: #65676b;
            margin-bottom: 20px;
            line-height: 20px;
        }

        .permission-info {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
            color: #65676b;
            line-height: 18px;
        }

        .button-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #dadde1;
            padding: 16px;
            max-width: 400px;
            margin: 0 auto;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 12px;
        }

        .btn-primary {
            background-color: #1877f2;
            color: white;
        }

        .btn-primary:hover {
            background-color: #166fe5;
        }

        .btn-secondary {
            background-color: #e4e6ea;
            color: #1c1e21;
        }

        .btn-secondary:hover {
            background-color: #d8dadf;
        }

        .footer-text {
            font-size: 12px;
            color: #65676b;
            line-height: 16px;
            text-align: center;
            margin-top: 12px;
        }

        .footer-links {
            color: #1877f2;
            text-decoration: none;
        }

        .footer-links:hover {
            text-decoration: underline;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading.show {
            display: block;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #1877f2;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            padding: 20px;
            overflow-y: auto;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-header {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #dadde1;
            position: relative;
        }

        .modal-header-icons {
            display: flex;
            align-items: center;
            margin-right: 12px;
        }

        .modal-fb-icon {
            width: 24px;
            height: 24px;
            background: #1877f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            margin-right: 6px;
        }

        .modal-arrow {
            color: #65676b;
            font-size: 14px;
            margin: 0 6px;
        }

        .modal-app-icon {
            width: 24px;
            height: 24px;
            background: #dc2626;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 10px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #1c1e21;
            flex: 1;
            text-align: center;
        }

        .modal-close {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f0f2f5;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #65676b;
        }

        .modal-close:hover {
            background: #e4e6ea;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-text {
            font-size: 14px;
            line-height: 20px;
            color: #1c1e21;
            margin-bottom: 16px;
        }

        .modal-list {
            list-style: none;
            padding: 0;
            margin: 16px 0;
        }

        .modal-list li {
            padding: 8px 0;
            font-size: 14px;
            line-height: 20px;
            color: #1c1e21;
            position: relative;
            padding-left: 20px;
        }

        .modal-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #1c1e21;
            font-weight: bold;
        }

        .modal-links {
            color: #1877f2;
            text-decoration: none;
        }

        .modal-links:hover {
            text-decoration: underline;
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid #f0f2f5;
            font-size: 12px;
            color: #65676b;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div><img
                    src="{{ url('images/app-facebook-circle_filled_32_fds-blue-50.png
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ') }}"
                    alt="fb icon">
            </div>
            <div class="arrow-icon"><img
                    src="{{ url('images/repeat_filled_24_secondary-icon.png
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ') }}"
                    alt="exchange icon">
            </div>
            <div class="app-icon"><img
                    src="{{ url('images/app-rajeliker-circle_filled_32.png
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ') }}"
                    alt="exchange icon"></div>
        </div>

        <div class="content">
            <div class="title" id="permissionTitle">You previously logged into RajeLiker with Facebook.</div>
            <div class="subtitle">Would you like to continue?</div>

            <div class="loading" id="loadingDiv">
                <div class="spinner"></div>
                Getting your information...
            </div>
        </div>

        <div class="button-container">

            <button type="button" class="btn btn-primary" id="continueBtn">Continue as
                {{ $user['name'] }}</button>
            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>

            <div class="footer-text">
                By continuing, RajeLiker will receive ongoing access to the information you share and Meta will record
                when RajeLiker accesses it.
                <a href="#" class="footer-links" onclick="showLearnMoreModal(); return false;">Learn more</a>
                about this sharing and the settings you
                have.<br><br>
                RajeLiker's <a href="https://www.autolikerlive.com/privacy-policy" class="footer-links">Privacy
                    Policy</a> and <a href="https://www.autolikerlive.com/terms-of-service" class="footer-links">Terms
                    of Service</a>
            </div>
        </div>
    </div>

    <!-- Learn More Modal -->
    <div class="modal" id="learnMoreModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Sharing with Apps and Websites</div>
                <button class="modal-close" onclick="closeLearnMoreModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="modal-text">
                    When you log into an app or website with Facebook:
                </div>
                <ul class="modal-list">
                    <li>The app or website will be able to continue accessing the information you've shared with it. For
                        example, if you allow an editing app to access your photos, the app is able to access new photos
                        you add to Facebook.</li>
                    <li>You can review or change the information you share with <a href="#"
                            class="modal-links">apps and websites</a> settings. These settings are different from the <a
                            href="#" class="modal-links">audience selector settings</a> that control who can see
                        your content on Facebook.</li>
                    <li>This developer's apps and websites may request access to the information you've shared with them
                        from Facebook and use that data according to their <a href="#" class="modal-links">privacy
                            policies</a>. These requests are automatically logged by our systems and are not controlled
                        by your device settings.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <a href="https://www.autolikerlive.com/privacy-policy" class="modal-links">RajeLiker's Privacy
                    Policy</a> and <a href="https://www.autolikerlive.com/terms-of-service" class="modal-links">Terms of
                    Service</a>
            </div>
        </div>
    </div>

    <script>
        // Server-provided values, safely JSON-encoded so quotes or special
        // characters in tokens / user-agent strings can't break the script.
        const PROCESS_URL = @json(route('app.facebook.process'));
        const FALLBACK_URL = @json(route('app.index'));
        const CSRF_TOKEN = @json(csrf_token());
        const FLUTTER_TOKEN = @json($sec_ch_token ?? '');
        const ACCESS_TOKEN = @json($token ?? '');
        const FB_USER = @json($user ?? null);

        let isProcessing = false;
        let loginDone = false;

        // The Flutter JS bridge may not be ready immediately after page load.
        // Track readiness via the official platform-ready event.
        let flutterBridgeReady = Boolean(window.flutter_inappwebview && window.flutter_inappwebview.callHandler);
        window.addEventListener('flutterInAppWebViewPlatformReady', function() {
            flutterBridgeReady = true;
        });

        function hasFlutterHandler() {
            return flutterBridgeReady && window.flutter_inappwebview && typeof window.flutter_inappwebview.callHandler === 'function';
        }

        function setLoading(show, text) {
            const loadingDiv = document.getElementById('loadingDiv');
            const continueBtn = document.getElementById('continueBtn');
            if (loadingDiv) {
                loadingDiv.classList.toggle('show', show);
                loadingDiv.innerHTML = '<div class="spinner"></div>' + (text || 'Getting your information...');
            }
            if (continueBtn) {
                continueBtn.disabled = show;
            }
        }

        // fetch with a real timeout (the timer is cleared once the request settles)
        function fetchWithTimeout(url, options, timeout = 15000) {
            let timer;
            const timeoutPromise = new Promise((_, reject) => {
                timer = setTimeout(() => reject(new Error('Request timeout')), timeout);
            });
            return Promise.race([fetch(url, options), timeoutPromise])
                .finally(() => clearTimeout(timer));
        }

        // Notify the Flutter app. Returns true when a handler actually received it.
        // If the Dart side hasn't registered the handler yet (first-click race),
        // callHandler rejects — we catch that and fall through to the redirect
        // fallback instead of silently "doing nothing".
        async function notifyFlutter(handler, arg) {
            if (!hasFlutterHandler()) {
                return false;
            }
            try {
                await Promise.race([
                    window.flutter_inappwebview.callHandler(handler, arg),
                    new Promise((_, reject) => setTimeout(() => reject(new Error('handler timeout')), 3000))
                ]);
                return true;
            } catch (e) {
                console.warn('Flutter handler "' + handler + '" not delivered:', e && e.message);
                return false;
            }
        }

        async function continueAsUser() {
            // Ignore extra taps while a login request is already in flight.
            // This stops duplicate server-side logins caused by double clicks.
            if (isProcessing || loginDone) {
                return;
            }
            isProcessing = true;
            setLoading(true);

            const maxRetries = 3;
            const retryDelay = 1000; // 1 second
            let currentAttempt = 0;
            let lastError = null;

            while (currentAttempt < maxRetries) {
                currentAttempt++;
                console.log(`Attempt ${currentAttempt}/${maxRetries}`);

                try {
                    const response = await fetchWithTimeout(PROCESS_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'X-Flutter-Token': FLUTTER_TOKEN
                        },
                        body: JSON.stringify({
                            access_token: ACCESS_TOKEN,
                            user: FB_USER
                        })
                    }, 15000); // 15 second timeout

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (!data.success) {
                        throw new Error(data.message || 'Server returned error');
                    }

                    console.log('Token processed successfully');
                    // Keep the UI in the loading state — do NOT reset it on
                    // success, otherwise it looks like "nothing happened".
                    loginDone = true;
                    await handleLoginSuccess(data.dashboard_url || FALLBACK_URL);
                    return;
                } catch (error) {
                    console.error(`Attempt ${currentAttempt} failed:`, error && error.message);
                    lastError = error;

                    if (currentAttempt < maxRetries) {
                        // Update loading text to show retry
                        setLoading(true, `Retrying... (${currentAttempt}/${maxRetries})`);
                        await new Promise(resolve => setTimeout(resolve, retryDelay));
                    }
                }
            }

            // All attempts failed — reset UI so the user can try again.
            isProcessing = false;
            setLoading(false);

            let errorMessage = 'Login failed. ';
            const msg = (lastError && lastError.message) || '';
            if (msg.includes('timeout')) {
                errorMessage += 'Connection timeout. Please check your internet connection and try again.';
            } else if (msg.includes('Failed to fetch')) {
                errorMessage += 'Network error. Please check your internet connection and try again.';
            } else {
                errorMessage += msg || 'Please try again.';
            }

            alert(errorMessage);
        }

        async function handleLoginSuccess(dashboardUrl) {
            // 1) Try the native Flutter handler first (normal in-app path).
            await notifyFlutter('loginSuccess', 'Login Success');
            // 2) Fallback: navigate to the dashboard. If Flutter already handled
            // the login it closes/navigates away; if the handler was missed
            // (first-click race), this redirect still completes the login so a
            // second tap is never needed.
            setTimeout(function() {
                if (loginDone && !document.hidden) {
                    window.location.href = dashboardUrl;
                }
            }, 800);
        }

        async function cancelPermission() {
            const delivered = await notifyFlutter('permissionDenied');
            if (!delivered) {
                window.location.href = FALLBACK_URL + "?permission_denied=true";
            }
        }

        // Modal functions
        function showLearnMoreModal() {
            document.getElementById('learnMoreModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLearnMoreModal() {
            document.getElementById('learnMoreModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('learnMoreModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLearnMoreModal();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLearnMoreModal();
            }
        });

        // Bind buttons (single binding — no inline onclick, so one tap = one request)
        document.getElementById('continueBtn').addEventListener('click', continueAsUser);
        document.getElementById('cancelBtn').addEventListener('click', cancelPermission);
    </script>
</body>

</html>
