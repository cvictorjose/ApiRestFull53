<?php

namespace App\Policies;

use App\User;
use App\LayoutCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the layoutcategory.
     *
     * @param  \App\User  $user
     * @param  \App\LayoutCategory  $layoutcategory
     * @return mixed
     */
    public function index(User $user, LayoutCategory $layoutcategory)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_layoutcategory(User $user, LayoutCategory $layoutcategory)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create layoutcategorys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_layoutcategory(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the layoutcategory.
     *
     * @param  \App\User  $user
     * @param  \App\LayoutCategory  $layoutcategory
     * @return mixed
     */
    public function update_layoutcategory(User $user, LayoutCategory $layoutcategory)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the layoutcategory.
     *
     * @param  \App\User  $user
     * @param  \App\LayoutCategory  $layoutcategory
     * @return mixed
     */
    public function delete_layoutcategory(User $user, LayoutCategory $layoutcategory)
    {
        return $user->role === 'admin';
    }
}
