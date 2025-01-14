<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GiftOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $x, $order, $order_id, $course;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($x, $order, $order_id, $course)
    {
        $this->x = $x;
        $this->order = $order;
        $this->order_id = $order->id;
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.GiftOrder')->subject('Gift Course');
    }
}
