<?php

namespace App\Observers;

use App\Media;
use Illuminate\Support\Facades\Storage;

class MediaObserver
{
    /**
     * Handle the media "created" event.
     *
     * @param  \App\Media $media
     * @return void
     */
    public function created(Media $media)
    {
//        TODO : dispatch compress job.
    }

    /**
     * Handle the media "updated" event.
     *
     * @param  \App\Media $media
     * @return void
     */
    public function updated(Media $media)
    {
//        TODO : dispatch delete unused Job.
    }

    /**
     * Handle the media "deleted" event.
     *
     * @param  \App\Media $media
     * @return void
     */
    public function deleted(Media $media)
    {
        $paths = $media->media;

        foreach ($paths as $path)
            Storage::disk('public')->delete($path);

    }

}
