@extends('layouts.frontend')

@section('title', 'Stuck on Paper — Villa Fabulosa')

@section('content')

    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container">
            <div class="col-lg-12">
                <h2 class="mb-0">Stuck on Paper</h2>
            </div>
        </div>
    </div>

    <!-- Section 1 -->
    <section id="section1" class="site_section_wrapper site_section_mobile0 py-5" style="height:auto">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <a href="{{ url('/team-bonding') }}" class="btn btn-outline-primary mb-3">&larr; Back to Team
                        Bonding</a>
                    <h1>Stuck on Paper</h1>
                </div>
            </div>
            <div class="site_videos_row row justify-content-center">
                <div class="col-lg-8 mb-4">
                    <div class="site_video_box">
                        <div class="card">
                            <video width="100%" height="auto" controls
                                poster="{{ asset('frontend/imgs/team-bonding/stuck-on-paper.jpg') }}">
                                <source src="{{ asset('frontend/video/3-Stuck-on-Paper.mp4') }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
