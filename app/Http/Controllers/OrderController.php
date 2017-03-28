<?php

namespace App\Http\Controllers;

use App\CartElement;
use Carbon\Carbon;
use Hamcrest\Core\IsNull;
use Log;
use App;
use App\Library;
use Exception;
use App\Cart;
use App\Order;
use App\HotelOrder;
use App\OrderElement;
use App\Payment;
use App\Transaction;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use Response;
use App\Http\Controllers\PdfController;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Order);

        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Order::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        if (empty($input['order'])){
            $order="desc";
        }else{
            $order= $input['order'];
        }

        $results = DB::table('order');
        if (isset($field_order)){
            $results->orderBy($field_order, $order);
        }
        $results = $results->paginate($pagesize,['*'],'page_n');
        $results = $results->appends(array('sort' => $field_order, 'page_s' => $pagesize, 'order' => $order ));
        return $results;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::where('id', $id)->firstOrFail();
            $this->authorize('read_order', $order);
            $order_elements = OrderElement::where('order_id', $order->id)->get();
            $order_products = array();
            foreach($order_elements as $order_element){
                $order_products[]  =   array(
                    'id'            =>  $order_element->product_id,
                    'quantity'      =>  $order_element->quantity,
                    'identity_id'   =>  $order_element->identity_id,
                );
            }
            $order->products = $order_products;
            $order->order_elements = $order_elements;
            $order->hotel_orders = $order->hotelOrders;
            foreach($order->hotel_orders as $hotel_order){
                $h_o_h                  = $hotel_order->hotel;
                $hotel_order->room_type = $hotel_order->roomType;
            }
            return $this->createMessage($order,"200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), '400');
        }
    }



    /**
     * Place a new order, based on the current cart contents
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function place(Request $request)
    {
      $cart_session=Cart::getCurrent();
      $session_id=$cart_session->session_id;
        try {
            if(!in_array($request->input('payment_method'), array('paypal', 'setefi', 'mybank')))
                throw new Exception(sprintf('Payment method "%s" not recognized.', $request->input('payment_method')));
            $cart = DB::table('cart')->where('session_id', $session_id)->first();
            $cart_id=$cart->id;

            $date_visit = Carbon::parse($request->input('visit_date'))->format('Y-m-d');

            $order= new Order();
            $order->status          = 'pending';
            $order->session_id      = $cart->session_id;
            $order->coupon_code_id  = $cart->coupon_code_id;
            $order->identity_id     = $cart->identity_id;
            $order->total           = $cart->total;
            $order->payment_method  = $request->input('payment_method');
            $order->invoice         = $request->input('invoice');
            $order->save();

            $order_contains_services = false;
            $result = DB::table('cart_element')->where('cart_id', $cart_id)->orderBy('id', 'asc')->get();
            $result = json_decode($result, true);
            foreach ($result as $key => $value) {
                $result= new OrderElement();
                $result->title        = $value["title"];
                $result->price        = $value["price"];
                $result->identity_id  = $value["identity_id"];
                $result->order_id     = $order->id;
                $result->product_id   = intval($value["product_id"]);
                if($result->product_id>0){
                    $p = Product::find($result->product_id);
                    if($p){
                        if($p->type == 'service'){
                            $order_contains_services = true;
                        }
                    }
                }
                $result->quantity     = $value["quantity"];
                $result->save();
            }
            if($order_contains_services || ($request->has('hotel') && $request->has('roomtypes'))){
                $order->visit_date    = $date_visit;
                $order->save();
            }
            if($request->has('hotel') && $request->has('roomtypes')){
                if(!$date_visit){
                    throw new Exception('HotelOrder requires a date. Visit/arrival date not valid/specified');
                }
                $hotel_id = intval($request->input('hotel'));
                if($hotel_id>0){
                    foreach($request->input('roomtypes') as $roomtk => $roomtq){
                        if(intval($roomtq)>0){
                            HotelOrder::create([
                                'order_id'      =>  $order->id,
                                'hotel_id'      =>  $hotel_id,
                                'room_type_id'  =>  $roomtk,
                                'day'           =>  $date_visit,
                                'rooms'         =>  $roomtq,
                                'persons'       =>  0
                            ]);
                        }
                    }
                }
            }


            //Get IdOperazione and Code_transaction foreach element
            $this->getIdOperazione_master($order->id);
            return $this->createMessage(array(
                'id'            =>  $order->id,
                'payment_method'=>  $order->payment_method,
                'total'         =>  number_format($order->total, 2, '.', '')),
                '200');
            //$this->emptyCartElement();


        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage(), '400');
        }
    }

    /**
     * Pay an order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay($id)
    {
        try {

            $order = Order::where('id', $id)->firstOrFail();
            $this->authorize('read_order', $order);
            if($order->status != 'ok'){

                //$result = (new PdfController)->getOrderPdf($id);

                switch($order->payment_method){
                    case 'paypal':
                        $paypal_sku = $order->id;
                        $paypal_name = "New CCW order";
                        $paypal_total = $order->total;
                        global $transaction_code;
                        $transaction_code = $order->id;
                        global $payment_url;
                        include  __DIR__ ."/../../Library/PaymentMethods/paypal/index.php";
                        break;
                    case 'setefi':
                        $setefi_sku = $order->id;
                        $setefi_name = "New CCW order";
                        $setefi_total = $order->total;
                        global $transaction_code;
                        $transaction_code = $order->id;
                        global $payment_url;
                        include  __DIR__ ."/../../Library/PaymentMethods/setefi/index.php";
                        break;
                    case 'mybank':
                        $mybank_sku = $order->id;
                        $mybank_name = "New CCW order";
                        $mybank_total = $order->total;
                        global $transaction_code;
                        $transaction_code = $order->id;
                        global $payment_url;
                        include  __DIR__ ."/../../Library/PaymentMethods/mybank/index.php";
						break;
                    default:
                        throw new Exception(sprintf('The order has a payment_method "%s" not supported', $order->payment_method));
                }

                $this->emptyCartElement();
                return $this->createMessage($payment_url, '200');

            }else{
                throw new Exception('The order was already completed');
            }

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), '400');
        }
    }

    /**
     * Pay the order binded to the current cart/session
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payCurrent()
    {
        try {
            $session_id = Session::getId();
            $order = Order::where('session_id', $session_id)->firstOrFail();
            return $this->pay($order->id);

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), '400');
        }
    }

    /**
     * Mark the order as paid if payment has been successful
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function paymentOutcome(Request $request, $method, $outcome, $order_id=null)
    {
        try {
            switch($outcome){
                case 'success':
                    if($method == 'paypal' && $request->has('transaction_code')){
                        //return print_r($request->all(), true);
                        $order_id = intval($request->input('transaction_code'));
                        //$order = Order::where('session_id', Session::getId())->firstOrFail();
                        if($order_id>0){
                        //if($order->id>0){
                            Order::markAsCompleted($order_id);
                            //$order = Order::where('id', $order_id)->firstOrFail();
                            //$order->status = 'ok';
                            //$order->save();
                            //return $this->createMessage(sprintf("Order #%s successfully marked as paid", $order_id),"200");
                        }
                    }
                    break;
                case 'notify':
                    if($method == 'setefi'){
                        //error_log("FROM ORDER_CONTROLLER_LARAVEL: ".print_r($request->all(), true));
                        //Log::info('Log message', array('context' => 'FROM ORDER_CONTROLLER_LARAVEL: '.print_r($request->all(), true)));
                        include  __DIR__ ."/../../Library/PaymentMethods/setefi/notify.php";
                        return;
					}else if($method == 'mybank'){
						include  __DIR__ ."/../../Library/PaymentMethods/mybank/notify.php";
                        return;
					}
                    break;
                case 'result':
                    if($method == 'setefi'){
                        include  __DIR__ ."/../../Library/PaymentMethods/setefi/result.php";
					}else if($method == 'mybank'){
						include  __DIR__ ."/../../Library/PaymentMethods/mybank/result.php";
                        return;
					}
                    break;
                case 'recovery':
                    if($method == 'setefi')
                        include  __DIR__ ."/../../Library/PaymentMethods/setefi/recovery.php";
                    break;
            }
            if($_SERVER['HTTP_HOST'] == 'devel.ws.cinecittaworld.gag.it'){
                return redirect('http://devel.cinecittaworld.gag.it/biglietteria-2017-ordinecompletato/?outcome='.$outcome);
            }else{
                return redirect('http://www.cinecittaworld.it/biglietteria-2017-ordinecompletato/?outcome='.$outcome);
            }
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage().' Session ID: '.Session::getId(), '400');
        }
    }


    //Empty all elements from a Cart
    public function emptyCartElement()
    {
        $cart = Cart::where('session_id', Session::getId())->first();
        $cart_element= CartElement::where('cart_id', $cart->id)->delete();
    }


    /**
     * Return all transactions belong to a Order_id
     * Url:orders/3/transactions
     */
    public function getTransactions($id)
    {
        $order= Order::find($id);
        if($order)
        {
            return $order->transactions;
        }
        return $this->createMessageError('Order not found', 404);
    }



    /**
     * Return one transaction belong to a Order_id
     * Url:orders/2/transactions/5
     */
    public function getTransaction($id,$transaction_id)
    {
        $order= Order::find($id);
        if($order)
        {
            $transactions = $order->transactions();
            $transaction=$transactions->find($transaction_id);
            if($transaction)
            {
                return $this->createMessage($transaction,"200");
            }
            return $this->createMessageError('Transaction not found', 404);
        }
        return $this->createMessageError('Order not found', 404);
    }



    /**
     * Return all Invoices belong to a Order_id
     * Url:orders/1/invoices
     */
    public function getInvoices($id)
    {
        $order= Order::find($id);
        if($order)
        {
            return $order->invoices;
        }
        return $this->createMessageError('Order not found', 404);
    }

    /**
     * Return a Invoice belong to a Order_id
     * Url:orders/1/invoices/1
     */
    public function getInvoice($id,$invoice_id)
    {
        $order= Order::find($id);
        if($order)
        {
            $invoices = $order->invoices();
            $invoice=$invoices->find($invoice_id);
            if($invoice)
            {
                return $this->createMessage($invoice,"200");
            }
            return $this->createMessageError('Invoice not found', 404);
        }
        return $this->createMessageError('Order not found', 404);
    }

    /**
     * Return a new IdOperazione
     * Url:
     */
    /*public function getIdOperazione($order_id)
    {
        //var_dump('session_id:', \Session::getId());
         $order= App\Order::find($order_id);
         $identity= App\Identity::find($order->identity_id);

        //Update operazione_id foreach single element
        $order_elements = App\OrderElement::where('order_id',$order_id)->orderby('identity_id', 'DESC')->get();
        $order_elements = json_decode($order_elements, true);


        $regulus_id="";
        $coupon_code = null;

        if($order->coupon_code_id>0){
            $coupon_code = \App\CouponCode::find($order->coupon_code_id);
            $coupon_code = $coupon_code->code;
        }
        foreach ($order_elements as $key => $value) {
            $product_id= $value['product_id'];
            $type_product= App\Product::find($product_id);
            if ($type_product->type==="ticket") {

                $ticket=App\Ticket::where('product_id',$product_id)->first();
                $rate= App\Rate::find($ticket->rate_id);
                $riduzione_id=$rate->rid_id;
                $rid_code=$rate->rid_code;
                $turno_id=$rate->turno_id;

                if (empty($value['identity_id'])){
                    $regulus_id=$identity->regulus_id;

                }else{
                    $identity_2= App\Identity::find($value['identity_id']);
                    $regulus_id=$identity_2->regulus_id;
                }

                //Request an IdOperazione for each element
                try{
                $regulus = new App\Library\Regulus();
                $operazione = $regulus->getIdOperazione($identity->regulus_id,$regulus_id, $turno_id,
                    $riduzione_id,
                    $coupon_code, $rid_code);

                }catch(\Exception $e){
                    throw new Exception('Regulus error: '.$e->getMessage());
                }
                //return $operazione;

               $id= $value['id'];
               $operazione_id= $value['operazione_id'];
                if ($operazione_id === NULL){
                    $ticket_order = OrderElement::where('id', $id)->firstOrFail();
                    $ticket_order->operazione_id = $operazione['order_elements'][0]['operazione_id'];
                    $ticket_order->code_transaction = $operazione['codiceTransazione'];
                    $ticket_order->price = $operazione['order_elements'][0]['total'];
                    $ticket_order->save();
                }else {
                    return $this->createMessage("code_transaction and Operazione_id have been registered before","404");
                }
            }//endCheckTypeProduct
        }//end-forEach
    }*/


    public function getDownload($order_id){
        try {
           if (!is_numeric($order_id)){
               $order=Order::where('barcode',$order_id)->firstorfail();
               $order_id=$order->id;
           }
            $create_pdf_all = (new PdfController)->getAllPdf($order_id);
            $file="../storage/all/order-".$order_id."-info.pdf";
            $headers = array('Content-Type: application/pdf',);
            $newName = 'cinecitta-ordine-'.$order_id.'.pdf';
            return response()->download($file, $newName, $headers);
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), '400');
        }
    }

    public function getDownloadByBarcode($barcode){
        try {
            $order = Order::where('barcode', $barcode)->firstorfail();
            $order_id=$order->id;
            $create_pdf_all = (new PdfController)->getAllPdf($order_id);
            $file="../storage/all/order-".$order_id."-info.pdf";
            $headers = array('Content-Type: application/pdf',);
            $newName = 'cinecitta-ordine-'.$barcode.'.pdf';
            return response()->download($file, $newName, $headers);

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage(),'400');
        }
    }


    //TEST
    public function send($order_id){
       Order::markAsCompleted($order_id);
    }



    /**
     * NEW GetIdOperazione  Logic
     * Url:
     */
    public function getIdOperazione_master($order_id)
    {
        $order= App\Order::find($order_id);
        $identity= App\Identity::find($order->identity_id);

        //Update operazione_id foreach single element
        $order_elements = App\OrderElement::where('order_id',$order_id)->orderby('identity_id', 'DESC')->get();
        $order_elements = json_decode($order_elements, true);

        $regulus_id="";
        $coupon_code = null;

        if($order->coupon_code_id>0){
            $coupon_code = \App\CouponCode::find($order->coupon_code_id);
            $coupon_code = $coupon_code->code;
        }

        $data = array();
        $abbonamento=0;
        foreach ($order_elements as $key => $value) {
            $product_id= $value['product_id'];
            $type_product= App\Product::find($product_id);
            if ($type_product->type==="ticket") {

                $ticket=App\Ticket::where('product_id',$product_id)->first();
                $rate= App\Rate::find($ticket->rate_id);
                $riduzione_id=$rate->rid_id;
                $rid_code=$rate->rid_code;
                $turno_id=$rate->turno_id;

                if (empty($value['identity_id'])){
                    $regulus_id=$identity->regulus_id;
                }else{
                    $identity_2= App\Identity::find($value['identity_id']);
                    $regulus_id=$identity_2->regulus_id;
                }

                $data[]  =   array(
                    'regulus_id'    =>  $regulus_id,
                    'turno_id'      =>  $turno_id,
                    'riduzione_id'  =>  $riduzione_id,
                    'coupon_code'   =>  $coupon_code,
                    'rid_code'      =>  $rid_code,
                );
            }//endCheckTypeProduct
        }//end-forEach

        if(count($data)>0){


        //Request an IdOperazione for each element
        try{
            $regulus = new App\Library\Regulus();
            $operazione = $regulus->getIdOperazione_create_carrello($identity->regulus_id,$data);
            //print_r($operazione);

            $list_identity=array();

            foreach ($operazione['order_elements'] as $key => $value) {
               $obj = (object) $value;

                if (!in_array($obj->identity_id, $list_identity)) {
                    array_push($list_identity, $obj->identity_id);

                    $identity_ticket= App\Identity::where('regulus_id',$obj->identity_id)->first();
                    $matchThese = ['identity_id' => $identity_ticket->id, 'order_id' => $order_id];
                    $matchThese_2 = ['code_transaction' => Null, 'order_id' => $order_id];

                    $ticket_order = OrderElement::where($matchThese)->first();
                    if (empty($ticket_order) || is_null($ticket_order)){
                        $ticket_order = OrderElement::where($matchThese_2)->first();
                        $ticket_type=App\Ticket::where('product_id',$ticket_order->product_id)->first();
                        if ($ticket_type->subscription > 0){
                            $ticket_order->identity_id = $order->identity_id;
                        }
                    }

                   $ticket_order->operazione_id = $obj->operazione_id;
                   $ticket_order->code_transaction = $operazione['codiceTransazione'];
                   $ticket_order->price = $obj->total;
                   $ticket_order->save();

                }else{
                    $matchThese_2 = ['code_transaction' => Null, 'order_id' => $order_id];

                    $ticket_order = OrderElement::where($matchThese_2)->first();
                    $ticket_order->operazione_id = $obj->operazione_id;
                    $ticket_order->code_transaction = $operazione['codiceTransazione'];
                    $ticket_order->price = $obj->total;
                    $ticket_order->save();
                }
            }

        }catch(\Exception $e){
            throw new Exception('Regulus error getIdOperazione_create_carrello: '.$e->getMessage());
        }

        }

    }
}
