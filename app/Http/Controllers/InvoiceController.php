<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use DB;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Invoice);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Invoice::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('invoice');
        if (isset($field_order)){
            $ticket->orderBy($field_order);
        }
        $results= $ticket->paginate($pagesize,['*'],'page_n');
        $results= $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
        return $results;
    }


    /**
     * Create Code Invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCodeInvoice($order_id){

        $result = DB::table('order')
            ->join('order_element', 'order.id', '=', 'order_element.order_id')
            ->join('identity', 'order.identity_id', '=', 'identity.id')
            ->where('order.id', $order_id)
            ->select( DB::raw('
                  order.total as total, order.status as status, order.payment_method as method, order.barcode as barcode,
                  order_element.*, order_element.title as OrderElementTitle,
                  identity.*'))
            ->get();
        $result = json_decode($result, true);

        $vat_rate=array();
        $sum_tax=0;
        foreach ($result as $key => $value) {
            // return  Product::find(2)->first()->service->vat_rate;
            $p = Product::where('id', $value["product_id"])->firstOrFail();
            $vat=$p->getIva();
            $vat=$vat->vat_rate;
            if (!in_array($vat, $vat_rate)) {
                array_push($vat_rate, $vat);
                $sum_tax=intval($sum_tax) + intval($vat);
            }
        }

        $year = date('y');
        switch($sum_tax){
            case '4':
                $code_invoice=$year."_VTC";
                break;
            case '10':
                $code_invoice=$year."_VTB";
                break;
            case '22':
                $code_invoice=$year."_VTA";
                break;
            //Tax:10+4
            case '14':
                $code_invoice=$year."_VTF";
                break;
            //Tax:22+4
            case '26':
                $code_invoice=$year."_VTE";
                break;
            //Tax:22+10
            case '32':
                $code_invoice=$year."_VTD";
                break;
            //Tax:22+4+10
            case '36':
                $code_invoice=$year."_VTG";
                break;
            default:
                throw new Exception(sprintf('The order not has a TAX', 404));
        }

        $order = Order::where('code_invoice', 'like', $code_invoice.'%')->orderBy('id', 'desc')->latest()->first();
        $new_code_int=sprintf("%'.06d\n", 1);

        if (isset($order)){
            $code_int =  substr(preg_replace("/[^0-9]/","",$order->code_invoice), 2, 8);
            $new_code_int=sprintf("%'.06d\n", $code_int+1);

            /*if ($code_int<10){
                $new_code_int=sprintf("%'.06d\n", $code_int+1);
            }elseif($code_int>=10 && $code_int<=99 ){
                $new_code_int=sprintf("%'.06d\n", $code_int+1);
            }elseif($code_int>=100 && $code_int<=999 ){
                $new_code_int=sprintf("%'.06d\n", $code_int+1);
            }elseif($code_int>=1000 && $code_int<=9999 ){
                $new_code_int=sprintf("%'.06d\n", $code_int+1);
            }elseif($code_int>=10000 && $code_int<=99999 ){
                $new_code_int=sprintf("%'.06d\n", $code_int+1);
            }elseif($code_int>=100000 && $code_int<=999999 ){
                $new_code_int=sprintf("%'.06d\n", $code_int+1);
            }*/
        }

        $order = Order::where('id', $order_id)->firstOrFail();
        if (is_null($order->code_invoice)){
            $order->code_invoice = $code_invoice.$new_code_int;
            $order->save();
        }
        return $code_invoice.$new_code_int;

    }

}
