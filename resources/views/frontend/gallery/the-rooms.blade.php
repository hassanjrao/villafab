@extends('layouts.frontend')

@section('title', 'The Rooms — Villa Fabulosa')

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

        .gallery-video-wrapper {
            position: relative;
        }

        .gallery-video-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: auto;
        }
    </style>
@endsection

@section('content')

    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="site_subheader_inner">
                    <a href="{{ url('/about') }}" class="site_arrow_link site_arrow_left"><i
                            class="fa fa-arrow-circle-left fa-4x"></i></a>
                    <a href="{{ url('/game-rooms') }}" class="site_arrow_link site_arrow_right"><i
                            class="fa fa-arrow-circle-right fa-4x"></i></a>
                    <h2 class="mb-0">The Rooms</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1: The Grand Room -->
    <section class="site_section_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="site_content_box">
                        <h1 class="site_section_title">The Grand Room</h1>
                        <hr>
                        <ul class="site_content_list pl-4">
                            <li>Villa Fabulosa boasts 20-foot ceilings with huge windows, making this spectacular
                                home the brightest and happiest in all of Temecula!</li>
                            <li>The large sliding door with a 15' opening invites your guests to enjoy the most
                                magnificent backyard in Temecula Wine Country.</li>
                            <li>LED Lights on the opulent fireplace with a spectacular décor, three electric sofas
                                with seating for nine guests and an expansive view of the backyard make this room a
                                place that you won't want to leave.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row gallery-grid">
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/05-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/6-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/07-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/56-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/57-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/58-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/59-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/60-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/77-LIVING-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/IMG_1752-MLS.JPG') }}" alt="Grand Room"
                        class="img-fluid gallery-grid-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Dining Room -->
    <section class="site_section_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="site_content_box">
                        <h1 class="site_section_title">Dining Room</h1>
                        <hr>
                        <ul class="site_content_list pl-4">
                            <li>Villa Fabulosa features a gorgeous and very elegant handcrafted dining table with
                                seating for 16 guests, plus 4 additional guests at the center island.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row gallery-grid">
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/10-DINING-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/10-DINING-Edit-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/11-DINING-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/12-LIVING-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/13-DINING-Edit-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/09-DINING-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/IMG_1736-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/IMG_1737-MLS.JPG') }}" alt="Dining Room"
                        class="img-fluid gallery-grid-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: The Kitchen -->
    <section class="site_section_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="site_content_box">
                        <h1 class="site_section_title">The Kitchen</h1>
                        <hr>
                        <ul class="site_content_list pl-4">
                            <li>Villa Fabulosa's kitchen is fully equipped with a large refrigerator, double oven,
                                two coffee machines, two dishwashers, a separate ice maker, and even a large wine
                                cooler.</li>
                            <li>It includes top-of-the-line cookware, kitchen gadgets, cooking utensils etc. It
                                includes plateware, silverware, and glassware for 20 guests.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row gallery-grid">
                <div class="col-6 col-md-3 gallery-grid-item">
                    <a href="https://www.youtube.com/watch?v=qoP5hVuMsnQ" target="_blank"
                        class="gallery-video-wrapper d-block">
                        <img src="{{ asset('frontend/imgs/7-KITCHEN-MLS.JPG') }}" alt="Kitchen Video"
                            class="img-fluid gallery-grid-image">
                        <img src="{{ asset('frontend/imgs/youtube.png') }}" alt="Play video"
                            class="gallery-video-icon">
                    </a>
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/8-KITCHEN-MLS.JPG') }}" alt="Kitchen"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/66-KITCHEN-MLS.JPG') }}" alt="Kitchen"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/67-KITCHEN-MLS.JPG') }}" alt="Kitchen"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/68-KITCHEN-MLS.JPG') }}" alt="Kitchen"
                        class="img-fluid gallery-grid-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Second Seating Area -->
    <section class="site_section_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="site_content_box">
                        <h1 class="site_section_title">Second Seating Area</h1>
                        <hr>
                        <ul class="site_content_list pl-4">
                            <li>Villa Fabulosa features a second sitting area for guests to gather, watch TV or play
                                popular board games.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row gallery-grid">
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/53-MEDIA-MLS.JPG') }}" alt="Second Seating Area"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/13.30-MEDIA-MLS.JPG') }}" alt="Second Seating Area"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/126-IMG_1708-MLS.JPG') }}" alt="Second Seating Area"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/IMG_1715-MLS.JPG') }}" alt="Second Seating Area"
                        class="img-fluid gallery-grid-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: The Bedrooms -->
    <section class="site_section_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="site_content_box">
                        <h1 class="site_section_title">The Bedrooms</h1>
                        <hr>
                        <ul class="site_content_list pl-4">
                            <li>Villa Fabulosa features 7 Bedrooms including 2 King beds, 8 queen beds and 5 sofa
                                beds.</li>
                            <li>All bedrooms at Villa Fabulosa feature the most comfortable mattresses and bedding,
                                and walls adorned with beautiful modern artwork.</li>
                            <li>Each room at Villa Fabulosa includes a wall-mounted, 4K Smart TV, complete with a
                                free Netflix account and commercial-free Hulu.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row gallery-grid">
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/69-BEDROOM-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/70-BEDROOM-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/73-BEDROOM-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/74-BEDROOM-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/80-BEDROOM-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/81-BEDROOM-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/89-MASTER-BED-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/90-MASTER-BED-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/91-MASTER-BED-MLS.JPG') }}" alt="Bedroom"
                        class="img-fluid gallery-grid-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: The Bathrooms -->
    <section class="site_section_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="site_content_box">
                        <h1 class="site_section_title">The Bathrooms</h1>
                        <hr>
                        <ul class="site_content_list pl-4">
                            <li>Villa Fabulosa features 5.5 bathrooms. Two of the bathrooms offer a dual shower
                                head. All bathrooms feature a large rain shower head with spray and containers for
                                Shampoo, Rinse and Body wash.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row gallery-grid">
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/55-BATHROOM-MLS.JPG') }}" alt="Bathroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/71-BATHROOM-MLS.JPG') }}" alt="Bathroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/76-BATHROOM-MLS.JPG') }}" alt="Bathroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/82-BATHROOM-MLS.JPG') }}" alt="Bathroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/92-MASTER-BATH-MLS.JPG') }}" alt="Bathroom"
                        class="img-fluid gallery-grid-image">
                </div>
                <div class="col-6 col-md-3 gallery-grid-item">
                    <img src="{{ asset('frontend/imgs/93-MASTER-BATH-MLS.JPG') }}" alt="Bathroom"
                        class="img-fluid gallery-grid-image">
                </div>
            </div>
        </div>
    </section>

@endsection
