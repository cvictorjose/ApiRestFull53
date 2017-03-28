<?php

namespace App\Policies;

use App\User;
use App\Link;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function index(User $user, Link $link)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_link(User $user, Link $link)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create links.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_link(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function update_link(User $user, Link $link)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the link.
     *
     * @param  \App\User  $user
     * @param  \App\Link  $link
     * @return mixed
     */
    public function delete_link(User $user, Link $link)
    {
        return $user->role === 'admin';
    }
}
