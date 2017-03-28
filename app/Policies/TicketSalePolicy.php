<?php

namespace App\Policies;

use App\User;
use App\Ticketsale;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketSalePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticketsale.
     *
     * @param  \App\User  $user
     * @param  \App\Ticketsale  $ticketsale
     * @return mixed
     */
    public function index(User $user, Ticketsale $ticketsale)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_ticketsale(User $user, Ticketsale $ticketsale)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create ticketsales.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_ticketsale(User $user, Ticketsale $ticketsale)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the ticketsale.
     *
     * @param  \App\User  $user
     * @param  \App\Ticketsale  $ticketsale
     * @return mixed
     */
    public function update_ticketsale(User $user, Ticketsale $ticketsale)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the ticketsale.
     *
     * @param  \App\User  $user
     * @param  \App\Ticketsale  $ticketsale
     * @return mixed
     */
    public function delete_ticketsale(User $user, Ticketsale $ticketsale)
    {
        return $user->role === 'admin';
    }
}
