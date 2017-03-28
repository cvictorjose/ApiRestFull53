<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    protected $table = 'coupon_code';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'coupon_id', 'code', 'expiration_datetime', 'remaining_collections'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /*
    * name: coupon
    * params:
    * return:
    * desc: CouponCode belongs to a Coupon
    */
    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

}
