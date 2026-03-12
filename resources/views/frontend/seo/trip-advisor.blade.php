@extends('layouts.frontend')

@section('title', 'TripAdvisor — Villa Fabulosa')

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
        <h5 class="text-center mt-3">TripAdvisor</h5>
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
    <h5>Discover Luxury: TripAdvisor in Temecula Wine Country</h5>
    <ul>
                    <li>Explore top-rated luxury accommodations in Temecula Wine Country through TripAdvisor. Villa Fabulosa has been recognized as one of the premier vacation rentals in the region.</li>
                    <li>Our guests consistently rate Villa Fabulosa 5 stars for its exceptional amenities, breathtaking views, and unparalleled hospitality in the heart of Temecula Wine Country.</li>
                    <li>From the moment you arrive, you will be captivated by the stunning architecture, lush grounds, and world-class amenities that have earned Villa Fabulosa its stellar TripAdvisor reputation.</li>
                    <li>Join thousands of satisfied guests who have made Villa Fabulosa their home away from home in Temecula Wine Country. Read our reviews and see why we are the top-rated luxury rental in the area.</li>
                    <li>Book with confidence knowing that Villa Fabulosa is a TripAdvisor award-winning property, recognized for excellence in hospitality, comfort, and luxury.</li>
    </ul>
</div>

@endsection