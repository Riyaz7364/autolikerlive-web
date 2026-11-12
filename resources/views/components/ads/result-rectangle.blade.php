@if(\App\Support\Ads::unitEnabled('adsense_result_rectangle'))
<div class="ad-container ad-result-rectangle text-center" style="overflow:visible;margin:24px auto;text-align:center;min-height:250px;width:100%;">
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:250px;max-width:100%"
         data-ad-client="ca-pub-8426510303593933"
         data-ad-slot="4014375897"
         data-full-width-responsive="false"></ins>
    <script>
    (function(){var pushed=false;function push(){if(pushed)return;pushed=true;try{(window.adsbygoogle=window.adsbygoogle||[]).push({});}catch(e){}}var ins=document.currentScript?document.currentScript.previousElementSibling:null;function sched(){if('requestIdleCallback' in window)requestIdleCallback(push,{timeout:5000});else setTimeout(push,3000);}if(ins&&'IntersectionObserver' in window){var io=new IntersectionObserver(function(es){if(es[0].isIntersecting){push();io.disconnect();}},{rootMargin:'300px'});io.observe(ins);setTimeout(push,8000);}else sched();})();
    </script>
</div>
@endif
