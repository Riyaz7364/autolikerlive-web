# TempMail Mobile Client — App AI Implementation Prompt

Copy this entire file into the app-building AI. It is self-contained.
It **supersedes** `TEMP_MAIL_API_HANDOFF.md` wherever the two disagree.

---

## ROLE

You are the senior mobile engineer for the TempMail client.
Implement the complete client-side integration against the backend at:

```text
https://www.autolikerlive.com
```

Use **only** the request/response contracts in this file. Do not invent fields,
endpoints, envelopes, or WebSocket behavior. If something is not specified
here, stop and report it instead of guessing.

---

## 0. DELIVERABLES

Produce a working, tested client with:

1. A typed HTTP client for all TempMail endpoints.
2. Exact request/response models matching the field names below.
3. Firebase App Check header injection on every TempMail request.
4. Secure local storage for `email`, `inbox_token`, and `expires_at`.
5. Mailbox creation, message list, message detail, and delete flows.
6. Polling-based refresh as the **default reliable path**.
7. Optional WebSocket support behind a feature flag, using the exact channel,
   auth, and event contract below.
8. Error handling for every documented status code and error shape.
9. Unit tests with fixtures for success and error responses.
10. A short `BACKEND_BLOCKERS.md` in the app repo listing the live backend
    problems in section 12, so the human can coordinate the server fix.

Do not ship fake/mock data in production builds. Mocks are for tests only.

---

## 1. CRITICAL: READ THIS BEFORE CODING

The backend contracts below are real. **App Check and Reverb/WebSocket are
both live and verified.** Implement polling first as a fallback, then enable
WebSocket. Do not add a client-side bypass.

### 1.1 Firebase App Check is working (JWT verification)

The backend enforces `X-Firebase-AppCheck` on every TempMail endpoint and
verifies the App Check JWT against Google's App Check JWKS.

Firebase project values:

```text
project ID:     temp-mail-e39fe
project number: 610463736485

Android app IDs accepted by the backend:
- Play Store / release: 1:610463736485:android:44746b7286ac396716634c
- Debug / emulator:     1:610463736485:android:747df09ec27a30e116634c
```

The app must let the Firebase App Check SDK set the header. The SDK sends a
JWT; never send the debug-token UUID manually. The backend verifies:

- the JWT signature against `https://firebaseappcheck.googleapis.com/v1/jwks`
- `aud` contains `projects/610463736485`
- `iss` is `https://firebaseappcheck.googleapis.com/610463736485`
- `sub` is one of the two Android app IDs above

A missing header returns:

```http
HTTP/1.1 401
Content-Type: application/json

{"error":"Invalid request taken"}
```

A bad, expired, or foreign-project token returns:

```http
HTTP/1.1 403
Content-Type: application/json

{"error":"Unknown Invalid request taken"}
```

Live verification on 2026-10-20: a token minted for the Android app ID above
passed the middleware and reached the controller. The old "every token gets
403" behavior is fixed.

On failure, the backend logs `App Check verification failed` with the
unverified `aud`, `iss`, and `sub`, plus the expected project/app values. The
app can log the same three claims for comparison. Never log the full token.

**Debug builds only:**

- The app's configured debug token is
  `3F5FCA95-29D1-4343-93D0-DFEF9F4EFE2E`. Register the same value in Firebase
  Console → App Check → Apps → Manage debug tokens.
- Enable the App Check debug provider only in the debug variant. The SDK uses
  the debug token to obtain its App Check token; the UUID is not the literal
  `X-Firebase-AppCheck` header value.
- Keep the token in local debug configuration or a git-ignored `.env` file.
  Never ship it in a release build and never commit it to a public repo.
- For diagnostics, log only the unverified `aud`, `iss`, and `sub` claims.
  Never log the full token or a private key.

**Client instruction:** on 401/403, refresh the App Check token once, retry
once, then show a clear diagnostic. Do not loop or retry aggressively.

### 1.2 Reverb / WebSocket is live

Reverb is running and publicly reachable over TLS.

```text
Public host:     www.autolikerlive.com
Public port:     443
TLS:             yes (wss://)
Public app key:  u39m9tdnh7w4xhyloikh
WebSocket path:  /app/u39m9tdnh7w4xhyloikh
Full URL:        wss://www.autolikerlive.com/app/u39m9tdnh7w4xhyloikh?protocol=7&client=js&version=8.4.0&flash=false
```

