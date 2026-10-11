@extends('layouts.frontend')

@section('title', 'Miniature Golf Course — Villa Fabulosa')

@section('head_extra')
<style>
    .gallery-grid {
        margin-top: 1.5rem;
    }

    .gallery-grid-item {
        margin-bottom: 1.5rem;
    }

    .gallery-grid-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 4px;
    }

    @media (min-width: 992px) {
        .gallery-grid-image {
            height: 260px;
        }
    }

    @media (max-width: 575.98px) {
        .gallery-grid .gallery-grid-item {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/the-pool') }}" class="site_arrow_link site_arrow_left" aria-label="Previous page: The Pool"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/the-sports-area') }}" class="site_arrow_link site_arrow_right" aria-label="Next page: The Sports Area"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h1 class="mb-0">Miniature Golf Course</h1>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5 site_section_mobile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="site_display_table">
                    <div class="site_display_table_cell">
                        <div class="site_content_box p-0">
                            <h2 class="site_section_title">Miniature Golf Course</h2><hr>
                            <ul class="site_content_list pl-4">
                                <li>Villa Fabulosa is the only Short Term Rental that we know of featuring a professional and very challenging 18-hole miniature golf course!</li>
                                <li>Your entire family will have hours of fun playing miniature golf on such a beautiful setting with 360 views of Temecula Wine Country.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gallery-grid">
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-111.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-111-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-04.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-04-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-207.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-207-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-207-2.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-207-2-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-207-3.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-207-3-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-2.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-2-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-3.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-3-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-4.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-4-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-5.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-mini-golf-208-5-thumb.webp') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
        </div>
    </div>
</section>

{{-- Gallery lightbox overlay --}}
<div id="gallery-lightbox">
    <button class="glb-close" type="button" aria-label="Close">&times;</button>
    <button class="glb-prev" type="button" aria-label="Previous"><i class="fa fa-angle-left"></i></button>
    <img loading="lazy" decoding="async" id="glb-img" src="" alt="">
    <button class="glb-next" type="button" aria-label="Next"><i class="fa fa-angle-right"></i></button>
    <div class="glb-counter" id="glb-counter"></div>
</div>

@endsection

@section('scripts_extra')
<script src="{{ \App\Support\Seo::versioned('frontend/js/gallery-lightbox.js') }}" defer></script>
@endsection
