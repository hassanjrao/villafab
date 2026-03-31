<?php

namespace App\Console\Commands;

use App\Mail\BalanceReminderAdminMail;
use App\Mail\BalanceReminderMail;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBalanceReminders extends Command
{
    protected $signature   = 'bookings:send-balance-reminders';
    protected $description = 'Send reminder emails for deferred balance charges due soon.';

    public function handle(): void
    {
        Log::info('Starting balance reminder process.');
        $reminderDays = (int) env('BALANCE_REMINDER_DAYS_BEFORE', 7);
        $targetDate   = Carbon::today()->addDays($reminderDays)->toDateString();

        $bookings = Booking::pendingBalance()
            ->balanceDueOn($targetDate)
            ->whereNull('balance_reminder_sent_at')
            ->get();

        foreach ($bookings as $booking) {
            if ($booking->email) {
                Mail::to($booking->email)->send(new BalanceReminderMail($booking));
            }
            Mail::to(config('mail.from.address'))->send(new BalanceReminderAdminMail($booking));

            $booking->update(['balance_reminder_sent_at' => now()]);
        }

        $this->info("Sent balance reminders for {$bookings->count()} booking(s).");
    }
}
