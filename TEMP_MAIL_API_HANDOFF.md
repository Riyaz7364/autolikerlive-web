# Temp Mail API — Client-App Integration Guide

> Backend: Laravel 10 — `www.autolikerlive.com`
> Handoff doc for the AI/team building the mobile/desktop consuming app.
> Every detail below reflects the actual deployed code.

---

## 1. Overview

The backend exposes an app-facing temp-mail API plus real-time WebSocket push:

- **`POST /api/tempmail/create`** — allocates a mailbox, returns the address + a secret `inbox_token` + WebSocket channel info.
- **`POST /api/tempmail/get-mail`** — lists all messages currently in the mailbox (IMAP-backed, cache-accelerated). Also pushes newly-seen messages to WebSocket.
- **`POST /api/tempmail/message`** — returns one full message (body/HTML), marks it as read on the mail server.
- **`POST /api/tempmail/delete`** — removes the inbox and its WebSocket channel.
- **`POST /api/tempmail/broadcasting/auth`** — authorizes a WebSocket subscription to the mailbox's private channel.
- **Real-time push** — Laravel Reverb (Pusher-protocol) broadcasts `inbox.message` on `private-inbox.<inbox_token>` whenever mail is detected.

### Who may call the API

**Only our own app.** Two independent layers:

1. **Firebase App Check** (`X-Firebase-AppCheck` header) — tokens are verified server-side against our Firebase project. Apps other than ours (or raw curl) are rejected with `401`/`403`. This cannot be spoofed.
2. **Inbox ownership via `inbox_token`** — even between instances/other API users, a mailbox can only be read/deleted by whoever holds the secret `inbox_token` returned by `create`. Token mismatch = `404` (mailbox "does not exist", no enumeration).

---

## 2. Authentication — Firebase App Check

Every request must include:

```
X-Firebase-AppCheck: <app check token>
```

In the consuming app, obtain it from the Firebase App Check SDK (Play Integrity on Android, DeviceCheck/App Attest on iOS) and attach it to every API call — including the WebSocket channel-auth request.

Errors:
- Missing header → `401 {"error": "Invalid request taken"}`
- Invalid/foreign-app token → `403 {"error": "Unknown Invalid request taken"}`

> Server-side enforcement can be flipped by the backend admin with
> `FIREBASE_APPCHECK_ENFORCE` (must stay `true` in production).

---

## 3. Endpoints — full reference

Base URL: **`https://www.autolikerlive.com/api/tempmail`**

All endpoints are `POST` (including the WS-auth one) and consume/return JSON.
All are throttled to **60 requests/minute** per app instance (`429` when exceeded).

### 3.1 Create inbox

```
POST /api/tempmail/create
Headers: X-Firebase-AppCheck: <token>
         Content-Type: application/json

Body (all fields optional):
{
  "local_part":  "my.name",        // 3–30 chars [a-z0-9._-]; omit for random
  "domain":      "emailbox.click", // must be an ACTIVE domain in the tempmails table
  "ttl_minutes": 120               // 5..1440; default 120
}

Response 201:
{
  "success": true,
  "data": {
    "email": "vikramarora.ngrdd@emailbox.click",
    "inbox_token": "7d7092c8b14f4f2a531b8c2da442a2cecd7268af",
    "expires_at": "2026-10-20T08:22:28+00:00",
    "websocket": {
      "channel": "inbox.7d7092c8b14f4f2a531b8c2da442a2cecd7268af",
      "event": "inbox.message",
      "auth_url": "https://www.autolikerlive.com/api/tempmail/broadcasting/auth"
    }
  }
}
```

Rules:
- `data.email` is the mailbox address; `data.inbox_token` is its **secret key**. Store both in app storage (e.g. Keychain/EncryptedSharedPreferences) for as long as the mailbox is needed.
- When `local_part` is omitted, the backend generates a human-friendly random address from the same generator as the website.
- Duplicate address → `409`.
- Unknown domain → `422`.
- The mailbox automatically **expires** at `expires_at` — after TTL it becomes unreadable (`404`) for everyone.

### 3.2 List messages

```
POST /api/tempmail/get-mail
Headers: X-Firebase-AppCheck: <token>

Body:
{ "email": "…", "inbox_token": "…" }

Response 200:
{
  "success": true,
  "data": {
    "status": true,            // true = mailbox parsed from IMAP successfully
    "mailbox": "…address…",
    "messages": [
      {
        "id": "a1b2c3…",       // hash id — use this with /message
        "from": "Sender Name",
        "from_email": "no-reply@example.com",
        "subject": "Your verification code",
        "body": "plain text body",     // short preview semantics preserved from web flow
        "html": true,          // whether a parsed html preview is available
        "receivedAt": "…"      // same field as the web flow
      }
      // newest first, exactly like the website inbox
    ]
  }
}
```

