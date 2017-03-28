<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\TicketGroup;
use App\Ticket;

class TicketGroupController extends Controller
{
    /**
     * Return all tickets belongto an tickegroup
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get All TicketGroup
        $constraints = array_only($request->input(), 'ticket_sale_id');
        return response()->json(['data'=>TicketGroup::where($constraints)->get()]);
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
            $ticketgroup = TicketGroup::where('id', $id)->firstOrFail();
            return $this->createMessage($ticketgroup, "200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage(), $e->getStatusCode());
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
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = ['ticket_sale_id' => 'required', 'title'  => 'required', 'description' => 'required'];
        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            TicketGroup::create($request->all());
            return $this->createMessage("Added New TicketGroup","200");
        } catch (Exception $e) {
            \Log::info('Error creating TicketGroup: '.$e);
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

        $rules = ['ticket_sale_id' => 'required','title'  => 'required', 'description' => 'required'];
        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $ticketgroup = TicketGroup::find($id);
            $ticketgroup->update($request->all());
            return $this->createMessage("TicketGroup modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating TicketGroup: '.$e);
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
            $ticketgroup = TicketGroup::where('id', $id)->firstOrFail();
            $ticketgroup->delete();
            return $this->createMessage("TicketGroup deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting TicketGroup: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    /**
     * Return total tickets of a ticketgroup
     *
     */
    public function getTickets($id)
    {
        $ticketgroup= TicketGroup::find($id);
        $tickets        = $ticketgroup->tickets;
        $tickets_with_prices = array();
        foreach($tickets as $ticket){
            $pivot = $ticket->pivot;
            $ticket_with_price = $ticket;
            $ticket = Ticket::find($ticket->id);
            $ticket_with_price->price               =  $ticket->getPrice();
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
     * Return the value the single ticket of a ticketgroup
     *
     */
    public function getTicket($id, $ticket_id)
    {
        $ticketgroup= TicketGroup::find($id);
        $tickets = $ticketgroup->tickets();
        $ticket=$tickets->find($ticket_id);
        if(!$ticket)
        {
            return $this->createMessageError("Ticket not found","404");
        }
        return $this->createMessage($ticket,"200");
    }

    /**
     * Add values to pivot table, ticketgroup_id and ticket_id.
     *
     * @param  $ticketgroup_id  $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function addTicket(Request $request, $ticketgroup_id, $ticket_id)
    {
        $ticketgroup = TicketGroup::find($ticketgroup_id);
        if($ticketgroup)
        {
            $ticket = Ticket::find($ticket_id);
            if($ticket)
            {
                $tickets = $ticketgroup->tickets();
                if($tickets->find($ticket_id))
                {
                    return $this->createMessageError("The Ticket #$ticket_id can not added, is already in database", 409);
                }
                $ticketgroup->tickets()->attach($ticket_id, ['default_quantity' => $request->input('default_quantity')]);
                return $this->createMessage("True","200");
            }
            return $this->createMessageError('False - Ticket Not exist into DB', 404);
        }
        return $this->createMessageError('False - TicketGroup Not exist into DB', 404);
    }

    /**
     * Remove in the Pivot table (ticket_ticket__group), match ticketgroup_id and ticket_id.
     *
     * @param  int  ticketgroup_id, ticket_id
     * @return \Illuminate\Http\Response
     */
    public function deleteTicket($ticketgroup_id, $ticket_id)
    {
        $ticketgroup = TicketGroup::find($ticketgroup_id);
        if($ticketgroup)
        {
            $ticket = Ticket::find($ticket_id);
            if($ticket)
            {
                $tickets = $ticketgroup->tickets();
                if($tickets->find($ticket_id))
                {
                    $ticketgroup->tickets()->detach($ticket_id);
                    return $this->createMessage("true","200");
                }
            }
            return $this->createMessageError('False - Ticket Not exist into DB', 404);
        }
        return $this->createMessageError('False - TicketGroup Not exist into DB', 404);
    }
}
