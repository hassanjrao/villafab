@extends('layouts.frontend')

@section('title', 'Floor Plan — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <a href="{{ url('/birds-eye') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
        <a href="{{ url('/wineries') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
        <h2 class="mb-0">Floor Plan</h2>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5 site_section_mobile">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img src="{{ asset('frontend/imgs/updtairs.png') }}" class="img-fluid">
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('frontend/imgs/downstaris.png') }}" class="img-fluid">
            </div>
        </div>
    </div>
</section>

@endsection
