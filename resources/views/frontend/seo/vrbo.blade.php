@extends('layouts.frontend')

@section('title', 'VRBO — Villa Fabulosa')

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
        <h5 class="text-center mt-3">VRBO</h5>
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
    <h5>Luxurious Retreats Await: VRBO in Temecula Wine Country</h5>
    <ul>
                    <li>Welcome to your exclusive portal to luxury retreats in the heart of Temecula Wine Country! With VRBO in Temecula Wine Country, your ideal vacation destination is just a few clicks away.</li>
                    <li>Indulge in the ultimate escape as you explore our selection of exquisite accommodations. From charming cottages to sprawling estates, each VRBO in Temecula Wine Country is meticulously designed to exceed your expectations.</li>
                    <li>Start your day with a leisurely breakfast on the terrace, overlooking panoramic views of the vineyards bathed in golden sunlight.</li>
                    <li>After a day of adventure, return to your VRBO retreat and unwind in style. Relax by the poolside with a glass of local wine in hand, or gather around the outdoor fire pit for an intimate evening under the stars.</li>
                    <li>Whether you are planning a romantic getaway, a family reunion, or a group retreat, VRBO in Temecula Wine Country has the perfect accommodation to suit your needs.</li>
    </ul>
</div>

@endsection