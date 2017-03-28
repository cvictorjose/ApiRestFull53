<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BarCodeController extends Controller
{
    public function index ($order_id){

        $results = DB::table('order')
            ->join('identity', 'order.identity_id', '=', 'identity.id')
            ->where('order.id', $order_id)
            ->select( DB::raw('
              order.id as id, order.code_invoice as code_invoice, order.barcode as barcode,
              identity.regulus_id as  regulus_id'))
            ->get();


        if ($results[0]->barcode == Null){
            //Id Order
            $a = strtoupper(dechex($results[0]->id));
            //Extract Words from Code_invoice and convert it
            //$b = substr(preg_replace("/[^A-Z]/","",$results[0]->code_invoice), 0, 3);
            //Regulus user Id
            $c = strtoupper(dechex($results[0]->regulus_id));
            //Get Seconds and miliseconds
            $d = strtoupper(hexdec(date('s.u')));
            //BarCode
            $final_code= $a.$c.$d;

            $order = Order::where('id', $order_id)->firstOrFail();
            $order->barcode = $final_code;
            $order->save();
            return $final_code;
        }

        return $results[0]->barcode;
        //return view('pdf.barcode')->with('product',$final_code);
    }
}
