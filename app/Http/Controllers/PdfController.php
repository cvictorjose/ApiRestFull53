<?php

namespace App\Http\Controllers;

use App\OrderElement;
use App\Order;
use App\Product;
use App\Ticket;
use App\TicketSale;
use Carbon\Carbon;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use App;
use App\Library;

use DB;
use App\Cart;
use Dompdf\Dompdf;
use FPDI;
use Storage;
use Session;


class PdfController extends Controller
{
    //Check type of product. Ticket or Service  -- Nota: ho creato la stessa funzione sul modello product
    public function checkTypeProduct($product_id) {
        $type_product= App\Product::find($product_id);
        return $type_product->type;
    }

    //Check type of product. Ticket or Service -- Nota: ho creato la stessa funzione sul modello Ticket
    public function checkTypeTicket($product_id) {
        $result= App\Ticket::where('product_id',$product_id)->firstOrFail();
        return $result->subscription;
    }

    //Check payment status
    public function checkStatusPayment($order_id) {
        $statusPayment= App\Order::find($order_id);
        return $statusPayment->status;
    }

    //Create un ORder Pdf + Merge all single order elements from Regulus
    public function getOrderPdf($order_id) {
        $order_element =  DB::table('order_element')->where('order_id', $order_id)->get();
        $result = json_decode($order_element, true);
        $pdf = new \Jurosh\PDFMerge\PDFMerger;
        $i=0;

        $list_abbonamento=array();
        foreach ($result as $key => $value) {
            $id_operazione      = $value["operazione_id"];
            $id                 = $value["id"];
            $product_id         = $value['product_id'];

            $typeproduct=$this->checkTypeProduct($product_id);

            if ($typeproduct ==="ticket") {
                $exist_file = Storage::disk('local')->exists($id_operazione.'.pdf');
                if (empty($exist_file)){

                    $p_ticket=$this->checkTypeTicket($product_id);

                    if ($p_ticket>0){
                        if (!in_array($product_id, $list_abbonamento)) {
                            array_push($list_abbonamento, $product_id);

                            try {
                                $this->getOrderElementPdf($id);
                                $pdf->addPDF('../storage/orders/'.$id_operazione.'.pdf', 'all', 'vertical');
                            } catch(Exception $e) {
                                return $this->createMessageError($e->getMessage(),$e->getStatusCode());
                            }
                        }
                    }else{
                        try {
                            $this->getOrderElementPdf($id);
                            $pdf->addPDF('../storage/orders/'.$id_operazione.'.pdf', 'all', 'vertical');

                        } catch(Exception $e) {
                            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
                        }

                    }
                    //$this->getOrderElementPdf($id);
                     //mettere un controlllo se non esiste il pdf


                }else {
                    $pdf->addPDF('../storage/orders/'.$id_operazione.'.pdf', 'all', 'vertical');
                }
                $i++;
            }//endChecktype

         }

        if ($i>0){
            $pdf->merge('file', '../storage/orders/'.$order_id.'-order.pdf');
            return $this->createMessage("Pdf Order created","200");
        }else{
            return $i;
        }
    }


