<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Product);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Product::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('product');
        if (isset($field_order)){
            $ticket->orderBy($field_order);
        }
        $results= $ticket->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_product', new \App\Product);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'name'      => 'required',
            'description'     => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }

            Product::create($request->all());
            return ['created' => true];
            //$data = ['error' => ['message' => 'Not Found', 'status_code' => 404]];
            //return response()->json($data);

        } catch (Exception $e) {
            \Log::info('Error creating Product: '.$e);
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
            $result = Product::where('id', $id)->firstOrFail();
            $this->authorize('read_product', $result);

            return $this->createMessage($result,"200");
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
            'name'      => 'required',
            'description'     => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }
            $product = Product::find($id);
            $this->authorize('update_product', $product);
            $product->update($request->all());
            return ['updated' => true];

        } catch (Exception $e) {
            \Log::info('Error updating Product: '.$e);
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
            $result = Product::where('id', $id)->firstOrFail();
            $this->authorize('delete_product', $result);
            $result->delete();
            return $this->createMessage("Ticket deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Ticket: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }


    }
}
