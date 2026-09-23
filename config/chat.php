<?php

return [
    // Master switch — set CHAT_ENABLED=false to remove widget + disable APIs instantly.
    'enabled' => env('CHAT_ENABLED', true),

    // Public WS URL used by the browser widget (wss through Nginx).
    'ws_url' => env('CHAT_WS_URL', 'wss://www.autolikerlive.com/chat-ws/'),

    // Internal Node endpoint (Laravel -> Node publish). Never exposed publicly.
    'node_url' => env('CHAT_NODE_URL', 'http://127.0.0.1:8766'),

    // Shared secret for Laravel <-> Node server-to-server calls.
    'sync_secret' => env('CHAT_SYNC_SECRET', 'change-me-chat-secret'),

    'poll_interval' => 3000,
    'offline_email' => env('CHAT_OFFLINE_EMAIL', 'contact@autolikerlive.com'),
];
