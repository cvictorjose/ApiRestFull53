<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'type', 'ticket_sale_id', 'layout_id', 'layout_title', 'behaviour_id', 'discount_fixed', 'discount_percent']; // if ticket_sale_id is null we assume the coupon valid for all ticketsales

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /*
  * name: getCoupons
  * params:
  * return:
  * desc: Return all CouponCodes of a Coupon specific
  */
    public function couponCodes(){
        return $this->hasMany(CouponCode::class);
    }

    /*
  * name: behaviour
  * params:
  * return:
  * desc: Return the behaviour eventually connected to this coupon
  */
    public function behaviour()
    {
        return $this->belongsTo('App\Behaviour');
    }
}