Pusher/Echo settings:

```text
wsHost:             www.autolikerlive.com
wsPort:             443
wssPort:            443
forceTLS:           true
wsPath:             ""        // omit it; Pusher appends /app/{key}
enabledTransports:  ["ws", "wss"]
key:                u39m9tdnh7w4xhyloikh
```

Do **not** set `wsPath` to `/app` with the standard Pusher/Echo client: it
would produce `/app/app/{key}`. The default empty path produces the correct
`/app/{key}`.

Private channel naming:

```text
create returns: inbox.<inbox_token>
subscribe to:   private-inbox.<inbox_token>
```

Authorize the private channel with:

```http
POST https://www.autolikerlive.com/api/tempmail/broadcasting/auth
Content-Type: application/json
X-Firebase-AppCheck: <fresh JWT>

{"socket_id":"<socket id>","channel_name":"private-inbox.<inbox_token>"}
```

The response is `{"auth":"<public_key>:<signature>"}`. Never compute the
signature in the app.

Laravel Echo example:

```js
window.Echo = new Echo({
  broadcaster: 'reverb',
  key: 'u39m9tdnh7w4xhyloikh',
  wsHost: 'www.autolikerlive.com',
  wsPort: 443,
  wssPort: 443,
  forceTLS: true,
  enabledTransports: ['ws', 'wss'],
  authEndpoint: 'https://www.autolikerlive.com/api/tempmail/broadcasting/auth',
  auth: {
    headers: {
      'X-Firebase-AppCheck': appCheckToken,
    },
  },
});
```

Live end-to-end verification on 2026-10-20: a Node WebSocket client connected
to the URL above, subscribed to `private-inbox.<token>` using the auth
endpoint, and received a real `inbox.message` event. The old 404/523 behavior
is fixed.

**Client instruction:** keep polling as a fallback, but WebSocket can be
enabled. If the socket fails or disconnects, keep polling and show a
non-blocking "live updates unavailable" state. Do not reconnect forever.

### 1.3 No background mail sweep is scheduled

The `tempmail:watch` command exists, but there is no `schedule:run` cron entry.
Even after WebSocket is fixed, pushes only happen when some client calls
`get-mail`. The app must poll.

---

## 2. CONFIGURATION

Use these values, but keep them in one config object so they can be changed
without touching logic.

```text
BASE_URL          = https://www.autolikerlive.com
API_PREFIX        = /api/tempmail
WS_HOST           = www.autolikerlive.com
WS_PORT           = 443
WS_SCHEME         = https
WS_APP_KEY        = u39m9tdnh7w4xhyloikh
WS_PATH           = ""                   // Pusher appends /app/{key}
WS_URL            = wss://www.autolikerlive.com/app/u39m9tdnh7w4xhyloikh
WS_ENABLED        = true                 // polling remains the fallback
POLL_INTERVAL     = 10..15 seconds       // foreground only
REQUEST_TIMEOUT   = 30 seconds
```

Never put any of the following in the client:

- Reverb app secret
- Firebase service-account JSON
- Database credentials
- Server-side signing keys

The client only ever needs the **public** `WS_APP_KEY`.
The client never computes the WebSocket auth signature; the server does.

Every HTTP request must send:

```http
Content-Type: application/json
Accept: application/json
X-Firebase-AppCheck: <fresh Firebase App Check token>
```

No `Authorization` header, cookies, CSRF token, `Origin`, or `User-Agent`
requirement exists.

Always send `Accept: application/json`. Without it, framework errors such as
429 can come back as HTML instead of JSON.

---

## 3. REST CONTRACTS

All endpoints are **POST**. Base prefix:

```text
https://www.autolikerlive.com/api/tempmail
```

### 3.1 Create inbox

```http
POST /api/tempmail/create
```

All body fields are optional:

```json
{
  "local_part": "sample.user.ab12c",
  "domain": "emailbox.click",
  "ttl_minutes": 120
}
```

Rules:

- `local_part`: optional, 3–30 chars, lowercase `[a-z0-9._-]`, must start and
  end alphanumeric. Omit to let the server generate a random one.
