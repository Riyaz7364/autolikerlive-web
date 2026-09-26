@props(['placement' => 'tiktok_views', 'variant' => 'full'])

@php
try {
    $promos = \App\Models\Promotion::activeFor($placement);
} catch (\Throwable $e) {
    $promos = collect();
}
$themeOf = function ($promo) {
    $t = strtolower(trim($promo->theme ?? 'default'));
    if (!in_array($t, ['fb', 'instagram'], true)) {
        // auto-detect from URL when theme left as default
        $url = strtolower($promo->button_url ?? '');
        if (str_contains($url, 'instagram') || str_contains($url, 'insta')) return 'instagram';
        if (str_contains($url, 'rajeliker') || str_contains($url, '/app/')) return 'fb';
    }
    return in_array($t, ['fb', 'instagram'], true) ? $t : 'default';
};
$shortOf = function ($promo) {
    if (!empty($promo->short_name)) return $promo->short_name;
    $url = strtolower($promo->button_url ?? '');
    if (str_contains($url, 'instagram') || str_contains($url, 'insta')) return 'InstaLiker';
    if (str_contains($url, 'rajeliker')) return 'RajeLiker';
    return \Illuminate\Support\Str::limit($promo->title ?? 'App', 22, '');
};
@endphp

@if($promos->count())
<style>
.promo-banner{max-width:680px;margin:0 auto 12px;width:100%;border-radius:20px;overflow:hidden;position:relative;color:#fff}
.promo-theme-default{background:linear-gradient(135deg,#1a0b2e 0%,#2d1b4e 40%,#4c1d95 70%,#831843 100%);
  border:1px solid rgba(168,85,247,.35);box-shadow:0 14px 40px rgba(124,58,237,.35)}
.promo-theme-fb{background:linear-gradient(135deg,#0a2a5e 0%,#0d47a1 45%,#1877F2 100%);
  border:1px solid rgba(147,197,253,.45);box-shadow:0 14px 40px rgba(24,119,242,.35)}
.promo-theme-instagram{background:linear-gradient(135deg,#4c1d95 0%,#833AB4 35%,#FD1D1D 70%,#FCB045 100%);
  border:1px solid rgba(253,29,29,.4);box-shadow:0 14px 40px rgba(131,58,180,.4)}
.promo-banner::before{content:'';position:absolute;width:340px;height:340px;left:-110px;top:-130px;
  background:radial-gradient(closest-side,rgba(255,255,255,.22),transparent 70%);pointer-events:none}
.promo-banner-inner{padding:22px 22px 20px;position:relative;z-index:1}
.promo-badge{display:inline-flex;align-items:center;gap:6px;background:#f59e0b;color:#111;font-size:11px;font-weight:800;
  letter-spacing:.08em;padding:5px 11px;border-radius:999px;margin-bottom:10px}
.promo-title{font-size:clamp(18px,3vw,23px);font-weight:800;line-height:1.25;margin:0 0 6px}
.promo-sub{font-size:14px;color:rgba(255,255,255,.85);margin:0 0 14px;line-height:1.55}
.promo-row{display:flex;gap:12px;align-items:center}
.promo-icon{width:52px;height:52px;border-radius:15px;flex-shrink:0;background:#fff;display:grid;place-items:center;
  font-size:26px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,.3)}
.promo-icon img{width:100%;height:100%;object-fit:cover}
.promo-btn{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:8px;font-weight:800;font-size:15px;
  padding:13px 20px;border-radius:14px;transition:.2s;white-space:nowrap;text-decoration:none}
.promo-theme-default .promo-btn{background:#fff;color:#6d28d9}
.promo-theme-default .promo-btn:hover{background:#f5f3ff;color:#5b21b6;transform:translateY(-1px)}
.promo-theme-fb .promo-btn{background:#fff;color:#0d47a1}
.promo-theme-fb .promo-btn:hover{background:#e8f0fe;transform:translateY(-1px)}
.promo-theme-instagram .promo-btn{background:#fff;color:#c13584}
.promo-theme-instagram .promo-btn:hover{background:#fdf2f8;transform:translateY(-1px)}
.promo-close{position:absolute;top:8px;right:10px;z-index:2;background:rgba(255,255,255,.15);border:0;color:#fff;
  width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:15px;line-height:1}
.promo-close:hover{background:rgba(255,255,255,.3)}
.promo-meta{font-size:11px;color:rgba(255,255,255,.75);margin-top:10px;text-align:center}
@media(max-width:520px){.promo-row{flex-direction:column}.promo-btn{width:100%}}
/* ---- compact sidebar variant: icon + name + Install ---- */
.promo-compact{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:14px;color:#fff;position:relative;margin-bottom:10px}
.promo-compact-icon{width:40px;height:40px;border-radius:11px;flex-shrink:0;background:#fff;display:grid;place-items:center;
  font-size:22px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.25)}
.promo-compact-icon img{width:100%;height:100%;object-fit:cover}
.promo-compact-name{flex:1;min-width:0;font-weight:800;font-size:14px;line-height:1.3}
.promo-compact-name small{display:block;font-weight:500;font-size:11px;opacity:.8}
.promo-compact-btn{flex-shrink:0;background:#fff;font-weight:800;font-size:14px;padding:12px 20px;border-radius:10px;text-decoration:none;min-height:44px;display:inline-flex;align-items:center}
.promo-theme-default .promo-compact-btn{color:#6d28d9}
.promo-theme-fb .promo-compact-btn{color:#0d47a1}
.promo-theme-instagram .promo-compact-btn{color:#c13584}
.promo-compact-close{position:absolute;top:2px;right:4px;background:transparent;border:0;color:rgba(255,255,255,.7);
  width:32px;height:32px;font-size:14px;cursor:pointer;line-height:1;padding:0}
.promo-compact-close:hover{color:#fff}
</style>

@if($variant === 'compact')
    @foreach($promos as $promo)
    @php $th = $themeOf($promo); @endphp
    <div class="promo-banner promo-compact promo-theme-{{ $th }}" id="promo-banner-{{ $promo->id }}" role="complementary" aria-label="Promotion: {{ $shortOf($promo) }}">
        <button class="promo-compact-close" aria-label="Dismiss" onclick="promoDismiss({{ $promo->id }})">✕</button>
        <div class="promo-compact-icon" aria-hidden="true">
            @if($promo->image_url)
                <img src="{{ $promo->image_url }}" alt="" loading="lazy">
            @else
                {{ $promo->emoji ?? ($th === 'fb' ? '👍' : '📸') }}
            @endif
        </div>
        <div class="promo-compact-name">{{ $shortOf($promo) }}<small>Free APK</small></div>
        <a href="{{ $promo->button_url }}" class="promo-compact-btn">⬇ Install</a>
    </div>
    <script>
    (function(){try{var k='promo_dismiss_{{ $promo->id }}';var ts=parseInt(localStorage.getItem(k)||'0',10);if(ts&&Date.now()-ts<36e5){var el=document.getElementById('promo-banner-{{ $promo->id }}');if(el)el.remove();}else if(ts){localStorage.removeItem(k);}}catch(e){}})();
    </script>
    @endforeach
@else
    @foreach($promos as $promo)
    @php $th = $themeOf($promo); @endphp
    <div class="promo-banner promo-theme-{{ $th }}" id="promo-banner-{{ $promo->id }}" role="complementary" aria-label="Promotion: {{ $promo->title }}">
        <button class="promo-close" aria-label="Dismiss" onclick="promoDismiss({{ $promo->id }})">✕</button>
        <div class="promo-banner-inner">
            @if($promo->badge_text)
            <span class="promo-badge">✨ {{ strtoupper($promo->badge_text) }}</span>
            @endif
            <div class="promo-row">
                <div class="promo-icon" aria-hidden="true">
                    @if($promo->image_url)
                        <img src="{{ $promo->image_url }}" alt="" loading="lazy">
                    @else
                        {{ $promo->emoji ?? ($th === 'fb' ? '👍' : '📸') }}
                    @endif
                </div>
                <div style="flex:1;min-width:0">
                    <p class="promo-title">{{ $promo->title }}</p>
                    @if($promo->subtitle)
                    <p class="promo-sub">{{ $promo->subtitle }}</p>
                    @endif
                </div>
            </div>
            <a href="{{ $promo->button_url }}" class="promo-btn" style="margin-top:14px;width:100%">
                ⬇ {{ $promo->button_text }} →
            </a>
            <div class="promo-meta">Free · Android APK · 🔒 Secure download from autolikerlive.com</div>
        </div>
    </div>
    <script>
    (function(){try{var k='promo_dismiss_{{ $promo->id }}';var ts=parseInt(localStorage.getItem(k)||'0',10);if(ts&&Date.now()-ts<36e5){var el=document.getElementById('promo-banner-{{ $promo->id }}');if(el)el.remove();}else if(ts){localStorage.removeItem(k);}}catch(e){}})();
    </script>
    @endforeach
@endif
<script>
function promoDismiss(id){try{var el=document.getElementById('promo-banner-'+id);if(el)el.remove();localStorage.setItem('promo_dismiss_'+id,String(Date.now()));}catch(e){}}
</script>
@endif
