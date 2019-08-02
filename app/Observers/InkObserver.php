<?php

namespace App\Observers;

use App\Ink;

class InkObserver
{
    /**
     * Handle the ink "created" event.
     *
     * @param  \App\Ink $ink
     * @return void
     */
    public function created(Ink $ink)
    {
//        TODO : notify the first see users;
    }

    /**
     * Handle the ink "updated" event.
     *
     * @param  \App\Ink $ink
     * @return void
     */
    public function updated(Ink $ink)
    {
        //
    }

    /**
     * Handle the ink "deleted" event.
     *
     * @param  \App\Ink $ink
     * @return void
     */
    public function deleted(Ink $ink)
    {
//        TODO : reset the notify
        $ink->media->delete();

        $ink->comment()->each(function ($comment) {
            $comment->delete();
        });
        $ink->like()->each(function ($like) {
            $like->delete();
        });
    }

    /**
     * Handle the ink "restored" event.
     *
     * @param  \App\Ink $ink
     * @return void
     */
    public function restored(Ink $ink)
    {
        //
    }

    /**
     * Handle the ink "force deleted" event.
     *
     * @param  \App\Ink $ink
     * @return void
     */
    public function forceDeleted(Ink $ink)
    {
        //
    }
}
