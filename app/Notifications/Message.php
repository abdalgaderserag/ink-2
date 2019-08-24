<?php

namespace App\Notifications;

use App\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class Message extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $media = Media::setMedia($request);
        $media->save();
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
        return [
            //
        ];
    }
}
