<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\CouponCode;
use Illuminate\Http\Request;

class CouponCouponCodeController extends Controller
{
    /**
     * Return All Tickets with an Rate_id specific.
     *
     */
    public function getCouponCodes($id)
    {
        $coupon = Coupon::find($id);
        if(!$coupon)
        {
            return $this->createMessageError("Coupon not found","404");
        }
        return $this->createMessage($coupon->getCouponCode,"200");
    }



    /**
     * Return All Coupons with a Coupon_Code_id specific.
     *
     */
    public function getCoupons($id)
    {
        $coupon = CouponCode::find($id);
        if(!$coupon)
        {
            return $this->createMessageError("Coupon not found","404");
        }
        return $this->createMessage($coupon->getCoupons,"200");
    }
}
