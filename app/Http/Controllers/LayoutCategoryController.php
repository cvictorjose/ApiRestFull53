<?php

namespace App\Http\Controllers;

use App\LayoutCategory;
use Illuminate\Http\Request;
use App\TicketSale;
use DB;

class LayoutCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new LayoutCategory);

        //Get All layoutcategorys
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=LayoutCategory::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $layoutcategory = DB::table('layout_category');
        if (isset($field_order)){
            $layoutcategory->orderBy($field_order);
        }
        $results= $layoutcategory->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_layoutcategory', new \App\LayoutCategory);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title' => 'required',
            'type'  => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            LayoutCategory::create($request->all());
            return $this->createMessage("Added New LayoutCategory","200");

        } catch (Exception $e) {
            \Log::info('Error creating LayoutCategory: '.$e);
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
            $layoutcategory = LayoutCategory::where('id', $id)->firstOrFail();
            $this->authorize('read_layoutcategory', $layoutcategory);
            return $this->createMessage($layoutcategory,"200");
            // return response()->json(['data'=>$layoutcategory]);

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
            'type'   => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $layout_category = LayoutCategory::find($id);
            $this->authorize('update_layoutcategory', $layout_category);
            $layout_category->update($request->all());
            return $this->createMessage("LayoutCategory modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating LayoutCategory: '.$e);
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
            $layoutcategory = LayoutCategory::where('id', $id)->firstOrFail();
            $this->authorize('delete_layoutcategory', $layoutcategory);
            $layoutcategory->delete();
            return $this->createMessage("LayoutCategory deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting LayoutCategory: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}
