<?php

namespace App\Http\Controllers;

use App\Models\MinimumStay;
use App\Models\PricingSetting;
use App\Models\RatePeriod;
use Carbon\Carbon;
use ICal\ICal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function minimumStays(): JsonResponse
    {
        $rows = MinimumStay::orderBy('day_of_week')
            ->get(['day_of_week', 'day_name', 'minimum_nights']);

        $byDow = [];
        foreach ($rows as $row) {
            $byDow[(int) $row->day_of_week] = (int) $row->minimum_nights;
        }

        return response()->json([
            'by_dow' => $byDow,
            'days'   => $rows,
        ]);
    }

    public function bookedDates(): JsonResponse
    {
        try {
            $ical = new ICal(env('GOOGLE_CAL_ICS_URL'), [
                'defaultSpan'      => 2,
                'defaultTimeZone'  => 'America/Los_Angeles',
                'skipRecurrence'   => false,
            ]);

            $events = collect($ical->events())->map(function ($event) use ($ical) {
                return [
                    'title'   => 'Booked',
                    'start'   => $ical->iCalDateToDateTime($event->dtstart)->format('Y-m-d'),
                    'end'     => $ical->iCalDateToDateTime($event->dtend)->format('Y-m-d'),
                    'color'   => '#e74c3c',
                    'display' => 'background',
                ];
            })->values();

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function priceQuote(Request $request): JsonResponse
    {
        $checkin  = $request->query('checkin');
        $checkout = $request->query('checkout');
        $guests   = (int) $request->query('guests', 1);

        if (!$checkin || !$checkout) {
            return response()->json(['valid' => false, 'error' => 'Missing dates.']);
        }

        try {
            $checkinDate  = Carbon::parse($checkin);
            $checkoutDate = Carbon::parse($checkout);
        } catch (\Exception $e) {
            return response()->json(['valid' => false, 'error' => 'Invalid dates.']);
        }

        $nights = $checkinDate->diffInDays($checkoutDate);
        if ($nights <= 0) {
            return response()->json(['valid' => false, 'error' => 'Check-out must be after check-in.']);
        }

        // ── Minimum stay check ────────────────────────────────────────────────
        $checkinDow = (int) $checkinDate->dayOfWeek; // 0=Sun … 6=Sat
        $minNights  = MinimumStay::forDow($checkinDow);

        if ($nights < $minNights) {
            return response()->json([
                'valid'       => false,
                'min_stay'    => $minNights,
                'nights'      => $nights,
                'checkin_day' => $checkinDate->format('l'),
            ]);
        }

        // ── Rate calculation ──────────────────────────────────────────────────
        $settings = PricingSetting::current();
        $extraGuests = max(0, $guests - $settings->extra_guest_threshold);

        $nightlyBreakdown = [];
        $baseTotal        = 0.0;
        $extraGuestTotal  = 0.0;

        $current = $checkinDate->copy();
        while ($current->lt($checkoutDate)) {
            $baseRate        = (float) (RatePeriod::rateForDate($current) ?? 0);
            $extraPerNight   = $extraGuests * $settings->extra_guest_price;
            $nightTotal      = $baseRate + $extraPerNight;

            $nightlyBreakdown[] = [
                'date'          => $current->format('Y-m-d'),
                'day'           => $current->format('l'),
                'base_rate'     => $baseRate,
                'extra_fee'     => $extraPerNight,
                'night_total'   => $nightTotal,
            ];

            $baseTotal       += $baseRate;
            $extraGuestTotal += $extraPerNight;
            $current->addDay();
        }

        $subtotal     = $baseTotal + $extraGuestTotal;
        $cleaningFee  = (float) $settings->cleaning_fee;
        $taxBase      = $subtotal + $cleaningFee;
        $taxAmount    = round($taxBase * ($settings->tax_rate / 100), 2);
        $total        = round($taxBase + $taxAmount, 2);

        return response()->json([
            'valid'            => true,
            'nights'           => $nights,
            'guests'           => $guests,
            'extra_guests'     => $extraGuests,
            'nightly_breakdown'=> $nightlyBreakdown,
            'base_total'       => round($baseTotal, 2),
            'extra_guest_fee'  => round($extraGuestTotal, 2),
            'subtotal'         => round($subtotal, 2),
            'cleaning_fee'     => $cleaningFee,
            'tax_rate'         => $settings->tax_rate,
            'tax_amount'       => $taxAmount,
            'total'            => $total,
        ]);
    }
}
