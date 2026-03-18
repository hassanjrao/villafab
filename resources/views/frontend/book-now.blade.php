@extends('layouts.frontend')

@section('page-name', 'Book Now')

@section('head_extra')
<style>
    /* ── Page chrome ── */
    .bn-page {
        background: #f5f5f5;
        min-height: 100vh;
        padding: 48px 0 64px;
    }

    .bn-page .container {
        max-width: 1060px;
    }

    .bn-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #555;
        text-decoration: none;
        margin-bottom: 28px;
        transition: color .2s;
    }

    .bn-back-link:hover { color: #1da3dd; text-decoration: none; }

    /* ── Columns ── */
    .bn-col-rules {
        padding-right: 28px;
    }

    .bn-col-summary {
        padding-left: 12px;
    }

    /* ── Section cards ── */
    .bn-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0,0,0,.07);
        padding: 28px 28px 24px;
        margin-bottom: 20px;
    }

    .bn-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        border-bottom: 2px solid #e8e8e8;
        padding-bottom: 12px;
        margin-bottom: 18px;
        color: #222;
    }

    /* ── House Rules ── */
    .bn-rules-section-title {
        font-weight: 700;
        font-size: 0.92rem;
        margin: 16px 0 6px;
        color: #1a1a1a;
    }

    .bn-rules-section-title:first-child { margin-top: 0; }

    .bn-rules-item {
        font-size: 0.88rem;
        color: #444;
        padding: 5px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.5;
    }

    .bn-rules-item i {
        color: #1da3dd;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* ── Booking summary header ── */
    .bn-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.92rem;
        color: #333;
    }

    .bn-summary-row:last-child { border-bottom: none; }

    .bn-summary-label { font-weight: 600; }

    .bn-edit-link {
        font-size: 0.8rem;
        color: #1da3dd;
        text-decoration: underline;
        cursor: pointer;
        white-space: nowrap;
        margin-left: 12px;
    }

    .bn-edit-link:hover { color: #0d8fca; }

    /* ── Breakdown rows ── */
    .bn-breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        font-size: 0.9rem;
        color: #444;
        border-bottom: 1px solid #f4f4f4;
    }

    .bn-breakdown-row:last-child { border-bottom: none; }

    .bn-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0 4px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #111;
        border-top: 2px solid #e0e0e0;
        margin-top: 6px;
    }

    .bn-total-amount { color: #1da3dd; font-size: 1.25rem; }

    /* ── Spinner ── */
    @keyframes bn-spin { to { transform: rotate(360deg); } }

    .bn-loading {
        text-align: center;
        padding: 32px 0;
        color: #1da3dd;
        font-size: 0.9rem;
    }

    .bn-loading-ring {
        display: inline-block;
        width: 22px; height: 22px;
        border: 3px solid #c8e8f4;
        border-top-color: #1da3dd;
        border-radius: 50%;
        animation: bn-spin .7s linear infinite;
        vertical-align: middle;
        margin-right: 8px;
    }

    /* ── Error / missing dates ── */
    .bn-alert-warning {
        background: #fff8e1;
        border: 1px solid #ffe082;
        border-radius: 10px;
        padding: 18px 20px;
        font-size: 0.9rem;
        color: #6d5600;
        line-height: 1.6;
    }

    .bn-alert-warning a { color: #1da3dd; }

    /* ── Guarantee box ── */
    .bn-guarantee {
        border: 1.5px solid #333;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }

    .bn-guarantee-title {
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .bn-guarantee-item {
        font-size: 0.82rem;
        color: #444;
        padding: 3px 0;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .bn-guarantee-item i { color: #27ae60; }

    /* ── Terms box ── */
    .bn-terms-box {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 14px;
        font-size: 0.8rem;
        color: #666;
        line-height: 1.7;
    }

    .bn-terms-box a { color: #1da3dd; }

    /* ── Agree button ── */
    .bn-agree-btn {
        display: block;
        width: 100%;
        background: #1da3dd;
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 15px 0;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .03em;
        text-align: center;
        cursor: pointer;
        transition: background .2s, transform .15s;
        text-decoration: none;
    }

    .bn-agree-btn:hover {
        background: #178fc0;
        color: #fff !important;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .bn-no-charge {
        text-align: center;
        font-size: 0.76rem;
        color: #aaa;
        margin-top: 8px;
    }

    /* ── Page title strip ── */
    .bn-page-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: #111;
        margin-bottom: 4px;
    }

    .bn-page-sub {
        font-size: 0.9rem;
        color: #777;
        margin-bottom: 28px;
    }

    @media (max-width: 767px) {
        .bn-col-rules { padding-right: 15px; margin-bottom: 24px; }
        .bn-col-summary { padding-left: 15px; }
        .bn-page { padding: 28px 0 48px; }
    }
</style>
@endsection

@section('content')

<div class="bn-page">
    <div class="container">

        {{-- Back link --}}
        <a href="{{ route('home') }}" class="bn-back-link">
            <i class="fa fa-arrow-left"></i> Back to Villa Fabulosa
        </a>

        <div class="bn-page-title">Confirm Your Booking</div>
        <div class="bn-page-sub">Review house rules and your price before confirming.</div>

        @if(!$checkin || !$checkout)
            {{-- Missing dates — redirect prompt --}}
            <div class="bn-alert-warning">
                <i class="fa fa-calendar-times-o" style="font-size:1.2rem;vertical-align:middle;margin-right:8px;"></i>
                No dates selected. Please
                <a href="{{ route('home') }}">go back to the home page</a>
                and choose your check-in and check-out dates before continuing.
            </div>
        @else

        <div class="row">

            {{-- ── Left: House Rules ── --}}
            <div class="col-md-5 bn-col-rules">
                <div class="bn-card">
                    <div class="bn-card-title">House Rules</div>

                    <div class="bn-rules-section-title">Special Restrictions</div>
                    <div class="bn-rules-item">
                        <i class="fa fa-check-circle"></i>
                        You must be at least 25 years old to book this property.
                    </div>
                    <div class="bn-rules-item">
                        <i class="fa fa-check-circle"></i>
                        No Smoking of any kind
                    </div>
                    <div class="bn-rules-item">
                        <i class="fa fa-check-circle"></i>
                        No noise outside after 10:00 pm
                    </div>
                    <div class="bn-rules-item">
                        <i class="fa fa-check-circle"></i>
                        No pets of any kind
                    </div>
                    <div class="bn-rules-item">
                        <i class="fa fa-check-circle"></i>
                        No motor home or large vehicles
                    </div>

                    <div class="bn-rules-section-title">Cancellation &amp; Refund</div>
                    <div class="bn-rules-item">
                        <i class="fa fa-info-circle"></i>
                        Cancel with more than 60 days notice — full refund.
                    </div>
                    <div class="bn-rules-item">
                        <i class="fa fa-info-circle"></i>
                        Cancel between 59 and 31 days from booking — 50% refund.
                    </div>
                    <div class="bn-rules-item">
                        <i class="fa fa-info-circle"></i>
                        Cancel within 30 days of booking — no refund.
                    </div>
                </div>
            </div>

            {{-- ── Right: Booking Summary ── --}}
            <div class="col-md-7 bn-col-summary">

                {{-- Date & guest summary --}}
                <div class="bn-card">
                    <div class="bn-card-title">Your Selection</div>

                    <div class="bn-summary-row">
                        <div class="bn-summary-label">
                            <i class="fa fa-calendar" style="color:#1da3dd;margin-right:6px;"></i>
                            <span id="bn-date-display">Loading…</span>
                        </div>
                        <a href="{{ route('home') }}?checkin={{ urlencode($checkin) }}&checkout={{ urlencode($checkout) }}&guests={{ $guests }}"
                           class="bn-edit-link">Edit</a>
                    </div>

                    <div class="bn-summary-row">
                        <div class="bn-summary-label">
                            <i class="fa fa-users" style="color:#1da3dd;margin-right:6px;"></i>
                            {{ $guests }} guest{{ $guests > 1 ? 's' : '' }}
                        </div>
                        <a href="{{ route('home') }}?checkin={{ urlencode($checkin) }}&checkout={{ urlencode($checkout) }}&guests={{ $guests }}"
                           class="bn-edit-link">Edit</a>
                    </div>
                </div>

                {{-- Price breakdown --}}
                <div class="bn-card">
                    <div class="bn-card-title">Price Breakdown</div>

                    {{-- Loading state --}}
                    <div id="bn-loading" class="bn-loading">
                        <span class="bn-loading-ring"></span> Calculating price&hellip;
                    </div>

                    {{-- Error state --}}
                    <div id="bn-quote-error" style="display:none;" class="bn-alert-warning"></div>

                    {{-- Breakdown rows (filled by JS) --}}
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
                    <div class="bn-guarantee-item">
                        <i class="fa fa-check-circle"></i> Lowest price by booking directly
                    </div>
                    <div class="bn-guarantee-item">
                        <i class="fa fa-check-circle"></i> 24 hour free cancellation after booking
                    </div>
                    <div class="bn-guarantee-item">
                        <i class="fa fa-check-circle"></i> 24/7 support throughout your stay
                    </div>
                </div>

                {{-- Terms box --}}
                <div class="bn-terms-box">
                    By clicking the button below, I agree to Villa Fabulosa's
                    <a href="#" data-toggle="modal" data-target="#tnc-modal">Terms &amp; Conditions</a>
                    and cancellation policy.&nbsp;
                    <a href="{{ route('contact') }}">Contact us</a>
                    if you have any questions!
                </div>

                {{-- Agree and continue button --}}
                <a href="{{ route('contact') }}?checkin={{ urlencode($checkin) }}&checkout={{ urlencode($checkout) }}&guests={{ $guests }}"
                   class="bn-agree-btn" id="bn-agree-btn">
                    Agree and continue
                </a>
                <p class="bn-no-charge">You won't be charged yet</p>

            </div>
        </div>

        @endif
    </div>
</div>

{{-- Terms & Conditions Modal --}}
<div class="modal fade" id="tnc-modal" tabindex="-1" role="dialog" aria-labelledby="tnc-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;">
            <div class="modal-header" style="background:#1da3dd;color:#fff;border-bottom:none;">
                <h5 class="modal-title" id="tnc-modal-label" style="font-weight:700;font-size:1.1rem;">
                    Terms &amp; Conditions
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color:#fff;opacity:1;">
                    <span aria-hidden="true">&times;</span>
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
<script>
(function () {
    var checkin  = '{{ addslashes($checkin) }}';
    var checkout = '{{ addslashes($checkout) }}';
    var guests   = {{ (int) $guests }};

    if (!checkin || !checkout) { return; }

    /* ── Format display date "YYYY-MM-DD" → "Mon, Mar 22, 2026" ── */
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

    /* ── Populate date display ── */
    var nights = nightsBetween(checkin, checkout);
    document.getElementById('bn-date-display').textContent =
        friendlyDate(checkin) + ' – ' + friendlyDate(checkout) + ' · ' +
        nights + ' night' + (nights !== 1 ? 's' : '');

    /* ── Fetch price quote ── */
    var url = '{{ route("api.price-quote") }}?checkin=' + checkin +
              '&checkout=' + checkout + '&guests=' + guests;

    fetch(url)
        .then(function (r) { return r.json(); })
        .then(function (q) {
            document.getElementById('bn-loading').style.display = 'none';

            if (!q.valid) {
                var errDiv = document.getElementById('bn-quote-error');
                var msg = q.min_stay
                    ? 'Minimum stay for a ' + q.checkin_day + ' check-in is ' +
                      q.min_stay + ' night' + (q.min_stay !== 1 ? 's' : '') +
                      '. Please go back and select valid dates.'
                    : (q.error || 'Invalid dates. Please go back and re-select.');
                errDiv.innerHTML = '<i class="fa fa-exclamation-triangle" style="margin-right:6px;"></i>' + msg +
                    ' <a href="{{ route("home") }}">Go back</a>';
                errDiv.style.display = 'block';
                document.getElementById('bn-agree-btn').style.opacity = '0.4';
                document.getElementById('bn-agree-btn').style.pointerEvents = 'none';
                return;
            }

            /* Build breakdown rows */
            var rows = '';
            if (q.base_total > 0) {
                rows += '<div class="bn-breakdown-row"><span>Nightly rates &times; ' +
                    q.nights + ' night' + (q.nights !== 1 ? 's' : '') +
                    '</span><span>' + fmt(q.base_total) + '</span></div>';
            }
            if (q.extra_guest_fee > 0) {
                rows += '<div class="bn-breakdown-row"><span>Extra guests (' +
                    q.extra_guests + ' &times; ' + q.nights + ' nights)</span><span>' +
                    fmt(q.extra_guest_fee) + '</span></div>';
            }
            rows += '<div class="bn-breakdown-row"><span>Cleaning fee</span><span>' +
                fmt(q.cleaning_fee) + '</span></div>';
            rows += '<div class="bn-breakdown-row"><span>Taxes (' + q.tax_rate + '%)</span><span>' +
                fmt(q.tax_amount) + '</span></div>';

            document.getElementById('bn-breakdown-rows').innerHTML = rows;
            document.getElementById('bn-total').textContent = fmt(q.total);
            document.getElementById('bn-breakdown').style.display = 'block';
        })
        .catch(function () {
            document.getElementById('bn-loading').style.display = 'none';
            var errDiv = document.getElementById('bn-quote-error');
            errDiv.innerHTML = 'Could not load pricing. Please try again or ' +
                '<a href="{{ route("home") }}">go back</a>.';
            errDiv.style.display = 'block';
        });
})();
</script>
@endsection
