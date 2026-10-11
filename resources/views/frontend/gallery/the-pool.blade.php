@extends('layouts.frontend')

@section('title', 'The Pool — Villa Fabulosa')

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
        <a href="{{ url('/bridal-suite') }}" class="site_arrow_link site_arrow_left" aria-label="Previous page: Bridal Suite"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/miniature-golf-course') }}" class="site_arrow_link site_arrow_right" aria-label="Next page: Miniature Golf Course"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h1 class="mb-0">The Pool</h1>
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
                            <h2 class="site_section_title">The Pool</h2><hr>
                            <ul class="site_content_list pl-4">
                                <li>Villa Fabulosa features a beautiful and private pool with two Baja Shelves, four lounge chairs and an 8' x 12' spa.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gallery-grid">
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-pool-30.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-pool-30-thumb.webp') }}" alt="Pool"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-pool-13.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-pool-13-thumb.webp') }}" alt="Pool"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-pool-13-2.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-pool-13-2-thumb.webp') }}" alt="Pool"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-pool-31.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-pool-31-thumb.webp') }}" alt="Pool"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-pool-33.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-pool-33-thumb.webp') }}" alt="Pool"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-pool-34.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-pool-34-thumb.webp') }}" alt="Pool"
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
