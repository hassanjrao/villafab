@extends('layouts.backend')

@section('page-name', 'Pricing Settings')

@section('content')

    {{-- Hero --}}
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">Pricing Settings</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Manage nightly rates, minimum stays, and fee rules.
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item"><a class="link-fx" href="{{ route('admin.dashboard.index') }}">Admin</a></li>
                        <li class="breadcrumb-item" aria-current="page">Pricing</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- END Hero --}}

    <div class="content">

        {{-- Success alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.pricing.update') }}" method="POST" id="pricingForm">
            @csrf

            {{-- ════════════════════════════════════════════
                 SECTION A — Nightly Rate Periods
            ════════════════════════════════════════════ --}}
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-calendar-o me-2 text-primary"></i> Enter Rates
                    </h3>
                    <div class="block-options">
                        <span class="text-muted small">
                            <span class="badge bg-secondary me-1" style="opacity:.6;">Gray</span> = unsaved &nbsp;
                            <span class="badge bg-dark me-1">Black</span> = saved
                        </span>
                    </div>
                </div>
                <div class="block-content">

                    @foreach($ratePeriods as $period)
                    <div class="card mb-4 border">
                        <div class="card-header bg-light py-2">
                            <strong>Rate Period {{ $period->sort_order }}</strong>
                            @if($period->sort_order === 1)
                                <span class="text-muted small ms-2">(Default / Base Rates — used when no date range matches)</span>
                            @endif
                        </div>
                        <div class="card-body">

                            {{-- Date range --}}
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <label class="form-label fw-semibold small">From this date</label>
                                    <input type="date"
                                           name="periods[{{ $period->id }}][date_from]"
                                           class="form-control pricing-input"
                                           value="{{ $period->date_from ? $period->date_from->format('Y-m-d') : '' }}"
                                           placeholder="Leave blank for default">
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="form-label fw-semibold small">To this date</label>
                                    <input type="date"
                                           name="periods[{{ $period->id }}][date_to]"
                                           class="form-control pricing-input"
                                           value="{{ $period->date_to ? $period->date_to->format('Y-m-d') : '' }}"
                                           placeholder="Leave blank for default">
                                </div>
                            </div>

                            {{-- Day rates --}}
                            <div class="row g-3">
                                @foreach([
                                    'monday_rate'    => 'Monday',
                                    'tuesday_rate'   => 'Tuesday',
                                    'wednesday_rate' => 'Wednesday',
                                    'thursday_rate'  => 'Thursday',
                                    'friday_rate'    => 'Friday',
                                    'saturday_rate'  => 'Saturday',
                                    'sunday_rate'    => 'Sunday',
                                ] as $col => $dayLabel)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-auto" style="min-width:140px;">
                                    <label class="form-label fw-semibold small">{{ $dayLabel }}</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">$</span>
                                        <input type="number"
                                               name="periods[{{ $period->id }}][{{ $col }}]"
                                               class="form-control pricing-input text-end"
                                               value="{{ $period->{$col} ?? '' }}"
                                               min="0"
                                               step="1"
                                               placeholder="—">
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- ════════════════════════════════════════════
                 SECTION B — Minimum Stay Per Check-in Day
            ════════════════════════════════════════════ --}}
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-moon-o me-2 text-primary"></i> Minimum Stay (nights) by Check-in Day
                    </h3>
                </div>
                <div class="block-content pb-3">
                    <p class="text-muted small mb-3">
                        Set the minimum number of nights required when checking in on each day of the week.
                    </p>
                    <div class="row g-3">
                        @foreach($days as $dow => $dayLabel)
                            @php $stay = $minimumStays->get($dow) @endphp
                            <div class="col-6 col-sm-4 col-md-3 col-lg-auto" style="min-width:150px;">
                                <label class="form-label fw-semibold small">{{ $dayLabel }}</label>
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                           name="stays[{{ $dow }}][minimum_nights]"
                                           class="form-control pricing-input text-center"
                                           value="{{ $stay ? $stay->minimum_nights : 2 }}"
                                           min="1"
                                           max="30"
                                           step="1">
                                    <span class="input-group-text">nights</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════
                 SECTION C — Fees & Extra-Guest Rules
            ════════════════════════════════════════════ --}}
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fa fa-usd me-2 text-primary"></i> Fees &amp; Extra-Guest Rules
                    </h3>
                </div>
                <div class="block-content pb-3">
                    <div class="row g-4">

                        {{-- Extra guest threshold --}}
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-semibold">Extra-guest fee starts after</label>
                            <div class="input-group">
                                <input type="number"
                                       name="settings[extra_guest_threshold]"
                                       class="form-control pricing-input text-center"
                                       value="{{ $settings->extra_guest_threshold }}"
                                       min="1" step="1">
                                <span class="input-group-text">guests</span>
                            </div>
                            <div class="form-text">Charge extra for guests <em>above</em> this number.</div>
                        </div>

                        {{-- Extra guest price --}}
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-semibold">Extra-guest price per night</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       name="settings[extra_guest_price]"
                                       class="form-control pricing-input"
                                       value="{{ $settings->extra_guest_price }}"
                                       min="0" step="1">
                                <span class="input-group-text">/ night</span>
                            </div>
                        </div>

                        {{-- Cleaning fee --}}
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-semibold">Cleaning Fee</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       name="settings[cleaning_fee]"
                                       class="form-control pricing-input"
                                       value="{{ $settings->cleaning_fee }}"
                                       min="0" step="1">
                            </div>
                            <div class="form-text">Flat fee added once per booking.</div>
                        </div>

                        {{-- Tax rate --}}
                        <div class="col-sm-6 col-lg-3">
                            <label class="form-label fw-semibold">Tax Rate</label>
                            <div class="input-group">
                                <input type="number"
                                       name="settings[tax_rate]"
                                       class="form-control pricing-input"
                                       value="{{ $settings->tax_rate }}"
                                       min="0" max="100" step="0.01">
                                <span class="input-group-text">%</span>
                            </div>
                            <div class="form-text">Applied to nightly subtotal + cleaning fee.</div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Save button --}}
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary btn-lg px-5" id="saveBtn">
                    <i class="fa fa-save me-2"></i> Save All Settings
                </button>
            </div>

        </form>
    </div>

@endsection

@section('scripts_extra')
<style>
    /* Saved state = dark text (default) */
    .pricing-input { color: #222; transition: color 0.2s; }
    /* Unsaved / dirty = gray text */
    .pricing-input.is-dirty { color: #aaa; }
</style>
<script>
    (function () {
        document.querySelectorAll('.pricing-input').forEach(function (input) {
            input.addEventListener('input', function () {
                this.classList.add('is-dirty');
            });
        });

        /* On successful save the page reloads — all inputs start clean (no is-dirty) */
        document.getElementById('pricingForm').addEventListener('submit', function () {
            document.getElementById('saveBtn').disabled = true;
            document.getElementById('saveBtn').innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Saving…';
        });
    })();
</script>
@endsection
