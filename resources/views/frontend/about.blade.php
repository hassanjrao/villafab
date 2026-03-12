@extends('layouts.frontend')

@section('title', 'About Us — Villa Fabulosa')

@section('head_extra')
<style>
    @media screen and (max-width: 767px) {
        .carousel-item { height: 25vh !important; }
    }
</style>
@endsection

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="site_subheader_inner">
                <a href="{{ url('/your-hosts') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
                <a href="{{ url('/the-rooms') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
                <h2 class="mb-0">About Us</h2>
            </div>
        </div>
    </div>
</div>

<!-- Section 1 -->
<section id="site_seciton1" class="site_section_wrapper">
    <div class="container-fluid px-0">
        <div class="row no-gutters">
            <div class="col-lg-6">
                <div id="site_sc1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="background-image:url({{ asset('frontend/imgs/about-us-image.png') }});"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="site_display_table">
                    <div class="site_display_table_cell">
                        <div class="site_content_box">
                            <h1 class="site_section_title">About Us</h1>
                            <hr>
                            <ul class="site_content_list pl-4">
                                <li>Villa Fabulosa is an enchanting haven of indulgence with unparalleled beauty, luxury, and elegance. Incredible outdoor kitchen with 2 Pizza Ovens and Teppanyaki Grill. Game Room with Video Arcades, shuffleboard, poker table, Ice Hockey, and more. Professional Pool Table, Pickleball/Basketball Court, Bocce Court, 18-hole miniature golf, Volleyball/Badminton court, play area for kids, and amazing views from every room. Be one of the first 3 reservations and receive a 20% discount.</li>
                            </ul>
                        </div>
                        <div class="site_content_box">
                            <h1 class="site_section_title">The Space</h1>
                            <hr>
                            <ul class="site_content_list pl-4">
                                <li>Perched on a breathtaking hillside, this architectural masterpiece boasts panoramic views of hot air balloons and Temecula wine country, where over 45 nearby wineries await your exploration.</li>
                                <li>The moment you step inside, you'll be greeted by an elegant interior adorned with tasteful furnishings and contemporary decor. Every detail has been carefully curated to provide the ultimate luxury experience.</li>
                                <li>With 7 bedrooms and 5.5 bathrooms, this sprawling retreat ensures ample space and privacy for up to 20 guests. It even includes a tastefully designed bridal suite to get ready for her special day.</li>
                                <li>Prepare to be captivated by the stunning and very private pool area, featuring two Baja shelfs, inviting you to relax and bask in the sun. Our expansive pergola with seating for 20 guests will be the perfect place to gather together and enjoy spectacular sunsets.</li>
                                <li>Our large game room promises endless fun, with multiple full-size video arcades, ice hockey, foosball, shuffleboard, and a poker table to entertain guests of all ages.</li>
                                <li>For sports enthusiasts and recreation lovers, our property boasts an array of entertainment options to satisfy all desires. Challenge your skills on the professional 18-hole miniature golf course, engage in friendly matches on the pickleball and basketball courts, test your putting prowess on the green, enjoy the art of bocce on our dedicated court, or spend hours of fun playing pool on our professional 8' pool table.</li>
                                <li>Culinary enthusiasts will find their utopia in our state-of-the-art indoor kitchen, tailored for the most discerning chef.</li>
                                <li>Our outdoor kitchen is equipped with two pizza ovens, a huge BBQ grill, a Teppanyaki grill, a full refrigerator, ice maker, bar, TV, and more.</li>
                                <li>Every inch of this opulent Villa has been thoughtfully designed to provide the utmost in beauty, luxury, and comfort.</li>
                                <li>If the Villa Fabulosa is not available, please check out our sister Villa at <a href="https://www.airbnb.com/h/Villa-Magnifica" target="_blank">Airbnb.com/h/Villa-Magnifica</a>.</li>
                            </ul>
                        </div>
                        <div class="site_content_box">
                            <h1 class="site_section_title">Guest Access</h1>
                            <hr>
                            <ul class="site_content_list pl-4">
                                <li>The entire house, pool area, outdoor kitchen, game room, and 18-hole miniature golf course.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
