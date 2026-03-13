@extends('layouts.frontend')

@section('title', 'The Sports Area — Villa Fabulosa')

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
        <a href="{{ url('/miniature-golf-course') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/birds-eye') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">The Sports Area</h2>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5 site_section_mobile">
    <div class="container">
        <div class="row"><div class="col-lg-12">
            <div class="site_display_table"><div class="site_display_table_cell">
                <div class="site_content_box p-0">
                    <h1 class="site_section_title">The Sports Area</h1><hr>
                    <ul class="site_content_list pl-4">
                        <li>Villa Fabulosa offers a plethora of sports areas to satisfy the athletic abilities of everyone in the family. It features a pickleball and basketball court, a putting green, and a Bocce Ball Court. It also features a Volleyball and badminton court, along with popular lawn games such as Corn Hole and many more. Villa Fabulosa also provides other sports equipment such as soccer ball, football and so much more.</li>
                    </ul>
                </div>
            </div></div>
        </div></div>

        <div class="row gallery-grid">
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/4-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/13.13-AERIAL-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/118-AERIAL-Edit-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/38-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/39-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/40-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/41-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/42-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/44-FIELD-MLS.JPG') }}" alt="Sports Area"
                     class="img-fluid gallery-grid-image">
            </div>
        </div>
    </div>
</section>

@endsection
