@extends('layouts.frontend')

@section('title', 'Booking.com — Villa Fabulosa')

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
        <h5 class="text-center mt-3">Booking.com</h5>
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
    <h5>Book Your Dream Stay: Booking.com in Temecula Wine Country</h5>
    <ul>
                    <li>Find and book your perfect luxury vacation rental through Booking.com. Villa Fabulosa in Temecula Wine Country offers an unparalleled experience in one of California top wine destinations.</li>
                    <li>Our property is featured on Booking.com with exceptional ratings, offering transparent pricing, secure booking, and a seamless reservation experience for your dream Temecula getaway.</li>
                    <li>Villa Fabulosa provides everything you need for an extraordinary vacation in Temecula Wine Country — from private pools and game rooms to miniature golf and outdoor kitchens.</li>
                    <li>Book directly through Booking.com and enjoy flexible cancellation policies, instant confirmation, and peace of mind knowing your luxury villa is secured for your chosen dates.</li>
                    <li>With Booking.com, planning your Temecula Wine Country vacation has never been easier. Browse availability, read guest reviews, and book your stay at Villa Fabulosa today.</li>
    </ul>
</div>

@endsection