<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Search Console Authorization</title>
    <style>
        :root {
            color-scheme: light dark;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            align-items: center;
            background: #f6f8fb;
            color: #172033;
            display: flex;
            justify-content: center;
            margin: 0;
            min-height: 100vh;
            padding: 24px;
        }

        main {
            background: #ffffff;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            max-width: 640px;
            padding: 32px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            line-height: 1.2;
            margin: 0 0 12px;
        }

        p {
            font-size: 16px;
            line-height: 1.55;
            margin: 0 0 16px;
        }

        .status {
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 12px 14px;
        }

        .success {
            background: #eaf7ee;
            border: 1px solid #bce5c8;
            color: #174f2a;
        }

        .error {
            background: #fff1f0;
            border: 1px solid #ffccc7;
            color: #7a1f14;
        }

        code {
            background: #eef2f7;
            border-radius: 4px;
            padding: 2px 5px;
        }
    </style>
</head>
<body>
    <main>
        @if ($hasError)
            <div class="status error">Google returned an authorization error.</div>
            <h1>Authorization was not completed</h1>
            <p>{{ $errorDescription ?: $error ?: 'Please run the connection command again.' }}</p>
        @elseif ($hasCode)
            <div class="status success">Authorization code received.</div>
            <h1>Return to the terminal</h1>
            <p>Copy the full URL from this browser address bar and paste it into the waiting <code>php artisan gsc:connect</code> prompt.</p>
            <p>The current connection flow stores an access token directly, so use the URL that contains #access_token when available.</p>
        @else
            <div id="token-status" class="status error">Checking authorization response...</div>
            <h1 id="token-title">Return to the terminal</h1>
            <p id="token-message">If the browser address bar contains <code>#access_token=</code>, copy the full URL and paste it into the waiting <code>php artisan gsc:connect</code> prompt.</p>
            <p id="token-detail">The access token is in the URL fragment, so only this browser page can see it.</p>
        @endif
    </main>
    <script>
        (function () {
            var status = document.getElementById('token-status');
            if (!status) {
                return;
            }

            var params = new URLSearchParams(window.location.hash.replace(/^#/, ''));
            var title = document.getElementById('token-title');
            var message = document.getElementById('token-message');
            var detail = document.getElementById('token-detail');

            if (params.get('access_token')) {
                status.className = 'status success';
                status.textContent = 'Access token received.';
                title.textContent = 'Return to the terminal';
                message.innerHTML = 'Copy the full URL from this browser address bar, including <code>#access_token=</code>, and paste it into the waiting <code>php artisan gsc:connect</code> prompt.';
                detail.textContent = 'The command will verify the state value and store the access token for Search Console keyword research.';
                return;
            }

            if (params.get('error')) {
                status.className = 'status error';
                status.textContent = 'Google returned an authorization error.';
                title.textContent = 'Authorization was not completed';
                message.textContent = params.get('error_description') || params.get('error') || 'Please run the connection command again.';
                detail.textContent = '';
                return;
            }

            status.className = 'status error';
            status.textContent = 'No access token was found.';
            title.textContent = 'Run the connection again';
            message.innerHTML = 'Start a fresh <code>php artisan gsc:connect</code> session and approve the Google prompt again.';
            detail.textContent = 'Make sure the final URL includes the fragment after # before pasting it into the terminal.';
        })();
    </script>
</body>
</html>
