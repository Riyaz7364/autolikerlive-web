@props(['smartUrl' => 'https://www.profitableratecpmnetwork.com/vjwjr87emq?key=cd64907d82fae28ffcff1d1f9ea5f3ac'])

@php
    $smartLinkUrl = $smartUrl ?: 'https://www.profitableratecpmnetwork.com/vjwjr87emq?key=cd64907d82fae28ffcff1d1f9ea5f3ac';
@endphp

{{-- Smart Link: opens the Adsterra smart link in a popUnder when a visitor submits a form. --}}
@if(\App\Support\Ads::unitEnabled('adsterra_smart_link') && \App\Support\Ads::networkEnabled('adsterra'))
<script>
(function () {
    if (window.__adsterraSmartLinkBound) { return; }
    window.__adsterraSmartLinkBound = true;

    document.addEventListener('submit', function (event) {
        var form = event.target;
        if (!form || form.tagName !== 'FORM') { return; }
        if (form.closest('[data-adsterra-skip]')) { return; }
        var action = (form.getAttribute('action') || '').toLowerCase();
        if (action.indexOf('/admin') !== -1) { return; }

        var win = null;
        try {
            win = window.open({!! json_encode($smartLinkUrl) !!}, 'adsterraSmartLink', 'width=1000,height=800,scrollbars=yes,resizable=yes');
        } catch (e) {
            return;
        }

        // Popup blocked (or closed) — nothing else to do, the form proceeds.
        if (!win) { return; }
    }, true);
})();
</script>
@endif
