<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use App\EmailTemplate;

class EmailVerificationNotificationViaAPI extends VerifyEmail
{
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $verificationUrl1= $this->findFirst("/email",'/api/email', $verificationUrl);
        
        return (new MailMessage)
            // ->subject('Verify Email Address')
            // ->line('Please click the button below to verify your email address.')
            // ->action('Verify Email Address',$verificationUrl1)
            // ->line('If you did not create an account, no further action is required.');
            ->subject(EmailTemplate::where('type','verification')->value('subject'))
            ->line(EmailTemplate::where('type','verification')->value('title'))
            ->action(EmailTemplate::where('type','verification')->value('action'), url('/'))
            ->line(EmailTemplate::where('type','verification')->value('message'));
    }

    function findFirst($findingWord, $replacingWord, $url) {
        return implode($replacingWord, explode($findingWord, $url, 2));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}