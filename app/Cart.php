<?php

namespace App;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'cart';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['identity_id','session_id','coupon_code_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public static function getCurrent(){
        return Cart::where('session_id', Session::getId())->first();
    }

    public function coupon_code()
    {
        return $this->belongsTo('App\CouponCode');
    }

}
