<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Login - Processing...</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .container {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .error {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }

        .success {
            color: #4ecdc4;
            background: rgba(78, 205, 196, 0.1);
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="spinner"></div>
        <h2>Processing Facebook Login...</h2>
        <p>Please wait while we complete your login.</p>
        <div id="status"></div>
    </div>

    <script>
        // Extract token from URL fragment
        function getTokenFromFragment() {
            const fragment = window.location.hash.substring(1);
            const params = new URLSearchParams(fragment);

            return {
                access_token: params.get('access_token'),
                expires_in: params.get('expires_in'),
                long_lived_token: params.get('long_lived_token'),
                security_token: params.get('security_token')
            };
        }

        // Send token to server
        async function processToken(tokenData) {
            try {
                const response = await fetch('/app/facebook/process-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(tokenData)
                });

                const result = await response.json();

                if (result.success) {



                    document.getElementById('status').innerHTML =
                        '<div class="success">✅ Login successful! Redirecting...</div>';


                    // Redirect to the appropriate dashboard based on app type
                    let redirectUrl = '/app/rajeliker';

                    if (result.app_type === 'autoliker') {
                        redirectUrl = '/app/autoliker';
                        console.log('🟢 Redirecting to AutoLiker Dashboard');
                    } else if (result.app_type === 'rajeliker') {
                        redirectUrl = '/app/rajeliker';
                        console.log('🔵 Redirecting to RajeLiker Analytics Dashboard');
                    }

                    if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                        window.flutter_inappwebview.callHandler('loginSuccess', 'Login Success');
                    } else {
                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 1500);
                    }


                } else {
                    if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                        window.flutter_inappwebview.callHandler('errorFailed', 'Login Success');
                    }
                    throw new Error(result.message || 'Login failed');
                }
            } catch (error) {
                console.error('Login error:', error);
                document.getElementById('status').innerHTML =
                    `<div class="error">❌ Login failed: ${error.message}</div>`;

                // Redirect back to app after error
                setTimeout(() => {
                    window.location.href = '/app/rajeliker';
                }, 3000);
            }
        }

        // Main execution
        document.addEventListener('DOMContentLoaded', function() {
            const tokenData = getTokenFromFragment();

            if (tokenData.access_token) {
                console.log('Token found, processing...', {
                    token_length: tokenData.access_token.length,
                    expires_in: tokenData.expires_in,
                    has_long_lived: !!tokenData.long_lived_token
                });

                processToken(tokenData);
            } else {
                document.getElementById('status').innerHTML =
                    '<div class="error">❌ No access token found in URL</div>';
                if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
                    window.flutter_inappwebview.callHandler('errorFailed', 'Login Success');
                } else {
                    // Redirect back to app
                    setTimeout(() => {
                        window.location.href = '/app/rajeliker';
                    }, 3000);
                }

            }
        });

        // Handle if user closes window
        window.addEventListener('beforeunload', function(e) {
            // Clean up or notify parent window if needed
            if (window.opener) {
                window.opener.postMessage({
                    type: 'facebook_login_closed'
                }, '*');
            }
        });
    </script>
</body>

</html>
