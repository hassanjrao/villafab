@extends('layouts.frontend')

@section('title', 'Temecula — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/wineries') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/team-bonding') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Temecula</h2>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="section1" class="site_section_wrapper site_section_mobile" style="height:auto">
    <div class="container"><div class="row"><div class="col-lg-12">
        <div class="site_display_table"><div class="site_display_table_cell">
            <div class="site_content_box">
                <ul class="site_temecula_links site_content_list pl-4">
                    <li>
                        <a class="site_temecula_link" href="https://www.winemag.com/top-10-wine-travel-destinations-2019/" target="_blank">10 Best Wine Destinations in the World</a>
                        <p>Temecula was selected among the top 10 wine destinations in the world! Not even Napa made the list!</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.rivcoparks.org/" target="_blank">Lake Skinner</a>
                        <p>Fishing, Camping, Hiking 3 minutes from Villa Fabulosa</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://weather.com/weather/today/l/USCA1136:1:US" target="_blank">Weather</a>
                        <p>Find the weather in Temecula</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.visittemeculavalley.com/things-to-do/events/" target="_blank">Events</a>
                        <p>What's going on in Temecula on any given day</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.yelp.com/search?find_desc=Golf+COurse&find_loc=Temecula%2C+CA&ns=1" target="_blank">Golf Courses</a>
                        <p>Find the best courses in Temecula</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.yelp.com/search?find_desc=Restaurants&find_loc=Temecula,+CA" target="_blank">Restaurants</a>
                        <p>Find the best restaurants in Temecula</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.temeculavalleyhospital.com/" target="_blank">Hospitals/Emergency</a>
                        <p>Find information on Temecula's Hospital</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.yelp.com/search?cflt=physicians&find_loc=Temecula%2C+CA" target="_blank">Doctors in Temecula</a>
                        <p>Find the best doctors in Temecula</p>
                    </li>
                    <li>
                        <a class="site_temecula_link" href="https://www.pechanga.com/" target="_blank">Pechanga Casino</a>
                        <p>Are you feeling lucky?</p>
                    </li>
                </ul>
            </div>
        </div></div>
    </div></div></div>
</section>

@endsection
