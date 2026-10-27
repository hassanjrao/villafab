@extends('layouts.frontend')

@section('title', 'Villa Fabulosa')

@section('head_extra')
    {{-- The hero photo is the LCP element; preloading it removes the round trip
         the browser would otherwise spend discovering it in the markup. --}}
    <link rel="preload" as="image" href="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero.webp') }}"
        imagesrcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero1x.webp') }} 800w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero.webp') }} 1200w"
        imagesizes="100vw" fetchpriority="high">
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
        #photoTourModal {
            z-index: 10010 !important;
            padding-top: 60px !important;
        }

        .modal-backdrop {
            z-index: 10009 !important;
        }

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

        /* Keep navbar above the lightbox and photo tour modal */
        #mainNav {
            z-index: 10011 !important;
        }

        /* ── Lightbox ── */
        #photo-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 10020;
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
            top: 70px;
            right: 24px;
            background: none;
            border: none;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            line-height: 1;
            z-index: 10021;
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
            z-index: 10021;
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
            color: #595959;
        }

        .rating-total {
            font-size: 2rem;
            color: #595959;
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
            color: #595959;
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
            border-color: #076b96;
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
            color: #595959;
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
            border-color: #076b96;
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
            background: linear-gradient(135deg, #076b96 0%, #1485b8 100%);
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
            color: #595959;
            margin-bottom: 6px;
        }

        .booking-clear-dates {
            display: block;
            text-align: center;
            font-size: 0.76rem;
            color: #595959;
            text-decoration: underline;
            cursor: pointer;
        }

        .booking-clear-dates:hover {
            color: #b42318;
        }

        @keyframes bk-spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Litepicker grid alignment fix ── */
        .litepicker .month-item-weekdays-row {
            display: grid !important;
            grid-template-columns: repeat(7, 1fr) !important;
        }

        .litepicker .month-item-weekdays-row > div {
            text-align: center !important;
        }

        .litepicker .container__days {
            display: grid !important;
            grid-template-columns: repeat(7, 1fr) !important;
        }

        /* ── Litepicker theme overrides ── */
        .litepicker .container__days .day-item.is-locked {
            pointer-events: none;
            color: #595959;
            background-color: #e9e9e9;
            border-radius: 50%;
        }

        .litepicker .container__days .day-item.is-start-date,
        .litepicker .container__days .day-item.is-end-date {
            background-color: #076b96 !important;
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
            fill: #076b96;
        }

        .litepicker .container__tooltip {
            background: #076b96;
            color: #fff;
        }

        .litepicker .container__tooltip::before {
            border-top-color: #076b96;
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

        @media (max-width: 767px) {
            .litepicker .container__months {
                flex-direction: column !important;
                width: 100% !important;
            }

            .litepicker .container__months .month-item {
                width: 100% !important;
            }
        }
    </style>
    <style>
        /* ══ 3D estate hero ══════════════════════════════════════════════ */
        /* Nothing on this page should ever scroll sideways, including the
           in-flight reveal transforms below. */
        #main-content {
            overflow-x: clip;
        }

        .estate-hero {
            --navy: #0b1430;
            --gold: #f0c27a;
            --glass: rgba(14, 22, 52, 0.55);
            position: relative;
            height: clamp(560px, calc(100vh - 72px), 920px);
            height: clamp(560px, calc(100svh - 72px), 920px);
            background: var(--navy);
            color: #fff;
            overflow: hidden;
            isolation: isolate;
        }

        .estate-hero__viewport,
        .estate-hero__stage {
            position: absolute;
            inset: 0;
        }

        .estate-hero__stage {
            touch-action: pan-y;
            cursor: grab;
        }

        .estate-hero__stage.is-dragging {
            cursor: grabbing;
        }

        .estate-hero__poster,
        .estate-hero__canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .estate-hero__canvas {
            opacity: 0;
            transition: opacity 1.2s ease;
        }

        .estate-hero.is-3d .estate-hero__canvas {
            opacity: 1;
        }

        .estate-hero__shade {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(90deg, rgba(8, 12, 32, 0.78) 0%, rgba(8, 12, 32, 0.45) 30%, rgba(8, 12, 32, 0) 55%),
                linear-gradient(0deg, rgba(8, 12, 32, 0.7) 0%, rgba(8, 12, 32, 0) 32%);
        }

        .estate-hero__intro {
            position: absolute;
            left: clamp(20px, 5vw, 80px);
            top: 50%;
            transform: translateY(-58%);
            max-width: 520px;
            z-index: 3;
            pointer-events: none;
        }

        .estate-hero__intro > * {
            pointer-events: auto;
        }

        /* On wide screens the open spot card and its close-up take the stage;
           the introduction steps back until the card closes. */
        @media (min-width: 992px) {
            .estate-hero__intro {
                transition: opacity 0.4s ease, transform 0.5s ease;
            }

            .estate-hero.has-card .estate-hero__intro {
                opacity: 0;
                transform: translate(-30px, -58%);
                pointer-events: none;
            }

            .estate-hero.has-card .estate-hero__intro > * {
                pointer-events: none;
            }

            .estate-hero.has-card .estate-hero__shade {
                opacity: 0.45;
            }
        }

        .estate-hero__shade {
            transition: opacity 0.4s ease;
        }

        .estate-hero__eyebrow {
            margin: 0 0 0.6rem;
            font-size: 0.85rem;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 700;
        }

        .estate-hero__eyebrow span {
            white-space: nowrap;
        }

        @media (max-width: 575.98px) {
            .estate-hero__eyebrow {
                font-size: 0.75rem;
                letter-spacing: 0.14em;
            }
        }

        .estate-hero__title {
            margin: 0;
            font-size: clamp(2.6rem, 5.6vw, 5.2rem);
            line-height: 0.95;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-shadow: 0 6px 30px rgba(0, 0, 0, 0.45);
        }

        .estate-hero__lead {
            margin: 1rem 0 1.4rem;
            font-size: 1.15rem;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.88);
            max-width: 26em;
        }

        .estate-hero__facts {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0 0 1.6rem;
            padding: 0;
            list-style: none;
        }

        .estate-hero__facts li {
            padding: 7px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            font-size: 0.92rem;
        }

        .estate-hero__facts strong {
            font-size: 1.05rem;
            margin-right: 3px;
        }

        .estate-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .estate-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            padding: 0 26px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .estate-btn--primary {
            background: linear-gradient(180deg, #ffd796, #e9a94e);
            color: #1d1306;
            box-shadow: 0 10px 30px rgba(233, 169, 78, 0.35);
        }

        .estate-btn--primary:hover,
        .estate-btn--primary:focus-visible {
            color: #1d1306;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 14px 34px rgba(233, 169, 78, 0.5);
        }

        .estate-btn--ghost {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .estate-btn--ghost:hover,
        .estate-btn--ghost:focus-visible {
            background: rgba(255, 255, 255, 0.18);
        }

        /* Chips: the accessible way to every spot, with or without 3D. */
        .estate-hero__explore {
            position: absolute;
            left: clamp(20px, 5vw, 80px);
            right: clamp(20px, 5vw, 80px);
            bottom: 26px;
            z-index: 3;
        }

        .estate-hero__explore-label {
            margin: 0 0 8px;
            font-size: 0.78rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 700;
        }

        .estate-hero__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .estate-chip {
            min-height: 40px;
            padding: 0 16px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: var(--glass);
            color: #fff;
            font-size: 0.92rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .estate-chip:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .estate-chip[aria-pressed="true"] {
            background: #fff;
            color: var(--navy);
            border-color: #fff;
        }

        .estate-hero__hint {
            margin: 10px 0 0;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .estate-hero__tools {
            position: absolute;
            top: 20px;
            right: clamp(16px, 3vw, 40px);
            display: flex;
            gap: 10px;
            z-index: 3;
        }

        .estate-toggle {
            display: flex;
            padding: 4px;
            border-radius: 999px;
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .estate-toggle button,
        .estate-tool {
            min-height: 36px;
            padding: 0 14px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
        }

        .estate-toggle button[aria-pressed="true"] {
            background: #fff;
            color: var(--navy);
        }

        .estate-tool {
            background: var(--glass);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .estate-chip:focus-visible,
        .estate-toggle button:focus-visible,
        .estate-tool:focus-visible,
        .estate-btn:focus-visible,
        .estate-card__close:focus-visible,
        .estate-card__link:focus-visible {
            outline: 3px solid var(--gold);
            outline-offset: 3px;
        }

        /* Pins that follow the model (mouse/touch only; chips cover keyboard). */
        .estate-hero__pins {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 2;
            display: none;
        }

        .estate-hero.is-3d .estate-hero__pins {
            display: block;
        }

        .estate-pin {
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            align-items: center;
            gap: 6px;
            margin: -14px 0 0 -12px;
            padding: 4px 11px 4px 6px;
            border: 0;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: #0b1430;
            font-size: 0.78rem;
            font-weight: 700;
            white-space: nowrap;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.28);
            pointer-events: auto;
            cursor: pointer;
            transition: opacity 0.25s ease, background 0.2s ease;
            will-change: transform;
        }

        .estate-pin.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .estate-pin.is-active {
            background: var(--gold);
        }

        .estate-pin__dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #22b8e8;
            box-shadow: 0 0 0 0 rgba(34, 184, 232, 0.6);
            animation: estate-pulse 2.2s infinite;
        }

        @keyframes estate-pulse {
            70% { box-shadow: 0 0 0 10px rgba(34, 184, 232, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 184, 232, 0); }
        }

        /* Spot card */
        .estate-card {
            position: absolute;
            right: clamp(16px, 3vw, 40px);
            top: 76px;
            width: min(360px, 34vw);
            z-index: 4;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            color: #1b2133;
            box-shadow: 0 30px 70px rgba(4, 8, 24, 0.5);
            animation: estate-card-in 0.45s cubic-bezier(.2, .8, .2, 1);
            transform-origin: right center;
        }

        @keyframes estate-card-in {
            from { opacity: 0; transform: perspective(900px) rotateY(-14deg) translateX(30px); }
            to { opacity: 1; transform: none; }
        }

        .estate-card__img {
            display: block;
            width: 100%;
            height: auto;
            aspect-ratio: 3 / 2;
            object-fit: cover;
            background: #dfe6ee;
        }

        .estate-card__body {
            padding: 18px 20px 20px;
        }

        .estate-card__title {
            margin: 0 0 6px;
            font-size: 1.3rem;
            font-weight: 700;
            color: #0b1430;
        }

        .estate-card__text {
            margin: 0 0 12px;
            font-size: 0.97rem;
            line-height: 1.5;
            color: #3a4256;
        }

        .estate-card__link {
            font-weight: 700;
            color: #076b96;
        }

        .estate-card__link::after {
            content: " \2192";
        }

        .estate-card__close {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: rgba(11, 20, 48, 0.72);
            color: #fff;
            font-size: 1.5rem;
            line-height: 1;
            cursor: pointer;
        }

        /* ══ Below the hero: depth and motion ═════════════════════════════ */
        .photo-strip-heading {
            padding: 56px 15px 20px;
            text-align: center;
        }

        .photo-strip-heading h2 {
            color: #076b96;
            margin-bottom: 6px;
        }

        .photo-strip-heading p {
            margin: 0;
            color: #555;
        }

        .site_services_box_wrapper {
            perspective: 1200px;
        }

        .site_service_box {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 12px 30px rgba(11, 20, 48, 0.12);
            padding-bottom: 14px;
            transform-style: preserve-3d;
            transition: transform 0.35s cubic-bezier(.2, .8, .2, 1), box-shadow 0.35s ease;
            will-change: transform;
        }

        .site_service_box img {
            width: 100%;
            object-fit: cover;
        }

        .site_service_box h3 {
            transform: translateZ(30px);
        }

        .site_service_box.is-tilting {
            box-shadow: 0 26px 50px rgba(11, 20, 48, 0.22);
            transition: transform 0.08s linear, box-shadow 0.35s ease;
        }

        .booking-widget-card {
            scroll-margin-top: 96px;
        }

        /* Scroll reveal: only armed once JS adds .reveal-ready, so content
           is never hidden from users or crawlers without script. */
        .reveal-ready [data-reveal] {
            opacity: 0;
            transform: perspective(1000px) translateY(40px) translateZ(-90px) rotateX(8deg);
            transition: opacity 0.8s ease, transform 0.9s cubic-bezier(.2, .8, .2, 1);
        }

        .reveal-ready [data-reveal].is-revealed {
            opacity: 1;
            transform: none;
        }

        @media (prefers-reduced-motion: reduce) {
            .estate-hero__canvas,
            .estate-card,
            .estate-pin__dot,
            .reveal-ready [data-reveal] {
                animation: none;
                transition: none;
            }

            .reveal-ready [data-reveal] {
                opacity: 1;
                transform: none;
            }
        }

        /* ── Tablet and phone: model on top, introduction below ── */
        @media (max-width: 991.98px) {
            .estate-hero {
                height: auto;
                display: flex;
                flex-direction: column;
            }

            .estate-hero__viewport {
                position: relative;
                inset: auto;
                height: 64vh;
                height: 64svh;
                min-height: 380px;
                max-height: 640px;
            }

            .estate-hero__shade {
                background: linear-gradient(0deg, rgba(8, 12, 32, 0.85) 0%, rgba(8, 12, 32, 0) 42%);
            }

            .estate-hero__intro {
                position: static;
                transform: none;
                max-width: none;
                padding: 26px 20px 34px;
                background: var(--navy);
            }

            .estate-hero__explore {
                left: 0;
                right: 0;
                bottom: 14px;
            }

            .estate-hero__explore-label,
            .estate-hero__hint {
                padding: 0 16px;
            }

            /* One swipeable row instead of wrapping over the model. */
            .estate-hero__chips {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding: 2px 16px 4px;
                scrollbar-width: none;
                -webkit-overflow-scrolling: touch;
            }

            .estate-hero__chips::-webkit-scrollbar {
                display: none;
            }

            .estate-chip {
                white-space: nowrap;
            }

            .estate-hero__tools {
                top: 12px;
                right: 12px;
            }

            .estate-card {
                top: auto;
                right: 12px;
                left: 12px;
                bottom: 12px;
                width: auto;
                display: grid;
                grid-template-columns: 38% 1fr;
                transform-origin: center bottom;
                animation-name: estate-sheet-in;
            }

            @keyframes estate-sheet-in {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: none; }
            }

            .estate-card__img {
                height: 100%;
                aspect-ratio: auto;
            }

            .estate-card__body {
                padding: 14px 44px 14px 14px;
            }

            .estate-card__title {
                font-size: 1.05rem;
            }

            .estate-card__text {
                font-size: 0.86rem;
                margin-bottom: 8px;
            }

            .estate-card__close {
                width: 32px;
                height: 32px;
                font-size: 1.25rem;
                top: 8px;
                right: 8px;
            }

            .estate-pin {
                font-size: 0.72rem;
            }
        }

        @media (max-width: 575.98px) {
            .estate-hero__viewport {
                height: 58svh;
                min-height: 340px;
            }

            .estate-pin__label {
                display: none;
            }

            .estate-pin {
                padding: 6px;
                margin: -12px 0 0 -12px;
            }

            /* Stay side by side so the card leaves the model in view. */
            .estate-card {
                grid-template-columns: 34% 1fr;
            }

            .estate-card__body {
                padding: 12px 40px 12px 12px;
            }

            .estate-card__title {
                font-size: 0.98rem;
                margin-bottom: 4px;
            }

            .estate-card__text {
                font-size: 0.8rem;
                line-height: 1.4;
                margin-bottom: 6px;
            }

            .estate-card__link {
                font-size: 0.86rem;
            }

            .estate-hero__facts li {
                font-size: 0.85rem;
                padding: 6px 12px;
            }

            .estate-btn {
                flex: 1 1 auto;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ \App\Support\Seo::versioned('frontend/litepicker/litepicker.css') }}" media="print" onload="this.media='all';this.onload=null;">
    <noscript><link rel="stylesheet" href="{{ \App\Support\Seo::versioned('frontend/litepicker/litepicker.css') }}"></noscript>
@endsection

@section('content')

    {{-- ══════════════════════════════════════════
     3D ESTATE HERO
     The poster photo is the LCP element and the whole experience without
     WebGL: the chips still open each spot's card. The 3D model is layered
     over it after load (see the loader in scripts_extra).
══════════════════════════════════════════ --}}
    @php
        $estateSpots = [
            ['id' => 'pool', 'label' => 'Pool & spa', 'title' => 'Designer pool & 14-person spa',
             'text' => 'Dual Baja shelves with in-pool loungers, a spa for the whole group and lighting for evening swims.',
             'img' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-2-pool-thumb.webp', 'alt' => 'Lit pool with in-pool loungers at dusk',
             'href' => '/the-pool', 'link' => 'See the pool'],
            ['id' => 'villa', 'label' => 'The villa', 'title' => 'Brand-new Ibiza-style home',
             'text' => '7 bedrooms, 12 beds and 5.5 baths, a chef’s kitchen and a fireplace under a 22-foot ceiling.',
             'img' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-06-thumb.webp', 'alt' => 'Living room with fireplace wall',
             'href' => '/the-rooms', 'link' => 'See the rooms'],
            ['id' => 'game', 'label' => 'Game room', 'title' => 'Game room & arcade',
             'text' => 'A full arcade, professional pool table, poker table, shuffleboard and air hockey.',
             'img' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-5-arcade-thumb.webp', 'alt' => 'Arcade machines and air hockey in the game room',
             'href' => '/game-rooms', 'link' => 'See the game room'],
            ['id' => 'court', 'label' => 'Sports court', 'title' => 'Full sports court',
             'text' => 'Basketball and pickleball on a private court right beside the lawn.',
             'img' => 'frontend/imgs/villa-fabulosa-sports-field-38-thumb.webp', 'alt' => 'Blue sports court with Villa Fabulosa lettering',
             'href' => '/the-sports-area', 'link' => 'See the sports area'],
            ['id' => 'lawn', 'label' => 'Lawn games', 'title' => 'Lawn games',
             'text' => 'Volleyball, bocce lanes and a putting green on the front lawn.',
             'img' => 'frontend/imgs/villa-fabulosa-sports-field-40-thumb.webp', 'alt' => 'Putting green on the lawn beside the villa',
             'href' => '/the-sports-area', 'link' => 'See the lawn'],
            ['id' => 'kitchen', 'label' => 'Outdoor kitchen', 'title' => 'Outdoor kitchen & bar',
             'text' => 'Pizza ovens, a teppanyaki grill and a BBQ station, with bar seating that faces the pool.',
             'img' => 'frontend/imgs/villa-fabulosa-pool-13-2-thumb.webp', 'alt' => 'Outdoor kitchen and bar beside the pool at dusk',
             'href' => '/the-pool', 'link' => 'See the pool area'],
            ['id' => 'pavilion', 'label' => 'Pavilion', 'title' => 'Poolside pavilion',
             'text' => 'A covered lounge over the pool deck, looking out across the hills of wine country.',
             'img' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-pergola-thumb.webp', 'alt' => 'Covered pavilion lounge beside the pool',
             'href' => '/the-pool', 'link' => 'See the pavilion'],
            ['id' => 'golf', 'label' => 'Mini golf', 'title' => '18-hole miniature golf',
             'text' => 'A professional 18-hole course on its own hillside terrace.',
             'img' => 'frontend/imgs/photos-for-vrbo/villa-fabulosa-mini-golf-11-thumb.webp', 'alt' => 'Aerial view of the 18-hole miniature golf course',
             'href' => '/miniature-golf-course', 'link' => 'See the course'],
        ];
    @endphp
    <section class="estate-hero" id="estateHero" aria-labelledby="estateHeroTitle"
        data-module="{{ \App\Support\Seo::versioned('frontend/js/villa-estate-3d.js') }}">

        <div class="estate-hero__viewport">
            <div class="estate-hero__stage" id="estateStage">
                <img class="estate-hero__poster"
                    src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero.webp') }}"
                    srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero1x.webp') }} 800w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-pool-01-hero.webp') }} 1200w"
                    sizes="100vw" width="1200" height="800" fetchpriority="high" decoding="async"
                    alt="Villa Fabulosa, its pool and courtyard lit up at dusk">
            </div>
            <div class="estate-hero__shade" aria-hidden="true"></div>

            <div class="estate-hero__tools" id="estateTools" hidden>
                <div class="estate-toggle" role="group" aria-label="Lighting">
                    <button type="button" data-mode="dusk" aria-pressed="true">Dusk</button>
                    <button type="button" data-mode="day" aria-pressed="false">Day</button>
                </div>
                <button type="button" class="estate-tool" data-action="reset">Reset view</button>
            </div>

            <div class="estate-hero__explore">
                <p class="estate-hero__explore-label" id="estateExploreLabel">Explore the estate</p>
                <ul class="estate-hero__chips" aria-labelledby="estateExploreLabel">
                    @foreach ($estateSpots as $spot)
                        <li>
                            <button type="button" class="estate-chip" data-spot="{{ $spot['id'] }}"
                                aria-pressed="false" aria-controls="estateCard"
                                data-title="{{ $spot['title'] }}" data-text="{{ $spot['text'] }}"
                                data-img="{{ asset($spot['img']) }}" data-alt="{{ $spot['alt'] }}"
                                data-href="{{ url($spot['href']) }}" data-link="{{ $spot['link'] }}">{{ $spot['label'] }}</button>
                        </li>
                    @endforeach
                </ul>
                <p class="estate-hero__hint" id="estateHint" hidden>Drag to look around &middot; Illustrative 3D model, not to scale</p>
            </div>

            <aside class="estate-card" id="estateCard" aria-labelledby="estateCardTitle" hidden>
                <button type="button" class="estate-card__close" aria-label="Close">&times;</button>
                <img class="estate-card__img" src="" alt="" width="640" height="427" decoding="async">
                <div class="estate-card__body">
                    <h2 class="estate-card__title" id="estateCardTitle"></h2>
                    <p class="estate-card__text"></p>
                    <a class="estate-card__link" href="#"></a>
                </div>
            </aside>
        </div>

        <div class="estate-hero__intro">
            <p class="estate-hero__eyebrow"><span>Temecula Wine Country</span> <span aria-hidden="true">&middot;</span> <span>Private 5&#8209;acre estate</span></p>
            <h1 class="estate-hero__title" id="estateHeroTitle">Villa Fabulosa</h1>
            <p class="estate-hero__lead">Walk the grounds before you arrive. Pick a spot to see it up close, then check your dates.</p>
            <ul class="estate-hero__facts">
                <li><strong>24</strong> guests</li>
                <li><strong>7</strong> bedrooms</li>
                <li><strong>12</strong> beds</li>
                <li><strong>5.5</strong> baths</li>
            </ul>
            <div class="estate-hero__actions">
                <a href="#book" class="estate-btn estate-btn--primary">Check availability</a>
                <button type="button" class="estate-btn estate-btn--ghost" onclick="openPhotoTour()">Show all photos</button>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
     PHOTO TOUR STRIP  (the former Airbnb-style hero)
