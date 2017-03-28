<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Rate;

use Illuminate\Support\Facades\App;


class TicketRateController extends Controller
{
    /**
     * Return All Tickets with an Rate_id specific.
     *
     */
    public function index($id)
    {
       $rate = Rate::find($id);
        if(!$rate)
        {
            return $this->createMessageError("Ticket not found","404");
        }
        return $this->createMessage($rate->ticket,"200");
    }

    /**
     * Return all tickets belong to only rate
     *
     */
    public function rateTicket($id)
    {
        $ticket = Ticket::find($id);
        if(!$ticket)
        {
            return $this->createMessageError("Ticket(s) not found","404");
        }
        return $this->createMessage($ticket->rate,"200");
    }

}
