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
