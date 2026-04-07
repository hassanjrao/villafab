<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\SetupIntent;
use Stripe\Stripe;

class UpdateCardController extends Controller
{
    /**
     * Show the update-card form (token-authenticated, no login required).
     */
    public function show(string $token)
    {
        $booking = Booking::where('card_update_token', $token)
            ->where('payment_type', 'deferred')
            ->whereIn('balance_status', ['pending', 'failed'])
            ->firstOrFail();

        Stripe::setApiKey(config('services.stripe.secret'));

        $setupIntent = SetupIntent::create([
            'customer'                => $booking->stripe_customer_id,
            'payment_method_types'    => ['card'],
        ]);

        return view('frontend.update-card', [
            'booking'      => $booking,
            'token'        => $token,
            'clientSecret' => $setupIntent->client_secret,
        ]);
    }

    /**
     * Process the card update after Stripe confirms the SetupIntent.
     */
    public function update(Request $request, string $token): JsonResponse
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $booking = Booking::where('card_update_token', $token)
            ->where('payment_type', 'deferred')
            ->whereIn('balance_status', ['pending', 'failed'])
            ->firstOrFail();

        Stripe::setApiKey(config('services.stripe.secret'));

        $newPmId = $request->input('payment_method');

        // Attach new payment method to the customer
        PaymentMethod::retrieve($newPmId)->attach([
            'customer' => $booking->stripe_customer_id,
        ]);

        // Set as default payment method on the customer
        Customer::update($booking->stripe_customer_id, [
            'invoice_settings' => ['default_payment_method' => $newPmId],
        ]);

        // Detach old payment method (if different)
        if ($booking->stripe_payment_method_id && $booking->stripe_payment_method_id !== $newPmId) {
            try {
                PaymentMethod::retrieve($booking->stripe_payment_method_id)->detach();
            } catch (\Exception $e) {
                // Old method may already be detached — non-fatal
            }
        }

        $booking->update(['stripe_payment_method_id' => $newPmId]);

        return response()->json(['success' => true]);
    }
}
