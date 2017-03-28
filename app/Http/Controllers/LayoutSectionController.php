<?php

namespace App\Http\Controllers;

use App\LayoutSection;
use App\LayoutCategory;
use Illuminate\Http\Request;
use App\TicketSale;
use DB;

class LayoutSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new LayoutSection);

        //Get All layoutsections
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=LayoutSection::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $layoutsection = DB::table('layout_section');
        if (isset($field_order)){
            $layoutsection->orderBy($field_order);
        }
        $results = $layoutsection->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_layoutsection', new \App\LayoutSection);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'  => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            LayoutSection::create($request->all());
            return $this->createMessage("Added New LayoutSection","200");

        } catch (Exception $e) {
            \Log::info('Error creating LayoutSection: '.$e);
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
            $layoutsection = LayoutSection::where('id', $id)->firstOrFail();
            $this->authorize('read_layoutsection', $layoutsection);
            return $this->createMessage($layoutsection,"200");
            // return response()->json(['data'=>$layoutsection]);

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
            'title'  => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $layout_section = LayoutSection::find($id);
            $this->authorize('update_layoutsection', $layout_section);
            $layout_section->update($request->all());
            return $this->createMessage("LayoutSection modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating LayoutSection: '.$e);
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
            $layoutsection = LayoutSection::where('id', $id)->firstOrFail();
            $this->authorize('delete_layoutsection', $layoutsection);
            $layoutsection->delete();
            return $this->createMessage("LayoutSection deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting LayoutSection: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    /**
     * Returns LayoutCategory objects binded to the current LayoutSection
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getLayoutCategories($id)
    {
        $layout_section    = LayoutSection::find($id);
        $layout_categories = $layout_section->layout_categories;
        // $tickets_with_prices = array();
        // foreach($tickets as $ticket){
        //     $pivot = $ticket->pivot;
        //     $ticket_with_price = $ticket;
        //     $ticket = Ticket::find($ticket->id);
        //     $ticket_with_price->price               =  $ticket->getPrice();
        //     $ticket_with_price->default_quantity    =  $pivot->default_quantity;
        //     $tickets_with_prices[]                  =  $ticket_with_price;
        // }
        if(!$layout_section)
        {
            return $this->createMessageError("LayoutSection not found", "415");
        }
        return $this->createMessage($layout_categories, "200");
    }

    /**
     * Add layout_category_id to layout_section.
     *
     * @param  $layout_section_id  $layout_category_id
     * @return \Illuminate\Http\Response
     */
    public function addLayoutCategory(Request $request, $id, $layout_category_id)
    {
        $layout_section    = LayoutSection::find($id);
        if($layout_section)
        {
            $layout_category = LayoutCategory::find($layout_category_id);
            if($layout_category)
            {
                $layout_categories = $layout_section->layout_categories;
                if($layout_categories->find($layout_category_id))
                {
                    return $this->createMessageError("The LayoutCategory #$layout_category_id can not added, is already in database", 409);
                }
                $layout_section->layout_categories()->attach($layout_category_id);
                return $this->createMessage("True", "200");
            }
            return $this->createMessageError('False - LayoutCategory Not exist into DB', 400);
        }
        return $this->createMessageError('False - LayoutSection Not exist into DB', 400);
    }

    /**
     * Remove layout_category from layout_section.
     *
     * @param  int  layout_section_id, layout_category_id
     * @return \Illuminate\Http\Response
     */
    public function deleteLayoutCategory($id, $layout_category_id)
    {
        $layout_section    = LayoutSection::find($id);
        if($layout_section)
        {
            $layout_category = LayoutCategory::find($layout_category_id);
            if($layout_category)
            {
                $layout_categories = $layout_section->layout_categories;
                if($layout_categories->find($layout_category_id))
                {
                    $layout_section->layout_categories()->detach($layout_category_id);
                    return $this->createMessage("True", "200");
                }
            }
            return $this->createMessageError('False - LayoutCategory Not exist into DB', 400);
        }
        return $this->createMessageError('False - LayoutSection Not exist into DB', 400);
    }
}
