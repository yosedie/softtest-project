<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\EmailTemplate;

class AdminOrder extends Notification
{
    use Queueable;

     private $course;
     public $order_id;
     public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($course,$order_id,$url)
    {
        $this->course = $course;
        $this->order_id = $order_id;
        $this->url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
        return (new MailMessage)
                    ->line(EmailTemplate::where('type','admin_order')->value('title'))
                    ->action(EmailTemplate::where('type','admin_order')->value('action'), url('/'))
                    ->line(EmailTemplate::where('type','admin_order')->value('message'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

            'id' => $this->course['title'],
            'image' => $this->course['image'],
            'data' => 'User Enrolled in '.$this->course['title'].'(order ID '.$this->order_id.')',
            'url' => $this->url
        ];
    }
}