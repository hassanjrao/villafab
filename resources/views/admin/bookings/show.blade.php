@extends('layouts.backend')

@section('page-name', 'Booking #' . $booking->id)

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Booking #{{ $booking->id }}</h1>
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">Reservation details</h2>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item" aria-current="page">#{{ $booking->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="row">
        <!-- Guest Information -->
        <div class="col-md-6 mb-4">
            <div class="block block-rounded h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-user me-2 text-primary"></i>Guest Information
                    </h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted fw-normal" style="width:140px;">Name</th>
                                <td class="fw-semibold">{{ $booking->name }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Email</th>
                                <td>
                                    @if($booking->email)
                                        <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Phone</th>
                                <td>{{ $booking->phone ?: '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Status</th>
                                <td>
                                    @if($booking->status === 'succeeded')
                                        <span class="badge bg-success fs-sm">Paid</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="badge bg-warning text-dark fs-sm">Pending</span>
                                    @else
                                        <span class="badge bg-secondary fs-sm">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Booked on</th>
                                <td>{{ $booking->created_at->format('M j, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Payment ID</th>
                                <td class="fs-sm text-muted" style="word-break:break-all;">{{ $booking->payment_intent_id }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reservation Details -->
        <div class="col-md-6 mb-4">
            <div class="block block-rounded h-100">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-calendar me-2 text-primary"></i>Reservation Details
                    </h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted fw-normal" style="width:140px;">Check-in</th>
                                <td class="fw-semibold">{{ $booking->checkin ? $booking->checkin->format('l, M j, Y') : '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Check-out</th>
                                <td class="fw-semibold">{{ $booking->checkout ? $booking->checkout->format('l, M j, Y') : '—' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Guests</th>
                                <td>{{ $booking->guests }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Nights</th>
                                <td>{{ $booking->nights }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Price Breakdown -->
        <div class="col-md-6 mb-4">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-usd me-2 text-primary"></i>Price Breakdown
                    </h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted fw-normal" style="width:160px;">Subtotal</th>
                                <td>${{ number_format($booking->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Cleaning Fee</th>
                                <td>${{ number_format($booking->cleaning_fee, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">Tax</th>
                                <td>${{ number_format($booking->tax_amount, 2) }}</td>
                            </tr>
                            <tr class="border-top">
                                <th class="fw-bold pt-3">Total Charged</th>
                                <td class="fw-bold pt-3 fs-lg">${{ number_format($booking->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-alt-secondary">
        <i class="fa fa-arrow-left me-1"></i> Back to Bookings
    </a>
</div>
@endsection
