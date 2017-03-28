<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Rate;
use App\Http\Requests;
use App\Library;
use DB;
class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Update Rates
        //$update_rate = new App\Library\TicketSale();
        //$result = $update_rate->updateTickets();

        //Get All Rates
        //return response()->json(['data'=>Rate::all()]);

        $this->authorize('index', new \App\Rate);

        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Rate::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('rate');
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
            $ticket = Rate::where('id', $id)->firstOrFail();
            $this->authorize('read_rate', $ticket);
            return $this->createMessage($ticket,"200");
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
        $this->authorize('create_rate', new \App\Rate);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'turno_id'            => 'required',
            'description'         => 'required',
            'rid_id'              => 'required',
            'rid_code'            => 'required',
            'rid_description'     => 'required',
            'prezzo'              => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            Rate::create($request->all());
            return $this->createMessage("Added New rate","200");

        } catch (Exception $e) {
            \Log::info('Error creating Rate: '.$e);
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
            'turno_id'            => 'required',
            'description'         => 'required',
            'rid_id'              => 'required',
            'rid_code'            => 'required',
            'rid_description'     => 'required',
            'prezzo'              => 'required'
        ];


        $id_turniLiberi = $request->input('turno_id');
        $descrizione = $request->input('description');
        $rid_id = $request->input('rid_id');
        $riduzione_codice = $request->input('rid_code');
        $riduzione_description = $request->input('rid_description');
        $riduzione_riservataCoupon = $request->input('rid_riservataCoupon');
        $prezzo = $request->input('prezzo');

        $items_rate = array(
            'turno_id'            => $id_turniLiberi,
            'description'         => $descrizione,
            'rid_id'              => $rid_id,
            'rid_code'            => $riduzione_codice,
            'rid_description'     => $riduzione_description,
            'rid_riservataCoupon' => $riduzione_riservataCoupon,
            'prezzo' => $prezzo,
        );


        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $rate = Rate::where('id', $id)->firstOrFail();
            $this->authorize('update_rate', $rate);

            $ticket = Rate::update_riduzioni_price($items_rate,$id_turniLiberi,$rid_id);
            return $this->createMessage("Rate modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Rate: '.$e);
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
            $ticket = Rate::where('id', $id)->firstOrFail();
            $this->authorize('delete_rate', $ticket);
            $ticket->delete();
            return $this->createMessage("Rate deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Rate: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}
