<?php

namespace App\Policies;

use App\User;
use App\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function index(User $user, Coupon $coupon)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_coupon(User $user, Coupon $coupon)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create coupons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_coupon(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function update_coupon(User $user, Coupon $coupon)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function delete_coupon(User $user, Coupon $coupon)
    {
        return $user->role === 'admin';
    }
}
