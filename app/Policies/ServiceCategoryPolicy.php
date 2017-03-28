<?php

namespace App\Policies;

use App\User;
use App\ServiceCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the serviceCategory.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceCategory  $serviceCategory
     * @return mixed
     */
    public function index(User $user, ServiceCategory $serviceCategory)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_servicecategory(User $user, ServiceCategory $serviceCategory)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create serviceCategories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_servicecategory(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the serviceCategory.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceCategory  $serviceCategory
     * @return mixed
     */
    public function update_servicecategory(User $user, ServiceCategory $serviceCategory)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the serviceCategory.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceCategory  $serviceCategory
     * @return mixed
     */
    public function delete_servicecategory(User $user, ServiceCategory $serviceCategory)
    {
        return $user->role === 'admin';
    }
}
