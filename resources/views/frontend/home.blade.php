@extends('layouts.frontend')

@section('title', 'Villa Fabulosa')

@section('head_extra')
    <style>
        .pluslink,
        .pluslink:visited,
        .pluslink:hover,
        .pluslink:active {
            text-decoration: none;
        }

        /* Villa info section: KTLA text – underline only on hover */
        .villinfo-link,
        .villinfo-link .villinfo-ktla-text {
            text-decoration: none;
        }
        .villinfo-link:hover .villinfo-ktla-text {
            text-decoration: underline;
        }

        /* ── Hero Gallery ── */
        .hero-gallery-wrapper {
            margin: 0;
            border-radius: 0;
            overflow: hidden;
            cursor: pointer;
            width: 100%;
            max-width: 100%;
            position: relative;
        }

        .hero-gallery-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
            grid-template-rows: 1fr 1fr;
            gap: 4px;
            height: clamp(280px, 38vw, 560px);
        }

        .hero-main {
            grid-row: 1 / 3;
            overflow: hidden;
            position: relative;
        }

        .hero-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .hero-main:hover img {
            transform: scale(1.03);
        }

        .hero-right {
            grid-row: 1 / 3;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 4px;
            height: 100%;
        }

        .hero-grid-item {
            overflow: hidden;
            position: relative;
            height: 100%;
        }

        .hero-grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .hero-grid-item:hover img {
            transform: scale(1.04);
        }

        .hero-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.88);
            font-size: 0.78rem;
            font-weight: 600;
            color: #222;
            padding: 4px 10px;
            border-radius: 4px;
            pointer-events: none;
        }

        .show-all-photos-btn {
            position: absolute;
            bottom: 14px;
            right: 14px;
            background: #fff;
            border: 1.5px solid #333;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #222;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            z-index: 5;
        }

        .show-all-photos-btn:hover {
            background: #f5f5f5;
        }

        /* hide non-main images on mobile */
        @media (max-width: 767px) {
            .hero-gallery-grid {
                grid-template-columns: 1fr;
                grid-template-rows: 280px;
                height: 280px;
            }

            .hero-right {
                display: none;
            }

            .hero-main {
                grid-row: 1;
            }

            .show-all-photos-btn-mobile {
                display: flex !important;
                position: absolute;
                bottom: 14px;
                right: 14px;
            }
        }

        /* ── Photo Tour Modal ── */
        .photo-tour-modal .modal-dialog {
            max-width: 100%;
            margin: 0;
            min-height: 100vh;
        }

        .photo-tour-modal .modal-content {
            min-height: 100vh;
            border: none;
            border-radius: 0;
        }

        .photo-tour-modal .modal-header {
            position: sticky;
            top: 0;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 14px 24px;
            z-index: 1050;
            display: flex;
            align-items: center;
        }

        .photo-tour-modal .btn-back {
            background: none;
            border: none;
            font-size: 1.3rem;
            color: #333;
            padding: 0 14px 0 0;
            cursor: pointer;
            line-height: 1;
        }

        .photo-tour-modal .btn-back:hover {
            color: #000;
        }

        .photo-tour-modal .modal-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #222;
            margin: 0;
            flex: 1;
        }

        .photo-tour-modal .modal-actions button {
            background: none;
            border: 1.5px solid #ccc;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            margin-left: 8px;
            transition: border-color 0.2s;
        }

        .photo-tour-modal .modal-actions button:hover {
            border-color: #333;
        }

        .photo-tour-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 14px;
            padding: 28px 32px;
        }

        @media (max-width: 1199px) {
            .photo-tour-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media (max-width: 991px) {
            .photo-tour-grid {
                grid-template-columns: repeat(4, 1fr);
                padding: 20px;
            }
        }

        @media (max-width: 767px) {
            .photo-tour-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                padding: 16px;
            }
        }

        .photo-tour-item {
            text-align: left;
        }

        .photo-tour-item img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            cursor: zoom-in;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .photo-tour-item img:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
        }

        .photo-tour-item .photo-label {
            font-size: 0.78rem;
            color: #555;
            margin-top: 6px;
            font-weight: 500;
        }

        /* ── Lightbox ── */
        #photo-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        #photo-lightbox.active {
            display: flex;
        }

        #photo-lightbox img {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 4px;
        }

        #photo-lightbox .lb-close {
            position: fixed;
            top: 20px;
            right: 24px;
            background: none;
            border: none;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            line-height: 1;
            z-index: 10001;
        }

        #photo-lightbox .lb-prev,
        #photo-lightbox .lb-next {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            padding: 12px 18px;
            border-radius: 4px;
            z-index: 10001;
            transition: background 0.2s;
        }

        #photo-lightbox .lb-prev:hover,
        #photo-lightbox .lb-next:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        #photo-lightbox .lb-prev {
            left: 16px;
        }

        #photo-lightbox .lb-next {
            right: 16px;
        }

        #photo-lightbox .lb-counter {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* ── Announcement Banner ── */
        .announcement-banner {
            background: linear-gradient(135deg, #f9f4ec 0%, #fdf8f0 100%);
            border: 1px solid #e8d5b0;
            border-radius: 8px;
            padding: 18px 28px;
            margin-bottom: 20px;
        }

        .announcement-banner .airbnb-link {
            color: #ff5a5f;
            font-weight: 600;
        }

        .announcement-banner .airbnb-link:hover {
            color: #e04045;
        }

        /* ── Features Section ── */
        .features-section {
            background-color: #f9f6f0;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .features-list li {
            padding: 6px 0;
            font-size: 1rem;
            border-bottom: 1px solid #e8e0d5;
        }

        .features-list li:last-child {
            border-bottom: none;
        }

        .features-list li::before {
            content: "✓";
            color: #c8a96e;
            font-weight: bold;
            margin-right: 10px;
        }

        .rating-stars {
            color: #f5a623;
            font-size: 1.5rem;
        }

        .rating-big {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .rating-divider {
            font-size: 2rem;
            color: #999;
        }

        .rating-total {
            font-size: 2rem;
            color: #999;
        }

        .btn-check-avail {
            display: inline-block;
            background-color: #4a90d9;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 14px 40px;
            border-radius: 4px;
            border: none;
            letter-spacing: 0.5px;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn-check-avail:hover {
            background-color: #2c6fad;
            color: #fff;
            text-decoration: none;
        }

        /* ── Reviews ── */
        .reviews-section {
            background-color: #fff;
        }

        .review-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 22px 24px;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .review-stars {
            color: #f5a623;
            font-size: 1rem;
        }

        .reviewer-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .review-text {
            font-size: 0.93rem;
            color: #444;
        }

        .overall-rating-box {
            background: #f9f6f0;
            border-radius: 10px;
            padding: 28px 20px;
            text-align: center;
        }

        /* ── Map ── */
        .map-section {
            position: relative;
        }

        .map-overlay {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.93);
            padding: 18px 36px;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            white-space: nowrap;
            z-index: 10;
        }

        .map-overlay h3 {
            margin: 0 0 10px 0;
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
        }

        .map-overlay .btn-contact {
            display: inline-block;
            background-color: #c8a96e;
            color: #fff;
            padding: 10px 28px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .map-overlay .btn-contact:hover {
            background-color: #a8893e;
            color: #fff;
        }
    </style>
@endsection

@section('content')

    {{-- ══════════════════════════════════════════
     HERO GALLERY  (Airbnb‑style)
══════════════════════════════════════════ --}}
    <div class="hero-gallery-wrapper" id="heroGallery">
        <div class="hero-gallery-grid">

            {{-- Large main photo --}}
            <div class="hero-main" onclick="openPhotoTour()">
                <img src="{{ asset('frontend/imgs/photos-for-vrbo/1-POOL-MLS.JPG') }}"
                    alt="Villa Fabulosa – front exterior with pool">
            </div>

            {{-- 2 × 2 right grid --}}
            <div class="hero-right">
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/13.13-AERIAL-MLS.JPG') }}" alt="Aerial view at dusk">
                </div>
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/3-FIELD-MLS.JPG') }}" alt="Sports court aerial view">
                </div>
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/6-LIVING-MLS.JPG') }}" alt="Living & media room">
                </div>
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/Golf-Course-11.jpg') }}"
                        alt="18-Hole Miniature Golf Course">
                    <div class="hero-label">18-Hole Miniature Golf Course</div>
                    <button class="show-all-photos-btn" onclick="event.stopPropagation(); openPhotoTour()">
                        <i class="fa fa-th" aria-hidden="true"></i> Show all photos
                    </button>
                </div>
            </div>

        </div>

        {{-- Mobile-only "Show all photos" overlay --}}
        <div class="show-all-photos-btn-mobile d-none" style="position:absolute;bottom:14px;right:14px;z-index:5;">
            <button class="show-all-photos-btn" onclick="openPhotoTour()">
                <i class="fa fa-th" aria-hidden="true"></i> Show all photos
            </button>
        </div>
    </div>
    {{-- ══════════════════════════════════════════ --}}


    {{-- ══════════════════════════════════════════
     PHOTO TOUR MODAL
══════════════════════════════════════════ --}}
    <div class="modal fade photo-tour-modal" id="photoTourModal" tabindex="-1" role="dialog" aria-label="Photo tour">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                {{-- Sticky header --}}
                <div class="modal-header">
                    <button class="btn-back" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                    <h5 class="modal-title">Photo tour</h5>
                    <div class="modal-actions">
                        {{-- <button><i class="fa fa-share-square-o"></i> Share</button>
                        <button><i class="fa fa-heart-o"></i> Save</button> --}}
                    </div>
                </div>

                {{-- Photo grid --}}
                <div class="modal-body p-0">
                    @php
                        $photoTour = [
                            ['src' => 'photos-for-vrbo/1-POOL-MLS.JPG', 'label' => 'Living room 1'],
                            ['src' => 'photos-for-vrbo/6-LIVING-MLS.JPG', 'label' => 'Living room 2'],
                            ['src' => 'photos-for-vrbo/7-KITCHEN-MLS.JPG', 'label' => 'Full kitchen'],
                            ['src' => 'photos-for-vrbo/13-DINING-Edit-MLS.JPG', 'label' => 'Dining area'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('54 BEDROOM MLS.JPG'), 'label' => 'Bedroom 1'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('70 BEDROOM MLS.JPG'), 'label' => 'Bedroom 2'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('73 BEDROOM MLS.JPG'), 'label' => 'Bedroom 3'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('80 BEDROOM MLS.JPG'), 'label' => 'Bedroom 4'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('84 BEDROOM MLS.JPG'), 'label' => 'Bedroom 5'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('87 BEDROOM MLS.JPG'), 'label' => 'Bedroom 6'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('Bridal Suite 3.jpg'), 'label' => 'Bedroom 7'],
                            [
                                'src' => 'photos-for-vrbo/' . rawurlencode('55 BATHROOM MLS.JPG'),
                                'label' => 'Full bathroom 1',
                            ],
                            [
                                'src' => 'photos-for-vrbo/' . rawurlencode('71 BATHROOM MLS.JPG'),
                                'label' => 'Full bathroom 2',
                            ],
                            [
                                'src' => 'photos-for-vrbo/' . rawurlencode('76 BATHROOM MLS.JPG'),
                                'label' => 'Full bathroom 3',
                            ],
                            [
                                'src' => 'photos-for-vrbo/' . rawurlencode('85 BATHROOM MLS.JPG'),
                                'label' => 'Full bathroom 4',
                            ],
                            ['src' => 'photos-for-vrbo/13.5KITCHENETTE-Edit-MLS.JPG', 'label' => 'Full bathroom 5'],
                            ['src' => 'photos-for-vrbo/13.8-IMG_1734-MLS.JPG', 'label' => 'Half bathroom'],
                            ['src' => 'photos-for-vrbo/' . rawurlencode('23 PATIO MLS.JPG'), 'label' => 'Backyard'],
                            ['src' => 'photos-for-vrbo/2-POOL-MLS.JPG', 'label' => 'Pool'],
                            ['src' => 'photos-for-vrbo/13.14-POOL-MLS.JPG', 'label' => 'Pool view'],
                            ['src' => 'photos-for-vrbo/5-ARCADE-MLS.JPG', 'label' => 'Game room 1'],
                            ['src' => 'photos-for-vrbo/13.11-GAME-MLS.JPG', 'label' => 'Game room 2'],
                            ['src' => 'photos-for-vrbo/Golf-Course-11.jpg', 'label' => 'Miniature golf'],
                            ['src' => 'photos-for-vrbo/4-AERIAL-MLS.JPG', 'label' => 'Aerial view'],
                            ['src' => 'photos-for-vrbo/13.13-AERIAL-MLS.JPG', 'label' => 'Aerial – dusk'],
                            ['src' => 'photos-for-vrbo/3-FIELD-MLS.JPG', 'label' => 'Sports court'],
                            ['src' => 'photos-for-vrbo/Pergola.jpg', 'label' => 'Pergola'],
                            ['src' => 'photos-for-vrbo/13-VIEW-MLS.JPG', 'label' => 'Wine country view'],
                            ['src' => 'photos-for-vrbo/13.19-FOYER-MLS.JPG', 'label' => 'Foyer'],
                            ['src' => 'photos-for-vrbo/8-KITCHEN-MLS.JPG', 'label' => 'Additional photos'],
                        ];
                    @endphp

                    <div class="photo-tour-grid">
                        @foreach ($photoTour as $i => $photo)
                            <div class="photo-tour-item">
                                <img src="{{ asset('frontend/imgs/' . $photo['src']) }}" alt="{{ $photo['label'] }}"
                                    onclick="openLightbox({{ $i }})" loading="lazy">
                                <div class="photo-label">{{ $photo['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- ══════════════════════════════════════════ --}}


    {{-- ══════════════════════════════════════════
     LIGHTBOX (full-screen image viewer)
══════════════════════════════════════════ --}}
    <div id="photo-lightbox">
        <button class="lb-close" onclick="closeLightbox()" aria-label="Close">&times;</button>
        <button class="lb-prev" onclick="lbNavigate(-1)" aria-label="Previous"><i class="fa fa-angle-left"></i></button>
        <img id="lb-img" src="" alt="">
        <button class="lb-next" onclick="lbNavigate(1)" aria-label="Next"><i class="fa fa-angle-right"></i></button>
        <div class="lb-counter" id="lb-counter"></div>
    </div>
    {{-- ══════════════════════════════════════════ --}}


    <!-- Villa Info Start - entire section links to KTLA announcement -->
    <a href="http://www.youtube.com/watch?v=xwmYm-XCr_o&t=206s"
       target="_blank"
       rel="noopener"
       class="d-block text-decoration-none villinfo-link"
       style="color: inherit; cursor: pointer; text-decoration: none;">
        <div id="villinfo" class="site_villa_info_wrapper mb-4 mt-4">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-12 text-center">
                        <h1 class="site_title_letter_space mb-3">Villa Fabulosa</h1>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="site_title_letter_space"><i>Voted by Expedia Group and VRBO as the Top vacation rental in
                                California and one of the top Ten Vacation Rentals in the entire country, out of over two
                                million homes!
                        </i>
                        </h3>
                        <h3 class="text-center text-white villinfo-ktla-text">
                            See the official announcement on KTLA
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <!-- Villa Info End -->

    {{-- Villa description + video --}}
    <section class="py-4">
        <div class="container">
            <div class="row align-items-stretch">
                {{-- Text box --}}
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <p class="mb-3">
                                Villa Fabulosa is the ultimate gathering place for family and friends&mdash;a luxurious
                                5‑acre estate perched in the heart of Temecula Wine Country, offering breathtaking
                                360‑degree views. Perfectly located among more than 55 top‑rated wineries (many with
                                excellent restaurants), Villa Fabulosa places you right in the center of it all.
                            </p>
                            <div class="collapse" id="villaDescriptionMore">
                                <p>
                                    On the property, you will find a private oasis with a beautiful pool and 14‑person
                                    spa, a fully equipped outdoor kitchen, an 18‑hole miniature golf course, a game room
                                    packed with arcades, and a full sports court for basketball, pickleball, volleyball,
                                    badminton, and more. Whether you are lounging by the pool or enjoying a friendly
                                    competition on the court, Villa Fabulosa delivers a true resort‑style experience
                                    that is hard to beat.
                                </p>
                            </div>
                            <button
                                class="btn btn-primary btn-sm mt-2"
                                type="button"
                                data-toggle="collapse"
                                data-target="#villaDescriptionMore"
                                aria-expanded="false"
                                aria-controls="villaDescriptionMore"
                                onclick="toggleVillaDescription(this)"
                            >
                                Show More
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Video --}}
                <div class="col-lg-6 mb-4">
                    <div class="embed-responsive embed-responsive-16by9 h-100">
                        <iframe
                            class="embed-responsive-item"
                            src="https://www.youtube.com/embed/u5zfhEQfkpk?si=vdTOesRahNdQ_Zmy"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="site_services_box_wrapper pb-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/the-rooms') }}">
                            <img style="height: 250px;"
                                src="{{ asset('frontend/imgs/photos-for-vrbo/12-LIVING-MLS.JPG') }}" class="img-fluid">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #1da3dd;">The Rooms</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/the-pool') }}">
                            <img style="height: 250px;"
                                src="{{ asset('frontend/imgs/photos-for-vrbo/13.13-AERIAL-MLS.JPG') }}"
                                class="img-fluid">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #1da3dd;">The Pool</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/game-rooms') }}">
                            <img style="height: 250px;"
                                src="{{ asset('frontend/imgs/photos-for-vrbo/5-ARCADE-MLS.JPG') }}" class="img-fluid">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #1da3dd;">Game Room</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/miniature-golf-course') }}">
                            <img style="height: 250px;"
                                src="{{ asset('frontend/imgs/photos-for-vrbo/4-AERIAL-MLS.JPG') }}" class="img-fluid">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #1da3dd;">Miniature Golf</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/wineries') }}">
                            <img style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/Pergola.jpg') }}"
                                class="img-fluid">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #1da3dd;">Wineries</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/birds-eye') }}">
                            <img style="height: 250px;" src="{{ asset('frontend/imgs/108-AERIAL-Edit-MLS.JPG') }}"
                                class="img-fluid">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #1da3dd;">Bird's Eye View</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services Boxes End -->

    {{-- Stats bar (blue strip) --}}
    <section class="py-3" style="background-color:#00a9e0;color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="mb-2" style="font-weight:600;">
                        The most luxurious, elegant, and modern vacation rental in Temecula Wine Country
                    </h3>
                </div>
            </div>
            <div class="row text-center" style="font-weight:600;font-size:1.05rem;">
                <div class="col-6 col-md-3 mb-2 mb-md-0">
                    24 Guests
                </div>
                <div class="col-6 col-md-3 mb-2 mb-md-0">
                    7 Bedrooms
                </div>
                <div class="col-6 col-md-3">
                    12 Beds
                </div>
                <div class="col-6 col-md-3">
                    5.5 Baths
                </div>
            </div>
        </div>
    </section>

    {{-- Space & Layout + Rating / Availability --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                {{-- Left column: space & layout lists --}}
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <h4 class="mb-3" style="font-weight:700;">Space &amp; Layout</h4>
                    <ol style="padding-left:1.2rem;">
                        <li>Brand new, Ibiza-style home</li>
                        <li>Super modern and elegant decor</li>
                        <li>Amazing 360 degree views</li>
                        <li>Bridal Suite for getting ready for the special event</li>
                        <li>A chef's kitchen with two dishwashers and ice makers</li>
                        <li>Every cooking gadget imaginable</li>
                        <li>Impressive fireplace with a 22-foot ceiling</li>
                        <li>Two Tesla chargers</li>
                        <li>ADA-accessible bathroom</li>
                    </ol>

                    <h4 class="mt-4 mb-3" style="font-weight:700;">Entertainment Paradise</h4>
                    <ol style="padding-left:1.2rem;">
                        <li>Professional 18-hole mini-golf</li>
                        <li>Pickleball, basketball, and bocce courts</li>
                        <li>Full arcade, poker table, shuffleboard, and air hockey</li>
                        <li>Professional pool table</li>
                        <li>Outdoor kitchen featuring pizza ovens, a teppanyaki grill, and BBQ station</li>
                        <li>Designer pool with dual Baja shelves</li>
                        <li>Two dining tables with seating for 16 guests</li>
                        <li>An intimate, private setting</li>
                        <li>In the center of wine country</li>
                    </ol>
                </div>

                {{-- Right column: rating + availability card --}}
                <div class="col-lg-5">
                    <div class="mb-3 d-flex align-items-start">
                        <div class="mr-3">
                            <span class="badge badge-warning" style="background:#fbdc7d;color:#000;font-weight:600;">
                                Guest favorite
                            </span>
                        </div>
                        <div>
                            <strong>One of the most loved homes on Airbnb, according to guests</strong>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div style="font-size:2.8rem;font-weight:700;line-height:1;">5.0</div>
                        <div class="ml-2">
                            <div style="color:#f5a623;">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div style="font-size:0.95rem;">31 Reviews</div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="#" method="GET" id="bookingPreviewForm" novalidate>
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label class="small text-muted mb-1" for="checkin_date">Check-in</label>
                                        <input
                                            type="date"
                                            id="checkin_date"
                                            name="checkin_date"
                                            class="form-control"
                                        >
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="small text-muted mb-1" for="checkout_date">Check-out</label>
                                        <input
                                            type="date"
                                            id="checkout_date"
                                            name="checkout_date"
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="small text-muted mb-1" for="guests">Guests</label>
                                    <select id="guests" name="guests" class="form-control">
                                        @for($i = 1; $i <= 24; $i++)
                                            <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="submit"
                                        class="btn btn-primary btn-block"
                                        style="font-weight:600;">
                                    Check Availability
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Airbnb + Vrbo badges with wine country map --}}
    <section class="pt-5 pb-4" style="background-color:#f7f7f7;">
        <div class="container">
            <h2 class="site_title_letter_space text-center mb-4" style="color: #1da3dd;">What our customers say</h2>

            {{-- Top badges bar --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                    {{-- Airbnb badge (left) --}}
                    <a href="https://www.airbnb.com/h/villa-fabulosa"
                       target="_blank"
                       class="d-flex align-items-center text-decoration-none mb-3 mb-md-0">
                        <img src="{{ asset('frontend/imgs/airbnb.png') }}" alt="Airbnb"
                             style="height:74px;width:auto;" class="mr-3">
                        <div class="d-flex flex-column">
                            <span style="font-size:1rem;">
                                <strong>5.0</strong>
                                <span style="color:#f5a623;margin-left:4px;">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                            </span>
                            <span class="text-muted" style="font-size:0.85rem;">
                                One of the most loved homes on Airbnb, according to guests
                            </span>
                        </div>
                    </a>

                    {{-- Vrbo badge (right) --}}
                    <a href="https://www.vrbo.com/3610312"
                       target="_blank"
                       class="d-flex align-items-center text-decoration-none ml-md-auto">
                        <img src="{{ asset('frontend/imgs/verbo.png') }}" alt="Vrbo"
                             style="height:34px;width:auto;" class="mr-3">
                        <div class="d-flex flex-column text-md-right">
                            <span class="text-muted" style="font-size:0.85rem;">
                                10/10 Loved by Guests
                            </span>
                            <span class="text-muted" style="font-size:0.85rem;">
                                Top 10% of guest reviews in this area
                            </span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Map section --}}
            <div class="text-center mb-3">
                <h3 class="mb-2" style="font-weight:600; color: #1da3dd;">Located in the heart of Wine Country</h3>
                <hr class="mb-4" style="border-top:1px solid #ddd;max-width:260px;">
            </div>
            <div class="text-center">
                <img src="{{ asset('frontend/imgs/temecula-wine-country-villa-fabulosa.png') }}"
                     alt="Temecula Wine Country map showing Villa Fabulosa"
                     class="img-fluid"
                     style="max-width:100%;height:auto;">
            </div>
        </div>
    </section>

    <!-- Contact Form Start -->
    <section id="contact" class="pt-5 pb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="container">
                    <div class="text-center mb-5">
                        <h1 class="site_section_title">Contact Us</h1>
                        <hr>
                        <p>We would love to hear from you. Please send us a note and let us know if you have any questions
                            or what you think about Villa Fabulosa.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="requestform" action="{{ route('contact') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fname') is-invalid @enderror"
                                    name="fname" value="{{ old('fname') }}">
                                <small class="form-text text-muted">First Name</small>
                                @error('fname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>&nbsp;</label>
                                <input type="text" class="form-control @error('lname') is-invalid @enderror"
                                    name="lname" value="{{ old('lname') }}">
                                <small class="form-text text-muted">Last Name</small>
                                @error('lname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>&nbsp;</label>
                                <textarea name="reason" class="form-control" cols="30" rows="1">{{ old('reason') }}</textarea>
                                <small class="form-text text-muted">How Did You Hear About Villa Fabulosa</small>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email Address<span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                    name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Message<span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                    <img src="{{ asset('frontend/imgs/processed-1985b06c-1830-4ea5-a2e8-f9f52acfcf49_9jhkqIFL.jpeg') }}"
                                        class="card-img" alt="Villa Magnifica" style="height: 230px; object-fit: cover;">
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


    {{-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ --}}
    <script>
        /* ── Photo Tour Modal ── */
        function openPhotoTour() {
            $('#photoTourModal').modal('show');
        }

        /* ── Lightbox ── */
        var lbPhotos = @json(array_map(function ($p) {
                return asset('frontend/imgs/' . $p['src']);
            }, $photoTour));
        var lbIndex = 0;

        function openLightbox(index) {
            lbIndex = index;
            document.getElementById('lb-img').src = lbPhotos[index];
            document.getElementById('lb-counter').textContent = (index + 1) + ' / ' + lbPhotos.length;
            document.getElementById('photo-lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('photo-lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        function lbNavigate(dir) {
            lbIndex = (lbIndex + dir + lbPhotos.length) % lbPhotos.length;
            document.getElementById('lb-img').src = lbPhotos[lbIndex];
            document.getElementById('lb-counter').textContent = (lbIndex + 1) + ' / ' + lbPhotos.length;
        }

        /* Keyboard navigation */
        document.addEventListener('keydown', function(e) {
            var lb = document.getElementById('photo-lightbox');
            if (!lb.classList.contains('active')) return;
            if (e.key === 'ArrowLeft') lbNavigate(-1);
            if (e.key === 'ArrowRight') lbNavigate(1);
            if (e.key === 'Escape') closeLightbox();
        });

        /* Close lightbox on background click */
        document.getElementById('photo-lightbox').addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });

        /* Restore body scroll when modal closes */
        $('#photoTourModal').on('hidden.bs.modal', function() {
            document.body.style.overflow = '';
        });

        /* Toggle villa description button text */
        function toggleVillaDescription(button) {
            var expanded = button.getAttribute('aria-expanded') === 'true';
            // After click, the state will flip
            var willBeExpanded = !expanded;
            button.textContent = willBeExpanded ? 'Show Less' : 'Show More';
        }
    </script>

@endsection
