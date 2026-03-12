@extends('layouts.frontend')

@section('title', 'Team Bonding — Villa Fabulosa')

@section('content')

    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="site_subheader_inner">
                    <a href="{{ url('/temecula') }}" class="site_arrow_link site_arrow_left"><i
                            class="fa fa-arrow-circle-left fa-4x"></i></a>
                    <a href="{{ url('/instructions') }}" class="site_arrow_link site_arrow_right"><i
                            class="fa fa-arrow-circle-right fa-4x"></i></a>
                    <h2 class="mb-0">Team Bonding Experience</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1 -->
    <section id="section1" class="site_section_wrapper site_section_mobile0 pb-5" style="height:auto">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="site_content_box text-center">
                        <h3 class="site_section_subtitle">At Villa Fabulosa</h3>
                    </div>
                    <div>
                        <p class="lead">Villa Fabulosa is the perfect place to host a series of hilarious Team Bonding
                            games. These games will surely entertain your friends and family, whether it's for a corporate
                            event or for the entire bridal party!</p>
                        <p class="lead">The cost for this 3 hour "Team Bonding" experience is $75 per person. This
                            includes the coach, all props and items for the game, and medals for the winners.</p>
                        <p class="lead">The minimum number of people is 16, and the maximum is 40.</p>
                        <p class="lead">The Team Bonding experience requires one night stay at Villa Fabulosa during the
                            week, or two nights on weekends.</p>
                        <p class="lead">This experience can also be done at a public park without reserving Villa
                            Fabulosa.</p>
                        <p class="lead">Call <a href="tel:619-578-4013">619-578-4013</a> for more information and to check
                            availability.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-5">
            <div class="site_teambox_row row">
                @php
                    $games = [
                        [
                            'href' => 'video/9-Butt-Balloon.mp4',
                            'img' => 'imgs/team-bonding/butt-balloon.jpg',
                            'title' => 'Butt Balloon',
                        ],
                        [
                            'href' => 'video/1-Rope-Escape.mp4',
                            'img' => 'imgs/team-bonding/rope-escape.jpg',
                            'title' => 'Untangle',
                        ],
                        [
                            'href' => 'video/5-Ping-Pong-in-a-Cup.mp4',
                            'img' => 'imgs/team-bonding/ping-pong-in-a-cup.jpg',
                            'title' => 'Ping Pong in a Cup',
                        ],
                        [
                            'href' => 'video/2-Balloon-Race.mp4',
                            'img' => 'imgs/team-bonding/balloon-race.jpg',
                            'title' => 'Balloon Race',
                        ],
                        [
                            'href' => 'video/6-Pass-the-Ball.mp4',
                            'img' => 'imgs/team-bonding/pass-the-ball.jpg',
                            'title' => 'Pass the Ball',
                        ],
                    ];
                @endphp

                @foreach ($games as $game)
                    <div class="col mb-4">
                        <div class="site_team_box">
                            <div class="card">
                                <a data-fancybox data-width="640" data-height="360"
                                    href="{{ asset('frontend/' . $game['href']) }}">
                                    <img src="{{ asset('frontend/' . $game['img']) }}" class="card-img-top"
                                        alt="{{ $game['title'] }}">
                                    <div class="card-body">
                                        <h5 class="card-title mb-0">{{ $game['title'] }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="site_teambox_row row">
                @php
                    $games2 = [
                        [
                            'href' => 'video/3-Stuck-on-Paper.mp4',
                            'img' => 'imgs/team-bonding/stuck-on-paper.jpg',
                            'title' => 'Stuck on Paper',
                        ],
                        [
                            'href' => 'video/4-Pass-the-block.mp4',
                            'img' => 'imgs/team-bonding/pass-the-block.jpg',
                            'title' => 'Pass the Block',
                        ],
                        [
                            'href' => 'video/7-Mine-Fields.mp4',
                            'img' => 'imgs/team-bonding/mine-fields.jpg',
                            'title' => 'Mine Fields',
                        ],
                        [
                            'href' => 'video/8-The-Nuts-Stacker.mp4',
                            'img' => 'imgs/team-bonding/the-nuts-stacker.jpg',
                            'title' => 'Nuts Stacker',
                        ],
                        [
                            'href' => 'video/10-Legs-Tied.mp4',
                            'img' => 'imgs/team-bonding/legs-tied.jpg',
                            'title' => 'Legs Tied',
                        ],
                    ];
                @endphp

                @foreach ($games2 as $game)
                    <div class="col mb-4">
                        <div class="site_team_box">
                            <div class="card">
                                <a data-fancybox data-width="640" data-height="360"
                                    href="{{ asset('frontend/' . $game['href']) }}">
                                    <img src="{{ asset('frontend/' . $game['img']) }}" class="card-img-top"
                                        alt="{{ $game['title'] }}">
                                    <div class="card-body">
                                        <h5 class="card-title mb-0">{{ $game['title'] }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
