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
</style>
@endsection

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/the-pool') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/the-sports-area') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Miniature Golf Course</h2>
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
                            <h1 class="site_section_title">Miniature Golf Course</h1><hr>
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
                <img src="{{ asset('frontend/imgs/111-AERIAL-Edit-MLS.JPG') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/4-AERIAL-MLS.JPG') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2076_MqbYXMhs-0pIYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2077_ezZXXMhs-EyGYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2078_BCYXXMhs-stHYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2081_ZQYXXMhs-fdJYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2082_hPbYXMhs-0pIYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2083_9QaYXMhs-fUJYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2084_8VYXXMhs-qCHYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
            <div class="col-6 col-md-3 gallery-grid-item">
                <img src="{{ asset('frontend/imgs/IMG_2085_0AbYXMhs-CVIYXMhs.jpg') }}" alt="Miniature Golf Course"
                     class="img-fluid gallery-grid-image">
            </div>
        </div>
    </div>
</section>

@endsection
