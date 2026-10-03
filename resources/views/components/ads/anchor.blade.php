@if(config('ads.adsense_enabled'))
<div class="alk-anchor d-md-none" id="alkAnchorAd" style="display:none;">
    <button type="button" class="alk-anchor-close" aria-label="Close ad"
        onclick="document.getElementById('alkAnchorAd').style.display='none';document.body.classList.remove('has-anchor');">✕</button>
    <ins class="adsbygoogle"
         style="display:inline-block;width:320px;height:50px"
         data-ad-client="ca-pub-8426510303593933"
         data-ad-slot="5606482216"></ins>
    <script>
    (function(){
        var box = document.getElementById('alkAnchorAd');
        if (!box) return;
        // Reserve layout space up-front so showing the ad never shifts CTAs.
        document.body.classList.add('has-anchor');
        var pushed = false;
        function show(){ box.style.display = 'flex'; }
        function push(){
            if (pushed) return; pushed = true;
            try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            show();
        }
        // Wait until the user scrolled past the first screen — the anchor
        // never competes with the above-the-fold tool form.
        var fired = false;
        function onScroll(){
            if (fired) return;
            if (window.scrollY > window.innerHeight * 0.6) { fired = true; push(); }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        setTimeout(push, 12000); // fallback: show after 12s even without scroll
    })();
    </script>
</div>
@endif
