<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveUserMessage extends Notification
{
    use Queueable;
    private $user;
    private $conversation_id;
    //private $message_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $conversation_id)
    {
        $this->user = $user;
        $this->conversation_id = $conversation_id;
       // $this->message_id = $message_id;

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
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'title' => "Message from ".$this->user->first_name,
            'conversation_id' => $this->conversation_id,
            //'message_id' => $this->message_id,
            'from' => Auth::id(), // TO ID CAN BE RETRIEVED FROM 'notifyable_id' column
            'date_time'  => Carbon::now()->toDateTimeString(),
        ];
    }
}
