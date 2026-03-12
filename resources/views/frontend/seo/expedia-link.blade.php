@extends('layouts.frontend')

@section('title', 'Expedia — Villa Fabulosa')

@section('head_extra')
<style>
    .headinggg { background: #1dace7; padding: 5px; color: white; }
    @media screen and (max-width: 767px) {
        .site_header_carousel_fixed .carousel-item { height: calc(40vh - 80px); }
    }
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="headinggg">
        <h5 class="text-center mt-3">Expedia.com</h5>
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

<!-- Text Section -->
<div class="container mb-5">
    <h5>Plan Your Luxury Escape: Expedia in Temecula Wine Country</h5>
    <ul>
                    <li>Discover and book Villa Fabulosa through Expedia.com and experience the best of Temecula Wine Country in unmatched luxury and style.</li>
                    <li>Expedia offers a convenient way to bundle your Villa Fabulosa booking with flights, car rentals, and local activities for a complete Temecula Wine Country vacation package.</li>
                    <li>Villa Fabulosa is proudly listed on Expedia with verified guest reviews, detailed amenity listings, and competitive rates for your luxury Temecula getaway.</li>
                    <li>Explore the surrounding wine country, visit world-class wineries, and return to the comfort of Villa Fabulosa each evening — the perfect base for your Expedia-booked Temecula adventure.</li>
                    <li>Book through Expedia today and unlock exclusive deals on your Villa Fabulosa stay in Temecula Wine Country. Your luxury vacation awaits!</li>
    </ul>
</div>

@endsection