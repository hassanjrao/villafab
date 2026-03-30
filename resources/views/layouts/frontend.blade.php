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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        });
    </script>
    @endif

    @yield('scripts_extra')

</body>
</html>
