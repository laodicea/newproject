<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddCorrectionBusinesTripToUser extends Notification
{
    use Queueable;

    protected $bi_trip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($businessTripFromController)
    {
        $this->bi_trip = $businessTripFromController;
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
                    ->subject('@business trip: Pracovná cesta na dopracovanie')
                    ->line('Na intranete sa Vám vrátila pracovná cesta na dopracovanie "'. $this->bi_trip->title. '".')
                    ->action('Zobraziť pracovnú cestu', url('/busines-trip/'.$this->bi_trip->id.'edit'))
                    ->line('');
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
