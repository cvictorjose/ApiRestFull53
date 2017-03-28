<?php

namespace App\Policies;

use App\User;
use App\Behaviour;
use Illuminate\Auth\Access\HandlesAuthorization;

class BehaviourPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the behaviour.
     *
     * @param  \App\User  $user
     * @param  \App\Behaviour  $behaviour
     * @return mixed
     */
    public function index(User $user, Behaviour $behaviour)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_behaviour(User $user, Behaviour $behaviour)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create behaviours.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_behaviour(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the behaviour.
     *
     * @param  \App\User  $user
     * @param  \App\Behaviour  $behaviour
     * @return mixed
     */
    public function update_behaviour(User $user, Behaviour $behaviour)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the behaviour.
     *
     * @param  \App\User  $user
     * @param  \App\Behaviour  $behaviour
     * @return mixed
     */
    public function delete_behaviour(User $user, Behaviour $behaviour)
    {
        return $user->role === 'admin';
    }
}
