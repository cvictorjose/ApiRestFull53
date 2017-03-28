<?php

namespace App;

use App\Coupon;

class CouponSubtract extends Coupon
{

    protected $table = 'coupon_subtract';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function __construct(array $attributes = array()){
        parent::__construct($attributes);
        $this->type = "coupon_subtract";
    }
}
