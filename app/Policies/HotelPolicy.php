<?php

namespace App\Policies;

use App\User;
use App\Hotel;
use Illuminate\Auth\Access\HandlesAuthorization;

class HotelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Hotel  $hotel
     * @return mixed
     */
    public function index(User $user, Hotel $hotel)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_hotel(User $user, Hotel $hotel)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_hotel(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Hotel  $hotel
     * @return mixed
     */
    public function update_hotel(User $user, Hotel $hotel)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Hotel  $hotel
     * @return mixed
     */
    public function delete_hotel(User $user, Hotel $hotel)
    {
        return $user->role === 'admin';
    }
}
