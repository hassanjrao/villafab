@extends('layouts.frontend')

@section('title', 'Game Room — Villa Fabulosa')

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
        <a href="{{ url('/the-rooms') }}" class="site_arrow_link site_arrow_left" aria-label="Previous page: The Rooms"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/bridal-suite') }}" class="site_arrow_link site_arrow_right" aria-label="Next page: Bridal Suite"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h1 class="mb-0">Game Room</h1>
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
                            <h2 class="site_section_title">Game Room</h2><hr>
                            <ul class="site_content_list pl-4">
                                <li>Villa Fabulosa features a very large game room with some of the top Video Arcades including: Tekken 5, a super exciting martial art game, Target Force Gold, a super fun shooting game similar to Time Crisis, Donkey Kong Junior, Terminator 2-Judgement day, Ms. Pac-Man and Midway Mortal Kombat 2.</li>
                                <li>Villa Fabulosa's game room also includes Ice Hockey, a Foosball, Shuffle Board and a Poker table. It includes two sofa beds with a 4K smart TV with Netflix and Hulu subscription.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gallery-grid">
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-05.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-05-thumb.webp') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-13.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-13-thumb.webp') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-46.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-46-thumb.webp') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-47.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-47-thumb.webp') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-48.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-48-thumb.webp') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-172.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-172-thumb.webp') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img loading="lazy" decoding="async" data-full="{{ asset('frontend/imgs/villa-fabulosa-game-room-172-2.webp') }}" src="{{ asset('frontend/imgs/villa-fabulosa-game-room-172-2-thumb.webp') }}" alt="Game Room"
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
