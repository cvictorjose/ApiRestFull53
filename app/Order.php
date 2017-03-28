<?php

namespace App;

use App\Http\Controllers\BarCodeController;
use App\Http\Controllers\InvoiceController;
use App\Service;
use Illuminate\Support\Facades\DB;
use Mail;
use App;
use App\Identity;
use App\Library;
use App\Library\Payback;
use Carbon\Carbon;
use Exception;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['identity_id','session_id','coupon_code_id','payment_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    //manca il campo order_id sulla tabella Identity
    public function identity()
    {
        return $this->hasOne(Identity::class);
    }

    /**
     * Return all transactions with relationship a Order_id
     * Url:orders/2/transactions
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            'App\Transaction', 'App\Payment',
            'order_id', 'payment_id', 'id'
        );

    }

    /**
     * Return all invoices with relationship a Order_id
     * Url:orders/1/invoices
     */
    public function invoices()
    {
        return $this->hasManyThrough(
            'App\Invoice', 'App\Payment',
            'order_id', 'payment_id', 'id'
        );

    }

    /**
     * Return all HotelOrder items with relationship a Order_id
     * Url:orders/1/invoices
     */
    public function hotelOrders()
    {
        return $this->hasMany(HotelOrder::class);
    }

    /**
     * Return a new IdOperazione
     * Url:
     */
    /*public static function getIdOperazione($order_id)
    {
        //var_dump('session_id:', \Session::getId());
        $order = Order::find($order_id);
        $identity= Identity::find($order->identity_id);


        //Update operazione_id foreach single element
        $order_elements = OrderElement::where('order_id',$order_id)->get();
        $order_elements = json_decode($order_elements, true);
        $i=0;
        $regulus_id="";
        $coupon_code = null;
        if($order->coupon_code_id>0){
            $coupon_code = CouponCode::find($order->coupon_code_id);
            $coupon_code = $coupon_code->code;
        }
        foreach ($order_elements as $key => $value) {
            $product_id= $value['product_id'];
            $type_product= Product::find($product_id);
            if ($type_product->type==="ticket") {
                $i=1;
                $ticket=Ticket::where('product_id',$product_id)->first();
                $rate=Rate::find($ticket->rate_id);
                $riduzione_id=$rate->rid_id;
                $rid_code=$rate->rid_code;
                $turno_id=$rate->turno_id;

                if (empty($value['identity_id'])){
                    $regulus_id=$identity->regulus_id;
                }else{
                    $identity_2= Identity::find($value['identity_id']);
                    $regulus_id=$identity_2->regulus_id;
                }

                //Request an IdOperazione for each element
                try{
                $regulus = new \App\Library\Regulus();
                $operazione = $regulus->getIdOperazione($regulus_id, $turno_id, $riduzione_id, $coupon_code, $rid_code);
                }catch(\Exception $e){
                    throw new \Exception('Regulus error: '.$e->getMessage());
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
                    throw new \Exception('code_transaction and Operazione_id have been registered before: ');
                }
            }//endCheckTypeProduct
        }
        if($i>0){
            try{
                $regulus = new \App\Library\Regulus();
                $code_confirm = $regulus->confermaPagamento($order_id);
            }catch(\Exception $e){
                throw new \Exception('Regulus confermaPagamento error: '.$e->getMessage());
            }

            //Biglietto non utilizza questo code_transaction, solo Abbonamento per scaricare il pdf
            $update_elements = OrderElement::where('order_id', $order_id)->update(['code_transaction' => $code_confirm]);

            //return $this->createMessage("code_transaction and Operazione_id created, Code:".$code_confirm,"200");
        }
        //return $this->createMessage("service created","200");

       //Donwload single pdf from regulus and merge all document
        //$result = (new PdfController)->getOrderPdf($order_id);
    }*/

    public static function markAsCompleted($order_id)
    {
        try{
            $regulus = new \App\Library\Regulus();
            $code_confirm = $regulus->confermaPagamento($order_id);
            //Biglietto non utilizza questo code_transaction, solo Abbonamento per scaricare il pdf
            $update_elements = OrderElement::where('order_id', $order_id)->update(['code_transaction' => $code_confirm]);
            $result = (new \App\Http\Controllers\PdfController)->getOrderPdf($order_id);
            
            $barcode="";
            $order = Order::find(intval($order_id));
            $order->status = 'ok';

            if ($order->invoice>0){
                //Create Code Invoice
                $code_invoice= (new InvoiceController())->createCodeInvoice($order_id);
                $order->code_invoice = $code_invoice;
            }

            //Create BarCode
            $bar_code = (new BarCodeController())->index($order_id);
            $order->barcode = $bar_code;
            $order->save();

            // Decreasing coupon code remaining collections START            
            if($order->coupon_code_id>0){ 
                $coupon_code = CouponCode::find($order->coupon_code_id);
                $coupon_code->remaining_collections--;
                $coupon_code->save();
            }
            // Decreasing coupon code remaining collections END

            // Decreasing hotel availability, if applicable START
            //$hotel_orders = HotelOrder::where('order_id', $order_id)->get();
            $hotel_orders = DB::select('SELECT hotel_order.hotel_id, hotel_order.day, hotel_order.room_type_id, hotel_order.rooms AS rooms, room_type.title AS room_type, hotel.title AS hotel, hotel.address AS hotel_address, hotel.email AS hotel_email FROM hotel_order, hotel, room_type WHERE hotel.id = hotel_order.hotel_id AND room_type.id = hotel_order.room_type_id AND hotel_order.order_id = ?', [$order_id]);
            foreach($hotel_orders as $hotel_order){
                $hotel_availability = HotelAvailability::where('hotel_id',      $hotel_order->hotel_id)
                                                        ->where('day',          $hotel_order->day)
                                                        ->where('room_type_id', $hotel_order->room_type_id)->first();
                $hotel_availability->rooms -= $hotel_order->rooms;
                $hotel_availability->save();
            }
            // Decreasing hotel availability, if applicable END

            $identity = Identity::find($order->identity_id);
            $carrello = OrderElement::where('order_id',$order_id)->get();
            $order_elements = json_decode($carrello, true);

            $ticket=0; $service=0; $abbonamento=0;
            foreach ($order_elements as $key => $value) {
                if (empty($value['operazione_id'])){ $service=1;}else{$ticket=1;}

                $TypeProduct = (new Product())->checkTypeProduct($value['product_id']);
                if($TypeProduct == "ticket"){
                    $TypeTicket = (new Ticket())->checkTypeTicket($value['product_id']);
                    if ($TypeTicket==1) $abbonamento=1;
                }
            }


            if(empty($hotel_orders)){ // No hotel-related-type order

                Mail::send('emails.order_confirmation', ['identity' => $identity, 'order' => $order, 'service'=>$service,
                    'ticket'=>$ticket, 'carrello'=>$order_elements, 'barcode'=>$bar_code, 'abbonamento'=>$abbonamento],
                    function ($m) use ($identity, $order, $ticket, $service, $bar_code) {
                        $m->from('cinecitta-ws-cl18@gag.it', 'Biglietteria CCW');
                        $m->to($identity->email, sprintf("%s %s", $identity->name, $identity->surname))->subject('Conferma ordine acquisto da Cinecittà World');
                });

            }else{

                Mail::send('emails.order_confirmation_hotel', ['identity' => $identity, 'order' => $order, 'service'=>$service, 'ticket'=>$ticket, 'carrello'=>$order_elements, 'barcode'=>$bar_code, 'abbonamento'=>$abbonamento, 'hotel_orders'=>$hotel_orders],
                    function ($m) use ($identity, $order, $ticket, $service, $bar_code) {
                        $m->from('cinecitta-ws-cl18@gag.it', 'Biglietteria CCW');
                        $m->to($identity->email, sprintf("%s %s", $identity->name, $identity->surname))->subject('Conferma ordine acquisto da Cinecittà World');
                });
                $order_day      = Carbon::parse($order->visit_date)->format('d/m/Y');
                $order_dayafter = date('d/m/Y', (strtotime($order->visit_date)+86400));
                $hotel_orders_by_hotel = array();
                foreach($hotel_orders as $hotel_order){
                    if(!empty($hotel_order->hotel_email)){
                        if(!array_key_exists($hotel_order->hotel_id, $hotel_orders_by_hotel)){
                            $hotel_orders_by_hotel[$hotel_order->hotel_id] = array(
                                'email' => $hotel_order->hotel_email,
                                'title' => $hotel_order->hotel,
                                'items' => array()
                            );
                        }
                        $hotel_orders_by_hotel[$hotel_order->hotel_id]['items'][] = $hotel_order;
                    }
                }
                foreach($hotel_orders_by_hotel as $hotel_order_by_hotel){
                    $hotel_email = $hotel_order_by_hotel['email'];
                    $hotel_title = $hotel_order_by_hotel['title'];
                    Mail::send('emails.order_confirmation_hotelowner', ['identity' => $identity, 'order_day'=>$order_day, 'order_dayafter'=>$order_dayafter, 'hotel_orders' => $hotel_order_by_hotel['items']],
                        function ($m) use ($hotel_email, $hotel_title, $order_day, $order_dayafter) {
                            $m->from('cinecitta-ws-cl18@gag.it', 'Biglietteria CCW');
                            $m->to($hotel_email, $hotel_title)->subject(sprintf('Prenotazione da Cinecittà World dal %s al %s', $order_day, $order_dayafter));
                    });
                }

            }


            if(!empty($identity->payback_card)){

                //$payback = new App\Library\Payback\CinecittaPayback();
                $payback = new App\Library\Payback\CinecittaPayback;
                $r = $payback->process_purchase($order_id);

            }
            return true;

        }catch(\Exception $e){
            //return false;
            throw new \Exception(sprintf('%s | File %s | Line %s', $e->getMessage(), $e->getFile(), $e->getLine()));
        }
    }
}
