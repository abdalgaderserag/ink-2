<?php

namespace App\Policies;

use App\User;
use App\Ink;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class InkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ink.
     *
     * @param  \App\User $user
     * @param  \App\Ink $ink
     * @return mixed
     */
    public function view(User $user, Ink $ink)
    {
        return true;
    }

    /**
     * Determine whether the user can create inks.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the ink.
     *
     * @param  \App\User $user
     * @param  \App\Ink $ink
     * @return mixed
     */
    public function update(User $user, Ink $ink)
    {
        return $user->id = $ink->user_id;
    }

    /**
     * Determine whether the user can delete the ink.
     *
     * @param  \App\User $user
     * @param  \App\Ink $ink
     * @return mixed
     */
    public function delete(User $user, Ink $ink)
    {
        return $user->id = $ink->user_id;
    }

}
