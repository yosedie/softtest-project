<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAppointment extends Mailable
{
    use Queueable, SerializesModels;
    public $x, $request, $appoint_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($x, $request)
    {
        $this->x = $x;
        $this->request = $request;
        $this->appoint_id = $request->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.userAppointment')->subject('Request Appointment');
    }
}
