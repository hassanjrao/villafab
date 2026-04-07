@extends('layouts.frontend')

@section('page-name', 'Update Payment Method')

@section('head_extra')
<style>
    .uc-wrap {
        max-width: 540px;
        margin: 60px auto;
        padding: 0 18px 60px;
    }

    .uc-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 32px 28px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
    }

    .uc-card h1 {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 6px;
        color: #111;
    }

    .uc-card .uc-sub {
        color: #6b7280;
        font-size: 14px;
        margin: 0 0 24px;
    }

    .uc-info {
        background: #f8fcff;
        border: 1px solid #dbe7ef;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 24px;
        font-size: 14px;
        line-height: 1.6;
    }

    .uc-info strong {
        display: inline-block;
        min-width: 130px;
    }

    #card-element {
        border: 1.5px solid #dde0e6;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 20px;
        background: #fff;
        transition: border-color .2s;
    }

    #card-element.StripeElement--focus {
        border-color: #1da3dd;
    }

    #card-element.StripeElement--invalid {
        border-color: #e74c3c;
    }

    #card-errors {
        display: none;
        background: #fff0f0;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.85rem;
        color: #c0392b;
        margin-bottom: 14px;
    }

    .uc-btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: #0b6aa2;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background .2s;
    }

    .uc-btn:hover {
        background: #095a8a;
    }

    .uc-btn:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    .uc-success {
        display: none;
        text-align: center;
        padding: 24px 0;
    }

    .uc-success svg {
        width: 64px;
        height: 64px;
        margin-bottom: 16px;
    }

    .uc-success h2 {
        font-size: 20px;
        font-weight: 700;
        color: #065f46;
        margin: 0 0 8px;
    }

    .uc-success p {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="uc-wrap">
    <div class="uc-card">

        {{-- Form state --}}
        <div id="uc-form-section">
            <h1>Update Payment Method</h1>
            <p class="uc-sub">Securely update the card on file for your upcoming balance payment.</p>

            <div class="uc-info">
                <strong>Booking:</strong> #{{ $booking->id }}<br>
                <strong>Guest:</strong> {{ $booking->name }}<br>
                <strong>Balance Due:</strong> ${{ number_format($booking->balance_due, 2) }}<br>
                <strong>Charge Date:</strong>
                {{ $booking->balance_charge_date ? $booking->balance_charge_date->format('F j, Y') : '-' }}
            </div>

            <div id="card-errors"></div>
            <div id="card-element"></div>

            <button type="button" id="uc-submit" class="uc-btn">Update Card</button>
        </div>

        {{-- Success state --}}
        <div class="uc-success" id="uc-success-section">
            <svg viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <h2>Card Updated Successfully</h2>
            <p>Your new payment method is now on file. Your balance of
                ${{ number_format($booking->balance_due, 2) }} will be charged on
                {{ $booking->balance_charge_date ? $booking->balance_charge_date->format('F j, Y') : '' }}.</p>
        </div>

    </div>
</div>
@endsection

@section('scripts_extra')
<script src="https://js.stripe.com/v3/"></script>
<script>
    (function () {
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '15px',
                    fontFamily: 'Inter, system-ui, sans-serif',
                    color: '#111',
                    '::placeholder': { color: '#aab7c4' },
                },
                invalid: { color: '#e74c3c' },
            },
        });
        cardElement.mount('#card-element');

        var errBox = document.getElementById('card-errors');
        var submitBtn = document.getElementById('uc-submit');
        var formSection = document.getElementById('uc-form-section');
        var successSection = document.getElementById('uc-success-section');

        cardElement.on('change', function (e) {
            if (e.error) {
                errBox.textContent = e.error.message;
                errBox.style.display = 'block';
            } else {
                errBox.style.display = 'none';
            }
        });

        submitBtn.addEventListener('click', function () {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing…';
            errBox.style.display = 'none';

            stripe.confirmCardSetup('{{ $clientSecret }}', {
                payment_method: { card: cardElement }
            }).then(function (result) {
                if (result.error) {
                    errBox.textContent = result.error.message;
                    errBox.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Update Card';
                    return;
                }

                // Send the new payment method to our server
                fetch('{{ route("booking.update-card.process", $token) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        payment_method: result.setupIntent.payment_method,
                    }),
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.success) {
                        formSection.style.display = 'none';
                        successSection.style.display = 'block';
                    } else {
                        errBox.textContent = data.message || 'Something went wrong. Please try again.';
                        errBox.style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Update Card';
                    }
                })
                .catch(function () {
                    errBox.textContent = 'Network error. Please try again.';
                    errBox.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Update Card';
                });
            });
        });
    })();
</script>
@endsection
