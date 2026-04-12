<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmedAdminMail;
use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use App\Models\MinimumStay;
use App\Models\PricingSetting;
use App\Models\RatePeriod;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class BookingController extends Controller
{
    public function createPaymentIntent(Request $request): JsonResponse
    {
        $request->validate([
            'checkin'      => 'required|date',
            'checkout'     => 'required|date|after:checkin',
            'guests'       => 'required|integer|min:1',
            'payment_type' => 'sometimes|in:full,split',
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

        // ── Determine payment type ────────────────────────────────────
        // Split payment is only available when check-in is far enough out.
        $chargesBefore  = (int) config('services.booking.balance_charge_days_before', 60);
        $daysToCheckin  = (int) Carbon::today()->diffInDays($checkin);
        $splitEligible  = $daysToCheckin > $chargesBefore;

        // User chooses: 'split' (deferred 50/50) or 'full' (default).
        $chosenType = $request->input('payment_type', 'full');
        $isDeferred = $splitEligible && $chosenType === 'split';

        Stripe::setApiKey(config('services.stripe.secret'));

        if ($isDeferred) {
            // ── Deferred: charge 50% now, 50% later ──────────────────
            $deposit           = round($total / 2, 2);
            $balance           = round($total - $deposit, 2);
            $balanceChargeDate = $checkin->copy()->subDays($chargesBefore)->toDateString();

            // Create a placeholder Customer (name/email added in success())
            $customer = Customer::create([]);

            $paymentIntent = PaymentIntent::create([
                'amount'                     => (int) round($deposit * 100),
                'currency'                   => 'usd',
                'customer'                   => $customer->id,
                'setup_future_usage'         => 'off_session',
                'automatic_payment_methods'  => ['enabled' => true],
                'metadata'                   => [
                    'checkin'              => $request->checkin,
                    'checkout'             => $request->checkout,
                    'guests'               => $guests,
                    'nights'               => $nights,
                    'subtotal'             => round($subtotal, 2),
                    'extra_guest_charges'  => round($extraGuestTotal, 2),
                    'cleaning_fee'         => $cleaningFee,
                    'tax_amount'           => $taxAmount,
                    'total'                => $total,
                    'payment_type'         => 'deferred',
                    'deposit'              => $deposit,
                    'balance_due'          => $balance,
                    'balance_charge_date'  => $balanceChargeDate,
                    'stripe_customer_id'   => $customer->id,
                ],
            ]);

            return response()->json([
                'client_secret'       => $paymentIntent->client_secret,
                'total'               => $deposit,
                'full_total'          => $total,
                'balance_due'         => $balance,
                'payment_type'        => 'deferred',
                'split_eligible'      => true,
                'balance_charge_date' => $balanceChargeDate,
            ]);
        }

        // ── Full payment ──────────────────────────────────────────────
        $paymentIntent = PaymentIntent::create([
            'amount'                    => (int) round($total * 100),
            'currency'                  => 'usd',
            'automatic_payment_methods' => ['enabled' => true],
            'metadata'                  => [
                'checkin'              => $request->checkin,
                'checkout'             => $request->checkout,
                'guests'               => $guests,
                'nights'               => $nights,
                'subtotal'             => round($subtotal, 2),
                'extra_guest_charges'  => round($extraGuestTotal, 2),
                'cleaning_fee'         => $cleaningFee,
                'tax_amount'           => $taxAmount,
                'total'                => $total,
                'payment_type'         => 'full',
            ],
        ]);

        $response = [
            'client_secret'  => $paymentIntent->client_secret,
            'total'          => $total,
            'payment_type'   => 'full',
            'split_eligible' => $splitEligible,
        ];

        // Include split details so the frontend can display the option
        if ($splitEligible) {
            $deposit           = round($total / 2, 2);
            $balance           = round($total - $deposit, 2);
            $balanceChargeDate = $checkin->copy()->subDays($chargesBefore)->toDateString();

            $response['full_total']          = $total;
            $response['deposit']             = $deposit;
            $response['balance_due']         = $balance;
            $response['balance_charge_date'] = $balanceChargeDate;
        }

        return response()->json($response);
    }

    public function success(Request $request)
    {
        $piId   = $request->query('payment_intent', '');
        $status = $request->query('redirect_status', '');
        $name   = $request->query('name', 'Guest');

        $checkin           = '';
        $checkout          = '';
        $guests            = 1;
        $total             = '';
        $paymentType       = 'full';
        $balanceChargeDate = null;
        $balanceDue        = null;
        $amountPaid        = null;

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

                $paymentType       = $meta['payment_type'] ?? 'full';
                $stripeCustomerId  = $meta['stripe_customer_id'] ?? null;
                $balanceDueMeta    = isset($meta['balance_due']) ? (float) $meta['balance_due'] : null;
                $balanceChargeDate = $meta['balance_charge_date'] ?? null;
                $fullTotal         = isset($meta['total']) ? (float) $meta['total'] : null;

                // Retrieve billing details from latest charge
                $bd    = $pi->latest_charge->billing_details ?? null;
                $email = $bd->email ?? '';
                $phone = $bd->phone ?? '';

                $chargedAmount = round($pi->amount / 100, 2);
                $amountPaid    = $chargedAmount;

                if ($paymentType === 'deferred') {
                    $total = '$' . number_format($chargedAmount, 2);

                    // Update Stripe Customer with guest billing details
                    if ($stripeCustomerId) {
                        Customer::update($stripeCustomerId, array_filter([
                            'name'  => $name,
                            'email' => $email ?: null,
                            'phone' => $phone ?: null,
                        ]));
                    }

                    $paymentMethodId = $pi->payment_method ?? null;
                    $balanceDue      = $balanceDueMeta;

                    $booking = Booking::firstOrCreate(
                        ['payment_intent_id' => $piId],
                        [
                            'name'                     => $name,
                            'email'                    => $email,
                            'phone'                    => $phone,
                            'checkin'                  => $checkin,
                            'checkout'                 => $checkout,
                            'guests'                   => $guests,
                            'nights'                   => $nights,
                            'subtotal'                 => (float) ($meta['subtotal']     ?? 0),
                            'extra_guest_charges'      => (float) ($meta['extra_guest_charges'] ?? 0),
                            'cleaning_fee'             => (float) ($meta['cleaning_fee'] ?? 0),
                            'tax_amount'               => (float) ($meta['tax_amount']   ?? 0),
                            'total'                    => $fullTotal ?? $chargedAmount,
                            'status'                   => 'deposit_paid',
                            'payment_type'             => 'deferred',
                            'stripe_customer_id'       => $stripeCustomerId,
                            'stripe_payment_method_id' => $paymentMethodId,
                            'card_update_token'        => Str::random(48),
                            'amount_paid'              => $chargedAmount,
                            'balance_due'              => $balanceDueMeta,
                            'balance_charge_date'      => $balanceChargeDate,
                            'balance_status'           => 'pending',
                        ]
                    );

                    if ($booking->wasRecentlyCreated) {
                        Mail::to($booking->email)->send(new BookingConfirmedMail($booking));
                        Mail::to(config('mail.from.address'))->send(new BookingConfirmedAdminMail($booking));
                    }
                } else {
                    $total = '$' . number_format($chargedAmount, 2);

                    $booking = Booking::firstOrCreate(
                        ['payment_intent_id' => $piId],
                        [
                            'name'                => $name,
                            'email'               => $email,
                            'phone'               => $phone,
                            'checkin'             => $checkin,
                            'checkout'            => $checkout,
                            'guests'              => $guests,
                            'nights'              => $nights,
                            'subtotal'            => (float) ($meta['subtotal']     ?? 0),
                            'extra_guest_charges' => (float) ($meta['extra_guest_charges'] ?? 0),
                            'cleaning_fee'        => (float) ($meta['cleaning_fee'] ?? 0),
                            'tax_amount'          => (float) ($meta['tax_amount']   ?? 0),
                            'total'               => $chargedAmount,
                            'status'              => $pi->status,
                            'payment_type'        => 'full',
                            'amount_paid'         => $chargedAmount,
                        ]
                    );

                    if ($booking->wasRecentlyCreated) {
                        Mail::to($booking->email)->send(new BookingConfirmedMail($booking));
                        Mail::to(config('mail.from.address'))->send(new BookingConfirmedAdminMail($booking));
                    }
                }
            } catch (\Exception $e) {
                Log::error('BookingController@success: Error in booking confirmation',[
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);
                // non-fatal — still show the success page
            }
        }
        else{
            Log::error('BookingController@success: Error in booking confirmation',[
                'error' => 'Payment intent ID or status is missing',
                'line' => __LINE__,
                'trace' => debug_backtrace(),
            ]);
        }

        return view('frontend.booking-success', compact(
            'name',
            'checkin',
            'checkout',
            'guests',
            'total',
            'status',
            'paymentType',
            'balanceChargeDate',
            'balanceDue',
            'amountPaid'
        ));
    }
}
