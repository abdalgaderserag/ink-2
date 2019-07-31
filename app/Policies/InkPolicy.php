<?php

namespace App\Policies;

use App\User;
use App\Ink;
use Illuminate\Auth\Access\HandlesAuthorization;

class InkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ink.
     *
     * @param  \App\User  $user
     * @param  \App\Ink  $ink
     * @return mixed
     */
    public function view(User $user, Ink $ink)
    {
        //
    }

    /**
     * Determine whether the user can create inks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the ink.
     *
     * @param  \App\User  $user
     * @param  \App\Ink  $ink
     * @return mixed
     */
    public function update(User $user, Ink $ink)
    {
        //
    }

    /**
     * Determine whether the user can delete the ink.
     *
     * @param  \App\User  $user
     * @param  \App\Ink  $ink
     * @return mixed
     */
    public function delete(User $user, Ink $ink)
    {
        //
    }

    /**
     * Determine whether the user can restore the ink.
     *
     * @param  \App\User  $user
     * @param  \App\Ink  $ink
     * @return mixed
     */
    public function restore(User $user, Ink $ink)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ink.
     *
     * @param  \App\User  $user
     * @param  \App\Ink  $ink
     * @return mixed
     */
    public function forceDelete(User $user, Ink $ink)
    {
        //
    }
}
