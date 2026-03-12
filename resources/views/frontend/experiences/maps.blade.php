@extends('layouts.frontend')

@section('title', 'Maps — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid"><div class="col-lg-12"><div class="site_subheader_inner">
        <h2 class="mb-0">Maps</h2>
    </div></div></div>
</div>

<!-- Section 1 -->
<section id="site_scroll_down" class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12 text-center">
                <h1 class="site_section_title">Location &amp; Maps</h1>
                <hr>
                <p class="lead">Villa Fabulosa is located in the heart of Temecula Wine Country, right in the center of the Winery Loop.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3321.1234567890!2d-117.026276!3d33.5477843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80db79c1dcd9f19f%3A0x2a6b5d1fb1e3d527!2s39575+Camino+Del+Vino%2C+Temecula%2C+CA+92592!5e0!3m2!1sen!2sus!4v1234567890" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
