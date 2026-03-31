<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceReminderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build(): self
    {
        return $this
            ->subject('[Admin] Upcoming Auto-Charge – Booking #' . $this->booking->id)
            ->view('emails.balance-reminder-admin');
    }
}
