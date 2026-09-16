@props(['placement' => 'fb_1000_likes', 'delayMs' => 3500])

@php
try {
    $popups = \App\Models\Promotion::activeFor($placement);
} catch (\Throwable $e) {
    $popups = collect();
}
$promoData = [];
foreach ($popups as $pp) {
    $t = strtolower(trim($pp->theme ?? 'default'));
    if (!in_array($t, ['fb', 'instagram'], true)) {
        $u = strtolower($pp->button_url ?? '');
        if (str_contains($u, 'instagram') || str_contains($u, 'insta')) $t = 'instagram';
        elseif (str_contains($u, 'rajeliker') || str_contains($u, '/app/')) $t = 'fb';
        else $t = 'default';
    }
    $promoData[] = [
        'id' => $pp->id,
        'badge' => $pp->badge_text,
        'title' => $pp->title,
        'subtitle' => $pp->subtitle,
        'btn' => $pp->button_text,
        'url' => $pp->button_url,
        'emoji' => $pp->emoji ?? ($t === 'fb' ? '👍' : '📸'),
        'img' => $pp->image_url,
        'theme' => $t,
    ];
}
@endphp

@if($popups->count())
<style>
.promo-modal-overlay{position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;padding:16px;background:rgba(0,0,0,.65);backdrop-filter:blur(3px)}
.promo-modal-overlay.show{display:flex}
.promo-modal{width:100%;max-width:440px;border-radius:20px;overflow:hidden;position:relative;color:#fff;animation:promoPop .25s ease-out}
.promo-modal-theme-default{background:linear-gradient(135deg,#1a0b2e 0%,#2d1b4e 40%,#4c1d95 70%,#831843 100%);
  border:1px solid rgba(168,85,247,.4);box-shadow:0 24px 70px rgba(0,0,0,.55)}
.promo-modal-theme-fb{background:linear-gradient(135deg,#0a2a5e 0%,#0d47a1 45%,#1877F2 100%);
  border:1px solid rgba(147,197,253,.5);box-shadow:0 24px 70px rgba(24,119,242,.45)}
.promo-modal-theme-instagram{background:linear-gradient(135deg,#4c1d95 0%,#833AB4 35%,#FD1D1D 70%,#FCB045 100%);
  border:1px solid rgba(253,29,29,.45);box-shadow:0 24px 70px rgba(131,58,180,.5)}
@keyframes promoPop{from{transform:scale(.94) translateY(8px);opacity:0}to{transform:scale(1) translateY(0);opacity:1}}
.promo-modal-inner{padding:24px 22px 20px;position:relative;z-index:1}
.promo-modal-close{position:absolute;top:10px;right:10px;z-index:2;background:rgba(255,255,255,.18);border:0;color:#fff;
  width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;line-height:1;display:grid;place-items:center}
.promo-modal-close:hover{background:rgba(255,255,255,.32)}
.promo-modal-badge{display:inline-flex;align-items:center;gap:6px;background:#f59e0b;color:#111;font-size:11px;font-weight:800;
  letter-spacing:.08em;padding:5px 11px;border-radius:999px;margin-bottom:10px}
.promo-modal-title{font-size:20px;font-weight:800;line-height:1.3;margin:0 0 6px}
.promo-modal-sub{font-size:14px;color:#e9d5ff;margin:0 0 14px;line-height:1.55}
.promo-modal-row{display:flex;gap:12px;align-items:center;margin-bottom:14px}
.promo-modal-icon{width:52px;height:52px;border-radius:15px;flex-shrink:0;background:#fff;display:grid;place-items:center;
  font-size:26px;overflow:hidden}
.promo-modal-icon img{width:100%;height:100%;object-fit:cover}
.promo-modal-btn{display:flex;align-items:center;justify-content:center;gap:8px;background:#fff;
  font-weight:800;font-size:15px;padding:13px 20px;border-radius:14px;text-decoration:none;width:100%}
.promo-modal-theme-default .promo-modal-btn{color:#6d28d9}
.promo-modal-theme-default .promo-modal-btn:hover{background:#f5f3ff;color:#5b21b6}
.promo-modal-theme-fb .promo-modal-btn{color:#0d47a1}
.promo-modal-theme-fb .promo-modal-btn:hover{background:#e8f0fe}
.promo-modal-theme-instagram .promo-modal-btn{color:#c13584}
.promo-modal-theme-instagram .promo-modal-btn:hover{background:#fdf2f8}
.promo-modal-meta{font-size:11px;color:#c4b5fd;margin-top:10px;text-align:center}
.promo-modal-dots{display:flex;gap:6px;justify-content:center;margin-top:12px}
.promo-modal-dot{width:7px;height:7px;border-radius:50%;background:rgba(255,255,255,.3);border:0;padding:0;cursor:pointer}
.promo-modal-dot.active{background:#fff}
</style>

<div class="promo-modal-overlay" id="promo-modal-overlay" role="dialog" aria-modal="true" aria-label="Recommended apps">
    <div class="promo-modal" id="promo-modal-box">
        <button class="promo-modal-close" id="promo-modal-close" aria-label="Close promotion">✕</button>
        <div class="promo-modal-inner" id="promo-modal-content">
            {{-- filled by JS from promos below --}}
        </div>
        @if($popups->count() > 1)
        <div class="promo-modal-dots" id="promo-modal-dots" style="padding-bottom:16px"></div>
        @endif
    </div>
</div>

<script>
(function(){
    var promos = @json($promoData);
    if (!promos.length) return;

    // Skip promos dismissed within the last 24h (per-promo, per-browser)
    try {
        var now = Date.now();
        promos = promos.filter(function(p){
            var ts = parseInt(localStorage.getItem('promo_dismiss_' + p.id) || '0', 10);
            if (ts && now - ts < 36e5) return false;
            if (ts) localStorage.removeItem('promo_dismiss_' + p.id);
            return true;
        });
    } catch(e){}
    if (!promos.length) return;

    var overlay = document.getElementById('promo-modal-overlay');
    var content = document.getElementById('promo-modal-content');
    var dotsWrap = document.getElementById('promo-modal-dots');
    var idx = 0;

    function render(i){
        idx = (i + promos.length) % promos.length;
        var p = promos[idx];
        var box = document.getElementById('promo-modal-box');
        box.className = 'promo-modal promo-modal-theme-' + (p.theme || 'default');
        content.innerHTML =
            (p.badge ? '<span class="promo-modal-badge">✨ ' + escapeHtml(p.badge.toUpperCase()) + '</span>' : '') +
            '<div class="promo-modal-row">' +
                '<div class="promo-modal-icon">' + (p.img ? '<img src="' + escapeAttr(p.img) + '" alt="" loading="lazy">' : escapeHtml(p.emoji)) + '</div>' +
                '<div style="flex:1;min-width:0"><p class="promo-modal-title">' + escapeHtml(p.title) + '</p></div>' +
            '</div>' +
            (p.subtitle ? '<p class="promo-modal-sub">' + escapeHtml(p.subtitle) + '</p>' : '') +
            '<a href="' + escapeAttr(p.url) + '" class="promo-modal-btn">⬇ ' + escapeHtml(p.btn) + ' →</a>' +
            '<div class="promo-modal-meta">Free · Android APK · 🔒 Secure download from autolikerlive.com</div>';
        if (dotsWrap) {
            dotsWrap.innerHTML = '';
            promos.forEach(function(_, di){
                var d = document.createElement('button');
                d.className = 'promo-modal-dot' + (di === idx ? ' active' : '');
                d.setAttribute('aria-label', 'Show promotion ' + (di + 1));
                d.addEventListener('click', function(ev){ ev.stopPropagation(); render(di); });
                dotsWrap.appendChild(d);
            });
        }
    }
    function escapeHtml(s){ return String(s ?? '').replace(/[&<>"']/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }
    function escapeAttr(s){ return escapeHtml(s).replace(/"/g, '&quot;'); }

    function open(){ overlay.classList.add('show'); document.body.style.overflow = 'hidden'; }
    function close(){
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        // remember dismissal for current promo only, expires after 24h (others still show)
        try { localStorage.setItem('promo_dismiss_' + promos[idx].id, String(Date.now())); } catch(e){}
    }

    document.getElementById('promo-modal-close').addEventListener('click', close);
    overlay.addEventListener('click', function(e){ if (e.target === overlay) close(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && overlay.classList.contains('show')) close(); });

    render(0);
    // auto-rotate when multiple promos, pause once user interacts
    if (promos.length > 1) {
        var timer = setInterval(function(){
            if (!overlay.classList.contains('show')) { clearInterval(timer); return; }
            render(idx + 1);
        }, 6000);
    }
    setTimeout(open, {{ (int) $delayMs }});
})();
</script>
@endif
