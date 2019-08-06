<?php

namespace App\Observers;

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

        if ($user->id != Auth::id())
            $user->notify(new CreateLikeNotification($like, $holder));
    }

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
        if (!empty($like->ink_id))
            $type = 'ink';
        else if (!empty($like->comment_id))
            $type = 'comment';
        else
            return;

        $user = $like[$type]->user;

        foreach ($user->notifications as $notification) {
            if ($notification['data']['like'])
                $notification->delete();
        }
    }

}
