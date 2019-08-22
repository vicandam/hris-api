<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ContactedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contact, $others;

    public function __construct($contact)
    {
        $this->contact = $contact;

        $this->others = json_decode($contact->others, true);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->contact->email)
            ->subject("New contact from jesuserwinsuarez.com site!")
            ->markdown('emails.contact');
        // return $this->markdown('emails.contact');
    }
}
