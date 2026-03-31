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

        /* ── Booking widget card ── */
        .booking-widget-card {
            border-radius: 14px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            background: #fff;
            padding: 22px 20px 18px;
        }

        .booking-widget-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .booking-widget-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #222;
            line-height: 1.2;
        }

        .booking-widget-subtitle {
            font-size: 0.8rem;
            color: #888;
            margin-top: 2px;
        }

        .booking-widget-rating {
            font-size: 0.82rem;
            color: #444;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        /* Date row - Airbnb segmented style */
        .booking-date-row {
            display: flex;
            border: 1.5px solid #b0b0b0;
            border-radius: 10px 10px 0 0;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .booking-date-row:hover {
            border-color: #1da3dd;
        }

        .booking-date-cell {
            flex: 1;
            padding: 10px 14px 8px;
            position: relative;
            transition: background 0.15s;
        }

        .booking-date-cell:hover {
            background: #f0f8ff;
        }

        .booking-date-cell+.booking-date-cell {
            border-left: 1.5px solid #b0b0b0;
        }

        .booking-field-label {
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: #333;
            display: block;
            margin-bottom: 3px;
        }

        .booking-date-input {
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 0.92rem;
            color: #222;
            background: transparent !important;
            font-weight: 500;
            box-shadow: none !important;
            cursor: pointer;
            width: 100%;
            height: auto !important;
            line-height: 1.3;
        }

        .booking-date-input::placeholder {
            color: #aaa;
            font-weight: 400;
        }

        /* Guests box */
        .booking-guests-box {
            border: 1.5px solid #b0b0b0;
            border-top: none;
            border-radius: 0 0 10px 10px;
            padding: 10px 14px 8px;
            margin-bottom: 14px;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .booking-guests-box:hover {
            border-color: #1da3dd;
        }

        .booking-guests-select {
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 0.92rem;
            color: #222;
            background: transparent !important;
            font-weight: 500;
            box-shadow: none !important;
            width: 100%;
            height: auto !important;
            cursor: pointer;
            outline: none;
        }

        /* Nights counter bar */
        .booking-nights-bar {
            background: #f0f9ff;
            border: 1px solid #bee3f8;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 0.85rem;
            color: #1a7aad;
            font-weight: 500;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Reserve button */
        .booking-reserve-btn {
            display: block;
            width: 100%;
            background: linear-gradient(135deg, #1da3dd 0%, #1485b8 100%);
            color: #fff !important;
            border: none;
            border-radius: 9px;
            padding: 13px;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-align: center;
            cursor: pointer;
            transition: opacity 0.18s, transform 0.12s;
            margin-bottom: 8px;
            text-decoration: none;
        }

        .booking-reserve-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: #fff !important;
        }

        .booking-no-charge-note {
            text-align: center;
            font-size: 0.76rem;
            color: #888;
            margin-bottom: 6px;
        }

        .booking-clear-dates {
            display: block;
            text-align: center;
            font-size: 0.76rem;
            color: #aaa;
            text-decoration: underline;
            cursor: pointer;
        }

        .booking-clear-dates:hover {
            color: #e74c3c;
        }

        @keyframes bk-spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Litepicker theme overrides ── */
        .litepicker .container__days .day-item.is-locked {
            pointer-events: none;
            text-decoration: line-through;
            color: #b23b3b;
            background-color: #fde2e2;
            border-radius: 50%;
            position: relative;
        }

        .litepicker .container__days .day-item.is-locked::after {
            content: '';
            position: absolute;
            left: 12%;
            right: 12%;
            top: 50%;
            height: 2px;
            background-color: rgba(178, 59, 59, 0.85);
            transform: translateY(-50%) rotate(-15deg);
        }

        .litepicker .container__days .day-item.is-start-date,
        .litepicker .container__days .day-item.is-end-date {
            background-color: #1da3dd !important;
            color: #fff !important;
            border-radius: 50%;
        }

        .litepicker .container__days .day-item.is-in-range {
            background-color: rgba(29, 163, 221, 0.13) !important;
            color: #1a7aad;
        }

        .litepicker .container__days .day-item.is-start-date:hover,
        .litepicker .container__days .day-item.is-end-date:hover {
            background-color: #1690c4 !important;
        }

        .litepicker .month-item-header .button-next-month svg,
        .litepicker .month-item-header .button-previous-month svg {
            fill: #1da3dd;
        }

        .litepicker .container__tooltip {
            background: #1da3dd;
            color: #fff;
        }

        .litepicker .container__tooltip::before {
            border-top-color: #1da3dd;
        }

        .booking-minstay-tooltip {
            position: fixed;
            z-index: 12000;
            background: #002b53;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            border-radius: 4px;
            padding: 6px 10px;
            pointer-events: none;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.22);
            transform: translate(-50%, -120%);
        }

        .booking-minstay-tooltip::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -6px;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #002b53;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">
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
    <a href="http://www.youtube.com/watch?v=xwmYm-XCr_o&t=206s" target="_blank" rel="noopener"
        class="d-block text-decoration-none villinfo-link" style="color: inherit; cursor: pointer; text-decoration: none;">
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
                            <button class="btn btn-primary btn-sm mt-2" type="button" data-toggle="collapse"
                                data-target="#villaDescriptionMore" aria-expanded="false"
                                aria-controls="villaDescriptionMore" onclick="toggleVillaDescription(this)">
                                Show More
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Video --}}
                <div class="col-lg-6 mb-4">
                    <div class="embed-responsive embed-responsive-16by9 h-100">
                        <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/u5zfhEQfkpk?si=vdTOesRahNdQ_Zmy"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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

                    <div class="booking-widget-card">

                        {{-- Header --}}
                        <div class="booking-widget-header">
                            <div>
                                <div class="booking-widget-title">Book Your Stay</div>
                                <div class="booking-widget-subtitle">Select dates to check availability</div>
                            </div>
                            <div class="booking-widget-rating">
                                <i class="fa fa-star" style="color:#f5a623;font-size:0.78rem;"></i>
                                <strong>5.0</strong>
                                <span class="text-muted">&nbsp;· 31 reviews</span>
                            </div>
                        </div>

                        <div id="bookingPreviewForm">

                            {{-- Date row --}}
                            <div class="booking-date-row">
                                <div class="booking-date-cell">
                                    <span class="booking-field-label">Check-in</span>
                                    <input type="text" id="checkin_date" name="checkin_date"
                                        class="booking-date-input" placeholder="Add date" readonly>
                                </div>
                                <div class="booking-date-cell">
                                    <span class="booking-field-label">Check-out</span>
                                    <input type="text" id="checkout_date" name="checkout_date"
                                        class="booking-date-input" placeholder="Add date" readonly>
                                </div>
                            </div>

                            {{-- Guests row (continues the segmented border) --}}
                            <div class="booking-guests-box">
                                <span class="booking-field-label">Guests</span>
                                <select id="guests" name="guests" class="booking-guests-select">
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}">{{ $i }}
                                            guest{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Minimum stay hint (shown once check-in is picked) --}}
                            <div class="booking-nights-bar" id="booking-nights-bar" style="display:none;">
                                <i class="fa fa-moon-o"></i>
                                <span id="booking-nights-text"></span>
                            </div>

                            {{-- Loading indicator --}}
                            <div id="booking-quote-loading"
                                style="display:none;
                                 text-align:center;padding:12px 0;margin-bottom:12px;
                                 color:#1da3dd;font-size:0.88rem;">
                                <span
                                    style="display:inline-block;width:16px;height:16px;
                                             border:2px solid #c8e8f4;border-top-color:#1da3dd;
                                             border-radius:50%;animation:bk-spin .7s linear infinite;
                                             vertical-align:middle;margin-right:6px;"></span>
                                Calculating price&hellip;
                            </div>

                            {{-- Min-stay error --}}
                            <div id="booking-minstay-error"
                                style="display:none;
                                 background:#fff3cd;border:1px solid #ffc107;border-radius:8px;
                                 padding:10px 14px;margin-bottom:12px;font-size:0.85rem;color:#856404;">
                                <i class="fa fa-exclamation-triangle me-1"></i>
                                <span id="booking-minstay-text"></span>
                            </div>

                            {{-- Price breakdown (shown when quote is valid) --}}
                            <div id="booking-price-breakdown"
                                style="display:none;
                                 background:#f8fffe;border:1px solid #c8e8f4;border-radius:10px;
                                 padding:14px 16px;margin-bottom:14px;font-size:0.88rem;">
                                <div id="breakdown-rows"></div>
                                <div
                                    style="border-top:1px solid #c8e8f4;margin-top:10px;padding-top:10px;
                                            display:flex;justify-content:space-between;align-items:center;">
                                    <strong style="font-size:1rem;">Total</strong>
                                    <strong id="breakdown-total" style="font-size:1.15rem;color:#1da3dd;"></strong>
                                </div>
                            </div>

                            {{-- Book Now button --}}
                            <a id="booking-book-now-btn" href="#" class="booking-reserve-btn"
                                style="display:block;text-align:center;text-decoration:none;">
                                Book Now
                            </a>

                            <p id="booking-no-dates-msg"
                                style="display:none;color:#e74c3c;
                               font-size:0.82rem;text-align:center;margin-top:6px;">
                                Please select check-in and check-out dates first.
                            </p>

                            <p class="booking-no-charge-note">You won't be charged yet</p>

                            <a href="#" class="booking-clear-dates" id="booking-clear-dates">Clear dates</a>

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
                    <a href="https://www.airbnb.com/h/villa-fabulosa" target="_blank"
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
                    <a href="https://www.vrbo.com/3610312" target="_blank"
                        class="d-flex align-items-center text-decoration-none ml-md-auto">
                        <img src="{{ asset('frontend/imgs/verbo.png') }}" alt="Vrbo" style="height:34px;width:auto;"
                            class="mr-3">
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
                    alt="Temecula Wine Country map showing Villa Fabulosa" class="img-fluid"
                    style="max-width:100%;height:auto;">
            </div>
        </div>
    </section>

    <!-- Contact Form Start -->
    <section id="contact" class="pt-5 pb-5" style="background:#f8f9fb;">
        <style>
            .cf-wrap {
                max-width: 760px;
                margin: 0 auto;
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 4px 32px rgba(0, 0, 0, .08);
                padding: 48px 52px 44px;
            }

            @media (max-width: 600px) {
                .cf-wrap {
                    padding: 28px 20px 24px;
                }
            }

            .cf-title {
                font-size: 2rem;
                font-weight: 800;
                color: #111;
                margin-bottom: 6px;
                text-align: center;
            }

            .cf-sub {
                text-align: center;
                color: #777;
                font-size: 0.95rem;
                margin-bottom: 36px;
                line-height: 1.6;
            }

            .cf-row {
                display: flex;
                gap: 16px;
                margin-bottom: 0;
            }

            @media (max-width: 600px) {
                .cf-row {
                    flex-direction: column;
                    gap: 0;
                }
            }

            .cf-field {
                flex: 1;
                display: flex;
                flex-direction: column;
                margin-bottom: 18px;
            }

            .cf-label {
                font-size: 0.78rem;
                font-weight: 700;
                color: #555;
                text-transform: uppercase;
                letter-spacing: .05em;
                margin-bottom: 6px;
            }

            .cf-label span {
                color: #e74c3c;
                margin-left: 2px;
            }

            .cf-input,
            .cf-textarea {
                border: 1.5px solid #dde0e6;
                border-radius: 9px;
                padding: 11px 14px;
                font-size: 0.93rem;
                color: #111;
                background: #fff;
                outline: none;
                transition: border-color .2s, box-shadow .2s;
                font-family: inherit;
                width: 100%;
            }

            .cf-input:focus,
            .cf-textarea:focus {
                border-color: #1da3dd;
                box-shadow: 0 0 0 3px rgba(29, 163, 221, .1);
            }

            .cf-input.is-invalid,
            .cf-textarea.is-invalid {
                border-color: #e74c3c;
            }

            .cf-error {
                font-size: 0.8rem;
                color: #e74c3c;
                margin-top: 4px;
            }

            .cf-hint {
                font-size: 0.77rem;
                color: #aaa;
                margin-top: 4px;
            }

            .cf-textarea {
                resize: vertical;
                min-height: 120px;
            }

            .cf-submit {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                width: 100%;
                background: #1da3dd;
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 14px 0;
                font-size: 1rem;
                font-weight: 700;
                letter-spacing: .03em;
                cursor: pointer;
                transition: background .2s, transform .15s;
                margin-top: 6px;
            }

            .cf-submit:hover {
                background: #178fc0;
                transform: translateY(-1px);
            }

            .cf-captcha-wrap {
                margin-top: 2px;
                margin-bottom: 14px;
            }

            /* Sister property card */
            .cf-sister {
                margin-top: 48px;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: 0 2px 16px rgba(0, 0, 0, .07);
                display: flex;
                text-decoration: none !important;
                color: inherit;
                transition: transform .2s, box-shadow .2s;
                max-width: 760px;
                margin-left: auto;
                margin-right: auto;
            }

            .cf-sister:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 24px rgba(0, 0, 0, .12);
            }

            .cf-sister img {
                width: 260px;
                min-height: 200px;
                object-fit: cover;
                flex-shrink: 0;
            }

            @media (max-width: 600px) {
                .cf-sister {
                    flex-direction: column;
                }

                .cf-sister img {
                    width: 100%;
                    height: 180px;
                }
            }

            .cf-sister-body {
                padding: 28px 28px;
                background: #fff;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .cf-sister-eyebrow {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: #1da3dd;
                font-weight: 700;
                margin-bottom: 8px;
            }

            .cf-sister-name {
                font-size: 1.4rem;
                font-weight: 800;
                color: #111;
                margin-bottom: 8px;
            }

            .cf-sister-desc {
                font-size: 0.88rem;
                color: #666;
                line-height: 1.6;
            }
        </style>

        <div class="container">

            <div class="cf-wrap">
                <div class="cf-title">Contact Us</div>
                <div class="cf-sub">We'd love to hear from you. Send us a note with any questions about Villa Fabulosa.
                </div>

                <form id="requestform" action="{{ route('contact') }}" method="POST" novalidate>
                    @csrf

                    <div class="cf-row">
                        <div class="cf-field">
                            <label class="cf-label" for="cf-fname">First Name <span>*</span></label>
                            <input type="text" id="cf-fname" name="fname"
                                class="cf-input @error('fname') is-invalid @enderror" value="{{ old('fname') }}"
                                placeholder="First name" autocomplete="given-name">
                            @error('fname')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="cf-field">
                            <label class="cf-label" for="cf-lname">Last Name <span>*</span></label>
                            <input type="text" id="cf-lname" name="lname"
                                class="cf-input @error('lname') is-invalid @enderror" value="{{ old('lname') }}"
                                placeholder="Last name" autocomplete="family-name">
                            @error('lname')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="cf-row">
                        <div class="cf-field">
                            <label class="cf-label" for="cf-email">Email Address <span>*</span></label>
                            <input type="email" id="cf-email" name="email"
                                class="cf-input @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="you@example.com" autocomplete="email">
                            @error('email')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="cf-field">
                            <label class="cf-label" for="cf-phone">Phone Number <span>*</span></label>
                            <input type="tel" id="cf-phone" name="phone_number"
                                class="cf-input @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number') }}" placeholder="+1 (555) 000-0000" autocomplete="tel">
                            @error('phone_number')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="cf-field">
                        <label class="cf-label" for="cf-reason">How Did You Hear About Us?</label>
                        <input type="text" id="cf-reason" name="reason" class="cf-input"
                            value="{{ old('reason') }}" placeholder="Google, referral, social media…">
                    </div>

                    <div class="cf-field">
                        <label class="cf-label" for="cf-message">Message <span>*</span></label>
                        <textarea id="cf-message" name="message" rows="5" class="cf-textarea @error('message') is-invalid @enderror"
                            placeholder="Tell us how we can help…">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="cf-error">{{ $message }}</div>
                        @enderror
                    </div>

                    @if (config('services.recaptcha.enabled') && config('services.recaptcha.site_key'))
                        <div class="cf-captcha-wrap">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            <div class="cf-error" id="cf-captcha-required" style="display:none;">
                                Please complete the captcha before submitting.
                            </div>
                            @error('g-recaptcha-response')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                            @error('captcha')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="cf-submit">
                        <i class="fa fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

            <a href="https://www.villamagnifica.com/" target="_blank" class="cf-sister">
                <img src="{{ asset('frontend/imgs/processed-1985b06c-1830-4ea5-a2e8-f9f52acfcf49_9jhkqIFL.jpeg') }}"
                    alt="Villa Magnifica">
                <div class="cf-sister-body">
                    <div class="cf-sister-eyebrow">Sister Property</div>
                    <div class="cf-sister-name">Villa Magnifica</div>
                    <div class="cf-sister-desc">Visit our other Short-Term Rental in Temecula Wine Country — equally
                        stunning and available to book.</div>
                </div>
            </a>

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
        var photoTourModalEl = document.getElementById('photoTourModal');
        if (photoTourModalEl) {
            photoTourModalEl.addEventListener('hidden.bs.modal', function() {
                document.body.style.overflow = '';
            });
        }

        /* Toggle villa description button text */
        function toggleVillaDescription(button) {
            var expanded = button.getAttribute('aria-expanded') === 'true';
            // After click, the state will flip
            var willBeExpanded = !expanded;
            button.textContent = willBeExpanded ? 'Show Less' : 'Show More';
        }
    </script>

