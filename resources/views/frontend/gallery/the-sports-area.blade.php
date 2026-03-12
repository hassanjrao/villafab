@extends('layouts.frontend')

@section('title', 'The Sports Area — Villa Fabulosa')

@section('head_extra')
<style>
    @media screen and (max-width: 767px) { .carousel-item { height: 30vh !important; } }
</style>
@endsection

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/miniature-golf-course') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/birds-eye') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">The Sports Area</h2>
    </div></div></div>
</div>

<!-- Slider -->
<div id="site_gallery_carousel" class="site_header_carousel_fixed carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/4-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/13.13-AERIAL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/118-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/38-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/39-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/40-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/41-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/42-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/44-FIELD-MLS.JPG') }});"></div>
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
                <h1 class="site_section_title">The Sports Area</h1><hr>
                <ul class="site_content_list pl-4">
                    <li>Villa Fabulosa offers a plethora of sports areas to satisfy the athletic abilities of everyone in the family. It features a pickleball and basketball court, a putting green, and a Bocce Ball Court. It also features a Volleyball and badminton court, along with popular lawn games such as Corn Hole and many more. Villa Fabulosa also provides other sports equipment such as soccer ball, football and so much more.</li>
                </ul>
            </div>
        </div></div>
    </div></div></div>
</section>

@endsection
