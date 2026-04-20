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
                        <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a>
                        </li>
                        <li class="breadcrumb-item"><a class="link-fx"
                                href="{{ route('admin.bookings.index') }}">Bookings</a></li>
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
                                        @if ($booking->email)
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
                                    <th class="text-muted fw-normal">Guest Note</th>
                                    <td style="white-space:pre-wrap;">{{ $booking->guest_note ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Status</th>
                                    <td>
                                        @if ($booking->status === 'succeeded')
                                            <span class="badge bg-success fs-sm">Paid</span>
                                        @elseif($booking->status === 'deposit_paid')
                                            <span class="badge bg-warning text-dark fs-sm">50% Paid &ndash; Balance
                                                Pending</span>
                                        @elseif($booking->status === 'fully_paid')
                                            <span class="badge bg-success fs-sm">Fully Paid</span>
                                        @elseif($booking->status === 'balance_failed')
                                            <span class="badge bg-danger fs-sm">Balance Charge Failed</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-secondary fs-sm">Cancelled</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="badge bg-warning text-dark fs-sm">Pending</span>
                                        @else
                                            <span class="badge bg-secondary fs-sm">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Payment Type</th>
                                    <td>
                                        @if ($booking->payment_type === 'deferred')
                                            <span class="badge bg-info text-dark fs-sm">Deferred (50/50)</span>
                                        @else
                                            <span class="badge bg-light text-dark border fs-sm">Full Payment</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Booked on</th>
                                    <td>{{ $booking->created_at->format('M j, Y g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Payment ID</th>
                                    <td class="fs-sm text-muted" style="word-break:break-all;">
                                        {{ $booking->payment_intent_id }}</td>
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
                                    <td class="fw-semibold">
                                        {{ $booking->checkin ? $booking->checkin->format('l, M j, Y') : '—' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Check-out</th>
                                    <td class="fw-semibold">
                                        {{ $booking->checkout ? $booking->checkout->format('l, M j, Y') : '—' }}</td>
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
                                    <th class="fw-bold pt-3">Total</th>
                                    <td class="fw-bold pt-3 fs-lg">${{ number_format($booking->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted fw-normal">Amount Paid</th>
                                    <td class="fw-semibold text-success">
                                        ${{ number_format($booking->amount_paid ?? $booking->total, 2) }}
                                    </td>
                                </tr>
                                @if ($booking->payment_type === 'deferred' && $booking->balance_due > 0)
                                    <tr>
                                        <th class="text-muted fw-normal">Balance Due</th>
                                        <td class="fw-semibold text-warning">
                                            ${{ number_format($booking->balance_due, 2) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($booking->payment_type === 'deferred')
            {{-- Deferred Payment Details --}}
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="fa fa-calendar-check-o me-2 text-info"></i>Deferred Payment Details
                            </h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="text-muted fw-normal" style="width:200px;">Deposit Paid</th>
                                                <td class="fw-semibold text-success">
                                                    ${{ number_format($booking->amount_paid, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">Balance Due</th>
                                                <td
                                                    class="fw-semibold
                                            @if ($booking->balance_status === 'charged') text-success
                                            @elseif($booking->balance_status === 'failed' || $booking->balance_status === 'cancelled') text-danger
                                            @else text-warning @endif">
                                                    ${{ number_format($booking->balance_due, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">Charge Date</th>
                                                <td>{{ $booking->balance_charge_date ? $booking->balance_charge_date->format('l, M j, Y') : '—' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th class="text-muted fw-normal" style="width:200px;">Balance Status</th>
                                                <td>
                                                    @if ($booking->balance_status === 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($booking->balance_status === 'charged')
                                                        <span class="badge bg-success">Charged</span>
                                                    @elseif($booking->balance_status === 'failed')
                                                        <span class="badge bg-danger">Charge Failed</span>
                                                    @elseif($booking->balance_status === 'cancelled')
                                                        <span class="badge bg-secondary">Cancelled</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ $booking->balance_status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted fw-normal">Reminder Sent</th>
                                                <td class="fs-sm text-muted">
                                                    {{ $booking->balance_reminder_sent_at ? $booking->balance_reminder_sent_at->format('M j, Y g:i A') : '—' }}
                                                </td>
                                            </tr>
                                            @if ($booking->balance_failure_notified_at)
                                                <tr>
                                                    <th class="text-muted fw-normal">Failure Notified</th>
                                                    <td class="fs-sm text-danger">
                                                        {{ $booking->balance_failure_notified_at->format('M j, Y g:i A') }}
                                                        &mdash; auto-cancels
                                                        {{ $booking->balance_failure_notified_at->addDays(2)->format('M j, Y') }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <a href="{{ route('admin.bookings.index') }}" class="btn btn-alt-secondary">
            <i class="fa fa-arrow-left me-1"></i> Back to Bookings
        </a>
    </div>
@endsection
