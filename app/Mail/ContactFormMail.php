<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this
            ->subject('New Contact Message from ' . $this->data['fname'] . ' ' . $this->data['lname'])
            ->markdown('emails.contact')
            ->with('data', $this->data);
    }
}
