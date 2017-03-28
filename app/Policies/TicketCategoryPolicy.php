<?php

namespace App\Policies;

use App\User;
use App\TicketCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticketCategory.
     *
     * @param  \App\User  $user
     * @param  \App\TicketCategory  $ticketCategory
     * @return mixed
     */
    public function index(User $user, TicketCategory $ticketCategory)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_ticketcategory(User $user, TicketCategory $ticketCategory)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create serviceCategories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_ticketcategory(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the ticketCategory.
     *
     * @param  \App\User  $user
     * @param  \App\TicketCategory  $ticketCategory
     * @return mixed
     */
    public function update_ticketcategory(User $user, TicketCategory $ticketCategory)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the ticketCategory.
     *
     * @param  \App\User  $user
     * @param  \App\TicketCategory  $ticketCategory
     * @return mixed
     */
    public function delete_ticketcategory(User $user, TicketCategory $ticketCategory)
    {
        return $user->role === 'admin';
    }
}
