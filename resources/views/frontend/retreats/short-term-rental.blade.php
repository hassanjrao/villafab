@extends('layouts.frontend')

@section('title', 'Short Term Rental in Temecula Wine Country — Villa Fabulosa')

@section('head_extra')
<style>
    @media screen and (max-width: 767px) {
        .site_header_carousel_fixed .carousel-item { height: calc(40vh - 80px); }
    }
</style>
@endsection

@section('content')

<div class="container-fluid">
    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container-fluid"><div class="col-lg-12">
            <div class="site_subheader_inner">
                <h2 class="mb-0">Short Term Rental</h2>
            </div>
        </div></div>
    </div>

    <!-- Slider -->
    <div id="site_gallery_carousel" class="site_header_carousel_fixed carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/banner-1.jpeg') }});"></div>
        </div>
    </div>

    <!-- Villa Info -->
    <div id="villinfo" class="site_villa_info_wrapper mt-2 mb-2">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-12 text-center">
                    <h1 class="site_title_letter_space mb-3">Villa Fabulosa</h1>
                    <h3 class="site_title_letter_space">An enchanting haven of indulgence with unparalleled beauty, luxury, and elegance.</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="site_villa_info list-inline">
                        <li class="list-inline-item"><i class="fa fa-users"></i> 24 Guests</li>
                        <li class="list-inline-item"><i class="fa fa-home"></i> 7 Bedrooms</li>
                        <li class="list-inline-item"><i class="fa fa-bed"></i> 12 Beds</li>
                        <li class="list-inline-item"><i class="fa fa-bath"></i> 5.5 Baths</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-lg-12">
                    <p class="lead">Perched on a breathtaking hillside, this architectural masterpiece boasts panoramic views of hot air balloons and Temecula wine country, where over 55 nearby wineries await your exploration.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Video -->
    <div class="container">
        <div class="site_video_wrapper mb-5">
            <div class="row">
                <div class="col-lg-12">
                    <iframe width="100%" height="400" src="https://www.youtube.com/embed/u5zfhEQfkpk?si=k10NMIhAtvL7cLZz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 1 -->
<section id="section1" class="site_section_wrapper site_section_mobile" style="height:auto">
    <div class="container"><div class="row"><div class="col-lg-12">
        <div class="site_display_table"><div class="site_display_table_cell">
            <div class="site_content_box">
                <ul class="site_temecula_links site_content_list pl-4">
                <li>Discover the Epitome of Elegance: Your Short-Term Rental in Temecula Wine Country</li>
                <li>Nestled amid the rolling hills and vineyards of Temecula Wine Country, our short-term rental stands as a testament to beauty and grace. Surrounded by the natural splendor of the area, this is the perfect retreat for wine enthusiasts, honeymooners, and those in pursuit of serenity and opulence.</li>
                <li>Our property redefines elegance with its stunning architecture and tasteful interior design.</li>
                <li>Indulge in luxury amenities that enhance your stay. Take a refreshing dip in the private pool, unwind in the hot tub while gazing at the vineyard views, or enjoy al fresco dining in the charming outdoor space.</li>
                <li>Book your dream short-term rental in Temecula Wine Country today and experience the finest in luxury living.</li>
                </ul>
            </div>
        </div></div>
    </div></div></div>
</section>

@endsection