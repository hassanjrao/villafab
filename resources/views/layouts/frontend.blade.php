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

    @yield('scripts_extra')

</body>
</html>
