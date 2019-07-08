<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class SecurityInform extends Notification
{
    use Queueable;

    private $title;
    private $text;
    private $category;
    private $slug;
    private $showlink;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $text, $category, $slug ,$showlink)
    {
        $this->title = $title;
        $this->text = substr($text,0,70). '...';
        $this->category = $category;
        $this->slug = $slug;
        $this->showlink = $showlink;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $date = Carbon::now();
        $date->subDay()->format('m-d-Y');

        return [
            'title' => $this->title,
            'text'  => $this->text,
            'category' => $this->category,
            'slug'     => $this->slug,
            'showlink' => $this->showlink,
            'time'  => $date
        ];
    }
}
