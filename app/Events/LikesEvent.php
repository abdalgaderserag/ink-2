<?php

namespace App\Events;

use App\Like;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class LikesEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id, $type, $op, $user;

    /**
     * Create a new event instance.
     *
     * @param Like $like
     * @param $op
     * @return void
     */
    public function __construct(Like $like, $op)
    {
        Log::debug($like);
        if (!empty($like->ink_id)) {
            $id = $like->ink_id;
            $type = 'ink';
        } else {
            $id = $like->comment_id;
            $type = 'comment';
        }
        $this->id = $id;
        $this->type = $type;
        $this->user = $like->user->id;
        $this->op = $op;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('likes.' . $this->type . '.' . $this->id);
    }

    public function broadcastWith()
    {
        return [
            'op' => $this->op,
            'user' => $this->user,
        ];
    }
}
