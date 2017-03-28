<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use DB;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Coupon);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Coupon::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $coupon = DB::table('coupon');
        if (isset($field_order)){
            $coupon->orderBy($field_order);
        }
        $results = $coupon->paginate($pagesize,['*'],'page_n');
        $results = $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
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
        $this->authorize('create_coupon', new \App\Coupon);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'  => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $request_vars = $request->all();
            $request_vars['ticket_sale_id'] = empty($request_vars['ticket_sale_id']) ? null : intval($request_vars['ticket_sale_id']);
            $request_vars['layout_id'] = empty($request_vars['layout_id']) ? null : intval($request_vars['layout_id']);
            $request_vars['behaviour_id'] = empty($request_vars['behaviour_id']) ? null : intval($request_vars['behaviour_id']);
            $request_vars['discount_fixed'] = empty($request_vars['discount_fixed']) ? null : floatval($request_vars['discount_fixed']);
            $request_vars['discount_percent'] = empty($request_vars['discount_percent']) ? null : floatval($request_vars['discount_percent']);
            Coupon::create($request_vars);
            return $this->createMessage("Added New Coupon","200");

        } catch (Exception $e) {
            \Log::info('Error creating Coupon: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
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
            $coupon = Coupon::where('id', $id)->firstOrFail();
            $this->authorize('read_coupon', $coupon);
            return $this->createMessage($coupon,"200");
            // return response()->json(['data'=>$coupon]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
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
            'title'  => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $coupon = Coupon::find($id);
            $this->authorize('update_coupon', $coupon);
            $request_vars = $request->all();
            $request_vars['ticket_sale_id'] = empty($request_vars['ticket_sale_id']) ? null : intval($request_vars['ticket_sale_id']);
            $request_vars['layout_id'] = empty($request_vars['layout_id']) ? null : intval($request_vars['layout_id']);
            $request_vars['behaviour_id'] = empty($request_vars['behaviour_id']) ? null : intval($request_vars['behaviour_id']);
            $request_vars['discount_fixed'] = empty($request_vars['discount_fixed']) ? null : floatval($request_vars['discount_fixed']);
            $request_vars['discount_percent'] = empty($request_vars['discount_percent']) ? null : floatval($request_vars['discount_percent']);
            $coupon->update($request_vars);
            return $this->createMessage("Coupon modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Coupon: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
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
            $coupon = Coupon::where('id', $id)->firstOrFail();
            $this->authorize('delete_coupon', $coupon);
            $coupon->delete();
            return $this->createMessage("Coupon deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Coupon: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    /**
     * Return All CouponCodes with an Coupon_id specific.
     *
     */
    public function getCouponCodes($id)
    {
        $coupon = Coupon::find($id);
        if(!$coupon)
        {
            return $this->createMessageError("Coupon not found","404");
        }
        return $this->createMessage($coupon->getCouponCodes,"200");
    }
}
