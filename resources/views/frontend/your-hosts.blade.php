@extends('layouts.frontend')

@section('title', 'Your Hosts — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="site_subheader_inner">
                <a href="{{ url('/instructions') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
                <a href="{{ url('/about') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
                <h2 class="mb-0">Your Hosts</h2>
            </div>
        </div>
    </div>
</div>

<!-- Section 1 -->
<section id="section1" class="site_section_wrapper site_section_mobile" style="height:auto">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="site_content_box">

                    <div class="row mb-5">
                        <div class="col-lg-4">
                            <img src="{{ asset('frontend/imgs/Alex_Elizabeth-older.jpg') }}" class="img-fluid">
                        </div>
                        <div class="col-lg-8">
                            <p class="lead">My wife and I were recognized as the foremost authorities in wedding planning in the early 2000's. We are the authors of 30 of the bestselling wedding planners sold in North America. We have also written other books in many other categories. Combined we have sold over 5 million copies of our books.</p>
                            <p class="lead">We recently discovered Temecula and fell in love with Villa Magnifica. We have completely renovated it and are now ready to host you and your guests in this beautiful villa able to accommodate up to 24 guests.</p>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-12"><h4>Wedding Books</h4></div>
                    </div>
                    <div class="site_book_thumb_row row text-center mb-4">
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Ultimate-Wedding-Planner-Organizer/dp/1934386405/"><img src="{{ asset('frontend/imgs/book/wedding-book/Ultimage Wedding Planner and Organizer.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Ultimate-Wedding-Planning-Guide/dp/1936061244/"><img src="{{ asset('frontend/imgs/book/wedding-book/Ultimage Wedding Planning Guice.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Ultimate-Wedding-Scrapbook-Alex-Lluch/dp/193438612X/"><img src="{{ asset('frontend/imgs/book/wedding-book/Ultimage Wedding Scrapbook.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/1001-Popular-Asked-Wedding-Questions/dp/193438688X/"><img src="{{ asset('frontend/imgs/book/wedding-book/1001 questions.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Ultimate-Wedding-Planner-Organizer/dp/1934386405/"><img src="{{ asset('frontend/imgs/book/wedding-book/Our Wedding Journal.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Making-Wedding-Beautiful-Memorable-Unique/dp/1887169709/"><img src="{{ asset('frontend/imgs/book/wedding-book/Making Your Wedding Memorable.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Bride-Groom-Challenge-Better-Winner/dp/1934386146/"><img src="{{ asset('frontend/imgs/book/wedding-book/Bride and Groom Challenge.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Ultimate-Book-Wedding-Lists-WedSpace-com/dp/1934386839/"><img src="{{ asset('frontend/imgs/book/wedding-book/Ultimate Book of Wedding Lists.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Ultimate-Grooms-Guide-Alex-Lluch/dp/1887169520/"><img src="{{ asset('frontend/imgs/book/wedding-book/Ultimate Grooms Guide.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/OMG-Wedding-Stories-Outrageous-Embarrassing/dp/1934386979/"><img src="{{ asset('frontend/imgs/book/wedding-book/OMG WEdding Stories.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Bride-Groom-Story-Fill-Blank/dp/1934386499/"><img src="{{ asset('frontend/imgs/book/wedding-book/Bride and Groom Story.jpg') }}" class="img-fluid"></a></div>
                        <div class="col-lg-4 mb-4"><a target="_blank" href="https://www.amazon.com/Before-Wedding-Provocative-Questions-Prepare/dp/1934386367/"><img src="{{ asset('frontend/imgs/book/wedding-book/Before the Wedding.jpg') }}" class="img-fluid"></a></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
