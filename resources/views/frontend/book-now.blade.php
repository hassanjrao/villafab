@extends('layouts.frontend')

@section('title', 'Book Now — Villa Fabulosa')

@section('content')

<!-- Sub Header -->
<div class="site_subheader">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="site_subheader_inner">
                <a href="{{ url('/your-hosts') }}" class="site_arrow_link site_arrow_left"><i class="fa fa-arrow-circle-left fa-4x"></i></a>
                <a href="{{ url('/the-rooms') }}" class="site_arrow_link site_arrow_right"><i class="fa fa-arrow-circle-right fa-4x"></i></a>
                <h2 class="mb-0">Book Now</h2>
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
                    <div class="text-center mb-5">
                        <p>Tell us about yourself, your event, which dates you are interested in and how many guests will be staying, and we will send you pricing and availability right away!</p>
                        <hr>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form id="booknowform" action="{{ route('contact') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" value="{{ old('fname') }}">
                                <small class="form-text text-muted">First Name</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label>&nbsp;</label>
                                <input type="text" class="form-control" name="lname" value="{{ old('lname') }}">
                                <small class="form-text text-muted">Last Name</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label>Phone Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                        </div>
                        <div class="form-group">
                            <label>How did you hear about Villa Fabulosa?</label>
                            <select class="form-control" name="reason">
                                <option value="">- Select -</option>
                                <option>Callaway Winery</option>
                                <option>Churon Winery</option>
                                <option>Europa Village</option>
                                <option>Faulkner Winery</option>
                                <option>Friend or Family</option>
                                <option>Google</option>
                                <option>Lake Oak Meadows</option>
                                <option>Leoness Cellars</option>
                                <option>Miramonte Winery</option>
                                <option>Mount Palomar Winery</option>
                                <option>Ponte Family Estate Winery</option>
                                <option>South Coast Winery</option>
                                <option>Thornton Winery</option>
                                <option>Wilson Creek Winery</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="message" rows="4">{{ old('message') }}</textarea>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