- `domain`: optional. Omit it and let the server choose a random active domain.
  Do not hardcode the domain list as a permanent contract. Current active
  values for display only: `emailbox.click`, `undelivered.shop`.
- `ttl_minutes`: optional, default **120**, min **5**, max **1440**.

Success is **HTTP 201**:

```json
{
  "success": true,
  "data": {
    "email": "sample.user.ab12c@emailbox.click",
    "inbox_token": "1bdf3bbb2ef211e1bba818429aa0db466f7f011a",
    "expires_at": "2026-10-20T13:27:03+00:00",
    "websocket": {
      "channel": "inbox.1bdf3bbb2ef211e1bba818429aa0db466f7f011a",
      "event": "inbox.message",
      "auth_url": "https://www.autolikerlive.com/api/tempmail/broadcasting/auth"
    }
  }
}
```

Notes:

- `inbox_token` is the mailbox secret: 40 lowercase hex chars.
- Store `email`, `inbox_token`, and `expires_at` in secure storage.
- `expires_at` is ISO8601 with `+00:00`.
- `websocket.channel` is `inbox.<token>`. The client subscribes to
  `private-inbox.<token>` (see section 6).
- `websocket.event` is `inbox.message`.
- `websocket.auth_url` is the full channel-auth URL.

Errors:

- Duplicate address → **409**:
  ```json
  {"success":false,"message":"Address already in use."}
  ```
- Unknown/inactive domain → **422**:
  ```json
  {
    "message": "The selected domain is invalid.",
    "errors": {"domain":["The selected domain is invalid."]}
  }
  ```
- Invalid `local_part` → **422**:
  ```json
  {"success":false,"message":"local_part must be 3-30 chars [a-z0-9._-]]."}
  ```
- TTL out of range → **422**:
  ```json
  {
    "message": "The ttl minutes field must be at least 5.",
    "errors": {"ttl_minutes":["The ttl minutes field must be at least 5."]}
  }
  ```
- No active domains → **503**:
  ```json
  {"success":false,"message":"No temp-mail domains configured."}
  ```

### 3.2 List messages

```http
POST /api/tempmail/get-mail
```

Body — **both fields are required**. It is not only `inbox_token`:

```json
{
  "email": "sample.user.ab12c@emailbox.click",
  "inbox_token": "1bdf3bbb2ef211e1bba818429aa0db466f7f011a"
}
```

Success is **HTTP 200**:

```json
{
  "success": true,
  "data": {
    "status": true,
    "mailbox": "sample.user.ab12c@emailbox.click",
    "email_token": "RjFRcjNLMCswVHptZFZOdFh2TjVIaWE4QUJwbTdWWXJpQVBWR1F5V0FQOGVNc3Nmakdtc3NKVXhCcytBazhmMw",
    "messages": [
      {
        "subject": "Your verification code",
        "from": "Acme Support",
        "from_email": "no-reply@acme.example",
        "to": "sample.user.ab12c@emailbox.click",
        "receivedAt": "2026-10-20 11:02:14",
        "id": "OEwXLe1yPmQlMB94ax0VdVZvYdJrg7A3Y2GRbq6kDKojv",
        "html": true,
        "content": "<!DOCTYPE html><html><body><p>Your code is <b>482913</b>.</p></body></html>",
        "attachments": [],
        "is_seen": true
      },
      {
        "subject": "Your receipt from Acme",
        "from": "Acme Billing",
        "from_email": "billing@acme.example",
        "to": "sample.user.ab12c@emailbox.click",
        "receivedAt": "2026-10-20 11:04:51",
        "id": "VyEeKBPnXMpj91Zwk0gJdq3YjzRDLvx3aQomrYO2WG7bN",
        "html": false,
        "content": "Thanks for your payment.<br/><br/>Receipt: $19.00",
        "attachments": [],
        "is_seen": false
      }
    ]
  }
}
```

Exact field mapping:

