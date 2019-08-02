<?php

namespace App\Policies;

use App\User;
use App\Media;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MediaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the media.
     *
     * @param  \App\User $user
     * @param  \App\Media $media
     * @return mixed
     */
    public function view(User $user, Media $media)
    {
        return true;
    }

    /**
     * Determine whether the user can create media.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the media.
     *
     * @param  \App\User $user
     * @param  \App\Media $media
     * @return mixed
     */
    public function update(User $user, Media $media)
    {
        $allow = false;

        if (!empty($media->ink)) {
            $allow = $user->id == $media->ink->user_id;
        } elseif (!empty($media->comment)) {
            $allow = $user->id == $media->comment->user_id;
        }

        return $allow;
    }

    /**
     * Determine whether the user can delete the media.
     *
     * @param  \App\User $user
     * @param  \App\Media $media
     * @return mixed
     */
    public function delete(User $user, Media $media)
    {
        $allow = false;

        if (!empty($media->ink)) {
            $allow = $user->id == $media->ink->user_id;
        } elseif (!empty($media->comment)) {
            $allow = $user->id == $media->comment->user_id;
        }

        return $allow;
    }

}
