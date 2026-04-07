<?php

namespace App\Console\Commands;

use App\Mail\BalanceReminderAdminMail;
use App\Mail\BalanceReminderMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class SendBalanceReminders extends Command
{
    protected $signature   = 'bookings:send-balance-reminders';
    protected $description = 'Send reminder emails for deferred balance charges due soon.';

    public function handle(): void
    {
        Log::info('Starting balance reminder process.');
        $reminderDays = (int) config('services.booking.balance_reminder_days_before', 3);
        $targetDate   = Carbon::today()->addDays($reminderDays)->toDateString();

        $bookings = Booking::pendingBalance()
            ->balanceDueOn($targetDate)
            ->whereNull('balance_reminder_sent_at')
            ->get();

        if ($bookings->isEmpty()) {
            Log::info('No balance reminders to send.', [
                'target_date' => $targetDate,
            ]);
             $this->info('No balance reminders to send.');
             return;
            $this->info('No balance reminders to send.');
            return;
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        foreach ($bookings as $booking) {
            $cardDetails = $this->fetchCardDetails($booking);

            if ($booking->email) {
                Mail::to($booking->email)->send(new BalanceReminderMail($booking, $cardDetails, $reminderDays));
            }
            Mail::to(config('mail.from.address'))->send(new BalanceReminderAdminMail($booking, $cardDetails, $reminderDays));

            $booking->update(['balance_reminder_sent_at' => now()]);
        }

        $this->info("Sent balance reminders for {$bookings->count()} booking(s).");
    }

    private function fetchCardDetails(Booking $booking): array
    {
        try {
            if (!$booking->stripe_payment_method_id) {
                return [];
            }

            $pm   = PaymentMethod::retrieve($booking->stripe_payment_method_id);
            $card  = $pm->card;

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
