<?php

namespace App\Policies;

use App\User;
use App\CouponCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponCodePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the couponCode.
     *
     * @param  \App\User  $user
     * @param  \App\CouponCode  $couponCode
     * @return mixed
     */
    public function index(User $user, CouponCode $couponCode)
    {
        return $user->role === 'admin' || $user->role === 'guest';
    }

    public function read_couponcode(User $user, CouponCode $couponCode)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create couponCodes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create_couponcode(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the couponCode.
     *
     * @param  \App\User  $user
     * @param  \App\CouponCode  $couponCode
     * @return mixed
     */
    public function update_couponcode(User $user, CouponCode $couponCode)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the couponCode.
     *
     * @param  \App\User  $user
     * @param  \App\CouponCode  $couponCode
     * @return mixed
     */
    public function delete_couponcode(User $user, CouponCode $couponCode)
    {
        return $user->role === 'admin';
    }
}
