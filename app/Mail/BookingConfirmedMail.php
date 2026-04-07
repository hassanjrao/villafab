<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build(): self
    {
        $checkinFormatted = $this->booking->checkin
            ? $this->booking->checkin->format('F j, Y')
            : '';

        return $this
            ->subject('New Booking Confirmed – Villa Fabulosa | ' . $this->booking->name . ' | ' . $checkinFormatted)
            ->view('emails.booking-confirmed');
    }
}
