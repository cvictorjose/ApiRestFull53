<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function index(User $user, Product $product)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }


    public function read_product(User $user, Product $product)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_product(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function update_product(User $user, Product $product)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function delete_product(User $user, Product $product)
    {
        return $user->role === 'admin';
    }
}
