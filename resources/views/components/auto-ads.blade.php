{{-- Remove any leftover AdMaven push service worker (sw.js) from returning visitors. --}}

@if(\App\Support\Ads::unitEnabled('adsense_auto_ads') && \App\Support\Ads::networkEnabled('adsense'))
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8426510303593933"
     crossorigin="anonymous"></script>
@endif
