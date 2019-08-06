<?php

namespace App\Observers;

use App\Comment;
use App\Notifications\Comment\CreateCommentNotification;
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
//        TODO : notify the ink owner about
        if (!empty($comment->ink_id)) {
            $type = 'ink';
            $holder = $comment->ink();
        } else if (!empty($comment->comment_id)) {
            $type = 'comment';
            $holder = $comment->parentComment();
        } else
            return;
        $user = $comment[$type];
        $holder->type = $type;

        Notification::send($user, new CreateCommentNotification($comment, $holder));
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
//        TODO: reset the notify

        $comment->media->delete();

        if (!empty($comment->replies))
            $comment->replies->each(function ($comment) {
                $comment->delete();
            });

//        $comment->like->each(function ($like) {
//            $like->delete();
//        });
    }
}
