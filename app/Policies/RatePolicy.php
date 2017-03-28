<?php

namespace App\Policies;

use App\User;
use App\Rate;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the rate.
     *
     * @param  \App\User  $user
     * @param  \App\Rate  $rate
     * @return mixed
     */
    public function index(User $user, Rate $rate){
        return $user->role === 'admin' || $user->role === 'guest';
    }


    public function read_rate(User $user, Rate $rate){
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create rates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_rate(User $user, Rate $rate){
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the rate.
     *
     * @param  \App\User  $user
     * @param  \App\Rate  $rate
     * @return mixed
     */
    public function update_rate(User $user, Rate $rate){
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the rate.
     *
     * @param  \App\User  $user
     * @param  \App\Rate  $rate
     * @return mixed
     */
    public function delete_rate(User $user, Rate $rate){
        return $user->role === 'admin';
    }
}
