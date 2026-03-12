@extends('layouts.frontend')

@section('title', 'Villa Fabulosa')

@section('head_extra')
<style>
    .pluslink, .pluslink:visited, .pluslink:hover, .pluslink:active { text-decoration: none; }
    .insta_href a { text-decoration: none; color: black; }
    .insta_href a i { color: #ee6666; }
    @media screen and (max-width: 767px) {
        .site_header_carousel_fixed .carousel-item { height: calc(100vh - 610px); }
    }
</style>
@endsection

@section('content')

<!-- Slider Start -->
<div id="site_gallery_carousel" class="site_header_carousel_fixed carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/banner-1.jpeg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/1-POOL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/2-POOL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/3-FIELD-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/Golf-Course-11.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/5-ARCADE-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/6-LIVING-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/7-KITCHEN-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/8-KITCHEN-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/10-DINING-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/12-LIVING-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13-DINING-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13-VIEW-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13.5KITCHENETTE-Edit-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/Outdoor-Kitchen-Zoomed.jpg') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13.8-IMG_1734-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13.11-GAME-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13.13-AERIAL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13.14-POOL-MLS.JPG') }});"></div>
        <div class="carousel-item" style="background-image:url({{ asset('frontend/imgs/photos-for-vrbo/13.19-FOYER-MLS.JPG') }});"></div>
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
<div class="site_slider_overlay">
    <div class="carousel-caption">
        <div class="scroll-down"><a href="#villinfo" class="animate js-scroll-trigger">More</a></div>
    </div>
</div>
<!-- Slider End -->

<!-- Villa Info Start -->
<div id="villinfo" class="site_villa_info_wrapper mb-5">
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
<!-- Villa Info End -->

<!-- Video Start -->
<div class="site_video_wrapper mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" id="video_one">
                <iframe width="100%" height="600" src="https://www.youtube.com/embed/u5zfhEQfkpk?si=k10NMIhAtvL7cLZz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Video End -->

<!-- Services Boxes Start -->
<div class="site_services_box_wrapper pb-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-4 mb-4">
                <div class="site_service_box">
                    <a href="{{ url('/the-rooms') }}">
                        <img style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/12-LIVING-MLS.JPG') }}" class="img-fluid">
                        <div class="site_service_title_wrapper">
                            <div class="site_service_title"><h1 class="mb-0">The Rooms</h1></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="site_service_box">
                    <a href="{{ url('/the-pool') }}">
                        <img style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/13.13-AERIAL-MLS.JPG') }}" class="img-fluid">
                        <div class="site_service_title_wrapper">
                            <div class="site_service_title"><h1 class="mb-0">The Pool</h1></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="site_service_box">
                    <a href="{{ url('/game-rooms') }}">
                        <img style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/5-ARCADE-MLS.JPG') }}" class="img-fluid">
                        <div class="site_service_title_wrapper">
                            <div class="site_service_title"><h1 class="mb-0">Game Room</h1></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="site_service_box">
                    <a href="{{ url('/miniature-golf-course') }}">
                        <img style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/4-AERIAL-MLS.JPG') }}" class="img-fluid">
                        <div class="site_service_title_wrapper">
                            <div class="site_service_title"><h1 class="mb-0">Miniature Golf</h1></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="site_service_box">
                    <a href="{{ url('/wineries') }}">
                        <img style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/Pergola.jpg') }}" class="img-fluid">
                        <div class="site_service_title_wrapper">
                            <div class="site_service_title"><h1 class="mb-0">Wineries</h1></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="site_service_box">
                    <a href="{{ url('/birds-eye') }}">
                        <img style="height: 250px;" src="{{ asset('frontend/imgs/108-AERIAL-Edit-MLS.JPG') }}" class="img-fluid">
                        <div class="site_service_title_wrapper">
                            <div class="site_service_title"><h1 class="mb-0">Bird's&nbsp; Eye&nbsp; View</h1></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Services Boxes End -->

<!-- Instagram Start -->
<div class="site_video_wrapper mb-5">
    <div class="container">
        <div class="insta_href text-center mt-3">
            <a href="https://www.instagram.com/villa.fabulosa/" target="_blank">
                <h1 class="site_title_letter_space">
                    <i class="fa fa-instagram" aria-hidden="true" style="font-size: 80px;"></i>&nbsp;
                    Visit Our Instagram Page at www.instagram.com/Villa.Fabulosa
                </h1>
            </a>
        </div>
    </div>
</div>
<!-- Instagram End -->

<!-- Booking Platforms Start -->
<section id="section10" class="pt-5 pb-5">
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-4 text-center">
                        <h1 class="site_title_letter_space mb-3">
                            <p>To see our excellent reviews, rates and availability, please visit :</p>
                        </h1>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="site_service_box" style="display:flex;justify-content:center;align-items:center;">
                            <a href="https://www.airbnb.com/h/villa-fabulosa" target="_blank">
                                <img src="{{ asset('frontend/imgs/airbnb.png') }}" class="img-fluid d-flex align-items-center" style="height: 90px;">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="site_service_box" style="display:flex;justify-content:center;align-items:center;">
                            <a href="https://www.vrbo.com/3610312" target="_blank">
                                <img src="{{ asset('frontend/imgs/verbo.png') }}" class="img-fluid d-flex align-items-center" style="margin-top: 25px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Booking Platforms End -->

<!-- Contact Form Start -->
<section id="contact" class="pt-5 pb-5">
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="site_section_title">Contact Us</h1>
                    <hr>
                    <p>We would love to hear from you. Please send us a note and let us know if you have any questions or what you think about Villa Fabulosa.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form id="requestform" action="{{ route('contact') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}">
                            <small class="form-text text-muted">First Name</small>
                            @error('fname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>&nbsp;</label>
                            <input type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}">
                            <small class="form-text text-muted">Last Name</small>
                            @error('lname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label>&nbsp;</label>
                            <textarea name="reason" class="form-control reason_textarea" cols="30" rows="1">{{ old('reason') }}</textarea>
                            <small class="form-text text-muted">How Did You Hear About Villa Fabulosa</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Email Address<span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}">
                            @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Message<span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4">{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>

                <div class="clearfix"></div>
                <a href="https://www.villamagnifica.com/" target="_blank" class="pluslink">
                    <div class="card mb-3" style="max-width: 100%; height: 235px;">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <img src="{{ asset('frontend/imgs/processed-1985b06c-1830-4ea5-a2e8-f9f52acfcf49_9jhkqIFL.jpeg') }}" class="card-img" alt="Villa Magnifica" style="height: 230px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <p class="card-text">Visit our sister Short-Term Rental:</p>
                                    <h5 class="card-title">Villa Magnifica</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Contact Form End -->

@endsection
