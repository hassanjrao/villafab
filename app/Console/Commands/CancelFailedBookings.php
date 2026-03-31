<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelFailedBookings extends Command
{
    protected $signature   = 'bookings:cancel-failed-bookings';
    protected $description = 'Cancel deferred bookings where the balance charge failed and the 2-day grace period has passed.';

    public function handle(): void
    {
        $deadline = Carbon::now()->subDays(2);

        $bookings = Booking::failedBalance()
            ->where('balance_failure_notified_at', '<=', $deadline)
            ->get();

        foreach ($bookings as $booking) {
            $booking->update([
                'status'         => 'cancelled',
                'balance_status' => 'cancelled',
            ]);

            $this->info("Cancelled booking #{$booking->id} (balance unpaid after 2-day grace period).");
        }

        $this->info("Cancelled {$bookings->count()} booking(s).");
    }
}
