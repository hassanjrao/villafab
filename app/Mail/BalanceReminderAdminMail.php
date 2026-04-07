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
    public array $cardDetails;
    public int $reminderDays;

    public function __construct(Booking $booking, array $cardDetails = [], int $reminderDays = 3)
    {
        $this->booking      = $booking;
        $this->cardDetails  = $cardDetails;
        $this->reminderDays = $reminderDays;
    }

    public function build(): self
    {
        return $this
            ->subject('Upcoming Payment Reminder – Villa Fabulosa | Charge in ' . $this->reminderDays . ' Days | Booking #' . $this->booking->id)
            ->view('emails.balance-reminder-admin');
    }
}
