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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">

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
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/fancybox/jquery.fancybox.min.css') }}">

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