| Meaning | Exact field | Notes |
|---|---|---|
| Message id | `id` | 45-char opaque Hashids string |
| Sender name | `from` | may be `null` |
| Sender email | `from_email` | |
| Subject | `subject` | may be empty |
| Preview/snippet | **none** | derive from `content`; truncate client-side |
| Full body | `content` | HTML if `html=true`, otherwise text with `<br/>` |
| Received timestamp | `receivedAt` | `Y-m-d H:i:s`, **UTC**, no offset |
| Unread flag | `is_seen` | `true` = read; unread is `!is_seen` |
| Attachment flag | **none** | `attachments` is always `[]` |
| HTML indicator | `html` | boolean |
| Recipient | `to` | |

There is no `sender`, `sender_email`, `preview`, `snippet`, `received_at`,
`is_read`, or `has_attachments`.

Important behavior:

- **Ordering is not newest-first.** The server returns IMAP ascending UID order
  (oldest first). Sort by `receivedAt` **descending** in the client.
- `receivedAt` has no `Z`/offset but is UTC. Parse it as UTC, not local time.
- `data.status` is a separate boolean; HTTP 200 does not mean IMAP succeeded.
- On IMAP failure, HTTP is still 200 and `success` is still `true`:
  ```json
  {
    "success": true,
    "data": {
      "status": false,
      "mailbox": "Unable to retrieve emails at this time. Please try Again",
      "messages": "Connection failed ...",
      "trace": "#0 ..."
    }
  }
  ```
  In that case `messages` is a **string**, not an array. Show a retry state;
  do not render an empty inbox and do not display `trace`.
- `get-mail` does **not** mark messages read.
- `get-mail` may push newly seen messages to WebSocket subscribers as a side
  effect. That is fine; dedupe by `id`.

### 3.3 Read one message

```http
POST /api/tempmail/message
```

The id key is **`id`**, not `message_id`, and it goes in the JSON body, not the
URL. All three fields are required:

```json
{
  "email": "sample.user.ab12c@emailbox.click",
  "inbox_token": "1bdf3bbb2ef211e1bba818429aa0db466f7f011a",
  "id": "VyEeKBPnXMpj91Zwk0gJdq3YjzRDLvx3aQomrYO2WG7bN"
}
```

Success is **HTTP 200**:

```json
{
  "success": true,
  "data": {
    "subject": "Your receipt from Acme",
    "from": "Acme Billing",
    "from_email": "billing@acme.example",
    "to": "sample.user.ab12c@emailbox.click",
    "receivedAt": "2026-10-20 11:04:51",
    "id": "VyEeKBPnXMpj91Zwk0gJdq3YjzRDLvx3aQomrYO2WG7bN",
    "html": false,
    "content": "Thanks for your payment.<br/><br/>Receipt: $19.00",
    "attachments": []
  }
}
```

Exact fields:

| Meaning | Exact field |
|---|---|
| Full body | `content` |
| HTML body | `content` when `html=true` |
| Plain text body | `content` when `html=false` |
| Subject | `subject` |
| Sender name | `from` |
| Sender email | `from_email` |
| Recipient | `to` |
| Received at | `receivedAt` (`Y-m-d H:i:s`, UTC) |
| Attachments | `attachments` (always `[]`) |
| Message id | `id` |
| HTML indicator | `html` |

There are **no separate** `body`, `body_text`, `body_html`, `received_at`,
`is_read`, `is_seen`, or attachment metadata fields.

Read-state behavior:

- Opening a message marks it read **on the IMAP server**. The server calls
  `setFlag('Seen')` before returning.
- The `/message` response does **not** include the updated read state.
  There is no `is_read`/`is_seen` in this payload.
- After opening, update the local list item to `is_seen = true`, or call
  `get-mail` again and use its `is_seen`.

Missing/expired message behavior — do **not** rely on 404:

- The backend has a dead check for `"no longer exists"` in the subject, but the
  helper returns subject `"Message no longer available"`. A missing message
  therefore returns **HTTP 200** with:
  ```json
  {
    "success": true,
    "data": {
      "subject": "Message no longer available",
      "from": "System",
      "from_email": "system@example.com",
      "to": "",
      "receivedAt": "2026-10-20 11:30:00",
      "id": "VyEeKBPnXMpj91Zwk0gJdq3YjzRDLvx3aQomrYO2WG7bN",
      "html": false,
      "content": "This message no longer exists. It may have expired or been deleted. Temp-mail messages are automatically removed after a few days.",
      "attachments": []
    }
  }
  ```
  Treat `data.subject == "Message no longer available"` as "message gone":
  remove it from the list or refresh the inbox.

