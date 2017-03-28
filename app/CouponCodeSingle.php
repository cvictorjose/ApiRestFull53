<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCodeSingle extends Model
{
    protected $table = 'coupon_code_single';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['coupon_code_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