@endsection

@section('scripts_extra')
    @if (config('services.recaptcha.enabled') && config('services.recaptcha.site_key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            (function() {
                var form = document.getElementById('requestform');
                var captchaError = document.getElementById('cf-captcha-required');

                if (!form) {
                    return;
                }

                form.addEventListener('submit', function(e) {
                    var isSolved = false;

                    if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.getResponse === 'function') {
                        isSolved = !!grecaptcha.getResponse();
                    }

                    if (!isSolved) {
                        e.preventDefault();
                        if (captchaError) {
                            captchaError.style.display = 'block';
                        }
                    } else if (captchaError) {
                        captchaError.style.display = 'none';
                    }
                });
            })();
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <script>
        (function() {
            var picker = null;
            var quoteTimer = null;
            var minStayByDow = {
                0: 1,
                1: 1,
                2: 1,
                3: 1,
                4: 1,
                5: 1,
                6: 1
            };

            /* ── Helpers ──────────────────────────────────────────────── */
            function fmt(n) {
                return '$' + parseFloat(n).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            /* Parse "MMM D, YYYY" (Litepicker display format) -> "YYYY-MM-DD"
               without relying on new Date() which misparses non-ISO strings. */
            function parseDisplayDate(val) {
                if (!val) {
                    return '';
                }
                var months = {
                    Jan: '01',
                    Feb: '02',
                    Mar: '03',
                    Apr: '04',
                    May: '05',
                    Jun: '06',
                    Jul: '07',
                    Aug: '08',
                    Sep: '09',
                    Oct: '10',
                    Nov: '11',
                    Dec: '12'
                };
                var m = val.match(/^([A-Za-z]{3})\s+(\d{1,2}),\s*(\d{4})$/);
                if (!m) {
                    return '';
                }
                var mm = months[m[1]];
                if (!mm) {
                    return '';
                }
                var dd = m[2].length === 1 ? '0' + m[2] : m[2];
                return m[3] + '-' + mm + '-' + dd;
            }

            function showError(msg) {
                document.getElementById('booking-minstay-text').textContent = msg;
                document.getElementById('booking-minstay-error').style.display = 'block';
                document.getElementById('booking-price-breakdown').style.display = 'none';
            }

            function showMinStayHint(checkinIso) {
                if (!checkinIso) {
                    document.getElementById('booking-nights-bar').style.display = 'none';
                    return;
                }
                var dow = window.VillaDateUtils.dayOfWeekFromIso(checkinIso);
                var min = parseInt(minStayByDow[dow] || 1, 10);
                document.getElementById('booking-nights-text').textContent =
                    'Min stay \u2022 ' + min + ' night' + (min !== 1 ? 's' : '');
                document.getElementById('booking-nights-bar').style.display = 'flex';
            }

            function getMinStayTextForIso(iso) {
                if (!iso) {
                    return '';
                }
                var dow = window.VillaDateUtils.dayOfWeekFromIso(iso);
                var min = parseInt(minStayByDow[dow] || 1, 10);
                return 'Min stay \u2022 ' + min + ' night' + (min !== 1 ? 's' : '');
            }

            function bindMinStayHoverTooltip() {
                var pickerRoot = document.querySelector('.litepicker');
                if (!pickerRoot || pickerRoot.dataset.minStayHoverBound === '1') {
                    return;
                }
                pickerRoot.dataset.minStayHoverBound = '1';

                var tip = document.createElement('div');
                tip.className = 'booking-minstay-tooltip';
                tip.style.display = 'none';
                document.body.appendChild(tip);

                function hideTip() {
                    tip.style.display = 'none';
                }

                pickerRoot.addEventListener('mousemove', function(e) {
                    var cell = e.target.closest('.day-item');
                    if (!cell || cell.classList.contains('is-locked')) {
                        hideTip();
                        return;
                    }

                    var ts = parseInt(cell.getAttribute('data-time') || '', 10);
                    if (!ts) {
                        hideTip();
                        return;
                    }

                    var iso = window.VillaDateUtils.toIsoDateLocal(new Date(ts));
                    var text = getMinStayTextForIso(iso);
                    if (!text) {
                        hideTip();
                        return;
                    }

                    tip.textContent = text;
                    tip.style.left = e.clientX + 'px';
                    tip.style.top = (e.clientY - 6) + 'px';
                    tip.style.display = 'block';
                });

                pickerRoot.addEventListener('mouseleave', hideTip);
                pickerRoot.addEventListener('mousedown', hideTip);
            }

            function showBreakdown(q) {
                document.getElementById('booking-minstay-error').style.display = 'none';

                var rows = '';

                /* Base nightly cost */
                if (q.base_total > 0) {
                    rows += '<div style="display:flex;justify-content:space-between;margin-bottom:5px;">' +
                        '<span>Nightly rates × ' + q.nights + ' night' + (q.nights !== 1 ? 's' : '') + '</span>' +
                        '<span>' + fmt(q.base_total) + '</span></div>';
                }

                /* Extra guest fee */
                if (q.extra_guest_fee > 0) {
                    rows += '<div style="display:flex;justify-content:space-between;margin-bottom:5px;">' +
                        '<span>Extra guests (' + q.extra_guests + ' × ' + q.nights + ' nights)</span>' +
                        '<span>' + fmt(q.extra_guest_fee) + '</span></div>';
                }

                /* Cleaning fee */
                rows += '<div style="display:flex;justify-content:space-between;margin-bottom:5px;">' +
                    '<span>Cleaning fee</span><span>' + fmt(q.cleaning_fee) + '</span></div>';

                /* Tax */
                rows += '<div style="display:flex;justify-content:space-between;margin-bottom:0;">' +
                    '<span>Taxes (' + q.tax_rate + '%)</span><span>' + fmt(q.tax_amount) + '</span></div>';

                document.getElementById('breakdown-rows').innerHTML = rows;
                document.getElementById('breakdown-total').textContent = fmt(q.total);
                document.getElementById('booking-price-breakdown').style.display = 'block';
            }

            function updateBookNowBtn(checkin, checkout, guests) {
                var btn = document.getElementById('booking-book-now-btn');
                var noMsg = document.getElementById('booking-no-dates-msg');
                if (checkin && checkout) {
                    var url = '{{ route('book-now') }}?checkin=' + checkin +
                        '&checkout=' + checkout + '&guests=' + guests;
                    btn.href = url;
                    btn.onclick = null;
                    if (noMsg) {
                        noMsg.style.display = 'none';
                    }
                } else {
                    btn.href = '#';
                    btn.onclick = function(e) {
                        e.preventDefault();
                        if (noMsg) {
                            noMsg.style.display = 'block';
                        }
                    };
                }
            }

            function hideAll() {
                document.getElementById('booking-minstay-error').style.display = 'none';
                document.getElementById('booking-price-breakdown').style.display = 'none';
                document.getElementById('booking-nights-bar').style.display = 'none';
                document.getElementById('booking-quote-loading').style.display = 'none';
                updateBookNowBtn('', '', 1);
            }

            function showLoading() {
                document.getElementById('booking-minstay-error').style.display = 'none';
                document.getElementById('booking-price-breakdown').style.display = 'none';
                document.getElementById('booking-quote-loading').style.display = 'block';
            }

            function hideLoading() {
                document.getElementById('booking-quote-loading').style.display = 'none';
            }

            function fetchQuote() {
                var checkin = parseDisplayDate(document.getElementById('checkin_date').value);
                var checkout = parseDisplayDate(document.getElementById('checkout_date').value);
                var guests = document.getElementById('guests').value;

                if (!checkin || !checkout) {
                    return;
                }

                showLoading();

                fetch('{{ route('api.price-quote') }}?checkin=' + checkin + '&checkout=' + checkout + '&guests=' +
                        guests)
                    .then(function(r) {
                        return r.json();
                    })
                    .then(function(q) {
                        hideLoading();
                        if (!q.valid) {
                            updateBookNowBtn('', '', guests);
                            if (q.min_stay) {
                                showError(
                                    'Minimum stay for a ' + q.checkin_day + ' check-in is ' +
                                    q.min_stay + ' night' + (q.min_stay !== 1 ? 's' : '') + '.'
                                );
                            } else {
                                showError(q.error || 'Invalid dates selected.');
                            }
                        } else {
                            showBreakdown(q);
                            updateBookNowBtn(checkin, checkout, guests);
                        }
                    })
                    .catch(function() {
                        hideLoading();
                    });
            }

            function debouncedFetch() {
                clearTimeout(quoteTimer);
                quoteTimer = setTimeout(fetchQuote, 60);
            }

            /* ── Litepicker init ──────────────────────────────────────── */
            function initPicker(lockDays) {
                picker = new Litepicker({
                    element: document.getElementById('checkin_date'),
                    elementEnd: document.getElementById('checkout_date'),
                    singleMode: false,
                    numberOfMonths: 2,
                    numberOfColumns: 2,
                    minDate: new Date(),
                    format: 'MMM D, YYYY',
                    lockDays: lockDays,
                    lockDaysFormat: 'YYYY-MM-DD',
                    disallowLockDaysInRange: true,
                    showTooltip: false,
                    autoApply: true,
                    resetButton: false,
                });

                /* 'selected' is Litepicker's EventEmitter event — fires after both
                   input values have been written, unlike the onSelect option which
                   does not fire reliably in range mode. */
                picker.on('selected', function(date1, date2) {
                    if (date1) {
                        showMinStayHint(date1.format('YYYY-MM-DD'));
                    }
                    if (date1 && date2) {
                        debouncedFetch();
                    }
                });

                /* Clear breakdown when selection is cleared */
                picker.on('clear:selection', function() {
                    hideAll();
                });

                bindMinStayHoverTooltip();
            }

            /* ── Fetch calendar locks + minimum stays → init picker ───── */
            Promise.all([
                    fetch('{{ route('api.booked-dates') }}').then(function(r) {
                        return r.json();
                    }),
                    fetch('{{ route('api.minimum-stays') }}').then(function(r) {
                        return r.json();
                    }).catch(function() {
                        return {
                            by_dow: {}
                        };
                    })
                ])
                .then(function(res) {
                    var events = res[0] || [];
                    var stays = res[1] || {
                        by_dow: {}
                    };
                    minStayByDow = Object.assign(minStayByDow, stays.by_dow || {});

                    var lockDays = [];
                    events.forEach(function(e) {
                        var cur = new Date(e.start + 'T12:00:00');
                        var end = new Date(e.end + 'T12:00:00');
                        while (cur < end) {
                            // Keep lock dates in local calendar date to avoid timezone shifts.
                            lockDays.push(window.VillaDateUtils.toIsoDateLocal(cur));
                            cur.setDate(cur.getDate() + 1);
                        }
                    });
                    initPicker(lockDays);
                })
                .catch(function() {
                    initPicker([]);
                });

            /* ── Guests change → re-fetch quote ───────────────────────── */
            document.getElementById('guests').addEventListener('change', debouncedFetch);

            /* ── Initialise Book Now button as disabled ────────────────── */
            updateBookNowBtn('', '', 1);

            /* ── Clear dates ──────────────────────────────────────────── */
            document.getElementById('booking-clear-dates').addEventListener('click', function(e) {
                e.preventDefault();
                if (picker) {
                    picker.clearSelection();
                }
                document.getElementById('checkin_date').value = '';
                document.getElementById('checkout_date').value = '';
                hideAll();
            });
        })();
    </script>
@endsection
