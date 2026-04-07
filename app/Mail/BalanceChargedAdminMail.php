<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceChargedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public float $chargedAmount;
    public float $previouslyPaid;
    public array $cardDetails;

    public function __construct(Booking $booking, float $chargedAmount, float $previouslyPaid, array $cardDetails = [])
    {
        $this->booking       = $booking;
        $this->chargedAmount = $chargedAmount;
        $this->previouslyPaid = $previouslyPaid;
        $this->cardDetails   = $cardDetails;
    }

    public function build(): self
    {
        return $this
            ->subject('Payment Received – Booking #' . $this->booking->id . ' Fully Confirmed')
            ->view('emails.balance-charged-admin');
    }
}