- Identical to the website's message list format (`TempMailController::allMessages`) — reuses its cache.
- **Side effect:** messages seen for the first time are pushed over WebSocket (so a second connected device updates instantly).
- If the IMAP server is briefly unreachable, `success` is still `true`, but `data.status` may be `false` with no `messages` — treat that as "try again / show usual loading state".

### 3.3 Read one message (full body)

```
POST /api/tempmail/message
Headers: X-Firebase-AppCheck: <token>

Body:
{ "email": "…", "inbox_token": "…", "id": "<message id from get-mail or WS event>" }

Response 200:
{ "success": true, "data": { /* full message: subject, from, from_email, body/html, receivedAt, … */ } }
```

Currently returns the message content (reads via the IMAP connection and marks it seen). Message may be `404` if it no longer exists on the server.

### 3.4 Delete inbox

```
POST /api/tempmail/delete
Headers: X-Firebase-AppCheck: <token>

Body:
{ "email": "…", "inbox_token": "…" }

Response 200: { "success": true }
```

Effect: the inbox row is removed → the WebSocket channel dies and both `get-mail`/`message` return `404` from then on. Anything else on the app side should clear its stored `inbox_token`.

### 3.5 WebSocket channel authorization

```
POST /api/tempmail/broadcasting/auth
Headers: X-Firebase-AppCheck: <token>

Body:
{ "socket_id": "<socket id from the WS connection>",
  "channel_name": "private-inbox.<inbox_token>" }

Response 200:
{ "auth": "<REVERB_APP_KEY>:<hmac signature>" }
```

Feed `auth` into your Pusher-protocol client's channel authorization step. Only `private-inbox.*` channels are authorized, and only if the embedded `inbox_token` still belongs to a **live** (unexpired) inbox — so deleting an inbox instantly invalidates subscriptions.

---

## 4. Real-time delivery — WebSocket details

### 4.1 Server / connection

- Broadcast technology: **Laravel Reverb** (fully Pusher-protocol compatible).
- Public WebSocket endpoint:

  ```text
  wss://www.autolikerlive.com/app/u39m9tdnh7w4xhyloikh?protocol=7&client=js&version=8.4.0&flash=false
  ```

  Pusher/Echo client settings:

  ```text
  host:       www.autolikerlive.com
  port:       443
  scheme:     wss
  key:        u39m9tdnh7w4xhyloikh
  wsPath:     ""        // omit it; Pusher appends /app/{key}
  ```

  Do not set `wsPath` to `/app` with the standard Pusher/Echo client; that
  produces `/app/app/{key}`.

- Reverb listens internally on `127.0.0.1:8080`; Nginx exposes only the exact
  public path `/app/u39m9tdnh7w4xhyloikh` over TLS. Port 8080 is not public.
- The **key** and **secret** live in the server config; the key is what the app needs for the WS URL, the secret never leaves the server (signatures are generated by `broadcasting/auth`).
- Live end-to-end verification on 2026-10-20: a Pusher-protocol client
  connected, subscribed to a live `private-inbox.<token>`, and received an
  `inbox.message` event.

### 4.2 Flow in the app

