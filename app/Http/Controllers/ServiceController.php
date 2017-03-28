<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service;
use DB;
use Illuminate\Support\Facades\Input;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Service);
        //Get All Services
        //Column 'title' in order clause is ambiguous = you need sort=service.title in your url request
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Service::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $service = DB::table('service');
        //->join('service_category', 'service.service_category_id', '=', 'service_category.id');
        if (isset($field_order)){
            $service->orderBy($field_order);
        }
        $results= $service->paginate($pagesize,['*'],'page_n');
        $results= $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
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
            $service = Service::where('id', $id)->firstOrFail();
            $this->authorize('read_service', $service);
            return $this->createMessage($service,"200");
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_service', new \App\Service);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $created_at=Carbon::now();
        $updated_at=Carbon::now();

        $rules = [
            'title'     =>  'required',
            'price'     =>  'required'           
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }

            //Insert a new product - type:service
            // $array_product= ['type' => "service"];
            // $product_id = Product::create($array_product)->id;

            // //Insert a new service + product_id
            // $data = Input::all();
            // $array_service = array();
            // $array_service= [
            //     'product_id' => $product_id,
            //     'title' => $data['title'],
            //     'description' => $data['description'],
            //     'created_at'=>$created_at,'updated_at'=>$updated_at
            // ];
            // $service[] = $array_service;
            // DB::table('service')->insert($service);
            Service::create($request->all());

            return $this->createMessage("Added New Service","200");

        } catch (Exception $e) {
            \Log::info('Error creating Service: '.$e);
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
            'title'      => 'required',
            'price'      => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $service = Service::find($id);
            $this->authorize('update_service', $service);
            $service->update($request->all());
            return $this->createMessage("Service modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Service: '.$e);
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
            $service = Service::where('id', $id)->firstOrFail();
            $this->authorize('delete_service', $service);
            $service->delete();
            return $this->createMessage("Service deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Service: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

}
