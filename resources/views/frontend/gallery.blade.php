@extends('layouts.frontend')

@section('title', 'Gallery — Villa Fabulosa')

@section('content')

<div class="container-fluid">
    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container-fluid"><div class="col-lg-12">
            <div class="site_subheader_inner">
                <h1 class="mb-0">Villa Fabulosa Photo Gallery</h1>
            </div>
        </div></div>
    </div>
</div>

<!-- Slider -->
<div id="site_gallery_carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-01.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-02.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-03.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-04.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-06.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-07.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-08.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-09.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-10.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-11.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-12.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-13.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-14.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-15.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-16.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-17.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-18.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-19.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-20.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-21.webp') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/villa-fabulosa-gallery-22.webp') }});"></div>
    </div>
    <a class="carousel-control-prev" href="#site_gallery_carousel" role="button" data-slide="prev">
        <i class="fa fa-arrow-circle-left fa-4x"></i>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#site_gallery_carousel" role="button" data-slide="next">
        <i class="fa fa-arrow-circle-right fa-4x"></i>
        <span class="sr-only">Next</span>
    </a>
</div>

@endsection
