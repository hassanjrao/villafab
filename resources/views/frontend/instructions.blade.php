@extends('layouts.frontend')

@section('title', 'Instructions — Villa Fabulosa')

@section('head_extra')
    <style>
        @media (max-width: 575px) {
            .Introductory_vdo {
                height: 250px !important;
            }

            .u_tube_icn {
                width: 100% !important;
                height: 50px !important;
            }
        }
    </style>
@endsection

@section('content')

    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="site_subheader_inner">
                    <a href="{{ url('/team-bonding') }}" class="site_arrow_link site_arrow_left"><i
                            class="fa fa-arrow-circle-left fa-4x"></i></a>
                    <a href="{{ url('/your-hosts') }}" class="site_arrow_link site_arrow_right"><i
                            class="fa fa-arrow-circle-right fa-4x"></i></a>
                    <h2 class="mb-0">How to Use &amp; Enjoy Everything at Villa Fabulosa</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1 -->
    <section id="site_scroll_down" class="py-5">
        <div class="container">

            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                    <h1 class="site_section_title text-dark">Indoor Instructions</h1>
                    <hr>
                </div>
            </div>

            <!-- Introductory Video -->
            <div class="site_video_wrapper mb-5">
                <div class="container">
                    <div class="row">
                        <h4>Introductory Video</h4>
                        <div class="col-lg-12" id="video_one">
                            <div class="Introductory_vdo" style="position: relative; width: 100%; height: 600px;">
                                <a href="https://www.youtube.com/watch?v=sApb0oPcF5c" target="_blank">
                                    <img src="{{ asset('frontend/imgs/indoor_sec_iframe_img.jpg') }}" width="100%"
                                        height="100%" style="cursor: pointer;">
                                </a>
                                <a href="https://www.youtube.com/watch?v=sApb0oPcF5c" target="_blank"
                                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                    <img src="{{ asset('frontend/imgs/youtube.png') }}" class="u_tube_icn" width="130"
                                        height="100">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $indoorItems = [
                    [
                        'url' => 'https://www.youtube.com/watch?v=qoP5hVuMsnQ',
                        'img' => 'imgs/7-KITCHEN-MLS.JPG',
                        'title' => 'Kitchen',
                    ],
                    [
                        'url' => 'https://www.youtube.com/watch?v=3ri1woO5z7w',
                        'img' => 'imgs/ins-pics/IMG_5095.jpg',
                        'title' => 'TV, Stereo, & Outdoor Speakers',
                    ],
                    [
                        'url' => 'https://youtu.be/5F9Tl-_3eow',
                        'img' => 'imgs/ins-pics/IMG_5099.jpg',
                        'title' => 'Fireplace',
                    ],
                    [
                        'url' => 'https://www.youtube.com/watch?v=TUuDAd7aqik',
                        'img' => 'imgs/ins-pics/IMG_5102.jpg',
                        'title' => 'Stereo System',
                    ],
                    [
                        'url' => 'https://www.youtube.com/watch?v=AC_sgSheP-A',
                        'img' => 'imgs/ins-pics/IMG_5105.jpg',
                        'title' => 'Oven',
                    ],
                    [
                        'url' => 'https://youtu.be/eQPkSOcgUTo',
                        'img' => 'imgs/ins-pics/IMG_5118.jpg',
                        'title' => 'Keurig',
                    ],
                    [
                        'url' => 'https://youtu.be/UkkRHfmdbGM',
                        'img' => 'imgs/ins-pics/IMG_5112.jpg',
                        'title' => 'Coffee Machines',
                    ],
                    [
                        'url' => 'https://youtu.be/zJX7rJzQRXM',
                        'img' => 'imgs/ins-pics/IMG_5107.jpg',
                        'title' => 'Microwave',
                    ],
                    [
                        'url' => 'https://youtu.be/XgEtf5tCqZ0',
                        'img' => 'imgs/ins-pics/IMG_5119.jpg',
                        'title' => 'Dishwashers',
                    ],
                    [
                        'url' => 'https://youtu.be/wtE8EDk8dCw',
                        'img' => 'imgs/ins-pics/IMG_5126.jpg',
                        'title' => 'Washing Machine & Dryers',
                    ],
                    [
                        'url' => 'https://youtu.be/GAweqH23kL0',
                        'img' => 'imgs/ins-pics/IMG_5141.jpg',
                        'title' => 'Printer',
                    ],
                ];
            @endphp

            <div class="row mb-4">
                @foreach ($indoorItems as $item)
                    <div class="col-lg-4 col-sm-4 mb-4">
                        <div class="site_ins_card card bg-light mb-3">
                            <div class="card-body">
                                <a data-fancybox data-width="740" data-height="460" href="{{ $item['url'] }}"
                                    target="_blank">
                                    <img src="{{ asset('frontend/' . $item['img']) }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="card-header text-center">
                                <a data-fancybox data-width="740" data-height="460" href="{{ $item['url'] }}"
                                    target="_blank">
                                    <h5 class="card-title mb-0">{{ $item['title'] }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Game Room Instructions -->
            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                    <h1 class="site_section_title text-dark">Game Room Instructions</h1>
                    <hr>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-4 col-sm-4 mb-4">
                    <div class="site_ins_card card bg-light mb-3">
                        <div class="card-body">
                            <a data-fancybox data-width="740" data-height="460" href="https://youtu.be/Xuvah9BdF0A"
                                target="_blank">
                                <img src="{{ asset('frontend/imgs/ins-pics/IMG_5140.jpg') }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="card-header text-center">
                            <a data-fancybox data-width="740" data-height="460" href="https://youtu.be/Xuvah9BdF0A"
                                target="_blank">
                                <h5 class="card-title mb-0">Video Arcades</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outdoor Instructions -->
            <div class="row mb-4">
                <div class="col-lg-12 text-center">
                    <h1 class="site_section_title text-dark">Outdoor Instructions</h1>
                    <hr>
                </div>
            </div>

            @php
                $outdoorItems = [
                    [
                        'url' => 'https://youtu.be/SBtvyVgweJg',
                        'img' => 'imgs/ins-pics/IMG_5135.jpg',
                        'title' => 'Teppanyaki',
                    ],
                    [
                        'url' => 'https://youtu.be/1HC6EHwJ70g',
                        'img' => 'imgs/ins-pics/IMG_5129.jpg',
                        'title' => 'Burners',
                    ],
                    [
                        'url' => 'https://youtu.be/CSynvLcFSOA',
                        'img' => 'imgs/ins-pics/IMG_5131.jpg',
                        'title' => 'Gas Heaters',
                    ],
                    [
                        'url' => 'https://youtu.be/70fCCNB4FDQ',
                        'img' => 'imgs/ins-pics/IMG_5131.jpg',
                        'title' => 'Pizza Oven',
                    ],
                    [
                        'url' => 'https://youtu.be/PJmnmxLa3ws',
                        'img' => 'imgs/ins-pics/IMG_5133.jpg',
                        'title' => 'BBQ Grill',
                    ],
                    [
                        'url' => 'https://www.youtube.com/watch?v=PUvtwjaAres',
                        'img' => 'imgs/out_door_sec_img.jpg',
                        'title' => 'Trash',
                    ],
                ];
            @endphp

            <div class="row mb-4">
                @foreach ($outdoorItems as $item)
                    <div class="col-lg-4 col-sm-4 mb-4">
                        <div class="site_ins_card card bg-light mb-3">
                            <div class="card-body">
                                <a data-fancybox data-width="740" data-height="460" href="{{ $item['url'] }}"
                                    target="_blank">
                                    <img src="{{ asset('frontend/' . $item['img']) }}" class="img-fluid">
                                </a>
                            </div>
                            <div class="card-header text-center">
                                <a data-fancybox data-width="740" data-height="460" href="{{ $item['url'] }}"
                                    target="_blank">
                                    <h5 class="card-title mb-0">{{ $item['title'] }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

@endsection
