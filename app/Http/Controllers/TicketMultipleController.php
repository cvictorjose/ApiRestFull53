<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Ticket;

class TicketMultipleController extends Controller
{
    /**
     * Store Multi Tickets array in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $created_at=Carbon::now();
        $updated_at=Carbon::now();

        $info_from_wp=$request->all();

        $array_data = array();
        foreach ($info_from_wp as $key => $value) {
            //Must Fields
            if (!isset($value["title"]) ){
                return $this->createMessageError("Attribute Tittle is missing","415");
            }

            if (!isset($value["description"]) ){
                return $this->createMessageError("Attribute description is missing","415");
            }

            if (!isset($value["rate_id"]) ){
                return $this->createMessageError("Attribute rate_id is missing","415");
            }

            //Optional Field
            if (!isset($value["ticket_category_id"]) ){$att4=NULL;
            }else{
                $att4=$value["ticket_category_id"];
            }

            $array_data= ['title' => $value["title"], 'description' => $value["description"], 'rate_id' =>
                $value["rate_id"], 'ticket_category_id' => $att4,
                'created_at'=>$created_at,'updated_at'=>$updated_at ];
            $tickets[] = $array_data;
        }

        if (isset($tickets)) {
            try {
                DB::table('ticket')->insert($tickets);
                return $this->createMessage("Tickets added successfully","200");
            } catch (Exception $e) {
                \Log::info('Error deleting Ticket: '.$e);
                return $this->createMessageError($e->getMessage(),$e->getStatusCode());
            }
        }return $this->createMessageError("Error Insert Array","415");
    }


    /**
     * Update Multi Tickets array in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $created_at=Carbon::now();
        $updated_at=Carbon::now();

        $info_from_wp=$request->all();

        $array_data = array();
        foreach ($info_from_wp as $key => $value) {
            //Must Fields
            if (!isset($value["id"]) ){
                return $this->createMessageError("Attribute ID is missing","415");
            }

            if (!isset($value["title"]) ){
                return $this->createMessageError("Attribute Tittle is missing","415");
            }

            if (!isset($value["description"]) ){
                return $this->createMessageError("Attribute description is missing","415");
            }

            if (!isset($value["rate_id"]) ){
                return $this->createMessageError("Attribute rate_id is missing","415");
            }

            //Optional Field
            if (!isset($value["ticket_category_id"]) ){$att4=NULL;
            }else{
                $att4=$value["ticket_category_id"];
            }

            $array_data= [
                'id' => $value["id"],
                'title' => $value["title"], 'description' => $value["description"],
                'rate_id' => $value["rate_id"], 'ticket_category_id' => $att4,
                'created_at'=>$created_at,'updated_at'=>$updated_at ];
            $tickets[] = $array_data;
        }

        foreach ($tickets as $key => $value) {
            $id= $value["id"];
            $ticket_category_id=$value["ticket_category_id"];
            $ticket=$value["title"];
            $description=$value["description"];
            $rate_id=$value["rate_id"];

            $update = Ticket::where('id', '=', $id)->first();
            if (isset($ticket_category_id)){
                $update->ticket_category_id = $ticket_category_id;
            }
            $update->title = $ticket;
            $update->description = $description;
            $update->rate_id = $rate_id;

            $update->created_at = $created_at;
            $update->updated_at = $created_at;

            $update->save();

        }return $this->createMessage("Tickets updated successfully","200");
    }
}
