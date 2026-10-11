@extends('layouts.frontend')

@section('title', "Bird's Eye — Villa Fabulosa")

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
        <a href="{{ url('/the-sports-area') }}" class="site_arrow_link site_arrow_left" aria-label="Previous page: The Sports Area"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/floorplan') }}" class="site_arrow_link site_arrow_right" aria-label="Next page: Floorplan"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h1 class="mb-0">Bird's Eye</h1>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="site_section_wrapper site_section_mobile" style="height:auto">
    <div class="container">
        <div class="row"><div class="col-lg-12">
            <div class="site_content_box">
                <h2 class="site_section_title">Bird's Eye</h2><hr>
                <ul class="site_temecula_links site_content_list pl-4">
                    <li>Perched on a breathtaking hillside, this architectural masterpiece boasts panoramic views of hot air balloons and Temecula wine country, where over 45 nearby wineries await your exploration.</li>
                </ul>
            </div>
        </div></div>

        <div class="row gallery-grid">
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-106.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-106-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-107.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-107-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-108.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-108-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-110.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-110-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-111.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-111-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-113.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-113-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-114.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-114-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-116.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-116-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-117.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-117-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-118.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-118-thumb.webp') }}" alt="Bird's Eye"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-120.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-120-thumb.webp') }}" alt="Bird's Eye"
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
