<?php

namespace App\Policies;

use App\User;
use App\RoomType;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the roomtype.
     *
     * @param  \App\User  $user
     * @param  \App\RoomType  $roomtype
     * @return mixed
     */
    public function index(User $user, RoomType $roomtype)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_roomtype(User $user, RoomType $roomtype)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create roomtypes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_roomtype(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the roomtype.
     *
     * @param  \App\User  $user
     * @param  \App\RoomType  $roomtype
     * @return mixed
     */
    public function update_roomtype(User $user, RoomType $roomtype)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the roomtype.
     *
     * @param  \App\User  $user
     * @param  \App\RoomType  $roomtype
     * @return mixed
     */
    public function delete_roomtype(User $user, RoomType $roomtype)
    {
        return $user->role === 'admin';
    }
}
