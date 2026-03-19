<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MinimumStay;
use App\Models\PricingSetting;
use App\Models\RatePeriod;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class BookingController extends Controller
{
    public function createPaymentIntent(Request $request): JsonResponse
    {
        $request->validate([
            'checkin'  => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'guests'   => 'required|integer|min:1',
        ]);

        $checkin  = Carbon::parse($request->checkin);
        $checkout = Carbon::parse($request->checkout);
        $guests   = (int) $request->guests;
        $nights   = $checkin->diffInDays($checkout);

        // ── Minimum stay check ────────────────────────────────────────
        $dow       = (int) $checkin->dayOfWeek;
        $minNights = MinimumStay::forDow($dow);

        if ($nights < $minNights) {
            return response()->json([
                'error' => 'Minimum stay for a ' . $checkin->format('l') .
                           ' check-in is ' . $minNights . ' night' . ($minNights !== 1 ? 's' : '') . '.',
            ], 422);
        }

        // ── Price calculation ─────────────────────────────────────────
        $settings    = PricingSetting::current();
        $extraGuests = max(0, $guests - $settings->extra_guest_threshold);

        $baseTotal       = 0.0;
        $extraGuestTotal = 0.0;
        $current         = $checkin->copy();

        while ($current->lt($checkout)) {
            $baseRate         = (float) (RatePeriod::rateForDate($current) ?? 0);
            $extraPerNight    = $extraGuests * $settings->extra_guest_price;
            $baseTotal       += $baseRate;
            $extraGuestTotal += $extraPerNight;
            $current->addDay();
        }

        $subtotal    = $baseTotal + $extraGuestTotal;
        $cleaningFee = (float) $settings->cleaning_fee;
        $taxBase     = $subtotal + $cleaningFee;
        $taxAmount   = round($taxBase * ($settings->tax_rate / 100), 2);
        $total       = round($taxBase + $taxAmount, 2);

        // ── Create Stripe PaymentIntent ───────────────────────────────
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount'   => (int) round($total * 100),
            'currency' => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'checkin'      => $request->checkin,
                'checkout'     => $request->checkout,
                'guests'       => $guests,
                'nights'       => $nights,
                'subtotal'     => round($subtotal, 2),
                'cleaning_fee' => $cleaningFee,
                'tax_amount'   => $taxAmount,
                'total'        => $total,
            ],
        ]);

        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
            'total'         => $total,
        ]);
    }

    public function success(Request $request)
    {
        $piId   = $request->query('payment_intent', '');
        $status = $request->query('redirect_status', '');
        $name   = $request->query('name', 'Guest');

        $checkin  = '';
        $checkout = '';
        $guests   = 1;
        $total    = '';

        if ($piId && $status === 'succeeded') {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));

                $pi = PaymentIntent::retrieve([
                    'id'     => $piId,
                    'expand' => ['latest_charge'],
                ]);

                $meta     = $pi->metadata;
                $checkin  = $meta['checkin']  ?? '';
                $checkout = $meta['checkout'] ?? '';
                $guests   = (int) ($meta['guests']   ?? 1);
                $nights   = (int) ($meta['nights']   ?? 0);
                $total    = '$' . number_format($pi->amount / 100, 2);

                // Retrieve billing details from latest charge
                $bd    = $pi->latest_charge->billing_details ?? null;
                $email = $bd->email ?? '';
                $phone = $bd->phone ?? '';

                // Persist booking record (idempotent — safe to call on page refresh)
                Booking::firstOrCreate(
                    ['payment_intent_id' => $piId],
                    [
                        'name'         => $name,
                        'email'        => $email,
                        'phone'        => $phone,
                        'checkin'      => $checkin,
                        'checkout'     => $checkout,
                        'guests'       => $guests,
                        'nights'       => $nights,
                        'subtotal'     => (float) ($meta['subtotal']     ?? 0),
                        'cleaning_fee' => (float) ($meta['cleaning_fee'] ?? 0),
                        'tax_amount'   => (float) ($meta['tax_amount']   ?? 0),
                        'total'        => round($pi->amount / 100, 2),
                        'status'       => $pi->status,
                    ]
                );
            } catch (\Exception $e) {
                // non-fatal — still show the success page
            }
        }

        return view('frontend.booking-success', compact('name', 'checkin', 'checkout', 'guests', 'total', 'status'));
    }
}
