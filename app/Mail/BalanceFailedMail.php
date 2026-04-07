<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public array $cardDetails;

    public function __construct(Booking $booking, array $cardDetails = [])
    {
        $this->booking     = $booking;
        $this->cardDetails = $cardDetails;
    }

    public function build(): self
    {
        return $this
            ->subject('Action Required: Issue Processing Your Payment – Villa Fabulosa')
            ->view('emails.balance-failed');
    }
}
