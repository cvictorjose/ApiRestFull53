<?php

namespace App\Http\Controllers;

use App\BehaviourLayoutItem;
use Illuminate\Http\Request;
use DB;

class BehaviourLayoutItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\BehaviourLayoutItem);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=BehaviourLayoutItem::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $behaviour_layout_item = DB::table('behaviour_layout_item');
        if (isset($field_order)){
            $behaviour_layout_item->orderBy($field_order);
        }
        $results = $behaviour_layout_item->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_behaviour_layout_item', new \App\BehaviourLayoutItem);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'behaviour_id'     => 'required',
            'layout_item_id'   => 'required',
            'use'              => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            BehaviourLayoutItem::create($request->all());
            return $this->createMessage("Added New BehaviourLayoutItem","200");

        } catch (Exception $e) {
            \Log::info('Error creating BehaviourLayoutItem: '.$e);
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
            $result = BehaviourLayoutItem::where('id', $id)->firstOrFail();
            $this->authorize('read_behaviour_layout_item', $result);
            return $this->createMessage($result,"200");
            // return response()->json(['data'=>$session]);

        } catch (Exception $e) {
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
            'behaviour_id'     => 'required',
            'layout_item_id'   => 'required',
            'use'              => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $result = BehaviourLayoutItem::find($id);
            $this->authorize('update_behaviour_layout_item', $result);
            $result->update($request->all());
            return $this->createMessage("BehaviourLayoutItem modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating BehaviourLayoutItem: '.$e);
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
            $result = BehaviourLayoutItem::where('id', $id)->firstOrFail();
            $this->authorize('delete_behaviour_layout_item', $result);
            $result->delete();
            return $this->createMessage("BehaviourLayoutItem deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting BehaviourLayoutItem: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}
