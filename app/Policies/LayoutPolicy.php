<?php

namespace App\Policies;

use App\User;
use App\Layout;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the layout.
     *
     * @param  \App\User  $user
     * @param  \App\Layout  $layout
     * @return mixed
     */
    public function index(User $user, Layout $layout)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_layout(User $user, Layout $layout)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create layouts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_layout(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the layout.
     *
     * @param  \App\User  $user
     * @param  \App\Layout  $layout
     * @return mixed
     */
    public function update_layout(User $user, Layout $layout)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the layout.
     *
     * @param  \App\User  $user
     * @param  \App\Layout  $layout
     * @return mixed
     */
    public function delete_layout(User $user, Layout $layout)
    {
        return $user->role === 'admin';
    }
}
