<?php

use App\Models\TempInbox;

return [
    /*
    |--------------------------------------------------------------------------
    | Temp Mail API (app-facing)
    |--------------------------------------------------------------------------
    */

    // Lifetime of an inbox created via POST /api/tempmail/create.
    'ttl_minutes' => (int) env('TEMPMAIL_TTL_MINUTES', 120),

    // Max per-request inbox TTL the app may ask for (protects against
    // "permanent" mailboxes).
    'max_ttl_minutes' => (int) env('TEMPMAIL_MAX_TTL_MINUTES', 1440),

    // Per-Firebase-app-check requests per minute.
    'rate_limit' => (int) env('TEMPMAIL_RATE_LIMIT', 60),

    // The tempmail:watch sweep only touches inboxes seen within this window.
    'watch_window_minutes' => (int) env('TEMPMAIL_WATCH_WINDOW_MINUTES', 30),

    // When true, GET-MAIL without an inbox_token is still allowed (legacy
    // behaviour, any verified app can read any mailbox). Keep false.
    'allow_unowned_access' => (bool) env('TEMPMAIL_ALLOW_UNOWNED_ACCESS', false),
];
