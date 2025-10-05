<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deletion Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }

        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0 0 5px 5px;
        }

        .detail-row {
            margin: 10px 0;
            padding: 10px;
            background-color: white;
            border-left: 4px solid #dc3545;
        }

        .label {
            font-weight: bold;
            color: #495057;
        }

        .value {
            margin-top: 5px;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>🚨 Account Deletion Request</h2>
    </div>

    <div class="content">
        <div class="warning">
            <strong>⚠️ URGENT:</strong> A user has requested to delete their account from AutoLiker Live platform.
        </div>

        <div class="detail-row">
            <div class="label">Facebook Username:</div>
            <div class="value"><strong>{{ $emailData['facebook_username'] }}</strong></div>
        </div>

        <div class="detail-row">
            <div class="label">Reason for Deletion:</div>
            <div class="value">{{ $emailData['reason'] }}</div>
        </div>

        <div class="detail-row">
            <div class="label">Request Date:</div>
            <div class="value">{{ $emailData['request_date'] }}</div>
        </div>

        <div class="detail-row">
            <div class="label">IP Address:</div>
            <div class="value">{{ $emailData['ip_address'] }}</div>
        </div>

        <div class="warning">
            <strong>Action Required:</strong>
            <ul>
                <li>Verify the user's identity</li>
                <li>Check if the account exists in the system</li>
                <li>Process the deletion request within 48 hours</li>
                <li>Send confirmation to the user</li>
            </ul>
        </div>

        <hr>
        <p style="font-size: 12px; color: #6c757d; text-align: center;">
            This email was automatically generated from AutoLiker Live Delete Account Request Form.<br>
            Please handle this request promptly to comply with user privacy rights.
        </p>
    </div>
</body>

</html>
