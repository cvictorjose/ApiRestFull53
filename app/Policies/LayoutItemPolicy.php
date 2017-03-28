<?php

namespace App\Policies;

use App\User;
use App\LayoutItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayoutItemPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function index(User $user, LayoutItem $layout_item)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }
}
