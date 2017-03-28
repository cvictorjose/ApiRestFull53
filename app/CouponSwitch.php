<?php

namespace App;

use App\Coupon;

class CouponSwitch extends Coupon
{
    protected $table = 'coupon_switch';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ticket_sale_id'];

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
        $this->type = "coupon_switch";
    }
}
