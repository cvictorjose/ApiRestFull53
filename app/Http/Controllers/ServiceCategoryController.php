<?php

namespace App\Http\Controllers;

use App\ServiceCategory;
use Illuminate\Http\Request;
use DB;
class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\ServiceCategory);

        //Get All ServiceCategory
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=ServiceCategory::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('service_category');
        if (isset($field_order)){
            $ticket->orderBy($field_order);
        }
        $results= $ticket->paginate($pagesize,['*'],'page_n');
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
            $service = ServiceCategory::where('id', $id)->firstOrFail();
            $this->authorize('read_servicecategory', $service);
            return $this->createMessage($service,"200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
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
        $this->authorize('create_servicecategory', new \App\ServiceCategory);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'         => 'required',
            'description'   => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            ServiceCategory::create($request->all());
            return $this->createMessage("Added New ServiceCategory","200");

        } catch (Exception $e) {
            \Log::info('Error creating ServiceCategory: '.$e);
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
            'title'         => 'required',
            'description'   => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $service = ServiceCategory::find($id);
            $this->authorize('update_servicecategory', $service);
            $service->update($request->all());
            return $this->createMessage("ServiceCategory modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating ServiceCategory: '.$e);
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
            $service = ServiceCategory::where('id', $id)->firstOrFail();
            $this->authorize('delete_servicecategory', $service);
            $service->delete();
            return $this->createMessage("ServiceCategory deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting ServiceCategory: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }


    /**
     * Return total tickets belong to category (id)
     *
     */
    public function getServices($id)
    {
        $servicegroup= ServiceCategory::find($id);

        if(!$servicegroup)
        {
            return $this->createMessageError("ServiceCategory not found","404");
        }
        return $this->createMessage($servicegroup->services,"200");
    }



}
