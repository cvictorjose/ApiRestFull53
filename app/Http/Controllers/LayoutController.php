<?php

namespace App\Http\Controllers;

use App\Layout;
use App\LayoutSection;
use App\LayoutSectionCategory;
use Illuminate\Http\Request;
use App\TicketSale;
use DB;

class LayoutController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Layout);

        //Get All Layouts
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Layout::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $layout = DB::table('layout');
        if (isset($field_order)){
            $layout->orderBy($field_order);
        }
        $results= $layout->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_layout', new \App\Layout);

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
            Layout::create($request->all());
            return $this->createMessage("Added New Layout","200");

        } catch (Exception $e) {
            \Log::info('Error creating Layout: '.$e);
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
            $layout = Layout::where('id', $id)->firstOrFail();
            $this->authorize('read_layout', $layout);
            return $this->createMessage($layout,"200");
            // return response()->json(['data'=>$layout]);

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
            $layout = Layout::find($id);
            $this->authorize('update_layout', $layout);
            $layout->update($request->all());
            return $this->createMessage("Layout modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Layout: '.$e);
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
            $layout = Layout::where('id', $id)->firstOrFail();
            $this->authorize('delete_layout', $layout);
            $layout->delete();
            return $this->createMessage("Layout deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Layout: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    /**
     * Return a singleLayout
     *
     */
    public function getLayout($id)
    {
        $ticketSale= TicketSale::find($id);
        if(!$ticketSale)
        {
            return $this->createMessageError("TicketSale not found","404");
        }
        return $this->createMessage($ticketSale->singleLayout,"200");
    }


    /**
     * Return all sections belong to a layout
     * Url:ticketsale/2/layouts/1/sections
     */
    public function getSections($id, $layout_id)
    {
        $ticketSale= TicketSale::find($id);
        if($ticketSale)
        {
            $layouts = $ticketSale->getLayouts();
            $layout=$layouts->find($layout_id);
            if($layout)
            {
                $sections = Layout::where('layout_id', $layout_id)->get();
                return $this->createMessage($sections,"200");
            }
            return $this->createMessageError('Layout not found', 404);
        }
        return $this->createMessageError('TicketSale not found', 404);
    }

    /**
     * Returns LayoutSection objects binded to the current Layout
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getLayoutSections($id)
    {
        $layout   = Layout::find($id);
        $layout_sections = $layout->layout_sections;
        // $tickets_with_prices = array();
        // foreach($tickets as $ticket){
        //     $pivot = $ticket->pivot;
        //     $ticket_with_price = $ticket;
        //     $ticket = Ticket::find($ticket->id);
        //     $ticket_with_price->price               =  $ticket->getPrice();
        //     $ticket_with_price->default_quantity    =  $pivot->default_quantity;
        //     $tickets_with_prices[]                  =  $ticket_with_price;
        // }
        if(!$layout)
        {
            return $this->createMessageError("Layout not found", "415");
        }
        return $this->createMessage($layout_sections, "200");
    }

    /**
     * Returns LayoutCategory objects binded to the current Layout
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getLayoutCategories($id) // id from GET/index will be the one of layout_category
    {
        $layout   = Layout::find($id);
        $layout_sections = $layout->layout_sections;
        $layout_categories = array();
        foreach($layout_sections as $layout_section){
            foreach($layout_section->layout_categories as $layout_category){
                $layout_categories[] = $layout_category;
            }
        }
        // $tickets_with_prices = array();
        // foreach($tickets as $ticket){
        //     $pivot = $ticket->pivot;
        //     $ticket_with_price = $ticket;
        //     $ticket = Ticket::find($ticket->id);
        //     $ticket_with_price->price               =  $ticket->getPrice();
        //     $ticket_with_price->default_quantity    =  $pivot->default_quantity;
        //     $tickets_with_prices[]                  =  $ticket_with_price;
        // }
        if(!$layout)
        {
            return $this->createMessageError("Layout not found", "415");
        }
        return $this->createMessage($layout_categories, "200");
    }

    /**
     * Returns LayoutSectionCategory objects binded to the current Layout
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getLayoutSectionCategories($id) // id from GET/index will be the one of layout_section_category (pivot)
    {
        $layout   = Layout::find($id);
        $layout_sections = $layout->layout_sections;
        $layout_section_categories = array();
        foreach($layout_sections as $layout_section){
            foreach($layout_section->layout_categories as $layout_category){
                $pivot = $layout_category->pivot;
                $layout_section_category = $layout_category;
                $layout_section_category->id = $pivot->id;
                $layout_section_categories[] = $layout_section_category;
            }
        }
        // $tickets_with_prices = array();
        // foreach($tickets as $ticket){
        //     $pivot = $ticket->pivot;
        //     $ticket_with_price = $ticket;
        //     $ticket = Ticket::find($ticket->id);
        //     $ticket_with_price->price               =  $ticket->getPrice();
        //     $ticket_with_price->default_quantity    =  $pivot->default_quantity;
        //     $tickets_with_prices[]                  =  $ticket_with_price;
        // }
        if(!$layout)
        {
            return $this->createMessageError("Layout not found", "415");
        }
        return $this->createMessage($layout_section_categories, "200");
    }

    /**
     * Return all Items belong to a section
     * Url:ticketsale/2/layouts/1/sections/items
     */
    public function duplicate($id)
    {
        $layout             = Layout::find($id);
        $new_layout         = Layout::create([  'title'         =>  sprintf('%s (copia)', $layout->title), 
                                                'ticket_sale_id'=>  $layout->ticket_sale_id ]);
        if($new_layout){
            foreach($layout->layout_sections as $layout_section){
                $new_layout_section = LayoutSection::create([   'title'     =>  $layout_section->title,
                                                                'layout_id' =>  $new_layout->id,
                                                                'icon'      =>  $layout_section->icon ]);
                if($new_layout_section){
                    foreach($layout_section->layout_section_categories as $layout_section_category){
                        $new_layout_section_category = LayoutSectionCategory::create([  
                                                                'layout_section_id' =>  $new_layout_section->id,
                                                                'layout_category_id'=>  $layout_section_category->layout_category_id ]);
                        if($new_layout_section_category){
                            foreach($layout_section_category->layout_items as $layout_item){
                                $new_layout_section_category->layout_items()->attach($layout_item->id, ['default_quantity' => $layout_item->pivot->default_quantity]);
                            }
                        }
                    }
                }
            }
            return $this->createMessage($new_layout->id, '200');
        }else{
            return $this->createMessage('Layout not generated', "500");
        }
    }

    /**
     * Return all Items belong to a section
     * Url:ticketsale/2/layouts/1/sections/items
     */
    public function getItems($id, $layout_id, $section_id)
    {
        $ticketSale= TicketSale::find($id);
        if($ticketSale)
        {
            $layouts = $ticketSale->getLayouts();
            $layout=$layouts->find($layout_id);
            if($layout)
            {
                $section = Layout::find($section_id);
                return $this->createMessage($section->items,"200");
            }
            return $this->createMessageError('Layout not found', 404);
        }
        return $this->createMessageError('TicketSale not found', 404);
    }
    /**
     * Return the item value
     * Url:ticketsale/2/layouts/1/sections/2/items/6
     */
    public function getItemsValue($id, $layout_id, $section_id, $item_id)
    {
        $ticketSale= TicketSale::find($id);
        if($ticketSale)
        {
            $layouts = $ticketSale->getLayouts();
            $layout=$layouts->find($layout_id);
            if($layout)
            {
                $section = Layout::find($section_id);
                if($section)
                {
                    $items=$section->items();
                    $item=$items->find($item_id);
                    return $this->createMessage($item,"200");
                }
                return $this->createMessageError('Section not found', 404);
            }
            return $this->createMessageError('Layout not found', 404);
        }
        return $this->createMessageError('TicketSale not found', 404);
    }
}
