@extends('layouts.frontend')

@section('title', 'Favorite Wineries — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <h2 class="mb-0">Favorite Wineries</h2>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12 text-center">
                <h1 class="site_section_title">Our Favorite Wineries</h1>
                <hr>
                <p class="lead">Explore our handpicked selection of the best wineries near Villa Fabulosa in Temecula Wine Country.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p>Visit <a href="{{ url('/wineries') }}">our full wineries listing</a> to see all 55+ wineries within a short drive from Villa Fabulosa.</p>
            </div>
        </div>
    </div>
</section>

@endsection
