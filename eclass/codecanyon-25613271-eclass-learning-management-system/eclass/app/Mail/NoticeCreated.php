<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $notice;
    public $courseName;

    public function __construct($notice)
    {
        $this->notice = $notice;
        $this->courseName = $notice->course->title;
    }

    public function build()
    {
        return $this->view('email.noticeCreated')
                    ->subject('New Notice Created');
    }
}