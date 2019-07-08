<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddApprovalBusinesTripToBoss extends Notification
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
                    ->subject('@business trip: Nová pracovná cesta na schválenie')
                    ->line('Na intranete Vám pribudla nová pracovná cesta na schválenie "'. $this->bi_trip->title. '" od zamestnanca "'. $this->bi_trip->user->email.'".')
                    ->action('Zobraziť pracovnú cestu', url('/busines-trip/'.$this->bi_trip->id.'/correction'))
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
