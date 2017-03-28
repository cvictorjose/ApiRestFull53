<?php

namespace App\Http\Controllers;

use App\Behaviour;
use Illuminate\Http\Request;
use DB;

class BehaviourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Behaviour);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Behaviour::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $behaviour = DB::table('behaviour');
        if (isset($field_order)){
            $behaviour->orderBy($field_order);
        }
        $results = $behaviour->paginate($pagesize,['*'],'page_n');
        $results = $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
        foreach($results as $r){
            $r->behaviour_layout_items = \App\BehaviourLayoutItem::where('behaviour_id', $r->id)->get();
            $r->origins = array();
            foreach($r->behaviour_layout_items as $b){
                if($b->use == 'origin'){
                    $r->origins[] = $b->layout_item_id;
                }elseif($b->use == 'destination'){
                    $r->destination = $b->layout_item_id;
                }
            }
        }
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
        $this->authorize('create_behaviour', new \App\Behaviour);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'     => 'required',
            'type'      => 'required',
            'attribute' => 'required',
            'ratio'     => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $request_vars = $request->all();
            $request_vars['ticket_sale_id'] = empty($request_vars['ticket_sale_id']) ? null : intval($request_vars['ticket_sale_id']);
            Behaviour::create($request_vars);
            return $this->createMessage("Added New Behaviour","200");

        } catch (Exception $e) {
            \Log::info('Error creating Behaviour: '.$e);
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
            $result = Behaviour::where('id', $id)->firstOrFail();
            $this->authorize('read_behaviour', $result);
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
            'title'     => 'required',
            'type'      => 'required',
            'attribute' => 'required',
            'ratio'     => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $result = Behaviour::find($id);
            $this->authorize('update_behaviour', $result);
            $request_vars = $request->all();
            $request_vars['ticket_sale_id'] = empty($request_vars['ticket_sale_id']) ? null : intval($request_vars['ticket_sale_id']);
            $result->update($request_vars);
            return $this->createMessage("Behaviour modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Behaviour: '.$e);
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
            $result = Behaviour::where('id', $id)->firstOrFail();
            $this->authorize('delete_behaviour', $result);
            $result->delete();
            return $this->createMessage("Behaviour deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Behaviour: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}

