@extends('layouts.frontend')

@section('title', 'Kitchen — Villa Fabulosa')

@section('content')

<div class="container-fluid">
    <!-- Sub Header -->
    <div class="site_subheader">
        <div class="container"><div class="col-lg-12">
            <h2 class="mb-0">Kitchen</h2>
        </div></div>
    </div>

    <!-- Section 1 -->
    <section id="site_scroll_down" class="py-5">
        <div class="container">
            <div class="row mb-2">
                <div class="col-lg-12">
                    <p class="text-center lead">
                        Villa Fabulosa Kitchen is very well stocked. We have created this page to give our guests an idea of what we normally have in our kitchen. This will help you plan your meals and know what you should bring or not bring to the Villa.
                    </p>
                    <p class="text-center lead text-primary">Please understand that we can not guarantee that we will have everything shown on these pictures at all times.</p>
                </div>
            </div>

            <div class="row">
                @php $kitchenImages = [1,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,34,35]; @endphp
                @foreach($kitchenImages as $i)
                <div class="col-lg-3 col-sm-6 mb-4">
                    <a data-fancybox="gallery" href="{{ asset('frontend/imgs/kitchen-gallery/' . $i . '.jpg') }}">
                        <div class="site_kitchen_box">
                            <img src="{{ asset('frontend/imgs/kitchen-gallery/' . $i . '.jpg') }}" class="zoom img-fluid" alt="Kitchen {{ $i }}">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

@endsection
