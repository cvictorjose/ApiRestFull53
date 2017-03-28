<?php
namespace App\Http\Controllers;

use App;
use App\Widget;
use App\Library;
use App\Coupon;
use App\CouponCode;
use App\Cart;
use App\TicketSale;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use Log;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new Widget);

        //Get All Widgets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Widget::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $widget = DB::table('widget');
        if (isset($field_order)){
            $widget->orderBy($field_order);
        }

        $results= $widget->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_widget', new Widget);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'          => 'required',
            'coupon_code_id' => 'required',
            'code'           => 'required'
        ];

        try {

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(), "400");
            }
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $widget = Widget::create($request_vars);
            $widget->generateEmbedCode();
            return $this->createMessage("Added New Widget","200");

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
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
            $result = Widget::where('id', $id)->firstOrFail();
            $this->authorize('read_widget', $result);
            return $this->createMessage($result,"200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByTitle($title)
    {
        return $this->showByAttr('title', $title);
    }

    public function showByCode($code)
    {
        return $this->showByAttr('code', $code);
    }

    public function showByAttr($attr_name, $attr_value)
    {
        try {
            $this->authorize('read_widget', new Widget);
            $widget     = Widget::where($attr_name, $attr_value)->first();
            if(!$widget){
                throw new \Exception('Failed retrieving widget details');
            }
            $coupon_code = CouponCode::where('code', $attr_value)->orWhere('code', 'CCW'.$attr_value)->orWhere('code', 'ELE'.$attr_value)->first();
            if(!$coupon_code){
                throw new \Exception('Failed retrieving coupon code');
            }
            $coupon = Coupon::find($coupon_code->coupon_id);
            if(!$coupon){
                throw new \Exception('Failed retrieving coupon');
            }
            $cart = Cart::getCurrent();
            if(!$cart){
                throw new \Exception('Failed retrieving cart');
            }
            $cart->coupon_code_id = $coupon_code->id;
            $cart->save();
            $ticketsale = TicketSale::where('title', 'Standard')->orWhere('id', 1)->first();
            if(!$ticketsale){
                throw new \Exception('Failed retrieving TicketSale');
            }   
            $layout     = $ticketsale->getExpandedLayout();
            if(!$layout){
                throw new \Exception('Expanded layout not available');
            }
            $widget->layout = $layout;
            return $this->createMessage($widget, '200');
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
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
            'title'          => 'required',
            'coupon_code_id' => 'required',
            'code'           => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $widget = Widget::find($id);
            $this->authorize('update_widget', $widget);
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $widget->update($request_vars);
            $widget->generateEmbedCode();
            return $this->createMessage("Widget modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Widget: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
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
            $result= Widget::where('id', $id)->firstOrFail();
            $this->authorize('delete_widget', $result);
            $result->delete();
            return $this->createMessage("Widget deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Widget: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

}
