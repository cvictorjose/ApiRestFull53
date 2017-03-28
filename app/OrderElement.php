<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App;
use App\Library;
use App\Identity;
use DB;
use Dompdf\Dompdf;
use FPDI;
use Storage;
use Session;
use Response;

class OrderElement extends Model
{
    protected $table = 'order_element';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','price','identity_id','cart_id', 'product_id','quantity','operazione_id',
        'code_transaction'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    //Sum price and Quantity of a single product
    public function getPriceQuantity($order_id, $product_id)
    {
        try {
            $data = DB::table('order_element')
                ->where('order_id', $order_id)
                ->where('product_id', $product_id)
                ->select( DB::raw('SUM(price) as total_sales, SUM(quantity) as total_qta'))
                ->first();
            return $data;

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

}
