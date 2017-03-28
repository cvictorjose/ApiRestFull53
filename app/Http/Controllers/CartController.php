<?php

namespace App\Http\Controllers;

use App;
use App\Library;
use App\Cart;
use App\CartElement;
use App\Coupon;
use App\CouponCode;
use App\Identity;
use App\OrderElement;
use App\Ticket;
use App\TicketSale;
use App\Service;
use Illuminate\Http\Request;
use DB;
use Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Cart);

        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Cart::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $carts = DB::table('cart');
        if (isset($field_order)){
            $carts->orderBy($field_order);
        }
        $results= $carts->paginate($pagesize,['*'],'page_n');
        $results= $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

		$this->authorize('create_cart', new \App\Cart);
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'name'          => 'required',
            'description'   => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }

            Cart::create($request->all());
            return ['created' => true];
            //$data = ['error' => ['message' => 'Not Found', 'status_code' => 404]];
            //return response()->json($data);

        } catch (Exception $e) {
            \Log::info('Error creating Cart: '.$e);
            return \Response::json(['created' => false], 500);
        }
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
            $cart = Cart::where('id', $id)->firstOrFail();
            $this->authorize('read_cart', $cart);

            $array_cart = array(
                'id'                => $cart->id,
                'type'              => "cart",
                'total'             =>  $cart->total,
                'session_id'        => $cart->session_id,
                'coupon_code_id'    => $cart->coupon_code_id,
                'coupon_code_code'  => (($cart->coupon_code) ? $cart->coupon_code->code : null),
                'identity_id'       => $cart->identity_id,
                'csrf-token'        => csrf_token(),
                'products' => array()
            );

			// gag-flavio: tmp debug test
			//$payback = new App\Library\Payback\CinecittaPayback();
			//mail('flavio@gag.it', '$payback', var_export($payback, true));

            $result2 = DB::table('cart_element')->where('cart_id', $cart->id)->get();
            $result2 = json_decode($result2, true);
            $products = array();

            foreach ($result2 as $key => $value) {
                $product_id=$value['product_id'];
                if (!in_array($product_id, $products)) {
                    array_push($products, $product_id);
                    $p = (new CartElement())->getPriceQuantity($id, $product_id);
                    //$ticket_id=Ticket::where('product_id',$value["product_id"])->first();
                    $array_cart['products'][] = array(
                        'id'          => $value["product_id"],
                        'quantity'    => $p->total_qta,
                        'identity_id' => $value["identity_id"],
                    );
                }
            }

            return $this->createMessage($array_cart,"200");

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }

    }

    public function showCurrent()
    {

        try {
            $c = Cart::getCurrent();
            return $this->show($c->id);

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

    /**
     * Create the elements of the current cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCurrent(Request $request)
    {
        $this->authorize('create_cart', new \App\Cart);
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        try {

            $ticket_sale_id = intval($request->input('ticketsale_id'));
            if(!($ticket_sale_id>0)){
                throw new \Exception('TicketSale id not found in HTTP request');
            }
            $ticket_sale = TicketSale::find($ticket_sale_id);
            if(!$ticket_sale){
                throw new \Exception('TicketSale object not found');
            }
            // Visit date check START
            if($ticket_sale->date_mandatory){ // Visit date check
                if(!empty($request->input('visit_date'))){
                    $visit_date_parts = explode('-', $request->input('visit_date'));
                    if(count($visit_date_parts)<3 || !checkdate($visit_date_parts[1], $visit_date_parts[0], $visit_date_parts[2])){
                        throw new \Exception('Visit date is mandatory and it is not valid');
                    }
                }else{
                    throw new \Exception('Visit date is mandatory and it is empty');
                }
            }
            // Visit date check END
            // Behaviour check START
            // foreach($ticket_sale->behaviours as $behaviour){
            //     if($behaviour->type == 'sum'){
            //         foreach($behaviour->behaviour_layout_items as $bli){
            //             if($bli->use == 'destination' && $bli->layout_item){
            //                 if($bli->layout_item->type == 'ticket'){
            //                     $bli_t = Ticket::where('layout_item_id', $bli->layout_item->id)->first();
            //                     if($bli_t->hidden || !($bli_t->interactive)){
                                    
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }
            // Behaviour check END
            $cart = Cart::getCurrent();
            if(!$cart){
                throw new \Exception('Cart object not found');
            }
            $total = 0;
            $tickets=$request->input('tickets');

            if(isset($tickets)){
                foreach($request->input('tickets') as $tk=>$tv){
                    if(intval($tv)>0){
                        $ticket = Ticket::find($tk);
                        for ($i=1; $i<=$tv; $i++) {
                            CartElement::create(array(
                                'title'         =>  $ticket->title,
                                'price'         =>  $ticket->getPrice(),
                                'cart_id'       =>  $cart->id,
                                'product_id'    =>  $ticket->product->id,
                                'quantity'      =>  1,
                            ));
                        }
                        $total += $ticket->getPrice()*intval($tv);
                    }
                }
            }

            $services=$request->input('services');
            if (isset($services)){
                foreach($request->input('services') as $sk=>$sv){
                    if(intval($sv)>0){
                        $service = Service::find($sk);

                        for ($i=1; $i<=$sv; $i++) {
                            CartElement::create(array(
                                'title'         =>  $service->title,
                                'price'         =>  $service->price,
                                'cart_id'       =>  $cart->id,
                                'product_id'    =>  $service->product->id,
                                'quantity'      =>  1,
                            ));
                        }
                        $total += $service->price*intval($sv);
                    }
                }
                //$this->emptyCartElement();
            }
            // Applying coupon (discount_fixed, discount_percent) logic
            if($cart->coupon_code_id>0){
                $coupon_code = CouponCode::find($cart->coupon_code_id);
                if($coupon_code){
                    $coupon = $coupon_code->coupon;
                    if($coupon){
                        if($coupon->type == 'discount_fixed'){
                            $total = $total - $coupon->discount_fixed;
                        }elseif($coupon->type == 'discount_percent'){
                            $total = $total - $total/100*$coupon->discount_percent;
                        }
                    }
                }
            }
            $cart->total    =   $total;
            $cart->save();
            return $this->createMessage('Cart populated properly (OK)', '200');

        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage(), '400');
        }

    }

    public function bindCouponCode(Request $request)
    {
        $this->authorize('update_cart', new \App\Cart);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }
        try {
            $cart = Cart::getCurrent();
            if(!$cart){
                throw new \Exception('Cart object not found');
            }
            $coupon_code_code = $request->input('coupon_code');
            if(empty($coupon_code_code)){
                throw new \Exception('Coupon code cannot be empty');
            }else{
                $coupon_code = CouponCode::where('code', $coupon_code_code)->orWhere('code', 'CCW'.$coupon_code_code)->orWhere('code', 'ELE'.$coupon_code_code)->first();
                if(!$coupon_code){
                    throw new \Exception('Coupon code not found');
                }
                $coupon = Coupon::find($coupon_code->coupon_id);
                if(!$coupon){
                    throw new \Exception('Failed retrieving Coupon');
                }else{
                    if($coupon->ticket_sale_id>0 && $coupon->ticket_sale_id!=intval($request->input('ticket_sale_id'))){
                        throw new \Exception('Failed. Trying to associate a ticketsale-related coupon to another ticketsale which it does not belong');
                    }else{
                        if($coupon_code->remaining_collections>0 &&  $coupon_code->expiration_datetime > date('Y-m-d H:m:s')){
                            $cart->coupon_code_id = $coupon_code->id;
                            $cart->save();
                            return $this->createMessage('Coupon code successfully bound', '200');
                        }else{
                            throw new \Exception('Coupon code is expired');
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            //return $this->createMessageError(sprintf("%s | File: %s | Line: %s", $e->getMessage(), $e->getFile(), $e->getLine()), '400');
            return $this->createMessageError($e->getMessage(), '400');
        }
    }

    public function removeBoundCouponCode(Request $request)
    {
        $this->authorize('update_cart', new \App\Cart);
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }
        try {
            $cart = Cart::getCurrent();
            $cart->coupon_code_id = null;
            $cart->save();
            return $this->createMessage('Removed any bound coupon code', '200');
        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), '400');
        }
    }

    public function bindIdentities(Request $request)
    {
        $this->authorize('update_cart', new \App\Cart);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        try {
            $cart = Cart::getCurrent();
            foreach($request->input('identities') as $ik => $iv){
				$type        = 'person';
				$company     = '';
				$company_vat = '';
				$address     = '';

                if($ik == 'main'){
                    // Checking Payback card validity
                    if(isset($iv['payback_card'])){
                        if(!Identity::isValidPaybackCard($iv['payback_card'])){
                            throw new \Exception('Payback card not valid');
                        }
                    }
                    if(!empty($iv['company_vat'])){
						$type        = 'company';
						$company     = (empty($iv['company'])) ? '' : $iv['company'];
						$company_vat = $iv['company_vat'];
                    	$address     = (empty($iv['address'])) ? '' : $iv['address'];
					}
				}

                $identity = Identity::create(array(
                    'name'        => $iv['name'],
                    'surname'     => $iv['surname'],
                    'email'       => $iv['email'],
                    'phone'       => $iv['phone'],
                    'type'        => $type,
                    'company'     => $company,
                    'company_vat' => $company_vat,
                    'address'     => $address,
                    'payback_card'=> (empty($iv['payback_card'])) ? '' : $iv['payback_card'],
                ));

                if($ik === 'main'){ // Assegno al cart solo identità main
					$cart->identity_id = $identity->id;
					$cart->save();
				}else{ // altrimenti la assegno al cart element

					$ticket = Ticket::where('id', $iv['ticket_id'])->firstOrFail();

					$element = CartElement::where('cart_id', $cart->id)
											->where('product_id', $ticket->product_id)
											->where('identity_id', null)
                                            ->orderby('id', 'DESC')
											->firstOrFail();
					$element->identity_id = $identity->id;
					$element->save();
				}

                $anagrafica_params = array(
                    'cognome' => $identity->surname,
                    'nome'    => $identity->name,
                    'cap'     => $identity->postal_code,
                    'telCell' => $identity->phone,
                    'mail1'   => $identity->email,
                    'azienda' => false,
                    'sistemaOrigine' => 'GAG'
                );

                //Request an ID REgulus for each user
                try{
                    $regulus = new App\Library\Regulus();
                    $id_user_regulus = $regulus->insertUser($anagrafica_params);
                    $identity = App\Identity::find($identity->id);
                    $identity->regulus_id = $id_user_regulus;
                    $identity->save();
                }catch(\Exception $e){
                    throw new Exception('Regulus insertUser error: '.$e->getMessage());
                }


            }
            return $this->createMessage('All identities successfully binded', '200');

        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage(), '400');
        }
    }

    public function emptyCurrent()
    {
        $cart = Cart::getCurrent();
        if($cart){
            CartElement::where('cart_id', $cart->id)->delete();
        }
    }

    //Empty all element from a Cart
    // public function emptyCartElement()
    // {
    //     $cart = Cart::where('session_id', Session::getId())->first();
    //     $cart_element= CartElement::where('cart_id', $cart->id)->delete();
    // }

    /**
     * Update the current cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCurrent(Request $request)
    {
        try {
            $this->emptyCurrent();
            return $this->storeCurrent($request);

        } catch (\Exception $e) {
            return $this->createMessageError($e->getMessage(), '400');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'name'          => 'required',
            'description'   => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }
            $product = Cart::find($id);
            $this->authorize('update_cart', $product);
            $product->update($request->all());
            return ['updated' => true];

        } catch (Exception $e) {
            \Log::info('Error updating Cart: '.$e);
            return \Response::json(['updated' => false], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = Cart::where('id', $id)->firstOrFail();
            $this->authorize('delete_cart', $result);
            $result->delete();
            return $this->createMessage("Cart deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Cart: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }
}
