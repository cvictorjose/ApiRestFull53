<?php

namespace App\Policies;

use App\User;
use App\BehaviourLayoutItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class BehaviourLayoutItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the behaviour_layout_item.
     *
     * @param  \App\User  $user
     * @param  \App\BehaviourLayoutItem  $behaviour_layout_item
     * @return mixed
     */
    public function index(User $user, BehaviourLayoutItem $behaviour)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_behaviour_layout_item(User $user, BehaviourLayoutItem $behaviour_layout_item)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create behaviour_layout_items.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_behaviour_layout_item(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the behaviour_layout_item.
     *
     * @param  \App\User  $user
     * @param  \App\BehaviourLayoutItem  $behaviour_layout_item
     * @return mixed
     */
    public function update_behaviour_layout_item(User $user, BehaviourLayoutItem $behaviour_layout_item)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the behaviour_layout_item.
     *
     * @param  \App\User  $user
     * @param  \App\BehaviourLayoutItem  $behaviour_layout_item
     * @return mixed
     */
    public function delete_behaviour_layout_item(User $user, BehaviourLayoutItem $behaviour_layout_item)
    {
        return $user->role === 'admin';
    }
}
