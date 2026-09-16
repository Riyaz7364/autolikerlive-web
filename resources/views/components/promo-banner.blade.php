@props(['placement' => 'tiktok_views'])

@php
try {
    $promos = \App\Models\Promotion::activeFor($placement);
} catch (\Throwable $e) {
    $promos = collect();
}
@endphp

@if($promos->count())
<style>
.promo-banner{max-width:680px;margin:0 auto;width:100%;border-radius:20px;overflow:hidden;position:relative;
  background:linear-gradient(135deg,#1a0b2e 0%,#2d1b4e 40%,#4c1d95 70%,#831843 100%);
  border:1px solid rgba(168,85,247,.35);box-shadow:0 14px 40px rgba(124,58,237,.35);color:#fff}
.promo-banner-inner{padding:22px 22px 20px;position:relative;z-index:1}
.promo-banner::before{content:'';position:absolute;width:340px;height:340px;left:-110px;top:-130px;
  background:radial-gradient(closest-side,rgba(249,115,22,.45),transparent 70%);pointer-events:none}
.promo-banner::after{content:'';position:absolute;width:340px;height:340px;right:-110px;bottom:-150px;
  background:radial-gradient(closest-side,rgba(37,244,238,.28),transparent 70%);pointer-events:none}
.promo-badge{display:inline-flex;align-items:center;gap:6px;background:#f59e0b;color:#111;font-size:11px;font-weight:800;
  letter-spacing:.08em;padding:5px 11px;border-radius:999px;margin-bottom:10px}
.promo-title{font-size:clamp(18px,3vw,23px);font-weight:800;line-height:1.25;margin:0 0 6px}
.promo-sub{font-size:14px;color:#e9d5ff;margin:0 0 14px;line-height:1.55}
.promo-row{display:flex;gap:12px;align-items:center}
.promo-icon{width:52px;height:52px;border-radius:15px;flex-shrink:0;background:#fff;display:grid;place-items:center;
  font-size:26px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,.3)}
.promo-icon img{width:100%;height:100%;object-fit:cover}
.promo-btn{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#fff;color:#6d28d9;
  font-weight:800;font-size:15px;padding:13px 20px;border-radius:14px;transition:.2s;white-space:nowrap}
.promo-btn:hover{background:#f5f3ff;color:#5b21b6;text-decoration:none;transform:translateY(-1px)}
.promo-close{position:absolute;top:10px;right:12px;z-index:2;background:rgba(255,255,255,.15);border:0;color:#fff;
  width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:15px;line-height:1}
.promo-close:hover{background:rgba(255,255,255,.3)}
.promo-meta{font-size:11px;color:#c4b5fd;margin-top:10px;text-align:center}
@media(max-width:520px){.promo-row{flex-direction:column}.promo-btn{width:100%}}
</style>

@foreach($promos as $promo)
<div class="promo-banner" id="promo-banner-{{ $promo->id }}" role="complementary" aria-label="Promotion: {{ $promo->title }}">
    <button class="promo-close" aria-label="Dismiss" onclick="document.getElementById('promo-banner-{{ $promo->id }}').remove();try{localStorage.setItem('promo_dismiss_{{ $promo->id }}','1')}catch(e){}">✕</button>
    <div class="promo-banner-inner">
        @if($promo->badge_text)
        <span class="promo-badge">✨ {{ strtoupper($promo->badge_text) }}</span>
        @endif
        <div class="promo-row">
            <div class="promo-icon" aria-hidden="true">
                @if($promo->image_url)
                    <img src="{{ $promo->image_url }}" alt="" loading="lazy">
                @else
                    {{ $promo->emoji ?? '📸' }}
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
            {{ $promo->emoji ?? '📸' }} {{ $promo->button_text }} →
        </a>
        <div class="promo-meta">Free · Android APK · 🔒 Secure download from autolikerlive.com</div>
    </div>
</div>
<script>
(function(){try{if(localStorage.getItem('promo_dismiss_{{ $promo->id }}')==='1'){var el=document.getElementById('promo-banner-{{ $promo->id }}');if(el)el.remove();}}catch(e){}})();
</script>
@endforeach
@endif
