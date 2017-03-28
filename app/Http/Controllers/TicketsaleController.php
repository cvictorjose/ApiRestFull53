<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LayoutCategory;
use App\TicketSale;
use App\TicketGroup;
use App\Ticket;
use App\Service;
use App\Link;
use DB;

class TicketSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get All Tickets
        $this->authorize('index', new \App\TicketSale);

        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=TicketSale::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order = "id";
        }else{
            $field_order = $input['sort'];
        }

        $ticket = DB::table('ticket_sale');
        if (isset($field_order)){
            $ticket->orderBy($field_order);
        }
        $results = $ticket->paginate($pagesize,['*'],'page_n');
        $results = $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
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
            $ticket = TicketSale::where('id', $id)->firstOrFail();
            $this->authorize('read_ticketsale', $ticket);
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
        $this->authorize('create_ticketsale', new \App\TicketSale);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'               => 'required',
            'description'         => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $ticketsale = TicketSale::create($request->all());
            if(!($ticketsale->ticket_group_id>0)){
                $ticketgroup = new \App\Ticketgroup();
                $ticketgroup->title          = sprintf("%s Gruppo 1", $request->input('title'));
                $ticketgroup->description    = sprintf("%s Gruppo 1 Desc", $request->input('title'));
                $ticketgroup->ticket_sale_id = $ticketsale->id;
                $ticketgroup->save();
                $ticketsale->ticket_group_id = $ticketgroup->id;
                $ticketsale->save();
            }
            return $this->createMessage("Added New TicketSale","200");

        } catch (Exception $e) {
            \Log::info('Error creating TicketSale: '.$e);
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
            'description'     => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            /*if(!($request->input('ticket_group_id')>0)){
                throw Exception('TicketGroup cannot be empty');
            }*/
            $ticketsale = TicketSale::find($id);
            $this->authorize('update_ticketsale', $ticketsale);
            $ticketsale->update($request->all());
            return $this->createMessage("TicketSale modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating TicketSale: '.$e);
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
            $ticket = TicketSale::where('id', $id)->firstOrFail();
            $this->authorize('delete_ticketsale', $ticket);
            $ticket->delete();
            return $this->createMessage("TicketSale deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting TicketSale: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    /**
     * Return all ticketgroups
     *
     */
    public function getTicketGroups($id)
    {
        $ticketSale= TicketSale::find($id);
        if(!$ticketSale)
        {
            return $this->createMessageError("TicketSale not found","404");
        }
        return $this->createMessage($ticketSale->ticketGroups,"200");
    }


    /**
     * Return the value the single ticketgroup
     *
     */
    public function getTicketGroup($id,$ticketgroup_id)
    {
        $ticketsales= TicketSale::find($id);
        $ticketgroups = $ticketsales->ticketGroups();
        $ticket=$ticketgroups->find($ticketgroup_id);
        if(!$ticket)
        {
            return $this->createMessageError("Ticket not found","404");
        }
        return $this->createMessage($ticket,"200");
    }

    /**
     * Return the value the tickets related to the currenly active TicketGroup
     *
     */
    public function getTickets($id)
    {
        $ticketsale     = TicketSale::find($id);
        $ticketgroup    = $ticketsale->defaultTicketGroup();
        $tickets        = $ticketgroup->tickets;
        $tickets_with_prices = array();
        foreach($tickets as $ticket){
            $pivot = $ticket->pivot;
            $ticket_with_price = $ticket;
            $ticket_with_price->price               =  $ticket->getPrice();
            $ticket_with_price->cat                 =  $ticket->category->title;
            $ticket_with_price->default_quantity    =  $pivot->default_quantity;
            $tickets_with_prices[]                  =  $ticket_with_price;
        }
        if(!$ticketgroup)
        {
            return $this->createMessageError("TicketGroup not found","404");
        }
        return $this->createMessage($tickets_with_prices,"200");
    }

    /**
     * Return the serices connected to the currenly active ServiceGroup
     *
     */
    public function getServices($id)
    {
        $ticketsale     = TicketSale::find($id);
        $servicegroup   = $ticketsale->defaultServiceGroup();
        if(!$servicegroup){
            return $this->createMessageError("ServiceGroup not found","404");
        }else{
            $services       = $servicegroup->services->sortBy('service_category_id');
            $services_array = array();
            foreach($services as $service){
                $pivot              =     $service->pivot;
                $s                  =     $service;
                $s->cat             =     $service->category->title;
                $s->default_quantity=     $pivot->default_quantity;
                $services_array[]   =     $s;
            }
            return $this->createMessage($services_array, "200");
        }
    }

    /**
     * Return the entire layout to populate the first web page of the ticketsale
     *
     */
    public function getLayout($id)
    {
        try{
            $ticketsale = TicketSale::find($id);
            $layout     = $ticketsale->getExpandedLayout();
            if(!$layout){
                return $this->createMessageError("Expanded layout not available", "500");
            }else{
                return $this->createMessage($layout, "200");
            }
        }catch(\Exception $e){
            return $this->createMessageError($e->getMessage(), "400");
        }
    }

    /**
     * Return all behaviours
     *
     */
    public function getBehaviours($id)
    {
        $ticketSale = TicketSale::find($id);
        if(!$ticketSale)
        {
            return $this->createMessageError("TicketSale not found", "400");
        }
        $layout = $ticketSale->getLayout();
        $behaviours = $ticketSale->behaviours;
        if($layout->coupon_behaviour){
            if($layout->coupon_behaviour->ticket_sale_id!=$id){
                $behaviours[] = $layout->coupon_behaviour;
            }
        }
        foreach($behaviours as $b){
            $behaviour_layout_items = \App\BehaviourLayoutItem::where('behaviour_id', $b->id)->get();
            $origins = array();
            foreach($behaviour_layout_items as $bli){
                if($bli->use == 'origin'){
                    $origins[] = $bli->layout_item_id;
                }elseif($bli->use == 'destination'){
                    $destination = $bli->layout_item_id;
                }
            }
            $b->behaviour_layout_items = $behaviour_layout_items;
            $b->origins = $origins;
            $b->destination = $destination;
        }
        return $this->createMessage($behaviours, "200");
    }

}
