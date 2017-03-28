<?php

namespace App\Policies;

use App\User;
use App\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function index(User $user, Service $service)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_service(User $user, Service $service)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_service(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function update_service(User $user, Service $service)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param  \App\User  $user
     * @param  \App\Service  $service
     * @return mixed
     */
    public function delete_service(User $user, Service $service)
    {
        return $user->role === 'admin';
    }
}
