<?php

namespace App\Observers;

use App\Comment;

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

        if (!empty($comment->replies()))
            $comment->replies()->each(function ($comment) {
                $comment->delete();
            });
        $comment->like()->each(function ($like) {
            $like->delete();
        });
    }
}
