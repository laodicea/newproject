<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddWikiNotifi extends Notification
{
    use Queueable;

    protected $wiki;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($wikiFromController)
    {
        $this->wiki= $wikiFromController;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->success()
                    ->subject('@wiki: nový termín')
                    ->line('Na intranet pribudol termín "'. $this->wiki->name. '".')
                    ->action('Pozrieť termín', url('/wiki/'.$this->wiki->id))
                    ->line('Ďakujeme za aktualizáciu termínu!');
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
            //
        ];
    }
}
