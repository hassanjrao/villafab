@extends('layouts.backend')

@section('page-name', 'Bookings')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Bookings</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">All confirmed guest reservations.</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Bookings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content">
        <div class="block block-rounded">
            <div class="block-content">
                @if ($bookings->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fa fa-calendar fa-3x mb-3 d-block"></i>
                        <p class="mb-0">No bookings yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter js-dataTable-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guest Name</th>
                                    <th>Email</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th class="text-center">Guests</th>
                                    <th class="text-center">Nights</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Paid</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="text-muted fs-sm">{{ $booking->id }}</td>
                                        <td class="fw-semibold">{{ $booking->name }}</td>
                                        <td class="fs-sm text-muted">{{ $booking->email ?: '—' }}</td>
                                        <td>{{ $booking->checkin ? $booking->checkin->format('M j, Y') : '—' }}</td>
                                        <td>{{ $booking->checkout ? $booking->checkout->format('M j, Y') : '—' }}</td>
                                        <td class="text-center">{{ $booking->guests }}</td>
                                        <td class="text-center">{{ $booking->nights }}</td>
                                        <td class="text-end fw-semibold">${{ number_format($booking->total, 2) }}</td>
                                        <td class="text-end text-muted fs-sm">
                                            ${{ number_format($booking->amount_paid ?? $booking->total, 2) }}
                                        </td>
                                        <td class="text-center">
                                            @if ($booking->payment_type === 'deferred')
                                                <span class="badge bg-info text-dark">Deferred</span>
                                            @else
                                                <span class="badge bg-light text-dark border">Full</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($booking->status === 'succeeded')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($booking->status === 'deposit_paid')
                                                <span class="badge bg-warning text-dark">50% Paid</span>
                                            @elseif($booking->status === 'fully_paid')
                                                <span class="badge bg-success">Fully Paid</span>
                                            @elseif($booking->status === 'balance_failed')
                                                <span class="badge bg-danger">Balance Failed</span>
                                            @elseif($booking->status === 'cancelled')
                                                <span class="badge bg-secondary">Cancelled</span>
                                            @elseif($booking->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="fs-sm text-muted">{{ $booking->created_at->format('M j, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.bookings.show', $booking) }}"
                                                class="btn btn-sm btn-alt-secondary">
                                                <i class="fa fa-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
