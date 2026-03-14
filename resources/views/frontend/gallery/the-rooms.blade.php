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

        /* Lightbox for gallery images */
        #gallery-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 1050;
            align-items: center;
            justify-content: center;
        }

        #gallery-lightbox.active {
            display: flex;
        }

        #gallery-lightbox img {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 4px;
        }

        #gallery-lightbox .glb-close,
        #gallery-lightbox .glb-prev,
        #gallery-lightbox .glb-next {
            position: fixed;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            cursor: pointer;
            z-index: 1051;
            transition: background 0.2s;
        }

        #gallery-lightbox .glb-close {
            top: 20px;
            right: 24px;
            font-size: 2rem;
            padding: 4px 10px;
        }

        #gallery-lightbox .glb-prev,
        #gallery-lightbox .glb-next {
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
            padding: 10px 16px;
        }

        #gallery-lightbox .glb-prev {
            left: 16px;
        }

        #gallery-lightbox .glb-next {
            right: 16px;
        }

        #gallery-lightbox .glb-prev:hover,
        #gallery-lightbox .glb-next:hover,
        #gallery-lightbox .glb-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        #gallery-lightbox .glb-counter {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
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

    {{-- Gallery lightbox overlay --}}
    <div id="gallery-lightbox">
        <button class="glb-close" type="button" aria-label="Close">&times;</button>
        <button class="glb-prev" type="button" aria-label="Previous"><i class="fa fa-angle-left"></i></button>
        <img id="glb-img" src="" alt="">
        <button class="glb-next" type="button" aria-label="Next"><i class="fa fa-angle-right"></i></button>
        <div class="glb-counter" id="glb-counter"></div>
    </div>

@endsection

@section('scripts_extra')
    <script>
        (function() {
            var lightbox = document.getElementById('gallery-lightbox');
            if (!lightbox) return;

            var imgEl = document.getElementById('glb-img');
            var counterEl = document.getElementById('glb-counter');
            var images = Array.prototype.slice.call(document.querySelectorAll('.gallery-grid-image'));
            if (!images.length) return;

            var currentIndex = 0;

            function openAt(index) {
                currentIndex = index;
                imgEl.src = images[index].src;
                counterEl.textContent = (index + 1) + ' / ' + images.length;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeLb() {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }

            function navigate(delta) {
                currentIndex = (currentIndex + delta + images.length) % images.length;
                imgEl.src = images[currentIndex].src;
                counterEl.textContent = (currentIndex + 1) + ' / ' + images.length;
            }

            images.forEach(function(img, idx) {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function(e) {
                    // Skip images that are inside a video link
                    if (img.closest('.gallery-video-wrapper')) return;
                    e.preventDefault();
                    openAt(idx);
                });
            });

            lightbox.querySelector('.glb-close').addEventListener('click', closeLb);
            lightbox.querySelector('.glb-prev').addEventListener('click', function() { navigate(-1); });
            lightbox.querySelector('.glb-next').addEventListener('click', function() { navigate(1); });

            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    closeLb();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (!lightbox.classList.contains('active')) return;
                if (e.key === 'Escape') closeLb();
                if (e.key === 'ArrowLeft') navigate(-1);
                if (e.key === 'ArrowRight') navigate(1);
            });
        })();
    </script>
@endsection
