<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Message extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @param Request $request
     * @param $id
     * @return void
     */
    public function __construct(Request $request)
    {
        $data['text'] = $request->text;
        $data['media'] = $request->media;
        $data['user_id'] = Auth::id();
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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


//    public function broadcastOn()
//    {
//        return new BroadcastMessage($this->data);
//    }

//    public function toBroadcast($notifiable)
//    {
//        return new BroadcastMessage($this->data);
//    }
}
