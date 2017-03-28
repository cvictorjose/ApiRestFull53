<?php

namespace App\Policies;

use App\User;
use App\Rate;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegulusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticketsale.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user, Rate $rate)
    {
        return $user->role === 'admin';
    }
}
