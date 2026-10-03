@if(config('ads.adsense_enabled'))
<div class="ad-container my-4 text-center d-none d-md-block" style="overflow:hidden;min-height:90px;">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-8426510303593933"
         data-ad-slot="7888884839"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
    (function(){var pushed=false;function push(){if(pushed)return;pushed=true;try{(window.adsbygoogle=window.adsbygoogle||[]).push({});}catch(e){}}var ins=document.currentScript?document.currentScript.previousElementSibling:null;function sched(){if('requestIdleCallback' in window)requestIdleCallback(push,{timeout:5000});else setTimeout(push,3000);}if(ins&&'IntersectionObserver' in window){var io=new IntersectionObserver(function(es){if(es[0].isIntersecting){push();io.disconnect();}},{rootMargin:'300px'});io.observe(ins);setTimeout(push,8000);}else sched();})();
    </script>
</div>
@endif
