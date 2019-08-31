<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $id, $type, $comment;

    /**
     * Create a new event instance.
     *
     * @param Comment $comment
     * @return void
     */
    public function __construct(Comment $comment)
    {
        if (!empty($comment->ink_id)) {
            $id = $comment->ink_id;
            $type = 'ink';
        } else {
            $id = $comment->comment_id;
            $type = 'comment';
        }
        $this->id = $id;
        $this->type = $type;
        $this->comment = $comment;
        $this->comment->user;
        $this->comment->media;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('comments.' . $this->type . '.' . $this->id);
    }

    public function broadcastWith()
    {
        return [
            'comment' => $this->comment,
        ];
    }
}
