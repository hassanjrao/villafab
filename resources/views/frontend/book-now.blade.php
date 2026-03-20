@extends('layouts.frontend')

@section('page-name', 'Book Now')

@section('head_extra')
<style>
    /* ── Page ── */
    .bn-page {
        background: #f0f2f5;
        min-height: 100vh;
        padding: 48px 0 72px;
    }

    .bn-page .container { max-width: 1100px; }

    .bn-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #555;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color .2s;
    }
    .bn-back-link:hover { color: #1da3dd; text-decoration: none; }

    .bn-page-title {
        font-size: 1.65rem;
        font-weight: 800;
        color: #111;
        margin-bottom: 4px;
    }
    .bn-page-sub {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 32px;
    }

    /* ── Cards ── */
    .bn-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 14px rgba(0,0,0,.06);
        padding: 28px 28px 24px;
        margin-bottom: 20px;
    }

    .bn-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #111;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    /* ── Form fields ── */
    .bn-field-row {
        display: flex;
        gap: 14px;
        margin-bottom: 16px;
    }

    .bn-field {
        flex: 1;
        display: flex;
        flex-direction: column;
        margin-bottom: 16px;
    }

    .bn-field-row .bn-field { margin-bottom: 0; }

    .bn-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #555;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 6px;
    }

    .bn-input {
        width: 100%;
        border: 1.5px solid #dde0e6;
        border-radius: 8px;
        padding: 11px 14px;
        font-size: 0.92rem;
        color: #111;
        background: #fff;
        transition: border-color .2s;
        outline: none;
    }
    .bn-input:focus { border-color: #1da3dd; }


    /* ── Stripe error ── */
    #bn-stripe-error {
        display: none;
        background: #fff0f0;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.85rem;
        color: #c0392b;
        margin-bottom: 14px;
    }

    /* ── Submit button ── */
    .bn-pay-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        background: #1da3dd;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 15px 0;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .03em;
        cursor: pointer;
        transition: background .2s, transform .15s;
    }
    .bn-pay-btn:hover:not(:disabled) {
        background: #178fc0;
        transform: translateY(-1px);
    }
    .bn-pay-btn:disabled { opacity: .6; cursor: not-allowed; }

    @keyframes bn-spin { to { transform: rotate(360deg); } }
    .bn-btn-spinner {
        display: none;
        width: 18px; height: 18px;
        border: 3px solid rgba(255,255,255,.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: bn-spin .7s linear infinite;
    }

    .bn-secure-note {
        text-align: center;
        font-size: 0.77rem;
        color: #aaa;
        margin-top: 10px;
    }
    .bn-secure-note i { margin-right: 4px; color: #27ae60; }

    /* ── Right summary column ── */
    .bn-summary-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 20px;
    }

    .bn-summary-icon {
        width: 56px; height: 56px;
        background: #1da3dd;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .bn-summary-icon i { font-size: 1.6rem; color: #fff; }

    .bn-summary-prop-name {
        font-size: 1.1rem;
        font-weight: 800;
        color: #111;
        margin-bottom: 4px;
    }

    .bn-summary-prop-details {
        font-size: 0.8rem;
        color: #777;
    }

    .bn-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.9rem;
        color: #333;
    }
    .bn-summary-row:last-child { border-bottom: none; }

    .bn-edit-link {
        font-size: 0.8rem;
        color: #1da3dd;
        text-decoration: underline;
        white-space: nowrap;
        margin-left: 12px;
    }
    .bn-edit-link:hover { color: #0d8fca; }

    /* ── Breakdown ── */
    .bn-breakdown-row {
        display: flex;
        justify-content: space-between;
        padding: 9px 0;
        font-size: 0.88rem;
        color: #555;
        border-bottom: 1px solid #f5f5f5;
    }
    .bn-breakdown-row:last-child { border-bottom: none; }

    .bn-total-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 14px 0 4px;
        font-size: 1rem;
        font-weight: 700;
        color: #111;
        border-top: 2px solid #e0e0e0;
        margin-top: 6px;
    }
    .bn-total-amount { font-size: 1.25rem; color: #1da3dd; }

    /* ── Loading / error states ── */
    @keyframes bn-ring-spin { to { transform: rotate(360deg); } }
    .bn-loading {
        text-align: center;
        padding: 28px 0;
        color: #1da3dd;
        font-size: 0.9rem;
    }
    .bn-loading-ring {
        display: inline-block;
        width: 20px; height: 20px;
        border: 3px solid #c8e8f4;
        border-top-color: #1da3dd;
        border-radius: 50%;
        animation: bn-ring-spin .7s linear infinite;
        vertical-align: middle;
        margin-right: 8px;
    }
    .bn-alert-warning {
        background: #fff8e1;
        border: 1px solid #ffe082;
        border-radius: 10px;
        padding: 14px 18px;
        font-size: 0.88rem;
        color: #6d5600;
        line-height: 1.6;
    }
    .bn-alert-warning a { color: #1da3dd; }

    /* ── Guarantee ── */
    .bn-guarantee {
        border: 1.5px solid #333;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }
    .bn-guarantee-title { font-size: 0.92rem; font-weight: 700; margin-bottom: 8px; }
    .bn-guarantee-item {
        font-size: 0.82rem;
        color: #444;
        padding: 3px 0;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .bn-guarantee-item i { color: #27ae60; }

    /* ── Terms ── */
    .bn-terms-box {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.79rem;
        color: #666;
        line-height: 1.7;
    }
    .bn-terms-box a { color: #1da3dd; }

    /* ── House rules collapsible ── */
    .bn-rules-toggle {
        font-size: 0.85rem;
        color: #1da3dd;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        margin-bottom: 0;
        background: none;
        border: none;
        padding: 0;
    }
    .bn-rules-body { font-size: 0.85rem; color: #555; line-height: 1.7; padding-top: 10px; }
    .bn-rules-body p { margin-bottom: 4px; }
    .bn-rules-body strong { color: #222; }

    /* ── Inline edit panels ── */
    .bn-edit-panel {
        background: #f8f9fb;
        border: 1.5px solid #dde0e6;
        border-radius: 10px;
        padding: 14px 14px 10px;
        margin-bottom: 6px;
    }

    .bn-edit-panel-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 12px;
    }

    .bn-panel-btn {
        border: none;
        border-radius: 7px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .bn-panel-btn-cancel {
        background: #eee;
        color: #555;
    }
    .bn-panel-btn-cancel:hover { background: #ddd; }
    .bn-panel-btn-apply {
        background: #1da3dd;
        color: #fff;
    }
    .bn-panel-btn-apply:hover:not(:disabled) { background: #178fc0; }
    .bn-panel-btn-apply:disabled { opacity: .5; cursor: not-allowed; }

    /* Guest counter */
    .bn-guest-counter {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 1rem;
    }
    .bn-guest-counter-btn {
        width: 34px; height: 34px;
        border: 1.5px solid #1da3dd;
        border-radius: 50%;
        background: #fff;
        color: #1da3dd;
        font-size: 1.2rem;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .15s, color .15s;
    }
    .bn-guest-counter-btn:hover { background: #1da3dd; color: #fff; }
    .bn-guest-counter-btn:disabled { opacity: .3; cursor: not-allowed; }
    .bn-guest-counter-val { font-weight: 700; font-size: 1.1rem; min-width: 28px; text-align: center; }

    /* Litepicker overrides inside the panel */
    #bn-litepicker-container .litepicker { width: 100% !important; box-shadow: none !important; border: none !important; }
    #bn-litepicker-container .litepicker .container__months { width: 100% !important; }
    #bn-litepicker-container .litepicker .month-item { width: 100% !important; }

    #bn-litepicker-container .litepicker .container__days .day-item.is-locked {
        color: #ccc;
        text-decoration: line-through;
        pointer-events: none;
    }
    #bn-litepicker-container .litepicker .container__days .day-item.is-start-date,
    #bn-litepicker-container .litepicker .container__days .day-item.is-end-date {
        background-color: #1da3dd !important;
        color: #fff !important;
        border-radius: 6px;
    }
    #bn-litepicker-container .litepicker .container__days .day-item.is-in-range {
        background-color: #d6f0fb;
        color: #111;
    }

    @media (max-width: 767px) {
        .bn-page { padding: 24px 0 48px; }
        .bn-field-row, .stripe-row { flex-direction: column; gap: 0; }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">
@endsection

@section('content')

<div class="bn-page">
    <div class="container">

        <a href="{{ route('home') }}" class="bn-back-link">
            <i class="fa fa-arrow-left"></i> Back to Villa Fabulosa
        </a>

        <div class="bn-page-title">Complete Your Booking</div>
        <div class="bn-page-sub">Enter your details and payment to confirm your reservation.</div>

        @if(!$checkin || !$checkout)
            <div class="bn-alert-warning">
                <i class="fa fa-calendar-times-o" style="margin-right:6px;"></i>
                No dates selected. Please <a href="{{ route('home') }}">go back</a>
                and choose your check-in and check-out dates.
            </div>
        @else

        <div class="row">

            {{-- ── LEFT: Personal Info + Payment ── --}}
            <div class="col-md-7" style="padding-right:20px;">

                {{-- Personal Info card --}}
                <div class="bn-card">
                    <div class="bn-card-title">
                        <i class="fa fa-user-circle" style="color:#1da3dd;margin-right:8px;"></i>
                        Personal Information
                    </div>

                    <div class="bn-field-row">
                        <div class="bn-field">
                            <label class="bn-label" for="bn-first-name">First Name</label>
                            <input type="text" id="bn-first-name" class="bn-input" placeholder="First name" autocomplete="given-name">
                        </div>
                        <div class="bn-field">
                            <label class="bn-label" for="bn-last-name">Last Name</label>
                            <input type="text" id="bn-last-name" class="bn-input" placeholder="Last name" autocomplete="family-name">
                        </div>
                    </div>

                    <div class="bn-field">
                        <label class="bn-label" for="bn-email">Email Address</label>
                        <input type="email" id="bn-email" class="bn-input" placeholder="you@example.com" autocomplete="email">
                        <small style="font-size:0.76rem;color:#aaa;margin-top:4px;">We'll send your receipt here</small>
                    </div>

                    <div class="bn-field" style="margin-bottom:0;">
                        <label class="bn-label" for="bn-phone">Phone Number</label>
                        <input type="tel" id="bn-phone" class="bn-input" placeholder="+1 (555) 000-0000" autocomplete="tel">
                    </div>
                </div>

                {{-- Payment card --}}
                <div class="bn-card">
                    <div class="bn-card-title">
                        <i class="fa fa-lock" style="color:#1da3dd;margin-right:8px;"></i>
                        Payment Method
                    </div>

                    {{-- Payment Element loading state --}}
                    <div id="bn-payment-loading" class="bn-loading" style="padding:20px 0;">
                        <span class="bn-loading-ring"></span> Loading payment form…
                    </div>

                    {{-- Stripe Payment Element (Card / other methods tabs) --}}
                    <div id="payment-element" style="margin-bottom:20px;"></div>

                    <div id="bn-stripe-error"></div>

                    <button id="bn-pay-btn" type="button" class="bn-pay-btn" disabled>
                        <span class="bn-btn-spinner" id="bn-btn-spinner"></span>
                        <span id="bn-pay-btn-text">Complete Booking &rarr;</span>
                    </button>

                    <p class="bn-secure-note">
                        <i class="fa fa-lock"></i> Secure, encrypted payment powered by Stripe
                    </p>
                </div>

            </div>

            {{-- ── RIGHT: Booking Summary ── --}}
            <div class="col-md-5" style="padding-left:8px;">

                {{-- Property summary --}}
                <div class="bn-card">
                    <div class="bn-summary-header">
                        <div class="bn-summary-icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div>
                            <div class="bn-summary-prop-name">Villa Fabulosa</div>
                            <div class="bn-summary-prop-details">
                                Temecula Wine Country &bull; 5 Bedrooms &bull; 6 Baths &bull; Up to 24 guests
                            </div>
                        </div>
                    </div>

                    <div class="bn-summary-row">
                        <span>
                            <i class="fa fa-calendar" style="color:#1da3dd;margin-right:5px;"></i>
                            <span id="bn-date-display" style="font-weight:600;">Loading…</span>
                        </span>
                        <a href="#" id="bn-edit-dates-btn" class="bn-edit-link">Edit</a>
                    </div>

                    {{-- Inline date edit panel --}}
                    <div id="bn-date-edit-panel" style="display:none;" class="bn-edit-panel">
                        <input id="bn-litepicker-input" type="text" readonly style="display:none;">
                        <div id="bn-litepicker-container"></div>
                        <div class="bn-edit-panel-actions">
                            <button type="button" id="bn-dates-cancel-btn" class="bn-panel-btn bn-panel-btn-cancel">Cancel</button>
                            <button type="button" id="bn-dates-apply-btn" class="bn-panel-btn bn-panel-btn-apply" disabled>Apply Dates</button>
                        </div>
                    </div>

                    <div class="bn-summary-row">
                        <span>
                            <i class="fa fa-users" style="color:#1da3dd;margin-right:5px;"></i>
                            <span id="bn-guests-display" style="font-weight:600;">{{ $guests }} guest{{ $guests > 1 ? 's' : '' }}</span>
                        </span>
                        <a href="#" id="bn-edit-guests-btn" class="bn-edit-link">Edit</a>
                    </div>

                    {{-- Inline guests edit panel --}}
                    <div id="bn-guests-edit-panel" style="display:none;" class="bn-edit-panel">
                        <div class="bn-guest-counter">
                            <button type="button" id="bn-g-dec" class="bn-guest-counter-btn" disabled>&minus;</button>
                            <span class="bn-guest-counter-val" id="bn-g-val">{{ $guests }}</span>
                            <button type="button" id="bn-g-inc" class="bn-guest-counter-btn">+</button>
                            <span style="font-size:0.85rem;color:#777;margin-left:4px;">guests (max 24)</span>
                        </div>
                        <div class="bn-edit-panel-actions">
                            <button type="button" id="bn-guests-cancel-btn" class="bn-panel-btn bn-panel-btn-cancel">Cancel</button>
                            <button type="button" id="bn-guests-apply-btn" class="bn-panel-btn bn-panel-btn-apply">Apply</button>
                        </div>
                    </div>
                </div>

                {{-- Price breakdown --}}
                <div class="bn-card">
                    <div class="bn-card-title">Price Breakdown</div>

                    <div id="bn-loading" class="bn-loading">
                        <span class="bn-loading-ring"></span> Calculating…
                    </div>
                    <div id="bn-quote-error" style="display:none;" class="bn-alert-warning"></div>
                    <div id="bn-breakdown" style="display:none;">
                        <div id="bn-breakdown-rows"></div>
                        <div class="bn-total-row">
                            <span>Total of stay</span>
                            <span id="bn-total" class="bn-total-amount"></span>
                        </div>
                    </div>
                </div>

                {{-- Guarantee --}}
                <div class="bn-guarantee">
                    <div class="bn-guarantee-title">Villa Fabulosa Guarantee</div>
                    <div class="bn-guarantee-item"><i class="fa fa-check-circle"></i> Lowest price by booking directly</div>
                    <div class="bn-guarantee-item"><i class="fa fa-check-circle"></i> 24 hour free cancellation after booking</div>
                    <div class="bn-guarantee-item"><i class="fa fa-check-circle"></i> 24/7 support throughout your stay</div>
                </div>

                {{-- Terms --}}
                <div class="bn-terms-box">
                    By completing your booking, I agree to Villa Fabulosa's
                    <a href="#" data-toggle="modal" data-target="#tnc-modal">Terms &amp; Conditions</a>
                    and cancellation policy.
                    <a href="{{ route('home') }}#contact">Contact us</a> with any questions.
                </div>

                {{-- House Rules collapsible --}}
                <div class="bn-card" style="margin-top:4px;">
                    <button class="bn-rules-toggle" type="button" id="bn-rules-toggle">
                        <i class="fa fa-chevron-down" id="bn-rules-chevron"></i> View House Rules
                    </button>
                    <div id="bn-rules-body" class="bn-rules-body" style="display:none;">
                        <p><strong>Special Restrictions</strong></p>
                        <p>Must be 25+ years old to book &bull; No smoking &bull; No noise after 10pm &bull; No pets &bull; No motor homes</p>
                        <p style="margin-top:8px;"><strong>Cancellation &amp; Refund</strong></p>
                        <p>60+ days: full refund &bull; 31–59 days: 50% refund &bull; 0–30 days: no refund</p>
                    </div>
                </div>

            </div>
        </div>

        @endif
    </div>
</div>

{{-- Terms & Conditions Modal --}}
<div class="modal fade" id="tnc-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header" style="background:#1da3dd;color:#fff;border-bottom:none;">
                <h5 class="modal-title" style="font-weight:700;">Terms &amp; Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:28px 32px;font-size:0.9rem;line-height:1.8;color:#333;">
                <p><em>Terms &amp; Conditions content coming soon. Please contact us for details.</em></p>
            </div>
            <div class="modal-footer" style="border-top:1px solid #eee;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts_extra')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
<script>
(function () {
    var checkin  = '{{ addslashes($checkin) }}';
    var checkout = '{{ addslashes($checkout) }}';
    var guests   = {{ (int) $guests }};

    if (!checkin || !checkout) { return; }

    var stripe         = Stripe('{{ config('services.stripe.key') }}');
    var stripeElements = null;
    var paymentElement = null;
    var litepicker     = null;
    var lockedDays     = [];   /* booked dates from Google Calendar */
    var pendingCheckin  = checkin;
    var pendingCheckout = checkout;
    var pendingGuests   = guests;

    /* ── Helpers ── */
    function friendlyDate(iso) {
        var days   = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var p = iso.split('-');
        var d = new Date(parseInt(p[0]), parseInt(p[1]) - 1, parseInt(p[2]));
        return days[d.getDay()] + ', ' + months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
    }

    function nightsBetween(c1, c2) {
        var p1 = c1.split('-'), p2 = c2.split('-');
        var d1 = new Date(parseInt(p1[0]), parseInt(p1[1])-1, parseInt(p1[2]));
        var d2 = new Date(parseInt(p2[0]), parseInt(p2[1])-1, parseInt(p2[2]));
        return Math.round((d2 - d1) / 86400000);
    }

    function fmt(n) {
        return '$' + parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function showStripeError(msg) {
        var el = document.getElementById('bn-stripe-error');
        el.textContent = msg;
        el.style.display = 'block';
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideStripeError() {
        document.getElementById('bn-stripe-error').style.display = 'none';
    }

    function setLoading(on) {
        var btn     = document.getElementById('bn-pay-btn');
        var spinner = document.getElementById('bn-btn-spinner');
        var btnText = document.getElementById('bn-pay-btn-text');
        btn.disabled          = on;
        spinner.style.display = on ? 'inline-block' : 'none';
        btnText.textContent   = on ? 'Processing…' : 'Complete Booking →';
    }

    function updateDateDisplay() {
        var nights = nightsBetween(checkin, checkout);
        document.getElementById('bn-date-display').textContent =
            friendlyDate(checkin) + ' – ' + friendlyDate(checkout) +
            ' · ' + nights + ' night' + (nights !== 1 ? 's' : '');
    }

    function updateGuestsDisplay() {
        document.getElementById('bn-guests-display').textContent =
            guests + ' guest' + (guests !== 1 ? 's' : '');
    }

    /* ── Main load / reload function ── */
    function loadQuoteAndStripe() {
        /* Reset price breakdown UI */
        document.getElementById('bn-loading').style.display = 'block';
        document.getElementById('bn-breakdown').style.display = 'none';
        document.getElementById('bn-quote-error').style.display = 'none';

        /* Unmount old Stripe element if re-loading */
        if (paymentElement) {
            paymentElement.unmount();
            paymentElement = null;
        }
        stripeElements = null;
        document.getElementById('payment-element').innerHTML = '';
        document.getElementById('bn-payment-loading').style.display = 'block';
        document.getElementById('bn-pay-btn').disabled = true;
        hideStripeError();

        fetch('{{ route("api.price-quote") }}?checkin=' + checkin + '&checkout=' + checkout + '&guests=' + guests)
            .then(function (r) { return r.json(); })
            .then(function (q) {
                document.getElementById('bn-loading').style.display = 'none';

                if (!q.valid) {
                    var errDiv = document.getElementById('bn-quote-error');
                    var msg = q.min_stay
                        ? 'Minimum stay for a ' + q.checkin_day + ' check-in is ' +
                          q.min_stay + ' night' + (q.min_stay !== 1 ? 's' : '') + '. Please select different dates.'
                        : (q.error || 'Invalid dates.');
                    errDiv.innerHTML = '<i class="fa fa-exclamation-triangle" style="margin-right:6px;"></i>' + msg;
                    errDiv.style.display = 'block';
                    document.getElementById('bn-payment-loading').style.display = 'none';
                    return;
                }

                /* Populate price breakdown */
                var rows = '';
                if (q.base_total > 0) {
                    rows += '<div class="bn-breakdown-row"><span>Nightly rates &times; ' + q.nights +
                        ' night' + (q.nights !== 1 ? 's' : '') + '</span><span>' + fmt(q.base_total) + '</span></div>';
                }
                if (q.extra_guest_fee > 0) {
                    rows += '<div class="bn-breakdown-row"><span>Extra guests (' + q.extra_guests +
                        ' &times; ' + q.nights + ' nights)</span><span>' + fmt(q.extra_guest_fee) + '</span></div>';
                }
                rows += '<div class="bn-breakdown-row"><span>Cleaning fee</span><span>' + fmt(q.cleaning_fee) + '</span></div>';
                rows += '<div class="bn-breakdown-row"><span>Taxes (' + q.tax_rate + '%)</span><span>' + fmt(q.tax_amount) + '</span></div>';
                document.getElementById('bn-breakdown-rows').innerHTML = rows;
                document.getElementById('bn-total').textContent = fmt(q.total);
                document.getElementById('bn-breakdown').style.display = 'block';

                return fetch('{{ route("booking.payment-intent") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ checkin: checkin, checkout: checkout, guests: guests }),
                });
            })
            .then(function (r) { return r ? r.json() : null; })
            .then(function (data) {
                if (!data) { return; }
                if (data.error) {
                    document.getElementById('bn-payment-loading').style.display = 'none';
                    showStripeError(data.error);
                    return;
                }

                stripeElements = stripe.elements({
                    clientSecret: data.client_secret,
                    appearance: {
                        theme: 'stripe',
                        variables: {
                            colorPrimary:    '#1da3dd',
                            colorBackground: '#ffffff',
                            colorText:       '#111111',
                            colorDanger:     '#e74c3c',
                            fontFamily:      'Inter, system-ui, sans-serif',
                            fontSizeBase:    '15px',
                            borderRadius:    '8px',
                            spacingUnit:     '4px',
                        },
                        rules: {
                            '.Input': { border: '1.5px solid #dde0e6', boxShadow: 'none' },
                            '.Input:focus': { border: '1.5px solid #1da3dd', boxShadow: 'none' },
                            '.Tab': { border: '1.5px solid #dde0e6' },
                            '.Tab--selected': { border: '1.5px solid #1da3dd', boxShadow: '0 0 0 1px #1da3dd' },
                        },
                    },
                });

                paymentElement = stripeElements.create('payment', {
                    layout: { type: 'tabs', defaultCollapsed: false },
                });
                paymentElement.mount('#payment-element');
                paymentElement.on('ready', function () {
                    document.getElementById('bn-payment-loading').style.display = 'none';
                    document.getElementById('bn-pay-btn').disabled = false;
                });
                paymentElement.on('change', function (e) {
                    if (e.complete) { hideStripeError(); }
                });
            })
            .catch(function () {
                document.getElementById('bn-loading').style.display    = 'none';
                document.getElementById('bn-payment-loading').style.display = 'none';
                var errDiv = document.getElementById('bn-quote-error');
                errDiv.innerHTML = '<i class="fa fa-exclamation-triangle" style="margin-right:6px;"></i>Could not load pricing. Please try again.';
                errDiv.style.display = 'block';
            });
    }

    /* ── Initial render ── */
    updateDateDisplay();
    updateGuestsDisplay();
    loadQuoteAndStripe();

    /* ── Pre-fetch booked dates for the calendar ── */
    fetch('{{ route("api.booked-dates") }}')
        .then(function (r) { return r.json(); })
        .then(function (events) {
            var days = [];
            events.forEach(function (e) {
                var cur = new Date(e.start + 'T12:00:00');
                var end = new Date(e.end   + 'T12:00:00');
                while (cur < end) {
                    days.push(cur.toISOString().split('T')[0]);
                    cur.setDate(cur.getDate() + 1);
                }
            });
            lockedDays = days;
        })
        .catch(function () { lockedDays = []; });

    /* ════════════════════════════════════════
       Inline Date Edit Panel
    ════════════════════════════════════════ */
    document.getElementById('bn-edit-dates-btn').addEventListener('click', function (e) {
        e.preventDefault();
        var panel      = document.getElementById('bn-date-edit-panel');
        var guestPanel = document.getElementById('bn-guests-edit-panel');
        guestPanel.style.display = 'none';

        if (panel.style.display !== 'none') {
            panel.style.display = 'none';
            return;
        }
        panel.style.display = 'block';

        /* Reset pending */
        pendingCheckin  = checkin;
        pendingCheckout = checkout;
        document.getElementById('bn-dates-apply-btn').disabled = true;

        /* Destroy previous picker if any */
        if (litepicker) { litepicker.destroy(); litepicker = null; }

        /* Clear container so Litepicker re-renders fresh */
        document.getElementById('bn-litepicker-container').innerHTML = '';

        litepicker = new Litepicker({
            element:                 document.getElementById('bn-litepicker-input'),
            parentEl:                document.getElementById('bn-litepicker-container'),
            inlineMode:              true,
            singleMode:              false,
            numberOfMonths:          1,
            numberOfColumns:         1,
            startDate:               checkin,
            endDate:                 checkout,
            minDate:                 new Date(),
            format:                  'YYYY-MM-DD',
            lockDays:                lockedDays,
            lockDaysFormat:          'YYYY-MM-DD',
            disallowLockDaysInRange: true,
            tooltipText:             { one: 'night', other: 'nights' },
            showTooltip:             true,
            autoApply:               true,
        });

        litepicker.on('selected', function (d1, d2) {
            pendingCheckin  = d1.format('YYYY-MM-DD');
            pendingCheckout = d2.format('YYYY-MM-DD');
            document.getElementById('bn-dates-apply-btn').disabled = false;
        });
    });

    document.getElementById('bn-dates-apply-btn').addEventListener('click', function () {
        checkin  = pendingCheckin;
        checkout = pendingCheckout;
        updateDateDisplay();
        document.getElementById('bn-date-edit-panel').style.display = 'none';
        document.getElementById('bn-dates-apply-btn').disabled = true;
        loadQuoteAndStripe();
    });

    document.getElementById('bn-dates-cancel-btn').addEventListener('click', function () {
        document.getElementById('bn-date-edit-panel').style.display = 'none';
    });

    /* ════════════════════════════════════════
       Inline Guests Edit Panel
    ════════════════════════════════════════ */
    document.getElementById('bn-edit-guests-btn').addEventListener('click', function (e) {
        e.preventDefault();
        var panel     = document.getElementById('bn-guests-edit-panel');
        var datePanel = document.getElementById('bn-date-edit-panel');
        datePanel.style.display = 'none';

        if (panel.style.display !== 'none') {
            panel.style.display = 'none';
            return;
        }

        pendingGuests = guests;
        document.getElementById('bn-g-val').textContent = pendingGuests;
        document.getElementById('bn-g-dec').disabled = (pendingGuests <= 1);
        document.getElementById('bn-g-inc').disabled = (pendingGuests >= 24);
        panel.style.display = 'block';
    });

    document.getElementById('bn-g-dec').addEventListener('click', function () {
        if (pendingGuests > 1) {
            pendingGuests--;
            document.getElementById('bn-g-val').textContent = pendingGuests;
            document.getElementById('bn-g-dec').disabled = (pendingGuests <= 1);
            document.getElementById('bn-g-inc').disabled = false;
        }
    });

    document.getElementById('bn-g-inc').addEventListener('click', function () {
        if (pendingGuests < 24) {
            pendingGuests++;
            document.getElementById('bn-g-val').textContent = pendingGuests;
            document.getElementById('bn-g-inc').disabled = (pendingGuests >= 24);
            document.getElementById('bn-g-dec').disabled = false;
        }
    });

    document.getElementById('bn-guests-apply-btn').addEventListener('click', function () {
        guests = pendingGuests;
        updateGuestsDisplay();
        document.getElementById('bn-guests-edit-panel').style.display = 'none';
        loadQuoteAndStripe();
    });

    document.getElementById('bn-guests-cancel-btn').addEventListener('click', function () {
        document.getElementById('bn-guests-edit-panel').style.display = 'none';
    });

    /* ════════════════════════════════════════
       Submit Payment
    ════════════════════════════════════════ */
    document.getElementById('bn-pay-btn').addEventListener('click', function () {
        var firstName = document.getElementById('bn-first-name').value.trim();
        var lastName  = document.getElementById('bn-last-name').value.trim();
        var email     = document.getElementById('bn-email').value.trim();
        var phone     = document.getElementById('bn-phone').value.trim();

        if (!firstName || !lastName) {
            showStripeError('Please enter your first and last name.');
            document.getElementById('bn-first-name').focus();
            return;
        }
        if (!email) {
            showStripeError('Please enter your email address.');
            document.getElementById('bn-email').focus();
            return;
        }
        if (!phone) {
            showStripeError('Please enter your phone number.');
            document.getElementById('bn-phone').focus();
            return;
        }
        hideStripeError();
        setLoading(true);

        var returnUrl = '{{ route("booking.success") }}' +
            '?name='     + encodeURIComponent(firstName + ' ' + lastName) +
            '&checkin='  + encodeURIComponent(checkin) +
            '&checkout=' + encodeURIComponent(checkout) +
            '&guests='   + guests;

        stripe.confirmPayment({
            elements: stripeElements,
            confirmParams: {
                return_url: returnUrl,
                payment_method_data: {
                    billing_details: {
                        name:  firstName + ' ' + lastName,
                        email: email,
                        phone: phone,
                    },
                },
            },
        }).then(function (result) {
            if (result.error) {
                showStripeError(result.error.message);
                setLoading(false);
            }
        });
    });

    /* ── House Rules toggle ── */
    document.getElementById('bn-rules-toggle').addEventListener('click', function () {
        var body    = document.getElementById('bn-rules-body');
        var chevron = document.getElementById('bn-rules-chevron');
        var open    = body.style.display !== 'none';
        body.style.display = open ? 'none' : 'block';
        chevron.className  = open ? 'fa fa-chevron-down' : 'fa fa-chevron-up';
        this.querySelector('span').textContent = open ? ' View House Rules' : ' Hide House Rules';
    });

})();
</script>
@endsection
