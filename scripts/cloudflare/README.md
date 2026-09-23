# Cloudflare bypass for `/admin*` + `/phpmineradmin*` (+ `/app/*` WebView)

## Important concept (read first)

Cloudflare **proxy on/off (orange/grey cloud) is per DNS record, not per URL
path**. You **cannot** set "bypass proxy only for `/admin`" on the same
hostname `www.autolikerlive.com`.

So there are two layers:

| Goal | How |
|---|---|
| True "not through Cloudflare proxy" | Separate **DNS-only (grey cloud)** hostname, e.g. `direct.autolikerlive.com` → `13.140.190.176`. Use it for admin + phpmineradmin. |
| Same hostname but Cloudflare must not cache / break admin | **Cache Rule: Bypass cache** + **Configuration Rule: disable performance** for the path expressions below. Traffic still passes Cloudflare, but is `cf-cache-status: DYNAMIC`, no minify/rocket-loader. |

This repo already does the origin side:
- `app/Http/Middleware/BypassCloudflareCache.php` sends
  `Cache-Control: no-store` + `CDN-Cache-Control: no-store` +
  `Cloudflare-CDN-Cache-Control: no-store` for `/admin*`, `/app/*`,
  `/phpmineradmin*`, `/session/*`.
- nginx `autolikerlive.com.conf` sends the same headers for
  `^~ /phpmineradmin/`, `^~ /admin`, `^~ /app/`.
- `AppController@rajeliker` sends no-store + detects Android WebView.

Verify live: `cf-cache-status` should be `DYNAMIC`, never `HIT`:
`curl -sI https://www.autolikerlive.com/app/rajeliker | grep -i cf-cache`

## Option A — Dashboard (fastest, recommended)

1. **Cache Rule** — Caching → Cache Rules → Create rule:
   - Name: `bypass-admin-phpmineradmin`
   - Expression (custom):
     ```
     (http.request.uri.path wildcard r"/admin*" or http.request.uri.path wildcard r"/phpmineradmin*" or http.request.uri.path wildcard r"/app/*" or http.request.uri.path wildcard r"/session/*")
     ```
   - Action: **Bypass cache**
   - Deploy, place first.

2. **Configuration Rule** — Rules → Configuration Rules → Create rule:
   - Same expression as above.
   - Disable: Auto Minify (all), Rocket Loader, Mirage, Polish,
     `Browser Integrity Check` OFF only if the Android WebView gets
     challenged (RajeLiker is a WebView page — Bot Fight Mode /
     Turnstile challenges break `flutter_inappwebview`).
   - Do NOT disable WAF globally; if admin gets 403s, add a targeted
     WAF skip for your office IP + `direct` hostname instead.

3. **True proxy bypass (DNS-only)** — DNS → Records → Add:
   - Type `A`, Name `direct`, Content `13.140.190.176`, Proxy **OFF**
     (grey cloud), TTL Auto.
   - Use `https://direct.autolikerlive.com/phpmineradmin/` and
     `https://direct.autolikerlive.com/admin` for admin work.
   - Nginx already serves all hosts on this box; no vhost change needed.
     The canonical-host redirect in nginx only triggers for non-www hosts
     except acme/autoconfig — add `direct.autolikerlive.com` to that
     allow-list if you want to keep it non-redirected (or just accept the
     redirect to www for normal traffic and use `direct` only for admin).

## Option B — API script

Needs a token with `Zone / Cache Rules:Edit`, `Zone / Config Rules:Edit`,
`Zone / DNS:Edit` and the zone id:

```bash
export CF_API_TOKEN=xxxx   # NOT the worker key in .env (CLOUDFLARE_WORKER_API_KEY)
export CF_ZONE_ID=xxxx     # Dashboard → domain → Overview → Zone ID
bash scripts/cloudflare/cloudflare-bypass-admin.sh
```

The script is idempotent: it lists existing `http_request_cache_settings`
phases, creates the ruleset if missing, and upserts the bypass rule.
DNS record creation for `direct` is printed as a manual step (safe default).
