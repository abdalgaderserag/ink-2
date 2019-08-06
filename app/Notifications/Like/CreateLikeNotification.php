<?php

namespace App\Notifications\Like;

use App\Like;
use Illuminate\Notifications\Notification;

class CreateLikeNotification extends Notification
{

    private $data = [];

    /**
     * Create a new notification instance.
     *
     * @param Like $like
     * @param $holder
     * @return void
     */
    public function __construct(Like $like, $holder)
    {
        $text = 'new comment added to your ' . $holder . ' by ' . $like->user->name;
        $like_id = $like->id;
        $this->data = [
            'text' => $text,
            'like' => $like_id,
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data;
    }
}
