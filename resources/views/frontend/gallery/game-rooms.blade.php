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
</style>
@endsection

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/the-rooms') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/bridal-suite') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Game Room</h2>
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
                            <h1 class="site_section_title">Game Room</h1><hr>
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
                <img src="{{ asset('frontend/imgs/5-ARCADE-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/13.11-GAME-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/46-ARCADE-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/47-ARCADE-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/48-ARCADE-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_1722-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_1723-MLS.JPG') }}" alt="Game Room"
                     class="img-fluid gallery-grid-image">
            </div>
        </div>
    </div>
</section>

@endsection
