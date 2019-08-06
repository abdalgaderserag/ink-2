<?php

namespace App\Notifications\Comment;

use App\Comment;
use Illuminate\Notifications\Notification;

class CreateCommentNotification extends Notification
{

    private $data = [];

    /**
     * Create a new notification instance.
     *
     * @param Comment $comment
     * @param $holder
     * @return void
     */
    public function __construct(Comment $comment, $holder)
    {
        $text = 'new comment added to your ' . $holder->type . ' by ' . $comment->user()->name;
        $comment_id = $comment->id;
        $this->data = [
            'text' => $text,
            'comment' => $comment_id,
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
