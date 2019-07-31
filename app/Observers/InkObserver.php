<?php

namespace App\Observers;

use App\Ink;

class InkObserver
{
    /**
     * Handle the ink "created" event.
     *
     * @param  \App\Ink  $ink
     * @return void
     */
    public function created(Ink $ink)
    {
        //
    }

    /**
     * Handle the ink "updated" event.
     *
     * @param  \App\Ink  $ink
     * @return void
     */
    public function updated(Ink $ink)
    {
        //
    }

    /**
     * Handle the ink "deleted" event.
     *
     * @param  \App\Ink  $ink
     * @return void
     */
    public function deleted(Ink $ink)
    {
        //
    }

    /**
     * Handle the ink "restored" event.
     *
     * @param  \App\Ink  $ink
     * @return void
     */
    public function restored(Ink $ink)
    {
        //
    }

    /**
     * Handle the ink "force deleted" event.
     *
     * @param  \App\Ink  $ink
     * @return void
     */
    public function forceDeleted(Ink $ink)
    {
        //
    }
}
