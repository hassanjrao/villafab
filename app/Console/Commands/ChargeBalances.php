<?php

namespace App\Console\Commands;

use App\Mail\BalanceChargedAdminMail;
use App\Mail\BalanceChargedMail;
use App\Mail\BalanceFailedAdminMail;
use App\Mail\BalanceFailedMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class ChargeBalances extends Command
{
    protected $signature   = 'bookings:charge-balances';
    protected $description = 'Attempt off-session balance charges for deferred bookings due today.';

    public function handle(): void
    {
        Log::info('Starting balance charge process.',[
            'date' => Carbon::today()->toDateString(),
        ]);
        $bookings = Booking::pendingBalance()
            ->balanceDueOn(Carbon::today())
            ->get();

        if ($bookings->isEmpty()) {
            Log::info('No balance charges due today.',[
                'date' => Carbon::today()->toDateString(),
            ]);
            $this->info('No balance charges due today.');
            return;
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        foreach ($bookings as $booking) {
            $this->processBooking($booking);
        }
    }

    private function processBooking(Booking $booking): void
    {
        try {
            Log::info("Attempting balance charge for booking #{$booking->id} (amount: \${$booking->balance_due}).");

            // Capture amounts before the update overwrites them
            $chargedAmount = (float) $booking->balance_due;
            $previouslyPaid = (float) $booking->amount_paid;
            $cardDetails = $this->fetchCardDetails($booking);

            DB::transaction(function () use ($booking) {

                PaymentIntent::create([
                    'amount'         => (int) round($booking->balance_due * 100),
                    'currency'       => 'usd',
                    'customer'       => $booking->stripe_customer_id,
                    'payment_method' => $booking->stripe_payment_method_id,
                    'off_session'    => true,
                    'confirm'        => true,
                    'metadata'       => [
                        'booking_id' => $booking->id,
                        'type'       => 'balance_charge',
                    ],
                ]);

                $booking->update([
                    'balance_status' => 'charged',
                    'status'         => 'fully_paid',
                    'amount_paid'    => $booking->total,
                    'balance_due'    => 0,
                ]);
            }, 5);

            $this->info("Charged balance for booking #{$booking->id}");
            Log::info("Successfully charged balance for booking #{$booking->id}");

            // Reload updated totals then notify guest and admin
            $booking->refresh();
            if ($booking->email) {
                Mail::to($booking->email)->send(new BalanceChargedMail($booking, $chargedAmount, $previouslyPaid, $cardDetails));
            }
            Mail::to(config('mail.from.address'))->send(new BalanceChargedAdminMail($booking, $chargedAmount, $previouslyPaid, $cardDetails));
        } catch (CardException $e) {
            $this->markFailed($booking, $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $this->markFailed($booking, $e->getMessage());
        } catch (\Exception $e) {
            $this->error("Unexpected error for booking #{$booking->id}: {$e->getMessage()}");
        }
    }

    private function markFailed(Booking $booking, string $reason): void
    {
        $booking->update([
            'balance_status'              => 'failed',
            'status'                      => 'balance_failed',
            'balance_failure_notified_at' => now(),
        ]);

        $cardDetails = $this->fetchCardDetails($booking);

        if ($booking->email) {
            Mail::to($booking->email)->send(new BalanceFailedMail($booking, $cardDetails));
        }
        Mail::to(config('mail.from.address'))->send(new BalanceFailedAdminMail($booking, $cardDetails));

        $this->error("Balance charge failed for booking #{$booking->id}: {$reason}");
    }

    private function fetchCardDetails(Booking $booking): array
    {
        try {
            if (!$booking->stripe_payment_method_id) {
                return [];
            }

            $pm   = PaymentMethod::retrieve($booking->stripe_payment_method_id);
            $card = $pm->card;

            if (!$card) {
                return [];
            }

            return [
                'brand'     => ucfirst($card->brand ?? ''),
                'last4'     => $card->last4 ?? '',
                'exp_month' => str_pad($card->exp_month ?? '', 2, '0', STR_PAD_LEFT),
                'exp_year'  => $card->exp_year ?? '',
            ];
        } catch (\Exception $e) {
            Log::warning("Could not retrieve card details for booking #{$booking->id}: {$e->getMessage()}");
            return [];
        }
    }
}
