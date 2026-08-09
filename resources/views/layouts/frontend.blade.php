<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
    @yield('head_extra')
</head>
<body id="{{ $bodyId ?? 'page-top' }}" onload="{{ $bodyOnload ?? '' }}">

    @include('layouts.partials.nav')

    @yield('content')

    @include('layouts.partials.footer')

    @include('layouts.partials.scripts')

    {{-- SweetAlert2 is 77 KB and only used to show a flash message, so it is
         fetched only on the requests that actually have one. --}}
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif
    <script>
        (function () {
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            function toIsoDateLocal(dateObj) {
                var y = dateObj.getFullYear();
                var m = String(dateObj.getMonth() + 1).padStart(2, '0');
                var d = String(dateObj.getDate()).padStart(2, '0');
                return y + '-' + m + '-' + d;
            }

            function dayOfWeekFromIso(iso) {
                var p = iso.split('-');
                var year = parseInt(p[0], 10);
                var month = parseInt(p[1], 10);
                var day = parseInt(p[2], 10);
                return new Date(Date.UTC(year, month - 1, day)).getUTCDay();
            }

            function friendlyDate(iso) {
                var p = iso.split('-');
                var year = parseInt(p[0], 10);
                var month = parseInt(p[1], 10);
                var day = parseInt(p[2], 10);
                return days[dayOfWeekFromIso(iso)] + ', ' + months[month - 1] + ' ' + day + ', ' + year;
            }

            window.VillaDateUtils = {
                toIsoDateLocal: toIsoDateLocal,
                dayOfWeekFromIso: dayOfWeekFromIso,
                friendlyDate: friendlyDate
            };
        })();
    </script>

    @if (session('success'))
    <script>
        Swal.fire({
            toast:            true,
            position:         'top-end',
            icon:             'success',
            title:            @json(session('success')),
            showConfirmButton: false,
            timer:            4500,
            timerProgressBar: true,
            customClass: {
                container: 'swal2-top-toast'
            }
        });
    </script>
    <style>.swal2-top-toast { z-index: 11000 !important; }</style>

    {{-- Enquiries are the main non-booking conversion. Fired server-side off
         the flash message rather than on form submit, so it only counts
         submissions that actually passed validation and were sent. --}}
    <script>
        window.villaTrack && villaTrack('generate_lead', {
            form: 'contact',
            page: @json(request()->path())
        });
    </script>
    @endif

    @yield('scripts_extra')

    @stack('video_facade_assets')

    {{-- Site-wide intent signals. Delegated from document so they cover
         links rendered after load, and kept out of the critical path. --}}
    <script>
        document.addEventListener('click', function (e) {
            var a = e.target.closest && e.target.closest('a[href]');
            if (!a || !window.villaTrack) return;

            var href = a.getAttribute('href') || '';

            if (href.indexOf('tel:') === 0) {
                villaTrack('contact_phone', { method: 'phone', value_text: href.replace('tel:', '') });
            } else if (href.indexOf('mailto:') === 0) {
                villaTrack('contact_email', { method: 'email' });
            } else if (a.pathname === '/book-now') {
                villaTrack('begin_checkout', { source: @json(request()->path()) });
            }
        }, { passive: true });
    </script>

</body>
</html>
