@extends('layouts.frontend')

@section('title', 'Gallery — Villa Fabulosa')

@section('content')

<!-- Slider -->
<div id="site_gallery_carousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/gallery/g1.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g2.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g3.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g4.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g6.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g7.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g8.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g9.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g10.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g11.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g12.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g13.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g14.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g15.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g16.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g17.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g18.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g19.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g20.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g21.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/gallery/g22.jpg') }});"></div>
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
