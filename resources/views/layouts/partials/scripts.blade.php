{{-- jQuery. 3.2.0 and 3.2.1 were both being loaded; 3.2.1 always won, so
     dropping 3.2.0 saves 84 KB and changes nothing. --}}
<script src="{{ \App\Support\Seo::versioned('frontend/js/jquery.min.js') }}"></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/popper.min.js') }}"></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/jquery.easing.min.js') }}"></script>

{{-- Fancybox is 66 KB of JS and only three pages open a gallery with it,
     so it is loaded where it is actually used. Add the route here if a new
     page starts using data-fancybox. --}}
@if (request()->routeIs('kitchen', 'instructions', 'team-bonding'))
    <script src="{{ asset('frontend/fancybox/jquery.fancybox.min.js') }}"></script>
@endif

<!-- Custom scripts -->
<script src="{{ \App\Support\Seo::versioned('frontend/js/scrolling-nav.js') }}" defer></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/script.js') }}" defer></script>
