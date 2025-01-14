<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
class TestMail extends Mailable
{
    use Queueable, SerializesModels;
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Email',
        );
    }
    public function build()
    {
        return $this->view('admin.email_template.testmail');
    }
}