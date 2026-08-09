{{--
    GA4.

    Two things are going on here.

    1. The tag is deferred. gtag.js is ~485 KB and was the largest script on
       the site, sitting on the critical path. It now loads on the first
       interaction, or shortly after window load, whichever happens first.

       No measurement is lost by doing this: gtag() pushes to dataLayer, and
       dataLayer is just an array until the real script arrives and drains
       it. So page_view and any events fired before the script loads are
       queued and sent once it does.

    2. Conversions are tracked. The property was previously recording
       page views only, which cannot answer whether direct bookings are
       growing -- the entire point of the SEO work. See villaTrack() below.
--}}
@php $gaId = config('services.ga.measurement_id', 'G-4YSNM6JHV9'); @endphp

<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }

    gtag('js', new Date());
    gtag('config', '{{ $gaId }}');

    /**
     * Fire a GA4 event. Safe to call at any point -- before the tag has
     * loaded the call simply queues in dataLayer.
     */
    window.villaTrack = function (name, params) {
        gtag('event', name, params || {});
    };

    (function () {
        var loaded = false;

        function loadGa() {
            if (loaded) return;
            loaded = true;

            var s = document.createElement('script');
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id={{ $gaId }}';
            document.head.appendChild(s);

            events.forEach(function (evt) {
                window.removeEventListener(evt, loadGa, opts);
            });
        }

        var events = ['pointerdown', 'keydown', 'scroll', 'touchstart'];
        var opts = { passive: true, once: false };

        events.forEach(function (evt) {
            window.addEventListener(evt, loadGa, opts);
        });

        // Backstop, so visitors who never interact are still counted.
        if (document.readyState === 'complete') {
            setTimeout(loadGa, 2000);
        } else {
            window.addEventListener('load', function () { setTimeout(loadGa, 2000); });
        }
    })();
</script>