### 3.4 Delete inbox

```http
POST /api/tempmail/delete
```

Method is **POST**. There is no DELETE route.

Body:

```json
{
  "email": "sample.user.ab12c@emailbox.click",
  "inbox_token": "1bdf3bbb2ef211e1bba818429aa0db466f7f011a"
}
```

Success is **HTTP 200**:

```json
{"success": true}
```

If the inbox is already expired or deleted, **HTTP 404**:

```json
{"success":false,"message":"Inbox not found or token mismatch."}
```

Treat that 404 as expected on cleanup: clear local storage and stop polling.

Deleting removes the DB row and the WebSocket uid cache, but not the IMAP
messages. Do not promise the user that mail is erased from the mail server.

### 3.5 WebSocket channel authorization

```http
POST /api/tempmail/broadcasting/auth
```

Headers:

```http
Content-Type: application/json
Accept: application/json
X-Firebase-AppCheck: <fresh token>
```

Request body, exact keys:

```json
{
  "socket_id": "123456.789012",
  "channel_name": "private-inbox.1bdf3bbb2ef211e1bba818429aa0db466f7f011a"
}
```

Success is **HTTP 200**:

```json
{
  "auth": "u39m9tdnh7w4xhyloikh:494fbcb6b2ee042c9d309f252919924258cae3ba0cfe88d1ed0fb99444c8dd9e"
}
```

Rules:

- `socket_id` must be the id from the live Pusher/Reverb connection.
- `channel_name` must start with `private-inbox.`. Sending the raw
  `inbox.<token>` fails validation.
- The response has only `auth`. There is no `channel_data`.
- The client never computes this signature; the server signs it.
- If the library supports a custom authorizer, wire it to this endpoint and
  return the `auth` value.
- A dead/expired inbox returns **403**. Live, because `APP_DEBUG=true`, the
  body is `{"message":"Unknown or expired inbox.", "exception":"...", "file":"...", "line":1277, "trace":[...]}`.
  The stable contract is `{"message":"Unknown or expired inbox."}`.
- Do not call the default Laravel `/broadcasting/auth`; it is not registered.

---

## 4. ERROR CONTRACT

There is **no single error envelope**. Handle all of these:

1. App Check middleware:
   ```json
   {"error":"..."}
   ```
2. Controller-owned errors:
   ```json
   {"success":false,"message":"..."}
   ```
   or
   ```json
   {"success":false,"message":{"field":["..."]}}
   ```
3. Framework validation:
   ```json
   {"message":"...","errors":{"field":["..."]}}
   ```
4. Framework abort/throttle with `APP_DEBUG=true`:
   ```json
   {"message":"...","exception":"...","file":"...","line":123,"trace":[...]}
   ```

Minimum mapping:

| Status | Meaning | Client behavior |
|---|---|---|
| 401 | Missing/invalid App Check header | Refresh App Check token once, retry once, then show backend-config error |
| 403 | App Check rejected, or dead channel on auth | Same as 401 for REST; for WS, stop reconnect loop and fall back to polling |
| 404 | Inbox expired/deleted/token mismatch | Clear local inbox state, prompt for a new inbox |
| 409 | Duplicate address on create | Generate a new local part or show a clear message |
| 422 | Validation/domain/local_part/TTL | Show field-level message if present; do not blind-retry |
| 429 | 60 req/min exceeded | Respect `Retry-After`; exponential backoff; never parallel-poll |
| 503 | No domains or WS not configured | Show service-unavailable state |

Exact 401/403 bodies:

```json
{"error":"Invalid request taken"}
```

```json
{"error":"Unknown Invalid request taken"}
```

Exact 404/409 bodies:

```json
{"success":false,"message":"Inbox not found or token mismatch."}
```

```json
{"success":false,"message":"Address already in use."}
```

Exact 422 missing-fields examples:

```json
{
  "success": false,
  "message": {
    "email": ["The email field is required."],
    "inbox_token": ["The inbox token field is required."]
  }
}
```

```json
{
  "success": false,
  "message": {
    "id": ["The id field is required."]
  }
}
```

