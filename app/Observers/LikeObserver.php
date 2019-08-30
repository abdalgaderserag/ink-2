<?php

namespace App\Observers;

use App\Events\LikesEvent;
use App\Like;
use App\Notifications\Like\CreateLikeNotification;
use Illuminate\Support\Facades\Auth;

class LikeObserver
{
    /**
     * Handle the like "created" event.
     *
     * @param  \App\Like $like
     * @return void
     */
    public function created(Like $like)
    {
        if (!empty($like->ink_id))
            $type = 'ink';
        else if (!empty($like->comment_id))
            $type = 'comment';
        else
            return;

        $user = $like[$type]->user;
        $holder = $type;
        event(new LikesEvent($like, true));
        if ($user->id != Auth::id())
            $user->notify(new CreateLikeNotification($like, $holder));
    }
//    public function broadcastOn()
//    {
//        return new PresenceChannel('likes.'.$this->like->id);
//        return new PresenceChannel('likes.1');
//    }

    /**
     * Handle the like "updated" event.
     *
     * @param  \App\Like $like
     * @return void
     */
    public function updated(Like $like)
    {
        //
    }

    /**
     * Handle the like "deleted" event.
     *
     * @param  \App\Like $like
     * @return void
     */
    public function deleted(Like $like)
    {
        event(new LikesEvent($like, false));


        if (!empty($like->ink_id)) {
            $type = 'ink';
            $hold = $like->ink()->dissociate();
        } else if (!empty($like->comment_id)) {
            $type = 'comment';
            $hold = $like->ink()->dissociate();
        } else
            return;

        $this->like = $like;

        $user = $hold->user;

        foreach ($user->notifications as $notification) {
            if (!empty($notification['data']['like']))
                if ($notification['data']['like'])
                    $notification->delete();
        }
    }

}
