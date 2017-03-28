<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Http\Request;
use DB;
class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Session);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Session::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('session');
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
        $this->authorize('create_session', new \App\Session);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'cart_id'  => 'required',
            'ticket_sale_id'  => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            Session::create($request->all());
            return $this->createMessage("Added New Session","200");

        } catch (Exception $e) {
            \Log::info('Error creating Session: '.$e);
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
            $session = Session::where('id', $id)->firstOrFail();
            $this->authorize('read_session', $session);
            return $this->createMessage($session,"200");
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
            'cart_id'  => 'required',
            'ticket_sale_id'  => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $session = Session::find($id);
            $this->authorize('update_session', $session);
            $session->update($request->all());
            return $this->createMessage("Session modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Session: '.$e);
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
            $session = Session::where('id', $id)->firstOrFail();
            $this->authorize('delete_session', $session);
            $session->delete();
            return $this->createMessage("Session deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Session: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}