```json
{
  "message": "The socket id field is required.",
  "errors": {"socket_id":["The socket id field is required."]}
}
```

429 starts with:

```json
{
  "message": "Too Many Attempts.",
  "exception": "Illuminate\\Http\\Exceptions\\ThrottleRequestsException",
  "file": "/home/autolikerlive/laravel/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php",
  "line": 232,
  "trace": ["..."]
}
```

Do not display `exception`, `file`, `line`, or `trace` to users.

Rate limit: **60 requests/minute per client IP**, not per app instance.
Use one serialized refresh loop; do not fire parallel `get-mail` calls.
Recommended foreground poll: every 10–15 seconds (well under 60/min).
Stop polling when the app is backgrounded; refresh on resume.

CORS/platform:

- `Access-Control-Allow-Origin: *`, methods `*`, headers `*`, no credentials.
- No `Origin`, `User-Agent`, platform, device, or app-version header required.
- No IP allowlist.
- Native mobile clients are unaffected by CORS.

---

## 5. CLIENT BEHAVIOR REQUIREMENTS

### 5.1 Local state

Persist:

```text
email
inbox_token
expires_at
```

Use Keychain / EncryptedSharedPreferences / secure storage.
Never log `inbox_token` or full message content.
Never put `inbox_token` in a URL or analytics event.

On app start:

- If `expires_at` is in the future, resume the inbox and call `get-mail`.
- If expired, clear state and prompt for a new inbox.
- Do not call `/delete` for an expired inbox; it will 404. Clear locally.

### 5.2 Message list

- Merge by `id`; never duplicate rows.
- Sort by `receivedAt` descending.
- `is_seen = true` means read; unread badge is `!is_seen`.
- Sender display: `from` if non-null/non-empty, otherwise `from_email`,
  otherwise `"(unknown sender)"`.
- Subject display: `subject` if non-empty, otherwise `"(no subject)"`.
- Preview: derive from `content` by stripping HTML/truncating. There is no
  server-side preview field.
- Do not show an attachment icon based on `attachments`; it is always `[]`.
  Attachment support is not implemented in the API.
- Treat `data.status == false` as an error/retry state, not an empty inbox.
- If `messages` is not an array, do not iterate it.

### 5.3 Opening a message

- Call `/message` only when the user actually opens a message.
- Do **not** call `/message` just to render list previews: it marks the
  message read on the server.
- If the WebSocket event arrives, do not call `/message` automatically for the
  same reason. Either:
  - call `get-mail` to refresh the full list (does not mark read), or
  - insert a metadata-only row and fetch content when the user taps it.
- After opening, set local `is_seen = true` immediately and/or refresh via
  `get-mail`.
- Render `content` according to `html`:
  - `html=true`: treat as untrusted HTML. Use a sanitized WebView or an HTML
    sanitizer. Disable JavaScript. Do not inject raw email HTML into a
    privileged context.
  - `html=false`: render as text/HTML; the server may already contain `<br/>`.
- If the response is the `"Message no longer available"` placeholder, treat it
  as gone and refresh the list.

### 5.4 Creating a mailbox

- Send `{}` to let the server pick `local_part`, `domain`, and default TTL.
- If the UI offers a custom address, enforce 3–30 chars, `[a-z0-9._-]`,
  start/end alphanumeric.
- If the UI offers a domain picker, only offer currently active domains and
  accept 422 if the list is stale.
- If the UI offers TTL, clamp to 5–1440; default 120.
- On 201, store the response and immediately call `get-mail` once.
- On 409, do not loop with the same local part.

### 5.5 Deleting a mailbox

- POST `/delete` with `email` + `inbox_token`.
- On 200, clear local state, stop polling, and disconnect WebSocket.
- On 404, clear local state anyway.
- Do not use HTTP DELETE.

### 5.6 Polling

- Default refresh path: `get-mail` every 10–15 seconds while foregrounded.
- Stop on background; refresh immediately on resume.
- Use a single in-flight request; coalesce refreshes.
- On 429, wait at least `Retry-After` (or 60 seconds) and back off.
- On 5xx/network error, back off exponentially, cap at ~60 seconds.
- On 401/403, refresh App Check once; if still failing, stop automatic retries
  and show the backend-config diagnostic.

