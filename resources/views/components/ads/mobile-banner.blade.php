@if(\App\Support\Ads::unitEnabled('adsense_mobile_banner'))
<div class="ad-container my-3 text-center d-block d-md-none" style="overflow:visible;min-height:50px;width:100%;">
    <ins class="adsbygoogle"
         style="display:block;width:100%;max-width:320px;height:50px;margin:0 auto"
         data-ad-client="ca-pub-8426510303593933"
         data-ad-slot="5606482216"></ins>
    <script>
    (function(){var pushed=false;function push(){if(pushed)return;pushed=true;try{(window.adsbygoogle=window.adsbygoogle||[]).push({});}catch(e){}}var ins=document.currentScript?document.currentScript.previousElementSibling:null;function sched(){if('requestIdleCallback' in window)requestIdleCallback(push,{timeout:5000});else setTimeout(push,3000);}if(ins&&'IntersectionObserver' in window){var io=new IntersectionObserver(function(es){if(es[0].isIntersecting){push();io.disconnect();}},{rootMargin:'300px'});io.observe(ins);setTimeout(push,8000);}else sched();})();
    </script>
</div>
@endif
