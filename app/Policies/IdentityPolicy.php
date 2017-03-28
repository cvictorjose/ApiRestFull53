<?php

namespace App\Policies;

use App\User;
use App\Identity;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdentityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the identity.
     *
     * @param  \App\User  $user
     * @param  \App\Identity  $identity
     * @return mixed
     */
    public function index(User $user, Identity $identity)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_identity(User $user, Identity $identity)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create identities.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_identity(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the identity.
     *
     * @param  \App\User  $user
     * @param  \App\Identity  $identity
     * @return mixed
     */
    public function update_identity(User $user, Identity $identity)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the identity.
     *
     * @param  \App\User  $user
     * @param  \App\Identity  $identity
     * @return mixed
     */
    public function delete_identity(User $user, Identity $identity)
    {
        return $user->role === 'admin';
    }
}