---

## 6. WEBSOCKET BEHAVIOR (LIVE, WITH POLLING FALLBACK)

Enable with `TEMPMAIL_WS_ENABLED=true`; the public `WS_URL` is supplied above.
Use a **Pusher-protocol-compatible** client (Reverb speaks Pusher protocol),
not a bare WebSocket unless you implement the protocol yourself.

### 6.1 Connection

```text
URL:    wss://www.autolikerlive.com/app/u39m9tdnh7w4xhyloikh
Port:   443
TLS:    required for production
Key:    u39m9tdnh7w4xhyloikh
wsPath: "" (omit; Pusher appends /app/{key})
```

Do **not** use `localhost`, `127.0.0.1`, `ws://`, or port `8080` in a shipped
mobile app. Reverb listens internally on `127.0.0.1:8080`; devices must use
`wss://www.autolikerlive.com` on port `443`. The path must remain
`/app/<key>`.

If the backend later exposes a dedicated host, use that host with `wss` on 443.
The path must remain `/app/<key>`.

### 6.2 Channel

Create returns:

```json
"channel": "inbox.<inbox_token>"
```

Subscribe to:

```text
private-inbox.<inbox_token>
```

The `private-` prefix is required. The auth endpoint only accepts
`private-inbox.`.

### 6.3 Authorization

Use the `auth_url` returned by `create`, or:

```text
https://www.autolikerlive.com/api/tempmail/broadcasting/auth
```

Send:

```json
{
  "socket_id": "<socket id from the live connection>",
  "channel_name": "private-inbox.<inbox_token>"
}
```

With headers:

```http
Content-Type: application/json
Accept: application/json
X-Firebase-AppCheck: <fresh token>
```

Return the response's `auth` value to the Pusher client. Do not add
`channel_data`. Do not sign anything client-side.

On 403, the channel is dead/expired; stop retrying and fall back to polling.
On 429, back off.
On 401, refresh App Check once.

### 6.4 Event handling

Event name exactly:

```text
inbox.message
```

Inner payload:

```json
{
  "id": "VyEeKBPnXMpj91Zwk0gJdq3YjzRDLvx3aQomrYO2WG7bN",
  "email": "sample.user.ab12c@emailbox.click",
  "from": "Acme Billing",
  "from_email": "billing@acme.example",
  "subject": "Your receipt from Acme",
  "receivedAt": "2026-10-20 11:04:51",
  "html": false
}
```

Pusher frame:

```json
{
  "event": "inbox.message",
  "channel": "private-inbox.1bdf3bbb2ef211e1bba818429aa0db466f7f011a",
  "data": "{\"id\":\"VyEeKBPnXMpj91Zwk0gJdq3YjzRDLvx3aQomrYO2WG7bN\",\"email\":\"sample.user.ab12c@emailbox.click\",\"from\":\"Acme Billing\",\"from_email\":\"billing@acme.example\",\"subject\":\"Your receipt from Acme\",\"receivedAt\":\"2026-10-20 11:04:51\",\"html\":false}"
}
```

Rules:

- `data` may be a JSON string; parse it.
- The event contains only metadata. It has no `content`, `to`, `attachments`,
  or `is_seen`.
- Do not call `/message` on receipt; that marks the message read.
- Best behavior: on event, trigger a `get-mail` refresh (does not mark read),
  or insert a metadata-only row and fetch on tap.
- Deduplicate by `id`.
- Ignore `pusher:*` control events for the message list.
- On reconnect/resume, always call `get-mail` to reconcile missed events.
- Reconnect with exponential backoff. Stop after repeated auth failures and
  fall back to polling.

---

## 7. TESTS / ACCEPTANCE CRITERIA

Write unit tests with fixtures for:

1. `create` 201 → parses `email`, `inbox_token`, `expires_at`,
   `websocket.channel`, `websocket.event`, `websocket.auth_url`.
2. `create` 409, 422 (domain/local_part/TTL), 503.
3. `get-mail` 200 with 2 messages → list sorted newest-first, `is_seen`
   mapped to read state, `from` null fallback.
4. `get-mail` 200 with `data.status=false` and `messages` as a string → error
   state, no crash.