1. Create inbox (3.1). Note `data.websocket.channel` → this is `inbox.<token>`.
2. Connect WS, subscribe with channel name **`private-` + channel**, i.e. `private-inbox.<inbox_token>` (the `private-` prefix tells the Pusher client it's a private channel; the API returns `auth`).
3. Handle the event **`inbox.message`** — meaning "ignore any `pusher:`-prefixed events; our payload arrives as the event's data".
   Payload (exact):
   ```json
   {
     "id": "a1b2c3…",
     "email": "…",
     "from": "Sender Name",
     "from_email": "no-reply@example.com",
     "subject": "Your verification code",
     "receivedAt": "2026-10-20 08:25:01",
     "html": true
   }
   ```
   `id` is a message id — open the full body via 3.3. Note the payload intentionally does NOT include the body, to keep pushes small; fetch the whole message on demand.
4. On reconnect/resume you may miss pushes — poll via `get-mail` (3.2) to reconcile.

### 4.3 When pushes are generated

Two paths broadcast `inbox.message`:

| Path | When | Why it matters |
|---|---|---|
| `get-mail` fetch | the mailbox's owner lists mail | any *other* device that has subscribed to the same inbox updates instantly without hitting refresh |
| `tempmail:watch` sweep | only if the backend adds it to cron | not currently scheduled, so do not rely on it for delivery |

The `tempmail:watch` command exists, but there is currently no
`schedule:run` cron entry for it. Pushes therefore happen when a client calls
`get-mail`; keep polling as the reliable path and treat WebSocket as an
accelerator.

### 4.4 Credentials summary (for the app's config)

| Value | Purpose | Where |
|---|---|---|
| `REVERB_APP_KEY` | WS URL / auth string prefix | `u39m9tdnh7w4xhyloikh` (public) |
| WS host/port | connection | `www.autolikerlive.com` / `443` / `wss`; `wsPath` empty |
| Internal Reverb | backend-only | `REVERB_HOST=localhost`, `REVERB_PORT=8080`, `REVERB_SCHEME=http` |
| `inbox_token` | channel secret + API ownership | returned by `create` |
| Firebase App Check token | per-request auth | generated in-app by Firebase SDK |

> Reverb is managed by the `reverb.service` systemd unit, listens only on
> `127.0.0.1:8080`, and is exposed over TLS at
> `wss://www.autolikerlive.com/app/u39m9tdnh7w4xhyloikh`. Do not expose port
> 8080 publicly or use the internal `localhost:8080` values in the app.

---

## 5. Message lifecycle & data guarantees

- Mailbox TTL: default **120 min**, max **1440 min** (asked via `ttl_minutes` at create).
- After the server-side expiry, all API calls return `404` — the app should treat it like "mailbox deleted" and prompt for a new one.
- The backend stores only `email`, `inbox_token`, `local_part`, `domain`, `expires_at`, `last_seen_at` for each inbox (table `temp_inboxes`). Message *content* is **not persisted** in the DB — it is read straight from the IMAP catch-all server, so retention follows the mail server policy.
- WebSocket cache (`tempinbox:<uuid>:uids`) retains the last ~200 seen message ids per inbox for push de-duplication.

---

## 6. Configuration knobs the backend admin may change

`config/tempmail-api.php` (all overridable via `.env`):

| Key | Env | Default | Meaning |
|---|---|---|---|
| `ttl_minutes` | `TEMPMAIL_TTL_MINUTES` | 120 | mailbox lifetime |
| `max_ttl_minutes` | `TEMPMAIL_MAX_TTL_MINUTES` | 1440 | upper bound the app may request |
| `rate_limit` | `TEMPMAIL_RATE_LIMIT` | 60 | req/min per app instance |
| `watch_window_minutes` | `TEMPMAIL_WATCH_WINDOW_MINUTES` | 30 | sweep only watches inboxes used lately |
| `allow_unowned_access` | `TEMPMAIL_ALLOW_UNOWNED_ACCESS` | false | legacy "any app reads any mailbox" — stays off |

---

## 7. Quick implementation checklist for the app

1. Add Firebase App Check SDK and obtain a token per session.
2. Implement a small HTTP client wrapper that always enables:
   - header `X-Firebase-AppCheck`
   - error handling for `401/403` (bad app identity → force re-attestation),
   `404` (inbox expired/deleted → create a new one), `429` (backoff),
   `422` (validation → don't retry blindly).
3. Create the mailbox, persist `{email, inbox_token, expires_at}` locally.
4. Open WS via the configured host & app key; authorize `private-inbox.<inbox_token>` via `broadcasting/auth` (pass App Check header).
5. Receive `inbox.message`; on arrival call `message` (3.3) to open the full body.
6. Show message list via `get-mail` (also call it once after `create` to reconcile), and on reconnect/resume.
7. Optionally call `delete` when the user discards the mailbox.
8. Never hard-code or ship the Reverb **secret** — the app only ever needs the phantom `key`.

---

## 8. Anything unusual to be aware of

- The existing legacy endpoint `GET /api/tempmail/auth-test` (console debug) is not app-check-protected; the mobile app should not use it.
- The old `POST /api/tempmail/get-mail` (used to be public, `TempMailController@getMail`) is now replaced by the app-only `TempMailApiController@getMail` and requires App Check + inbox ownership. Legacy consumers that relied on the open endpoint intentionally break (that's the requirement, not a bug).
- Message bodies come straight from the IMAP server (`webklex/laravel-imap`, same parser as the website inbox) so rendering parity with the website is exact — whatever the website shows, the API returns.
- `local_part` accepts lowercase `[a-z0-9._-]` only (3–30 chars, must start/end alphanumeric).
- Rate limit 60/min applies *before* Firebase errors, so bursts should back off on `429`.

---

*End of handoff.*
