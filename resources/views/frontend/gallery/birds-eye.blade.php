@extends('layouts.frontend')

@section('title', "Bird's Eye — Villa Fabulosa")

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/the-sports-area') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/floorplan') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Bird's Eye</h2>
    </div></div></div>
</div>

<!-- Slider -->
<div id="site_gallery_carousel" class="site_header_carousel_fixed carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/106-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/107-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/108-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/110-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/111-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/113-AERIAL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/114-AERIAL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/116-AERIAL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/117-AERIAL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/118-AERIAL-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/120-AERIAL-Edit-MLS.JPG') }});"></div>
    </div>
    <a class="carousel-control-prev" href="#site_gallery_carousel" role="button" data-slide="prev"><i class="fa fa-arrow-circle-left fa-4x"></i><span class="sr-only">Previous</span></a>
    <a class="carousel-control-next" href="#site_gallery_carousel" role="button" data-slide="next"><i class="fa fa-arrow-circle-right fa-4x"></i><span class="sr-only">Next</span></a>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="site_section_wrapper site_section_mobile" style="height:auto">
    <div class="container"><div class="row"><div class="col-lg-12">
        <div class="site_content_box">
            <h1 class="site_section_title">Bird's Eye</h1><hr>
            <ul class="site_temecula_links site_content_list pl-4">
                <li>Perched on a breathtaking hillside, this architectural masterpiece boasts panoramic views of hot air balloons and Temecula wine country, where over 45 nearby wineries await your exploration.</li>
            </ul>
        </div>
    </div></div></div>
</section>

@endsection
