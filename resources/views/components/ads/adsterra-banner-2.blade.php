@if(\App\Support\Ads::unitEnabled('adsterra_banner_2') && \App\Support\Ads::networkEnabled('adsterra'))
<div class="ad-container my-4 text-center" style="overflow:hidden;min-height:250px;">
    <script>
        atOptions = {
            'key' : '30afc04cbf8214cb783779ca60f062a2',
            'format' : 'iframe',
            'height' : 250,
            'width' : 300,
            'params' : {}
        };
    </script>
    <script src="https://www.highrevenueformat.com/30afc04cbf8214cb783779ca60f062a2/invoke.js"></script>
</div>
@endif
