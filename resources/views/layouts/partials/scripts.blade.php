{{-- All deferred: they sit at the end of the body, but without defer they
     still block the parser and land on the critical request chain.

     defer preserves document order, so jQuery is always ready before
     Bootstrap, Fancybox and our own scripts run. Safe here because the only
     inline jQuery call on the frontend is inside openPhotoTour(), which
     fires on click, and every Bootstrap component in use (carousel, modal,
     collapse) is data-attribute driven and initialises on DOM ready. --}}
<script src="{{ \App\Support\Seo::versioned('frontend/js/jquery.min.js') }}" defer></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/popper.min.js') }}" defer></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/bootstrap.min.js') }}" defer></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/jquery.easing.min.js') }}" defer></script>

{{-- Fancybox is 66 KB of JS and only three pages open a gallery with it,
     so it is loaded where it is actually used. Add the route here if a new
     page starts using data-fancybox. --}}
@if (request()->routeIs('kitchen', 'instructions', 'team-bonding'))
    <script src="{{ \App\Support\Seo::versioned('frontend/fancybox/jquery.fancybox.min.js') }}" defer></script>
@endif

<!-- Custom scripts -->
<script src="{{ \App\Support\Seo::versioned('frontend/js/scrolling-nav.js') }}" defer></script>
<script src="{{ \App\Support\Seo::versioned('frontend/js/script.js') }}" defer></script>