5. `get-mail` 404 → clear inbox state.
6. `message` 200 → renders HTML/text correctly, no read-state field assumed.
7. `message` 200 `"Message no longer available"` → treated as gone.
8. `message` 422 missing `id` → field error.
9. `delete` 200 → clears state; `delete` 404 → clears state.
10. 401/403 App Check → refresh once, then diagnostic; no infinite loop.
11. 429 → `Retry-After`/60s backoff; no parallel polling.
12. WebSocket auth request uses `socket_id` + `private-inbox.<token>` and
    sends App Check; parses `{"auth":"..."}`.
13. `inbox.message` payload parses; no body assumed; dedupe by `id`.
14. WebSocket disabled → polling still works.
15. Expired `expires_at` → prompt new inbox, stop polling.

Definition of done:

- No API call is missing the App Check header.
- No secret is in the app bundle.
- No production mock data.
- All timestamps parsed as UTC.
- Message list is sorted newest-first.
- Opening a message is the only action that marks it read.
- WebSocket is optional and cannot break the inbox when unavailable.
- 429 and 403 do not cause retry storms.
- `BACKEND_BLOCKERS.md` documents the live issues in section 12.

---

## 8. DO NOT DO

- Do not use `GET` for any TempMail endpoint.
- Do not use `DELETE /api/tempmail/delete`.
- Do not send `message_id`; the key is `id`.
- Do not put the message id in the URL.
- Do not send only `inbox_token` to `get-mail`; `email` is required.
- Do not subscribe to `inbox.<token>` directly; use `private-inbox.<token>`.
- Do not call `/message` to render previews.
- Do not assume `receivedAt` is ISO8601; it is `Y-m-d H:i:s` UTC.
- Do not assume messages are newest-first.
- Do not assume `attachments` contains data.
- Do not assume a single `{"success":false,"error":"..."}` envelope.
- Do not show `trace`/`exception`/`file`/`line` to users.
- Do not hardcode or ship the Firebase debug token.
- Do not compute the WebSocket signature in the app.
- Do not ship the Reverb app secret.
- Do not use `ws://` or port 8080 in production.
- Do not call the legacy `GET /api/tempmail/auth-test` endpoint.

---

## 9. BACKEND ISSUES TO REPORT (DO NOT FIX FROM THE APP)

App Check and Reverb are now configured and were verified live; they are
**not** blockers. The remaining backend issues are:

1. **No scheduled mail sweep.** `tempmail:watch` exists but is not in cron.
2. **`APP_DEBUG=true` in production** leaks stack traces in 403/429 responses.
3. **`/message` does not verify the message belongs to the supplied mailbox.**
   It checks the inbox token, then fetches an arbitrary IMAP UID. Message ids
   are reversible Hashids with a hard-coded salt. This is a multi-tenant
   isolation bug; the app cannot fix it.
4. **Attachments are not implemented.** `attachments` is always `[]`; the
   attachment handler is commented out.
5. **The `/message` 404 check is dead code.** Missing messages return 200 with
   the `"Message no longer available"` placeholder.
6. **`get-mail` can leak a stack trace** in `data.trace` when IMAP fails.

Server-side notes (for the backend owner, not the app):

- The App Check service-account JSON lives at
  `storage/app/firebase/service-account.json` and must stay outside `public/`.
  If it is rotated, update `FIREBASE_CREDENTIALS` and clear the Laravel config
  cache. Never expose the file or its private key to the app.
- Reverb runs as the systemd unit `reverb.service`, listens only on
  `127.0.0.1:8080`, and is exposed by Nginx only at the exact public path
  `/app/u39m9tdnh7w4xhyloikh`. Do not expose port 8080 publicly.

WebSocket is live, but the app should still keep polling as a fallback:
- show a non-blocking "live updates unavailable" state on socket failure,
- refresh App Check once on 401/403,
- do not reconnect forever.

---

## 10. FINAL INSTRUCTION TO THE APP AI

Implement the client exactly as specified. Do not simplify the error model.
Do not fake success. Do not hide the backend blockers. When a contract is
ambiguous, stop and report it rather than inventing a field. When finished,
output:

1. The files changed/created.
2. The test results.
3. A short list of any contract items you could not implement.
4. The contents of `BACKEND_BLOCKERS.md`.
