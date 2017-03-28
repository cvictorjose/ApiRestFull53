<?php

namespace App\Policies;

use App\User;
use App\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticketsale.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function index(User $user, Ticket $ticket)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_ticket(User $user, Ticket $ticket)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create ticketsales.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_ticket(User $user, Ticket $ticket)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the ticketsale.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function update_ticket(User $user, Ticket $ticket)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the ticketsale.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function delete_ticket(User $user, Ticket $ticket)
    {
        return $user->role === 'admin';
    }
    
}
