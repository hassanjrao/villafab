@extends('layouts.frontend')

@section('title', 'Game Room — Villa Fabulosa')

@section('head_extra')
<style>
    @media screen and (max-width: 767px) { .carousel-item { height: 30vh !important; } }
</style>
@endsection

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/the-rooms') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/bridal-suite') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Game Room</h2>
    </div></div></div>
</div>

<!-- Slider -->
<div id="site_gallery_carousel" class="site_header_carousel_fixed carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/5-ARCADE-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/13.11-GAME-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/46-ARCADE-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/47-ARCADE-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/48-ARCADE-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/IMG_1722-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/IMG_1723-MLS.JPG') }});"></div>
    </div>
    <a class="carousel-control-prev" href="#site_gallery_carousel" role="button" data-slide="prev"><i class="fa fa-arrow-circle-left fa-4x"></i><span class="sr-only">Previous</span></a>
    <a class="carousel-control-next" href="#site_gallery_carousel" role="button" data-slide="next"><i class="fa fa-arrow-circle-right fa-4x"></i><span class="sr-only">Next</span></a>
</div>
<div class="site_slider_overlay">
    <div class="carousel-caption"><div class="scroll-down"><a href="#site_scroll_down" class="animate js-scroll-trigger">More</a></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5 site_section_mobile">
    <div class="container"><div class="row"><div class="col-lg-12">
        <div class="site_display_table"><div class="site_display_table_cell">
            <div class="site_content_box p-0">
                <h1 class="site_section_title">Game Room</h1><hr>
                <ul class="site_content_list pl-4">
                    <li>Villa Fabulosa features a very large game room with some of the top Video Arcades including: Tekken 5, a super exciting martial art game, Target Force Gold, a super fun shooting game similar to Time Crisis, Donkey Kong Junior, Terminator 2-Judgement day, Ms. Pac-Man and Midway Mortal Kombat 2.</li>
                    <li>Villa Fabulosa's game room also includes Ice Hockey, a Foosball, Shuffle Board and a Poker table. It includes two sofa beds with a 4K smart TV with Netflix and Hulu subscription.</li>
                </ul>
            </div>
        </div></div>
    </div></div></div>
</section>

@endsection
