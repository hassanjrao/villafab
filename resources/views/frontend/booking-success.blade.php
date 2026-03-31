@extends('layouts.frontend')

@section('page-name', 'Booking Confirmed')

@section('content')
    <div
        style="background:#f5f5f5;min-height:80vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;">
        <div
            style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);
                max-width:540px;width:100%;padding:48px 40px;text-align:center;">

            <div
                style="width:72px;height:72px;background:#e8f8f0;border-radius:50%;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
                <i class="fa fa-check" style="font-size:2rem;color:#27ae60;"></i>
            </div>

            <h2 style="font-size:1.6rem;font-weight:800;color:#111;margin-bottom:10px;">
                Booking Confirmed!
            </h2>

            @if (isset($paymentType) && $paymentType === 'deferred')
                <p style="font-size:1rem;color:#555;margin-bottom:20px;line-height:1.6;">
                    Thank you, <strong>{{ $name }}</strong>!
                    Your deposit has been processed successfully.
                    A receipt has been sent to your email.
                </p>

                {{-- Deferred payment notice --}}
                <div
                    style="background:#fff8e1;border:1px solid #ffe082;border-radius:10px;
                        padding:14px 18px;margin-bottom:20px;text-align:left;font-size:0.9rem;color:#6d5600;line-height:1.6;">
                    <strong><i class="fa fa-calendar" style="margin-right:6px;"></i>Split Payment Plan</strong><br>
                    Your remaining balance of
                    <strong>${{ $balanceDue ? number_format($balanceDue, 2) : '—' }}</strong>
                    will be automatically charged to your card on
                    <strong>
                        {{ $balanceChargeDate ? \Carbon\Carbon::parse($balanceChargeDate)->format('F j, Y') : '—' }}
                    </strong>.
                    You will receive a reminder email {{ env('BALANCE_REMINDER_DAYS_BEFORE', 7) }} days before the charge.
                </div>
            @else
                <p style="font-size:1rem;color:#555;margin-bottom:28px;line-height:1.6;">
                    Thank you, <strong>{{ $name }}</strong>! Your reservation at Villa Fabulosa has been received
                    and your payment has been processed successfully. A receipt has been sent to your email.
                </p>
            @endif

            @if ($checkin && $checkout)
                <div
                    style="background:#f8fffe;border:1px solid #c8e8f4;border-radius:10px;
                    padding:16px 20px;margin-bottom:28px;text-align:left;font-size:0.9rem;color:#333;">
                    <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eaf6fc;">
                        <span style="color:#777;">Check-in</span>
                        <strong>{{ $checkin }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eaf6fc;">
                        <span style="color:#777;">Check-out</span>
                        <strong>{{ $checkout }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eaf6fc;">
                        <span style="color:#777;">Guests</span>
                        <strong>{{ $guests }}</strong>
                    </div>
                    @if ($total)
                        <div
                            style="display:flex;justify-content:space-between;padding:6px 0;
                        {{ isset($paymentType) && $paymentType === 'deferred' ? 'border-bottom:1px solid #eaf6fc;' : '' }}">
                            <span style="color:#777;">
                                {{ isset($paymentType) && $paymentType === 'deferred' ? 'Deposit paid today' : 'Total charged' }}
                            </span>
                            <strong style="color:#1da3dd;">{{ $total }}</strong>
                        </div>
                    @endif
                    @if (isset($paymentType) && $paymentType === 'deferred' && $balanceDue)
                        <div style="display:flex;justify-content:space-between;padding:6px 0;">
                            <span style="color:#777;">Balance due
                                {{ $balanceChargeDate ? 'on ' . \Carbon\Carbon::parse($balanceChargeDate)->format('M j, Y') : '' }}
                            </span>
                            <strong style="color:#f39c12;">${{ number_format($balanceDue, 2) }}</strong>
                        </div>
                    @endif
                </div>
            @endif

            <a href="{{ route('home') }}"
                style="display:inline-block;background:#1da3dd;color:#fff;border-radius:10px;
                  padding:13px 36px;font-size:0.95rem;font-weight:700;text-decoration:none;">
                Back to Villa Fabulosa
            </a>

            <p style="margin-top:18px;font-size:0.8rem;color:#aaa;">
                Questions? <a href="{{ route('home') }}#contact" style="color:#1da3dd;">Contact us</a>
            </p>
        </div>
    </div>
@endsection
