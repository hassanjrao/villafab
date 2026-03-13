@extends('layouts.frontend')

@section('title', 'Bridal Suite — Villa Fabulosa')

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
        <a href="{{ url('/game-rooms') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/the-pool') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Bridal Suite</h2>
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
                            <h1 class="site_section_title">The Bridal Suite</h1><hr>
                            <ul class="site_content_list pl-4">
                                <li>Villa Fabulosa even includes a 400-square foot bridal suite, complete with 4 hair and makeup stations, a champagne bar, a king size bed, a sofa bed, a large wall-mounted TV, a full-size mirror, a walk-in closet, and plenty of room for the entire bridal party to get ready for the special event! It also includes 2 washing machines and 2 dryers.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gallery-grid">
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/13.33-DRESSING-ROOM-MLS.JPG') }}" alt="Bridal Suite"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/73-BEDROOM-MLS.JPG') }}" alt="Bridal Suite"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/74-BEDROOM-MLS.JPG') }}" alt="Bridal Suite"
                     class="img-fluid gallery-grid-image">
            </div>
        </div>
    </div>
</section>

@endsection