    //Get single Pdf from Regulus
    public function getOrderElementPdf($order_element_id)
    {
        try {
            //var_dump('session_id:', \Session::getId());
            //$cart_session=Cart::getCurrent();
            //$identity_id=$cart_session->identity_id;
            $order_element = OrderElement::where('id', $order_element_id)->firstOrFail();
            $id_operazione=$order_element->operazione_id;
            $code_trans=$order_element->code_transaction;

            //$code_trans=(empty($order_element->code_transaction)) ? '0' : $order_element->code_transaction;

            $typeproduct=$this->checkTypeProduct($order_element->product_id);

            //0=Ticket, 1=Abbonamento
            $typeTicket = $this->checkTypeTicket($order_element->product_id);
            if ($typeTicket>0){$code=$order_element->code_transaction;}else{$code=$order_element->operazione_id;}

            if ($typeproduct ==="ticket") {
                $exist_file = Storage::disk('local')->exists($id_operazione.'.pdf');
                if (empty($exist_file)){
                    $regulus = new App\Library\Regulus();
                    $result = $regulus->getScaricaPdf($code,$typeTicket);
                    if ($result!=false){
                        Storage::disk('local')->put($id_operazione.'.pdf', $result);
                        return true;
                    }else{
                        return false;
                        //return $this->createMessageError("$id_operazione Pdf was not generated in regulus","404");
                    }
                }
                //return "200";
            }
            return $this->createMessageError("This Element is a $typeproduct","404");
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    public function getInvoicePdf($order_id) {
        $order= App\Order::where('id',$order_id)->first();
        //$identity= App\Identity::where('id',$order->identity_id)->first();
        //$user_type=$identity->type;


        //Generate Invoice if the invoice field in order is 1.
         if ($order->invoice > 0){
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

            $status=$this->checkStatusPayment($order_id);

            if($status=="ok"){
                $pdf = new DOMPDF();
                $date = date('d-m-Y');
                $invoice=$order->code_invoice;
                $barcode=$order->barcode;
                $view =  \View::make('pdf.invoice', compact('result', 'date', 'invoice', 'barcode'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);
                $output = $pdf->output();
                file_put_contents('../storage/invoices/'.$order_id.'-invoice.pdf', $output);
                return $this->createMessage("Pdf invoice created","200");
            }
            return $this->createMessage("There are not results for this order or his status is pending","404");
        }//EndCompanyCheck
	//return $this->createMessage("No Fattura","404");
	return 0;

    }
    /*public function getSummaryPdf($order_id) {
        $result = DB::table('order')
            ->join('order_element', 'order.id', '=', 'order_element.order_id')
            ->join('identity', 'order.identity_id', '=', 'identity.id')
            ->where('order.id', $order_id)
            ->select( DB::raw('
              order.total as total,
              order_element.*, order_element.title as OrderElementTitle,
             identity.*'))
            ->get();

        if(count($result)> 0){
            $bar_code = (new BarCodeController())->index($order_id);

            $pdf = new DOMPDF();
            $date = date('Y-m-d');
            $view =  \View::make('pdf.summary', compact('result', 'date', 'bar_code'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $output = $pdf->output();
            file_put_contents('../storage/summary/'.$order_id.'-summary.pdf', $output);
            return $this->createMessage("Pdf summary created","200");
        }
        return $this->createMessage("There are not results for this order","404");
    }*/

    public function getServicePdf($order_id) {

        $services=0;
        $percorsi=0;

        $order_elements =array();
        //GEt our services
        $services = DB::table('order')
            ->join('order_element', 'order.id', '=', 'order_element.order_id')
            ->join('product', 'order_element.product_id', '=', 'product.id')
            ->join('identity', 'order.identity_id', '=', 'identity.id')
            ->where('order.id', $order_id)
            ->where('product.type', 'service')
            ->select( DB::raw('
              order.total as total, product.type as producTYPE,order.barcode as barcode,order.visit_date as visit,
              order_element.*, order_element.title as OrderElementTitle, identity.*'))
            ->get();
        $services = json_decode($services, true);

        if(count($services)> 0) {
            foreach ($services as $key => $value) {
                $fullname      = $value["name"] ." ".$value["surname"];
                $email          = $value["email"];
                $phone          = $value["phone"];
                $address        = $value["address"];
                $company        = $value["company"];
                $company_vat    = $value["company_vat"];
                $order_id       = $value["order_id"];

                $total          = $value["total"];
                $p = Product::where('id', $value["product_id"])->firstOrFail();
                $order_elements[]    = array(
                    'title'=> $value["OrderElementTitle"],
                    'price'=> $value["price"],
                    'quantity'=> $value["quantity"],
                    'vat_rate'=> $p->getIva(),
                    'barcode'=> $value["barcode"],
                    'visit'=> $value["visit"],
                );
            }
            $barcode =  $order_elements[0]['barcode'];
            $visit_date= $order_elements[0]['visit'];
        }

        $order_percorsi =array();
        //Get School tickets as Percoso didattico
        $percorsi = DB::table('order')
            ->join('order_element', 'order.id', '=', 'order_element.order_id')
            ->join('product', 'order_element.product_id', '=', 'product.id')
            ->join('ticket', 'order_element.product_id', '=', 'ticket.product_id')
            ->join('identity', 'order.identity_id', '=', 'identity.id')
            ->where('order.id', $order_id)
            ->Where('ticket.educational', '1')
            ->select( DB::raw('
              order.total as total, product.type as producTYPE,order.barcode as barcode,order.visit_date as visit,
              order_element.*, order_element.title as OrderElementTitle, identity.*'))
            ->get();
        $percorsi = json_decode($percorsi, true);

        if(count($percorsi)> 0) {
            foreach ($percorsi as $key => $value) {
                $fullname      = $value["name"] ." ".$value["surname"];
                $email          = $value["email"];
                $phone          = $value["phone"];
                $address        = $value["address"];
                $company        = $value["company"];
                $company_vat    = $value["company_vat"];
                $order_id       = $value["order_id"];

                $p1 = Product::where('id', $value["product_id"])->firstOrFail();
                $order_percorsi[]    = array(
                    'title'=> $value["OrderElementTitle"],
                    'price'=> $value["price"],
                    'quantity'=> $value["quantity"],
                    'vat_rate'=> $p1->getIva(),
                    'barcode'=> $value["barcode"],
                    'visit'=> $value["visit"],
                );
            }//endForEach
            $barcode =  $order_percorsi[0]['barcode'];
            $visit_date= $order_percorsi[0]['visit'];
        }else{$order_percorsi=0;}

        $hotel_orders = DB::select('SELECT hotel_order.rooms AS rooms, room_type.title AS room_type, hotel.title AS hotel, hotel.address AS hotel_address, hotel_order.day AS day FROM hotel_order, hotel, room_type WHERE hotel.id = hotel_order.hotel_id AND room_type.id = hotel_order.room_type_id AND hotel_order.order_id = ?', [$order_id]);

        $hotel_orders_array = (array) $hotel_orders;
        if(count($hotel_orders_array)>0){
            $visit_date = $hotel_orders_array[0]->day;
        }
        if(count($percorsi)==0 && count($services)==0 && count($hotel_orders)>0){
            $order_obj = Order::find($order_id);
            $barcode = $order_obj->barcode;
        }

        if(count($percorsi)> 0 || count($services)> 0 || count($hotel_orders)>0){
            $pdf = new DOMPDF();
            $date = Carbon::parse($visit_date)->format('d-m-Y');

            if(count($percorsi)==0 && count($services)==0 && count($hotel_orders)>0){
                $view =  \View::make('pdf.hotelorder_noservice', compact('order_id', 'hotel_orders', 'barcode'))->render();
            }else{
                $view =  \View::make('pdf.service', compact('order_id','order_elements','hotel_orders', 'order_percorsi', 'fullname','email','address',
                    'phone','company','company_vat','date','barcode'))->render();
            }
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $output = $pdf->output();
            file_put_contents('../storage/orders/'.$order_id.'-service.pdf', $output);
            return $this->createMessage("Pdf Services created","200");
        }
        return 0;
        //return $this->createMessage("There are not results for this order","404");
    }


    public function getAllPdf($order_id) {

            $pdf = new \Jurosh\PDFMerge\PDFMerger;
            $list_file = array(  1 => 'summary',       2 => 'order',        3 => 'service',       4 => 'invoice');
            $list_folder = array(1 => 'summary',       2 => 'orders',       3 => 'orders',        4 => 'invoices');
            $list_storage= array(1 => "summary",       2 => "local",        3 => "local",         4 => "invoices");
            $list_funtion=array( 1 => "getSummaryPdf", 2 => "getOrderPdf",  3 => "getServicePdf", 4 => "getInvoicePdf");

            $exist_file = Storage::disk('all')->exists('order-'.$order_id.'-info.pdf');
            if (empty($exist_file)){
                for ($i = 2; $i < 5; $i++) {
                    $exist_file="";
                    $file=$list_file[$i];
                    $folder=$list_folder[$i];
                    $storages=$list_storage[$i];
                    $fuction=$list_funtion[$i];

                    $exist_file = Storage::disk($storages)->exists($order_id.'-'.$file.'.pdf');
                    if (empty($exist_file)){
                        $create_file=$this->$fuction($order_id);
                        if ($create_file == true){
                            $pdf->addPDF('../storage/'.$folder.'/'.$order_id.'-'.$file.'.pdf', 'all', 'vertical');
                        }
                    }else{
                        $pdf->addPDF('../storage/'.$folder.'/'.$order_id.'-'.$file.'.pdf', 'all', 'vertical');
                    }
                }
                $pdf->merge('file', '../storage/all/order-'.$order_id.'-info.pdf');
                return $this->createMessage("Pdf All created","200");
            }
            return $this->createMessage("Pdf All not created, exist into folder","200");
    }
}
