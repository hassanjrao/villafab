@php
    // Route-level metadata from config/seo.php, overridable per page with
    // @section('description'), @section('og_image') or @section('robots').
    $seo = \App\Support\Seo::current();

    $seoTitle       = trim($__env->yieldContent('title', $seo['title']));
    $seoDescription = trim($__env->yieldContent('description', $seo['description']));
    $seoRobots      = trim($__env->yieldContent('robots', $seo['robots']));
    $seoImage       = \App\Support\Seo::absolute(trim($__env->yieldContent('og_image', $seo['image'])));
    $seoCanonical   = \App\Support\Seo::canonical();
@endphp

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4YSNM6JHV9"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-4YSNM6JHV9');
</script>

<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="robots" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoCanonical }}">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Villa Fabulosa">
<meta property="og:locale" content="en_US">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:alt" content="{{ $seoTitle }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">

@include('layouts.partials.schema')

{{-- PT Sans is self-hosted. Google Fonts cost two serial round trips on the
     critical path -- the CSS from googleapis, which then revealed the woff2
     URLs on gstatic. Serving both ourselves removes the external hops, and
     preloading the files starts them without waiting for the CSS to parse. --}}
<link rel="preload" as="font" type="font/woff2" href="{{ asset('frontend/fonts/pt-sans-400.woff2') }}" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="{{ asset('frontend/fonts/pt-sans-700.woff2') }}" crossorigin>
{{-- Inlined rather than linked: the file was only 0.6 KB but cost a full
     render-blocking round trip. URLs are absolute via asset() because a
     relative path inside inline CSS resolves against the page, not the
     stylesheet. --}}
<style>
@font-face{font-family:'PT Sans';font-style:normal;font-weight:400;font-display:swap;src:url('{{ asset('frontend/fonts/pt-sans-400.woff2') }}') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
@font-face{font-family:'PT Sans';font-style:normal;font-weight:700;font-display:swap;src:url('{{ asset('frontend/fonts/pt-sans-700.woff2') }}') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
</style>

<style>
    /* Offset main content for fixed-top navbar so subheaders and sections
       are not hidden underneath the header. Adjusted for desktop and mobile. */
    body {
        padding-top: 72px;
    }

    @media (max-width: 767.98px) {
        body {
            padding-top: 64px;
        }
    }

    /* Shared gallery lightbox styles (used on home + all gallery pages) */
    #gallery-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.92);
        z-index: 1050;
        align-items: center;
        justify-content: center;
    }

    #gallery-lightbox.active {
        display: flex;
    }

    #gallery-lightbox img {
        max-width: 90vw;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 4px;
    }

    #gallery-lightbox .glb-close,
    #gallery-lightbox .glb-prev,
    #gallery-lightbox .glb-next {
        position: fixed;
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #fff;
        cursor: pointer;
        z-index: 1051;
        transition: background 0.2s;
        font-size: 2rem;
    }

    /* Close button (top-right) */
    #gallery-lightbox .glb-close {
        top: 20px;
        right: 24px;
        padding: 4px 10px;
    }

    /* Arrows (centered left/right) */
    #gallery-lightbox .glb-prev,
    #gallery-lightbox .glb-next {
        top: 50%;
        transform: translateY(-50%);
        padding: 10px 16px;
    }

    #gallery-lightbox .glb-prev {
        left: 16px;
    }

    #gallery-lightbox .glb-next {
        right: 16px;
    }

    #gallery-lightbox .glb-prev:hover,
    #gallery-lightbox .glb-next:hover,
    #gallery-lightbox .glb-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Counter at bottom center */
    #gallery-lightbox .glb-counter {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }
</style>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ \App\Support\Seo::versioned('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ \App\Support\Seo::versioned('frontend/style.css') }}">

{{-- Font Awesome supplies decorative icons only, so it is loaded off the
     critical path: the print media type makes it non-blocking, and onload
     switches it back to all. --}}
<link rel="stylesheet" href="{{ \App\Support\Seo::versioned('frontend/font-awesome/css/font-awesome.min.css') }}"
      media="print" onload="this.media='all';this.onload=null;">
<noscript><link rel="stylesheet" href="{{ \App\Support\Seo::versioned('frontend/font-awesome/css/font-awesome.min.css') }}"></noscript>

{{-- Only the three pages that actually open a Fancybox gallery need its CSS. --}}
@if (request()->routeIs('kitchen', 'instructions', 'team-bonding'))
    <link rel="stylesheet" href="{{ asset('frontend/fancybox/jquery.fancybox.min.css') }}">
@endif

<!-- Favicons. Google renders these beside mobile search results, so a
     missing one shows as a generic globe in the SERP. -->
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" type="image/png" sizes="180x180" href="{{ asset('frontend/imgs/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('frontend/imgs/favicon.png') }}">

{{-- Tawk.to live chat (commented out by default) --}}
{{--
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5a353083bbdfe97b137fbe1a/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
--}}
