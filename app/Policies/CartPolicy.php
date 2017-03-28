<?php

namespace App\Policies;

use App\User;
use App\Cart;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function index(User $user, Cart $cart)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    /**
     * Determine whether the user can create carts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function read_cart(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create carts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function read_own_cart(User $user)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    /**
     * Determine whether the user can create carts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_cart(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function update_cart(User $user, Cart $cart)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the cart.
     *
     * @param  \App\User  $user
     * @param  \App\Cart  $cart
     * @return mixed
     */
    public function delete_cart(User $user, Cart $cart)
    {
        return $user->role === 'admin';
    }
}
