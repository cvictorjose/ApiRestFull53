<?php

namespace App\Http\Controllers;

use App\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\TicketCategory);

        //Get All TicketCategory
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=TicketCategory::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticketcategory = DB::table('ticket_category');
        if (isset($field_order)){
            $ticketcategory->orderBy($field_order);
        }
        $results= $ticketcategory->paginate($pagesize,['*'],'page_n');
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
            $result = TicketCategory::where('id', $id)->firstOrFail();
            $this->authorize('read_ticketcategory', $result);
            return $this->createMessage($result,"200");
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
        $this->authorize('create_ticketcategory', new \App\TicketCategory);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = ['title'  => 'required', 'description' => 'required'];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            TicketCategory::create($request->all());
            return $this->createMessage("Added New TicketCategory","200");

        } catch (Exception $e) {
            \Log::info('Error creating TicketCategory: '.$e);
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

        $rules = ['title'  => 'required', 'description' => 'required'];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $result = TicketCategory::find($id);
            $this->authorize('update_ticketcategory', $result);
            $result->update($request->all());
            return $this->createMessage("TicketCategory modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating TicketCategory: '.$e);
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
            $result = TicketCategory::where('id', $id)->firstOrFail();
            $this->authorize('delete_ticketcategory', $result);
            $result->delete();
            return $this->createMessage("TicketCategory deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting TicketCategory: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }




    /**
     * Return total tickets belong to category (id)
     *
     */
    public function getTickets($id)
    {
        $ticketgroup= TicketCategory::find($id);
        if(!$ticketgroup)
        {
            return $this->createMessageError("TicketCategory not found","404");
        }
        return $this->createMessage($ticketgroup->tickets,"200");
    }
}
