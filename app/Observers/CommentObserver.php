<?php

namespace App\Observers;

use App\Comment;
use App\Notifications\Comment\CreateCommentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment $comment
     * @return void
     */
    public function created(Comment $comment)
    {

        if (!empty($comment->ink_id))
            $type = 'ink';
        else if (!empty($comment->comment_id))
            $type = 'comment';
        else
            return;

        $user = $comment[$type]->user;
        $holder = $type;

        if ($user->id != Auth::id())
            $user->notify(new CreateCommentNotification($comment, $holder));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {

        if (!empty($comment->ink_id))
            $type = 'ink';
        else if (!empty($comment->comment_id))
            $type = 'comment';
        else
            return;

        $user = $comment[$type]->user;
        if ($user->id != Auth::id())
            foreach ($user->notifications as $notification) {
                if ($notification['data']['comment'] == $comment->id)
                    $notification->delete();
            }

        $comment->media->delete();

        if (!empty($comment->replies))
            $comment->replies->each(function ($comment) {
                $comment->delete();
            });
    }
}
