@if(\App\Support\Ads::unitEnabled('adsense_anchor'))
<style>
.alk-anchor{position:fixed;left:0;right:0;bottom:0;z-index:999;display:none;align-items:center;justify-content:center;padding:8px 40px calc(8px + env(safe-area-inset-bottom,0px));background:rgba(255,255,255,.98);box-shadow:0 -4px 18px rgba(15,23,42,.12);box-sizing:border-box}
.alk-anchor .alk-anchor-close{position:absolute;top:6px;right:8px;width:28px;height:28px;border:0;border-radius:999px;background:#eef2f7;color:#334155;cursor:pointer;line-height:1}
.alk-anchor ins.adsbygoogle{display:block !important;width:100% !important;max-width:320px;min-height:50px}
body.has-anchor{padding-bottom:calc(74px + env(safe-area-inset-bottom,0px))}
@media (min-width:768px){.alk-anchor{display:none !important}body.has-anchor{padding-bottom:0}}
</style>
<div class="alk-anchor" id="alkAnchorAd">
    <button type="button" class="alk-anchor-close" aria-label="Close ad"
        onclick="var b=document.getElementById('alkAnchorAd');if(b)b.style.display='none';document.body.classList.remove('has-anchor');">✕</button>
    <ins class="adsbygoogle"
         style="display:block;width:100%;max-width:320px;height:50px"
         data-ad-client="ca-pub-8426510303593933"
         data-ad-slot="5606482216"></ins>
    <script>
    (function(){
        var box = document.getElementById('alkAnchorAd');
        if (!box || window.matchMedia('(min-width:768px)').matches) return;
        document.body.classList.add('has-anchor');
        var pushed = false;
        function show(){ if (!window.matchMedia('(min-width:768px)').matches) box.style.display = 'flex'; }
        function push(){
            if (pushed) return; pushed = true;
            try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            show();
        }
        var fired = false;
        function onScroll(){
            if (fired) return;
            if (window.scrollY > window.innerHeight * 0.6) { fired = true; push(); window.removeEventListener('scroll', onScroll); }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        setTimeout(push, 12000);
    })();
    </script>
</div>
@endif
