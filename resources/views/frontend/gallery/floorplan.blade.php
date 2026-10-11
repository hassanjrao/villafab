@extends('layouts.frontend')

@section('title', 'Floor Plan — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/birds-eye') }}" class="site_arrow_link site_arrow_left" aria-label="Previous page: Birds Eye"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/wineries') }}" class="site_arrow_link site_arrow_right" aria-label="Next page: Wineries"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h1 class="mb-0">Floor Plan</h1>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5 site_section_mobile">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ asset('frontend/imgs/villa-fabulosa-upstairs.webp') }}" class="img-fluid" alt="Upstairs floor plan" aria-describedby="upstairs-description">
                <h2 class="h4 mt-3">Upstairs layout</h2>
                <p id="upstairs-description">A central staircase opens onto the upper hall. The Cabernet room has a king bed; the Merlot room has a queen bed. The Pinot Noir and Zinfandel rooms each have two queen beds. The drawing shows closets and bathrooms beside the bedrooms.</p>
            </div>
            <div class="col-lg-6">
                <img loading="lazy" decoding="async" src="{{ asset('frontend/imgs/villa-fabulosa-floor-plan.webp') }}" class="img-fluid" alt="Downstairs floor plan" aria-describedby="downstairs-description">
                <h2 class="h4 mt-3">Downstairs layout</h2>
                <p id="downstairs-description">The kitchen with an island opens onto the living room and a dining table marked for 16 seats. The Champagne room has two queen beds; the Chardonnay room and Bridal Suite each have a queen bed. The game room has two queen sofa beds. The drawing also shows bathrooms, closets, a laundry area and the central staircase.</p>
            </div>
        </div>
    </div>
</section>

@endsection
