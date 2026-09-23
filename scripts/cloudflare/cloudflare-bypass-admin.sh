#!/usr/bin/env bash
# Upsert Cloudflare Cache Rule: bypass cache for /admin*, /phpmineradmin*,
# /app/* (RajeLiker Android WebView), /session/*.
#
# Usage:
#   CF_API_TOKEN=xxx CF_ZONE_ID=xxx bash scripts/cloudflare/cloudflare-bypass-admin.sh
#
# Notes:
# - Proxy on/off is per DNS record, not per path. This rule keeps traffic
#   DYNAMIC (uncached) on the proxied hostname. For a true non-proxied path,
#   create DNS-only A record `direct` -> origin IP (see README.md).
# - Requires: curl, jq (jq optional; script falls back to python3).
set -euo pipefail

: "${CF_API_TOKEN:?Set CF_API_TOKEN (Zone Cache Rules:Edit token)}"
: "${CF_ZONE_ID:?Set CF_ZONE_ID (Dashboard > domain > Overview > Zone ID)}"

API="https://api.cloudflare.com/client/v4"
AUTH=(-H "Authorization: Bearer ${CF_API_TOKEN}" -H "Content-Type: application/json")

RULE_NAME="bypass-admin-phpmineradmin"
EXPRESSION='(http.request.uri.path wildcard r"/admin*" or http.request.uri.path wildcard r"/phpmineradmin*" or http.request.uri.path wildcard r"/app/*" or http.request.uri.path wildcard r"/session/*")'

echo "==> Fetching existing cache rulesets for zone ${CF_ZONE_ID}"
PHASES_JSON=$(curl -s "${AUTH[@]}" "${API}/zones/${CF_ZONE_ID}/rulesets?per_page=50")

have_jq=0
command -v jq >/dev/null 2>&1 && have_jq=1

if [ "$have_jq" = "1" ]; then
  echo "$PHASES_JSON" | jq -r '.result[]? | "\(.phase) \(.id) \(.name)"' | head -n 20 || true
  CACHE_ID=$(echo "$PHASES_JSON" | jq -r '.result[]? | select(.phase=="http_request_cache_settings") | .id' | head -n 1)
else
  echo "$PHASES_JSON" | head -c 2000; echo
  CACHE_ID=$(python3 -c "import json,sys; d=json.load(open('/dev/stdin'))" 2>/dev/null || echo "")
fi

RULE_PAYLOAD=$(jq -n \
  --arg expr "$EXPRESSION" \
  --arg desc "${RULE_NAME}: admin + phpmineradmin + app WebView never cached" \
  '{action: "set_cache_settings", action_parameters: {cache: false}, expression: $expr, description: $desc, enabled: true}')

if [ -z "${CACHE_ID:-}" ] || [ "${CACHE_ID}" = "null" ]; then
  echo "==> No http_request_cache_settings ruleset; creating one with the bypass rule"
  CREATE_PAYLOAD=$(jq -n --argjson rule "$RULE_PAYLOAD" \
    '{name: "Cache bypass for admin paths", kind: "zone", phase: "http_request_cache_settings", rules: [$rule]}')
  curl -s "${AUTH[@]}" -X POST "${API}/zones/${CF_ZONE_ID}/rulesets" \
    -d "$CREATE_PAYLOAD" | (command -v jq >/dev/null && jq '.' || head -c 3000)
else
  echo "==> Ruleset exists (${CACHE_ID}); appending/updating rule (preserving other rules)"
  # Fetch current rules, drop any rule with same description prefix, append ours.
  CURRENT=$(curl -s "${AUTH[@]}" "${API}/zones/${CF_ZONE_ID}/rulesets/${CACHE_ID}")
  if [ "$have_jq" = "1" ]; then
    echo "$CURRENT" | jq -r '.result.rules[]? | "\(.description)"' | head -n 20 || true
    NEW_RULES=$(echo "$CURRENT" | jq --argjson r "$RULE_PAYLOAD" --arg n "$RULE_NAME" \
      '(.result.rules // []) | map(select(((.description // "") | startswith($n)) | not)) + [$r]')
    UPDATE_PAYLOAD=$(jq -n --argjson rules "$NEW_RULES" '{rules: $rules}')
    curl -s "${AUTH[@]}" -X PUT "${API}/zones/${CF_ZONE_ID}/rulesets/${CACHE_ID}" \
      -d "$UPDATE_PAYLOAD" | jq '{success, errors, messages, result: (.result.rules | map({description, expression, action, enabled}))}'
  else
    echo "jq is required for safe update. Install jq and re-run."
    exit 1
  fi
fi

echo ""
echo "Done. Verify:"
echo "  curl -sI https://www.autolikerlive.com/app/rajeliker | grep -i cf-cache"
echo "  curl -sI https://www.autolikerlive.com/phpmineradmin/ | grep -i cf-cache"
echo "Expected: cf-cache-status: DYNAMIC (never HIT) for those paths."
echo ""
echo "For TRUE proxy bypass, add DNS-only record:"
echo "  Type A, Name direct, Content <origin IP>, Proxy OFF (grey cloud)"
