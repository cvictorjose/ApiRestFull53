<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ticket;
use DB;
use Illuminate\Support\Facades\Input;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Ticket);

        //Get All Tickets
       $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Ticket::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="ticket.id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('ticket');
            //->join('rate', 'ticket.rate_id', '=', 'rate.id');
            if (isset($field_order)){
                $ticket->orderBy($field_order);
            }
        $results = $ticket->paginate($pagesize,['*'],'page_n');
        $results = $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
        foreach($results as $r){
            $t = Ticket::find($r->id);
            $r->rate = $t->rate;
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
        $this->authorize('create_ticket', new \App\Ticket);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $created_at=Carbon::now();
        $updated_at=Carbon::now();

        $rules = [
            'title'               => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }

            //Insert a new product - type:ticket
            // $array_product= ['type' => "ticket"];
            // $product_id = Product::create($array_product)->id;

            // //Insert a new ticket + product_id
            // $data = Input::all();
            // $array_ticket = array();
            // $array_ticket= [
            //         'product_id' => $product_id,
            //         'title' => $data['title'],
            //         'description' => $data['description'],
            //         'created_at'=>$created_at,'updated_at'=>$updated_at
            //     ];
            // $tickets[] = $array_ticket;
            // DB::table('ticket')->insert($tickets);
            Ticket::create($request->all());
            return $this->createMessage("Added New Ticket", "200");

        } catch (Exception $e) {
            \Log::info('Error creating Ticket: '.$e);
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
            $ticket = Ticket::where('id', $id)->firstOrFail();
            $this->authorize('read_ticket', $ticket);

            return $this->createMessage($ticket,"200");
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
            'title'        => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $ticket = Ticket::find($id);
            $this->authorize('update_ticket', $ticket);

            $request_vars = $request->all();
            $ticket->update($request_vars);
            return $this->createMessage(print_r($request_vars, true)."Ticket modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Ticket: '.$e);
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
            $ticket = Ticket::where('id', $id)->firstOrFail();
            $this->authorize('delete_ticket', $ticket);
            $ticket->delete();
            return $this->createMessage("Ticket deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Ticket: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

}
