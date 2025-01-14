<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportReplyNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $support;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($support)
    {
        $this->support = $support;
    }

    public function build()
    {
        return $this->view('email.support-reply-notification')
                    ->with(['support' => $this->support])
                    ->subject('Support Ticket Reply');
    }
}
