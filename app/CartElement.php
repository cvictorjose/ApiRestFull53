<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartElement extends Model
{
    protected $table = 'cart_element';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','price','identity_id','cart_id', 'product_id','quantity'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    //Sum price and Quantity of a single product
    public function getPriceQuantity($cart_id, $product_id)
    {
        try {
            $data = DB::table('cart_element')
                ->where('cart_id', $cart_id)
                ->where('product_id', $product_id)
                ->select( DB::raw('SUM(price) as total_sales, SUM(quantity) as total_qta'))
                ->first();
            return $data;

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}
