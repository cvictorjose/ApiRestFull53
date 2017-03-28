<?php

namespace App\Http\Controllers;

use App\CouponCode;
use Illuminate\Http\Request;
use DB;
class CouponCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\CouponCode);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=CouponCode::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $coupon_code = DB::table('coupon_code');
        if (isset($field_order)){
            $coupon_code->orderBy($field_order);
        }
        $results = $coupon_code->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_couponcode', new \App\CouponCode);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'                 => 'required',
            'coupon_id'             => 'required',
            'code'                  => 'required',
            'expiration_datetime'   => 'required',
            'remaining_collections' => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            CouponCode::create($request->all());
            return $this->createMessage("Added New CouponCode","200");

        } catch (Exception $e) {
            \Log::info('Error creating CouponCode: '.$e);
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
            $couponCode = CouponCode::where('id', $id)->firstOrFail();
            $this->authorize('read_couponcode', $couponCode);
            return $this->createMessage($couponCode,"200");
            // return response()->json(['data'=>$ticket]);

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
            'title'                 => 'required',
            'coupon_id'             => 'required',
            'code'                  => 'required',
            'expiration_datetime'   => 'required',
            'remaining_collections' => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $couponCode = CouponCode::find($id);
            $this->authorize('update_couponcode', $couponCode);
            $couponCode->update($request->all());
            return $this->createMessage("CouponCode modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating CouponCode: '.$e);
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
            $couponCode = CouponCode::where('id', $id)->firstOrFail();
            $this->authorize('delete_couponcode', $couponCode);
            $couponCode->delete();
            return $this->createMessage("CouponCode deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting CouponCode: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }


}