══════════════════════════════════════════ --}}
    <div class="photo-strip-heading container" data-reveal>
        <h2 class="site_title_letter_space">Take the photo tour</h2>
        <p>Every room and corner, photographed at the estate.</p>
    </div>
    <div class="hero-gallery-wrapper" id="heroGallery" data-reveal>
        <div class="hero-gallery-grid">

            {{-- Large main photo --}}
            <div class="hero-main" onclick="openPhotoTour()">
                <img src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-13-14-pool.webp') }}" width="1200" height="800" alt="Pool and courtyard at Villa Fabulosa" loading="lazy" decoding="async">
            </div>

            {{-- 2 × 2 right grid --}}
            <div class="hero-right">
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13-hero1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13-hero1x.webp') }} 460w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13-hero.webp') }} 900w" sizes="(max-width: 767px) 50vw, 460px" width="460" height="260" alt="Aerial view at dusk">
                </div>
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-sports-field-03-hero1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-sports-field-03-hero1x.webp') }} 460w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-sports-field-03-hero.webp') }} 900w" sizes="(max-width: 767px) 50vw, 460px" width="460" height="260" alt="Sports court aerial view">
                </div>
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-06-hero1x.webp') }}"
                        srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-06-hero1x.webp') }} 460w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-06-hero.webp') }} 900w"
                        sizes="(max-width: 767px) 50vw, 460px" width="460" height="260"
                        alt="Living & media room">
                </div>
                <div class="hero-grid-item" onclick="openPhotoTour()">
                    <img src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-mini-golf-11-hero1x.webp') }}"
                        srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-mini-golf-11-hero1x.webp') }} 460w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-mini-golf-11-hero.webp') }} 900w"
                        sizes="(max-width: 767px) 50vw, 460px" width="460" height="260"
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
                            ['src' => 'photos-for-vrbo/villa-fabulosa-1-pool.webp', 'label' => 'Living room 1'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-6-living.webp', 'label' => 'Living room 2'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-7-kitchen.webp', 'label' => 'Full kitchen'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-dining.webp', 'label' => 'Dining area'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-54-bedroom.webp', 'label' => 'Bedroom 1'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-70-bedroom.webp', 'label' => 'Bedroom 2'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-73-bedroom.webp', 'label' => 'Bedroom 3'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-80-bedroom.webp', 'label' => 'Bedroom 4'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-84-bedroom.webp', 'label' => 'Bedroom 5'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-87-bedroom.webp', 'label' => 'Bedroom 6'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-bridal-suite-3.webp', 'label' => 'Bedroom 7'],
                            [
                                'src' => 'photos-for-vrbo/villa-fabulosa-55-bathroom.webp',
                                'label' => 'Full bathroom 1',
                            ],
                            [
                                'src' => 'photos-for-vrbo/villa-fabulosa-71-bathroom.webp',
                                'label' => 'Full bathroom 2',
                            ],
                            [
                                'src' => 'photos-for-vrbo/villa-fabulosa-76-bathroom.webp',
                                'label' => 'Full bathroom 3',
                            ],
                            [
                                'src' => 'photos-for-vrbo/villa-fabulosa-85-bathroom.webp',
                                'label' => 'Full bathroom 4',
                            ],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-5kitchenette.webp', 'label' => 'Full bathroom 5'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-8-img-1734.webp', 'label' => 'Half bathroom'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-23-patio.webp', 'label' => 'Backyard'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-2-pool.webp', 'label' => 'Pool'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-14-pool.webp', 'label' => 'Pool view'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-5-arcade.webp', 'label' => 'Game room 1'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-11-game.webp', 'label' => 'Game room 2'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-golf-course-11.webp', 'label' => 'Miniature golf'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-4-aerial.webp', 'label' => 'Aerial view'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-13-aerial.webp', 'label' => 'Aerial – dusk'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-3-field.webp', 'label' => 'Sports court'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-pergola.webp', 'label' => 'Pergola'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-view.webp', 'label' => 'Wine country view'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-13-19-foyer.webp', 'label' => 'Foyer'],
                            ['src' => 'photos-for-vrbo/villa-fabulosa-8-kitchen.webp', 'label' => 'Additional photos'],
                        ];
                    @endphp

                    <div class="photo-tour-grid">
                        @foreach ($photoTour as $i => $photo)
                            <div class="photo-tour-item">
                                {{-- Tile loads the 640px thumbnail; openLightbox() pulls the
                                     full-size file from the photoTour array. --}}
                                <img src="{{ asset('frontend/imgs/' . str_replace('.webp', '-thumb.webp', $photo['src'])) }}"
                                    alt="{{ $photo['label'] }} at Villa Fabulosa, Temecula Wine Country"
                                    onclick="openLightbox({{ $i }})" loading="lazy" decoding="async">
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
    <div id="photo-lightbox" role="dialog" aria-modal="true" aria-label="Photo viewer">
        <button class="lb-close" onclick="closeLightbox()" aria-label="Close">&times;</button>
        <button class="lb-prev" onclick="lbNavigate(-1)" aria-label="Previous"><i class="fa fa-angle-left"></i></button>
        <img loading="lazy" decoding="async" id="lb-img" src="" alt="">
        <button class="lb-next" onclick="lbNavigate(1)" aria-label="Next"><i class="fa fa-angle-right"></i></button>
        <div class="lb-counter" id="lb-counter" role="status"></div>
    </div>
    {{-- ══════════════════════════════════════════ --}}


    <!-- Villa Info Start - entire section links to KTLA announcement -->
    <a href="http://www.youtube.com/watch?v=xwmYm-XCr_o&t=206s" target="_blank" rel="noopener"
        class="d-block text-decoration-none villinfo-link" style="color: inherit; cursor: pointer; text-decoration: none;">
        <div id="villinfo" class="site_villa_info_wrapper mb-4 mt-4">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-12 text-center">
                        <p class="h1 site_title_letter_space mb-3">Villa Fabulosa</p>
                    </div>
                    <div class="col-lg-12">
                        <h2 class="h3 site_title_letter_space text-center"><i>Voted by Expedia Group and VRBO as the Top
                                vacation rental in
                                California and one of the top Ten Vacation Rentals in the entire country, out of over two
                                million homes!
                            </i>
                        </h2>
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
    <section class="py-4" data-reveal>
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
                        @include('layouts.partials.video-facade', ['videoId' => 'u5zfhEQfkpk', 'title' => 'Tour Villa Fabulosa in Temecula Wine Country'])
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="site_services_box_wrapper pb-5" data-reveal>
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/the-rooms') }}">
                            <img loading="lazy" decoding="async" style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-12-card1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-12-card1x.webp') }} 350w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-living-room-12-card.webp') }} 700w" sizes="(max-width: 991px) 100vw, 350px" width="350" height="250" class="img-fluid" alt="Living room at Villa Fabulosa">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #076b96;">The Rooms</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/the-pool') }}">
                            <img loading="lazy" decoding="async" style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13-card1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13-card1x.webp') }} 350w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-13-card.webp') }} 700w" sizes="(max-width: 991px) 100vw, 350px" width="350" height="250" class="img-fluid" alt="The pool at Villa Fabulosa">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #076b96;">The Pool</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/game-rooms') }}">
                            <img loading="lazy" decoding="async" style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-game-room-05-card1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-game-room-05-card1x.webp') }} 350w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-game-room-05-card.webp') }} 700w" sizes="(max-width: 991px) 100vw, 350px" width="350" height="250" class="img-fluid" alt="Game room at Villa Fabulosa">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #076b96;">Game Room</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/miniature-golf-course') }}">
                            <img loading="lazy" decoding="async" style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-04-card1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-04-card1x.webp') }} 350w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-aerial-view-04-card.webp') }} 700w" sizes="(max-width: 991px) 100vw, 350px" width="350" height="250" class="img-fluid" alt="Aerial view of Villa Fabulosa">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #076b96;">Miniature Golf</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/wineries') }}">
                            <img loading="lazy" decoding="async" style="height: 250px;" src="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-villa-card1x.webp') }}" srcset="{{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-villa-card1x.webp') }} 350w, {{ asset('frontend/imgs/photos-for-vrbo/villa-fabulosa-villa-card.webp') }} 700w" sizes="(max-width: 991px) 100vw, 350px" width="350" height="250" class="img-fluid" alt="Villa Fabulosa estate">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #076b96;">Wineries</h3>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="site_service_box">
                        <a href="{{ url('/birds-eye') }}">
                            <img loading="lazy" decoding="async" style="height: 250px;" src="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-108-card1x.webp') }}" srcset="{{ asset('frontend/imgs/villa-fabulosa-aerial-view-108-card1x.webp') }} 350w, {{ asset('frontend/imgs/villa-fabulosa-aerial-view-108-card.webp') }} 700w" sizes="(max-width: 991px) 100vw, 350px" width="350" height="250" class="img-fluid" alt="Aerial view of the grounds">
                        </a>
                        <h3 class="mt-2 mb-0" style="color: #076b96;">Bird's Eye View</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services Boxes End -->

    {{-- Stats bar (blue strip) --}}
    <section class="py-3" style="background-color:#076b96;color:#fff;" data-reveal>
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

                    <div class="booking-widget-card" id="book">

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
                                <div class="booking-date-cell" data-date-target="checkin">
                                    <span class="booking-field-label">Check-in</span>
                                    <input type="text" id="checkin_date" name="checkin_date"
                                        class="booking-date-input" aria-label="Check-in date" placeholder="Add date" readonly>
                                </div>
                                <div class="booking-date-cell" data-date-target="checkout">
                                    <span class="booking-field-label">Check-out</span>
                                    <input type="text" id="checkout_date" name="checkout_date"
                                        class="booking-date-input" aria-label="Check-out date" placeholder="Add date" readonly>
                                </div>
                            </div>

                            {{-- Guests row (continues the segmented border) --}}
                            <div class="booking-guests-box" id="booking-guests-box">
                                <span class="booking-field-label">Guests</span>
                                {{-- The visible "Guests" text is a span inside a role="button"
                                     wrapper, so it never associated with this select. An explicit
                                     label keeps the control named for screen readers. --}}
                                <select id="guests" name="guests" class="booking-guests-select"
                                    aria-label="Number of guests">
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}">{{ $i }}
                                            guest{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Minimum stay hint (shown once check-in is picked) --}}
                            <div class="booking-nights-bar" id="booking-nights-bar" role="status" style="display:none;">
                                <i class="fa fa-moon-o"></i>
                                <span id="booking-nights-text"></span>
                            </div>

                            {{-- Loading indicator --}}
                            <div id="booking-quote-loading" role="status"
                                style="display:none;
                                 text-align:center;padding:12px 0;margin-bottom:12px;
                                 color:#076b96;font-size:0.88rem;">
                                <span
                                    style="display:inline-block;width:16px;height:16px;
                                             border:2px solid #c8e8f4;border-top-color:#076b96;
                                             border-radius:50%;animation:bk-spin .7s linear infinite;
                                             vertical-align:middle;margin-right:6px;"></span>
                                Calculating price&hellip;
                            </div>

                            {{-- Min-stay error --}}
                            <div id="booking-minstay-error" role="alert"
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
                                    <strong id="breakdown-total" style="font-size:1.15rem;color:#076b96;"></strong>
                                </div>
                            </div>

                            {{-- Book Now button --}}
                            <a id="booking-book-now-btn" href="#" class="booking-reserve-btn"
                                style="display:block;text-align:center;text-decoration:none;">
                                Book Now
                            </a>

                            <p id="booking-no-dates-msg"
                                style="display:none;color:#b42318;
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
    <section class="pt-5 pb-4" style="background-color:#f7f7f7;" data-reveal>
        <div class="container">
            <h2 class="site_title_letter_space text-center mb-4" style="color: #076b96;">What our customers say</h2>

            {{-- Top badges bar --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                    {{-- Airbnb badge (left) --}}
                    <a href="https://www.airbnb.com/h/villa-fabulosa" target="_blank"
                        class="d-flex align-items-center text-decoration-none mb-3 mb-md-0">
                        <img loading="lazy" decoding="async" src="{{ asset('frontend/imgs/villa-fabulosa-villa-2.webp') }}" alt="Airbnb"
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
                    <a href="https://vrbo.com/3610312?dateless=true" target="_blank"
                        class="d-flex align-items-center text-decoration-none ml-md-auto">
                        <img loading="lazy" decoding="async" src="{{ asset('frontend/imgs/villa-fabulosa-villa-3.webp') }}" alt="Vrbo" style="height:34px;width:auto;"
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
                <h3 class="mb-2" style="font-weight:600; color: #076b96;">Located in the heart of Wine Country</h3>
                <hr class="mb-4" style="border-top:1px solid #ddd;max-width:260px;">
            </div>
            <div class="text-center">
                <img loading="lazy" decoding="async" src="{{ asset('frontend/imgs/villa-fabulosa-wine-room.webp') }}"
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
                color: #595959;
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
                color: #b42318;
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
                border-color: #076b96;
                box-shadow: 0 0 0 3px rgba(29, 163, 221, .1);
            }

            .cf-input.is-invalid,
            .cf-textarea.is-invalid {
                border-color: #b42318;
            }

            .cf-error {
                font-size: 0.8rem;
                color: #b42318;
                margin-top: 4px;
            }

            .cf-hint {
                font-size: 0.77rem;
                color: #595959;
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
                background: #076b96;
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
                background: #075a80;
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
                color: #076b96;
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
                <h2 class="cf-title">Contact Us</h2>
                <div class="cf-sub">We'd love to hear from you. Send us a note with any questions about Villa Fabulosa.
                </div>

                <form id="requestform" action="{{ route('contact') }}" method="POST">
                    @csrf

                    <div class="cf-row">
                        <div class="cf-field">
                            <label class="cf-label" for="cf-fname">First Name <span>*</span></label>
                            <input type="text" id="cf-fname" name="fname"
                                class="cf-input @error('fname') is-invalid @enderror" value="{{ old('fname') }}"
                                placeholder="First name" autocomplete="given-name" required>
                            @error('fname')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="cf-field">
                            <label class="cf-label" for="cf-lname">Last Name <span>*</span></label>
                            <input type="text" id="cf-lname" name="lname"
                                class="cf-input @error('lname') is-invalid @enderror" value="{{ old('lname') }}"
                                placeholder="Last name" autocomplete="family-name" required>
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
                                placeholder="you@example.com" autocomplete="email" required>
                            @error('email')
                                <div class="cf-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="cf-field">
                            <label class="cf-label" for="cf-phone">Phone Number <span>*</span></label>
                            <input type="tel" id="cf-phone" name="phone_number"
                                class="cf-input @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number') }}" placeholder="+1 (555) 000-0000" autocomplete="tel"
                                inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9+\-().\s]/g,'');"
                                required>
                            <div class="cf-error" id="cf-phone-error" style="display:none;">Please enter a valid phone
                                number (digits only).</div>
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
                            placeholder="Tell us how we can help…" required>{{ old('message') }}</textarea>
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
                <img loading="lazy" decoding="async" src="{{ asset('frontend/imgs/villa-fabulosa-villa-198-card1x.webp') }}"
                    srcset="{{ asset('frontend/imgs/villa-fabulosa-villa-198-card1x.webp') }} 300w, {{ asset('frontend/imgs/villa-fabulosa-villa-198-card.webp') }} 600w"
                    sizes="(max-width: 991px) 100vw, 300px" width="300" height="200"
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
        var lbOverflow;
        var lbDescriptions = @json(array_column($photoTour, 'label'));

        function openLightbox(index) {
            lbIndex = index;
            lbOverflow = document.body.style.overflow;
            document.getElementById('lb-img').alt = lbDescriptions[index];
            document.getElementById('lb-img').src = lbPhotos[index];
            document.getElementById('lb-counter').textContent = (index + 1) + ' / ' + lbPhotos.length;
            document.getElementById('photo-lightbox').classList.add('active');
            VillaAccessibility.openDialog(document.getElementById('photo-lightbox'));
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('photo-lightbox').classList.remove('active');
            document.body.style.overflow = lbOverflow;
            VillaAccessibility.closeDialog();
        }

        function lbNavigate(dir) {
            lbIndex = (lbIndex + dir + lbPhotos.length) % lbPhotos.length;
            document.getElementById('lb-img').src = lbPhotos[lbIndex];
            document.getElementById('lb-img').alt = lbDescriptions[lbIndex];
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
    <script>
        /* ── 3D estate hero: spot cards, then the WebGL model after load ── */
        (function () {
            var hero = document.getElementById('estateHero');
            if (!hero) return;

            var stage = document.getElementById('estateStage');
            var card = document.getElementById('estateCard');
            var tools = document.getElementById('estateTools');
            var hint = document.getElementById('estateHint');
            var chips = Array.prototype.slice.call(hero.querySelectorAll('.estate-chip'));
            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var api = null;
            var current = null;
            var lastChip = null;

            function chipFor(id) {
                return hero.querySelector('.estate-chip[data-spot="' + id + '"]');
            }

            function openSpot(id) {
                var chip = chipFor(id);
                if (!chip) return;
                current = id;
                lastChip = chip;
                var img = card.querySelector('.estate-card__img');
                img.src = chip.dataset.img;
                img.alt = chip.dataset.alt;
                card.querySelector('.estate-card__title').textContent = chip.dataset.title;
                card.querySelector('.estate-card__text').textContent = chip.dataset.text;
                var link = card.querySelector('.estate-card__link');
                link.href = chip.dataset.href;
                link.textContent = chip.dataset.link;
                // Re-trigger the entrance animation when switching spots.
                card.hidden = true;
                void card.offsetWidth;
                card.hidden = false;
                hero.classList.add('has-card');
                chips.forEach(function (c) { c.setAttribute('aria-pressed', c === chip ? 'true' : 'false'); });
                if (chip.scrollIntoView && chip.parentNode.parentNode.scrollWidth > chip.parentNode.parentNode.clientWidth) {
                    chip.scrollIntoView({ block: 'nearest', inline: 'center', behavior: reduceMotion ? 'auto' : 'smooth' });
                }
                if (api) api.focus(id);
                if (window.villaTrack) villaTrack('estate_spot', { spot: id });
            }

            function closeSpot(restoreFocus) {
                card.hidden = true;
                hero.classList.remove('has-card');
                current = null;
                chips.forEach(function (c) { c.setAttribute('aria-pressed', 'false'); });
                if (api) api.reset();
                if (restoreFocus && lastChip) lastChip.focus();
            }

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    if (current === chip.dataset.spot) closeSpot(false);
                    else openSpot(chip.dataset.spot);
                });
            });
            card.querySelector('.estate-card__close').addEventListener('click', function () { closeSpot(true); });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && current) closeSpot(true);
            });

            tools.addEventListener('click', function (e) {
                var btn = e.target.closest('button');
                if (!btn || !api) return;
                if (btn.dataset.mode) {
                    api.setMode(btn.dataset.mode);
                    tools.querySelectorAll('[data-mode]').forEach(function (b) {
                        b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
                    });
                } else if (btn.dataset.action === 'reset') {
                    closeSpot(false);
                }
            });

            function webglAvailable() {
                try {
                    var c = document.createElement('canvas');
                    return !!(window.WebGLRenderingContext && (c.getContext('webgl2') || c.getContext('webgl')));
                } catch (e) {
                    return false;
                }
            }

            function boot() {
                var conn = navigator.connection;
                if ((conn && conn.saveData) || !webglAvailable()) return;
                var labels = {};
                chips.forEach(function (c) { labels[c.dataset.spot] = c.textContent.trim(); });
                import(hero.dataset.module).then(function (m) {
                    api = m.mountEstate(stage, {
                        reducedMotion: reduceMotion,
                        labels: labels,
                        onPick: openSpot,
                        onLost: function () {
                            hero.classList.remove('is-3d');
                            tools.hidden = true;
                            hint.hidden = true;
                            api = null;
                        }
                    });
                    hero.classList.add('is-3d');
                    tools.hidden = false;
                    hint.hidden = false;
                    if (current) api.focus(current);
                }).catch(function (err) {
                    // The poster and spot cards still work; nothing else to do.
                    if (window.console) console.warn('3D estate view unavailable:', err);
                });
            }

            // Wait for load and an idle moment so the model never delays
            // the poster photo, fonts or the booking widget.
            function whenIdle(fn) {
                (window.requestIdleCallback || function (f) { setTimeout(f, 300); })(fn, { timeout: 2500 });
            }
            if (document.readyState === 'complete') whenIdle(boot);
            else window.addEventListener('load', function () { whenIdle(boot); });
        })();

        /* ── Depth effects below the hero: tilt cards and scroll reveal ── */
        (function () {
            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (reduceMotion) return;

            if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
                document.querySelectorAll('.site_service_box').forEach(function (box) {
                    box.addEventListener('pointermove', function (e) {
                        var r = box.getBoundingClientRect();
                        var x = (e.clientX - r.left) / r.width - 0.5;
                        var y = (e.clientY - r.top) / r.height - 0.5;
                        box.classList.add('is-tilting');
                        box.style.transform = 'rotateX(' + (-y * 12).toFixed(2) + 'deg) rotateY(' + (x * 14).toFixed(2) + 'deg) translateZ(10px)';
                    });
                    box.addEventListener('pointerleave', function () {
                        box.classList.remove('is-tilting');
                        box.style.transform = '';
                    });
                });
            }

            if (!('IntersectionObserver' in window)) return;
            var targets = document.querySelectorAll('[data-reveal]');
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-revealed');
                    io.unobserve(entry.target);
                });
            }, { rootMargin: '0px 0px -8% 0px' });
            targets.forEach(function (t) { io.observe(t); });
            document.documentElement.classList.add('reveal-ready');
        })();
    </script>
    <script>
        /* ── Phone number: block non-numeric input ── */
        (function() {
            var phoneInput = document.getElementById('cf-phone');
            var phoneError = document.getElementById('cf-phone-error');
            var form = document.getElementById('requestform');
            if (!phoneInput || !form) return;

            phoneInput.addEventListener('keydown', function(e) {
                var allowed = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight',
                    'Home', 'End'
                ];
                /* Allow: allowed keys, Ctrl/Cmd combos, and valid phone chars */
                if (allowed.indexOf(e.key) !== -1 || e.ctrlKey || e.metaKey) return;
                if (/^[0-9+\-().\s]$/.test(e.key)) return;
                e.preventDefault();
            });

            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+\-().\s]/g, '');
                var valid = /\d/.test(this.value);
                phoneInput.classList.toggle('is-invalid', this.value.length > 0 && !valid);
                phoneError.style.display = (this.value.length > 0 && !valid) ? 'block' : 'none';
            });

            /* Also block paste of non-numeric text */
            phoneInput.addEventListener('paste', function(e) {
                e.preventDefault();
                var pasted = (e.clipboardData || window.clipboardData).getData('text');
                var cleaned = pasted.replace(/[^0-9+\-().\s]/g, '');
                var pos = this.selectionStart;
                this.value = this.value.slice(0, pos) + cleaned + this.value.slice(this.selectionEnd);
            });

            form.addEventListener('submit', function(e) {
                var val = phoneInput.value.trim();
                if (!val || !/\d/.test(val)) {
                    e.preventDefault();
                    phoneInput.classList.add('is-invalid');
                    phoneError.style.display = 'block';
                    phoneInput.focus();
                }
            }, true);
        })();
    </script>
    @if (config('services.recaptcha.enabled') && config('services.recaptcha.site_key'))
        {{-- reCAPTCHA pulls in about 1 MB across its script and two iframes,
             and almost nobody who lands on the home page submits this form.
             Load it on first contact with the form instead of on page load;
             api.js renders any .g-recaptcha element present when it arrives,
             so no explicit render call is needed. --}}
        <script>
            (function () {
                var form = document.getElementById('requestform');
                if (!form) return;

                var loaded = false;

                function loadRecaptcha() {
                    if (loaded) return;
                    loaded = true;

                    var s = document.createElement('script');
                    s.src = 'https://www.google.com/recaptcha/api.js';
                    s.async = true;
                    s.defer = true;
                    document.head.appendChild(s);

                    form.removeEventListener('focusin', loadRecaptcha);
                    form.removeEventListener('pointerdown', loadRecaptcha);
                }

                form.addEventListener('focusin', loadRecaptcha);
                form.addEventListener('pointerdown', loadRecaptcha);

                // If the page came back with validation errors the widget is
                // needed immediately -- the visitor is mid-submission.
                @if ($errors->any())
                    loadRecaptcha();
                @endif
            })();
        </script>
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
    <script src="{{ \App\Support\Seo::versioned('frontend/litepicker/litepicker.js') }}" defer></script>
    <script>
        (function() {
            var picker = null;
            var quoteTimer = null;
            var quoteRequestId = 0;
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

            /* Returns the min-stay (in nights) for a given check-in ISO date */
            function getMinStayForIso(iso) {
                if (!iso) return 1;
                var dow = window.VillaDateUtils.dayOfWeekFromIso(iso);
                return parseInt(minStayByDow[dow] || 1, 10);
            }

            /* The currently selected check-in ISO date (set when user picks first date) */
            var selectedCheckinIso = null;

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

                    /* Only show tooltip when user has selected check-in but not checkout yet */
                    if (!selectedCheckinIso) {
                        hideTip();
                        return;
                    }

                    var ts = parseInt(cell.getAttribute('data-time') || '', 10);
                    if (!ts) {
                        hideTip();
                        return;
                    }

                    var hoveredIso = window.VillaDateUtils.toIsoDateLocal(new Date(ts));
                    /* Calculate nights from check-in to hovered date */
                    var ciParts = selectedCheckinIso.split('-');
                    var hvParts = hoveredIso.split('-');
                    var ciDate = new Date(parseInt(ciParts[0]), parseInt(ciParts[1]) - 1, parseInt(ciParts[2]));
                    var hvDate = new Date(parseInt(hvParts[0]), parseInt(hvParts[1]) - 1, parseInt(hvParts[2]));
                    var nightsFromCheckin = Math.round((hvDate - ciDate) / 86400000);
                    var minNights = getMinStayForIso(selectedCheckinIso);

                    /* Only show tooltip if hovered date is too early (invalid checkout) */
                    if (nightsFromCheckin >= minNights || nightsFromCheckin <= 0) {
                        hideTip();
                        return;
                    }

                    tip.textContent = 'Min stay \u2022 ' + minNights + ' night' + (minNights !== 1 ? 's' : '');
                    tip.style.left = e.clientX + 'px';
                    tip.style.top = (e.clientY - 6) + 'px';
                    tip.style.display = 'block';
                });

                pickerRoot.addEventListener('mouseleave', hideTip);
                pickerRoot.addEventListener('mousedown', hideTip);

                /* Block clicks on checkout dates that violate minimum stay.
                   Intercept pointer/mouse/click in capture phase so Litepicker
                   never processes the event and the calendar stays open. */
                function isMinStayBlocked(e) {
                    if (!selectedCheckinIso) return false;
                    var cell = e.target.closest('.day-item');
                    if (!cell || cell.classList.contains('is-locked')) return false;
                    var ts = parseInt(cell.getAttribute('data-time') || '', 10);
                    if (!ts) return false;
                    var clickedIso = window.VillaDateUtils.toIsoDateLocal(new Date(ts));
                    var ciParts = selectedCheckinIso.split('-');
                    var clParts = clickedIso.split('-');
                    var ciDate = new Date(parseInt(ciParts[0]), parseInt(ciParts[1]) - 1, parseInt(
                        ciParts[2]));
                    var clDate = new Date(parseInt(clParts[0]), parseInt(clParts[1]) - 1, parseInt(
                        clParts[2]));
                    var nightsFromCheckin = Math.round((clDate - ciDate) / 86400000);
                    var minNights = getMinStayForIso(selectedCheckinIso);
                    return nightsFromCheckin > 0 && nightsFromCheckin < minNights;
                }
                function blockMinStayEvent(e) {
                    if (isMinStayBlocked(e)) {
                        e.stopImmediatePropagation();
                        e.preventDefault();
                    }
                }
                pickerRoot.addEventListener('pointerdown', blockMinStayEvent, true);
                pickerRoot.addEventListener('mousedown', blockMinStayEvent, true);
                pickerRoot.addEventListener('click', blockMinStayEvent, true);
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
                btn.setAttribute('aria-disabled', checkin && checkout ? 'false' : 'true');
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
                quoteRequestId++;
                document.getElementById('booking-minstay-error').style.display = 'none';
                document.getElementById('booking-price-breakdown').style.display = 'none';
                document.getElementById('booking-nights-bar').style.display = 'none';
                document.getElementById('booking-quote-loading').style.display = 'none';
                updateBookNowBtn('', '', 1);
            }

            function showLoading() {
                updateBookNowBtn('', '', document.getElementById('guests').value);
                document.getElementById('booking-minstay-error').style.display = 'none';
                document.getElementById('booking-price-breakdown').style.display = 'none';
                document.getElementById('booking-quote-loading').style.display = 'block';
            }

            function hideLoading() {
                document.getElementById('booking-quote-loading').style.display = 'none';
            }

            function fetchQuote() {
                var requestId = ++quoteRequestId;
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
                        if (requestId !== quoteRequestId) return;
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
                        if (requestId !== quoteRequestId) return;
                        hideLoading();
                        showError('Unable to check availability. Please try again.');
                    });
            }

            function debouncedFetch() {
                clearTimeout(quoteTimer);
                quoteTimer = setTimeout(fetchQuote, 60);
            }

            function openDatePicker(targetId) {
                var input = document.getElementById(targetId);
                if (!input) {
                    return;
                }
                if (picker) {
                    picker.show();
                }
                input.focus();
                input.click();
            }

            function bindBookingFieldClickTargets() {
                var dateCells = document.querySelectorAll('.booking-date-cell[data-date-target]');
                dateCells.forEach(function(cell) {
                    var target = cell.getAttribute('data-date-target');
                    var targetId = target === 'checkout' ? 'checkout_date' : 'checkin_date';

                    cell.addEventListener('click', function(e) {
                        if (e.target && e.target.closest('input')) {
                            return;
                        }
                        openDatePicker(targetId);
                    });

                    cell.addEventListener('keydown', function(e) {
                        if (e.target && e.target.closest('input')) {
                            return;
                        }
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            openDatePicker(targetId);
                        }
                    });
                });

                var guestsBox = document.getElementById('booking-guests-box');
                var guestsSelect = document.getElementById('guests');
                if (guestsBox && guestsSelect) {
                    function openGuests() {
                        guestsSelect.focus();
                        guestsSelect.click();
                    }

                    guestsBox.addEventListener('click', function(e) {
                        if (e.target && e.target.closest('select')) {
                            return;
                        }
                        openGuests();
                    });

                    guestsBox.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            openGuests();
                        }
                    });
                }
            }

            /* ── Litepicker init ──────────────────────────────────────── */
            function initPicker(lockDays) {
                /* litepicker.js is deferred, so it executes after this script
                   is parsed but before DOMContentLoaded. The availability
                   fetch below almost always resolves later than that, but
                   "almost always" is not a guarantee for the booking flow --
                   so if the library is not up yet, wait for the point where
                   deferred scripts are guaranteed to have run. */
                if (typeof Litepicker === 'undefined') {
                    document.addEventListener('DOMContentLoaded', function () {
                        initPicker(lockDays);
                    }, { once: true });
                    return;
                }

                var isMobile = window.innerWidth < 768;
                picker = new Litepicker({
                    element: document.getElementById('checkin_date'),
                    elementEnd: document.getElementById('checkout_date'),
                    singleMode: false,
                    numberOfMonths: isMobile ? 1 : 2,
                    numberOfColumns: isMobile ? 1 : 2,
                    minDate: new Date(),
                    format: 'MMM D, YYYY',
                    lockDays: lockDays,
                    lockDaysFormat: 'YYYY-MM-DD',
                    disallowLockDaysInRange: true,
                    showTooltip: false,
                    autoApply: true,
                    resetButton: false,
                });

                /* Track check-in selection for tooltip + min-stay enforcement */
                if (window.VillaAccessibility) {
                    function labelPicker(root) {
                        VillaAccessibility.labelCalendar(root);
                        root.onCalendarClose = function () { picker.hide(); };
                    }
                    document.querySelectorAll('.litepicker').forEach(labelPicker);
                    picker.on('render', labelPicker);
                }
                picker.on('preselect', function(date1, date2) {
                    if (date1 && !date2) {
                        /* User just picked check-in, now choosing checkout */
                        selectedCheckinIso = date1.format('YYYY-MM-DD');
                    }
                });

                /* 'selected' is Litepicker's EventEmitter event — fires after both
                   input values have been written, unlike the onSelect option which
                   does not fire reliably in range mode. */
                picker.on('selected', function(date1, date2) {
                    if (date1 && date2) {
                        var ci = date1.format('YYYY-MM-DD');
                        var co = date2.format('YYYY-MM-DD');
                        var ciParts = ci.split('-');
                        var coParts = co.split('-');
                        var ciD = new Date(parseInt(ciParts[0]), parseInt(ciParts[1]) - 1, parseInt(ciParts[
                            2]));
                        var coD = new Date(parseInt(coParts[0]), parseInt(coParts[1]) - 1, parseInt(coParts[
                            2]));
                        var nights = Math.round((coD - ciD) / 86400000);

                        /* Turnover-day guard: stay nights must not overlap a
                           booked check-in day (checkout on that day is fine). */
                        var stayD = new Date(ciD.getTime());
                        var blocked = false;
                        while (stayD < coD) {
                            if (cachedTurnoverDays.indexOf(window.VillaDateUtils.toIsoDateLocal(stayD)) !== -1) {
                                blocked = true;
                                break;
                            }
                            stayD.setDate(stayD.getDate() + 1);
                        }
                        if (blocked) {
                            picker.clearSelection();
                            document.getElementById('checkin_date').value = '';
                            document.getElementById('checkout_date').value = '';
                            selectedCheckinIso = null;
                            setTimeout(function() { picker.show(); }, 0);
                            return;
                        }

                        var minNights = getMinStayForIso(ci);

                        if (nights < minNights) {
                            picker.clearSelection();
                            document.getElementById('checkin_date').value = '';
                            document.getElementById('checkout_date').value = '';
                            selectedCheckinIso = null;
                            setTimeout(function() { picker.show(); }, 0);
                            return;
                        }

                        selectedCheckinIso = null;
                        showMinStayHint(ci);
                        debouncedFetch();
                    } else if (date1) {
                        selectedCheckinIso = date1.format('YYYY-MM-DD');
                        showMinStayHint(date1.format('YYYY-MM-DD'));
                    }
                });

                /* Clear breakdown when selection is cleared */
                picker.on('clear:selection', function() {
                    selectedCheckinIso = null;
                    hideAll();
                });

                bindMinStayHoverTooltip();
            }

            var cachedLockDays = [];
            var cachedTurnoverDays = [];
            var lastPickerMobile = null;

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
                    var turnoverDays = [];
                    events.forEach(function(e) {
                        var cur = new Date(e.start + 'T12:00:00');
                        var end = new Date(e.end + 'T12:00:00');
                        if (cur < end) {
                            turnoverDays.push(window.VillaDateUtils.toIsoDateLocal(cur));
                            cur.setDate(cur.getDate() + 1);
                        }
                        while (cur < end) {
                            lockDays.push(window.VillaDateUtils.toIsoDateLocal(cur));
                            cur.setDate(cur.getDate() + 1);
                        }
                    });
                    cachedLockDays = lockDays;
                    cachedTurnoverDays = turnoverDays;
                    lastPickerMobile = window.innerWidth < 768;
                    initPicker(lockDays);
                })
                .catch(function() {
                    cachedLockDays = [];
                    lastPickerMobile = window.innerWidth < 768;
                    initPicker([]);
                });

            /* Re-init picker when crossing the mobile/desktop breakpoint */
            var resizeTimer = null;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    var nowMobile = window.innerWidth < 768;
                    if (lastPickerMobile !== null && nowMobile !== lastPickerMobile) {
                        lastPickerMobile = nowMobile;
                        if (picker) {
                            picker.destroy();
                            picker = null;
                        }
                        initPicker(cachedLockDays);
                    }
                }, 250);
            });

            /* ── Guests change → re-fetch quote ───────────────────────── */
            document.getElementById('guests').addEventListener('change', debouncedFetch);
            bindBookingFieldClickTargets();

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
