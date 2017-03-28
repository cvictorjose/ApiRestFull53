<?php

namespace App\Policies;

use App\User;
use App\LayoutSection;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutSectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the layoutsection.
     *
     * @param  \App\User  $user
     * @param  \App\LayoutSection  $layoutsection
     * @return mixed
     */
    public function index(User $user, LayoutSection $layoutsection)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_layoutsection(User $user, LayoutSection $layoutsection)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create layoutsections.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_layoutsection(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the layoutsection.
     *
     * @param  \App\User  $user
     * @param  \App\LayoutSection  $layoutsection
     * @return mixed
     */
    public function update_layoutsection(User $user, LayoutSection $layoutsection)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the layoutsection.
     *
     * @param  \App\User  $user
     * @param  \App\LayoutSection  $layoutsection
     * @return mixed
     */
    public function delete_layoutsection(User $user, LayoutSection $layoutsection)
    {
        return $user->role === 'admin';
    }
}
