@if(\App\Support\Ads::unitEnabled('adsterra_banner') && \App\Support\Ads::networkEnabled('adsterra'))
<div class="ad-container my-4 text-center" style="overflow:hidden;min-height:50px;">
    <script>
        atOptions = {
            'key' : 'b507c3a70f654d83591120ef72ef6b1a',
            'format' : 'iframe',
            'height' : 50,
            'width' : 320,
            'params' : {}
        };
    </script>
    <script src="https://www.highrevenueformat.com/b507c3a70f654d83591120ef72ef6b1a/invoke.js"></script>
</div>
@endif
