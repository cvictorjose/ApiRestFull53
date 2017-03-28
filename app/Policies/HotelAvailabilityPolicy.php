<?php

namespace App\Policies;

use App\User;
use App\HotelAvailability;
use Illuminate\Auth\Access\HandlesAuthorization;

class HotelAvailabilityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the hotelavailability.
     *
     * @param  \App\User  $user
     * @param  \App\HotelAvailability  $hotelavailability
     * @return mixed
     */
    public function index(User $user, HotelAvailability $hotelavailability)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_hotelavailability(User $user, HotelAvailability $hotelavailability)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create hotelavailabilitys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_hotelavailability(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the hotelavailability.
     *
     * @param  \App\User  $user
     * @param  \App\HotelAvailability  $hotelavailability
     * @return mixed
     */
    public function update_hotelavailability(User $user, HotelAvailability $hotelavailability)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the hotelavailability.
     *
     * @param  \App\User  $user
     * @param  \App\HotelAvailability  $hotelavailability
     * @return mixed
     */
    public function delete_hotelavailability(User $user, HotelAvailability $hotelavailability)
    {
        return $user->role === 'admin';
    }
}
