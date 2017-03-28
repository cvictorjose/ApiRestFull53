<?php

namespace App\Http\Controllers;

use App\LayoutSectionCategory;
use App\LayoutItem;
use Illuminate\Http\Request;
use DB;

class LayoutSectionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$this->authorize('index', new \App\LayoutItem);

        //Get All Layouts
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=LayoutSectionCategory::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $layout_section_category = DB::table('layout_section_category');
        if (isset($field_order)){
            $layout_section_category->orderBy($field_order);
        }
        $results = $layout_section_category->paginate($pagesize,['*'],'page_n');
        $results = $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));

        // foreach($results as $r){
        //     $l = LayoutSectionCategory::find($r->id);
        //     $r->title = $l->title();
        //     $r->description = $l->description();
        // }

        return $results;
    }

    /**
     * Returns LayoutItem objects binded to the current LayoutSectionCategory
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getLayoutItems($id)
    {
        $layout_section_category    = LayoutSectionCategory::find($id);
        if(!$layout_section_category)
        {
            return $this->createMessageError("LayoutSectionCategory not found", "400");
        }else{
            $layout_items       = $layout_section_category->layout_items;
            $layout_items_q = array();
            foreach($layout_items as $layout_item){
                $pivot = $layout_item->pivot;
                $layout_item_q = $layout_item;
                $layout_item_q->default_quantity   =  $pivot->default_quantity;
                $layout_item_q->min_quantity       =  $pivot->min_quantity;
                $layout_item_q->max_quantity       =  $pivot->max_quantity;
                $layout_items_q[]                  =  $layout_item_q;
            }
            return $this->createMessage($layout_items_q, "200");
        }
    }

    /**
     * Add layout_item to layout_section_category.
     *
     * @param  $layout_section_category_id  $layout_item_id
     * @return \Illuminate\Http\Response
     */
    public function addLayoutItem(Request $request, $id, $layout_item_id)
    {
        $layout_section_category    = LayoutSectionCategory::find($id);
        if($layout_section_category)
        {
            $layout_item = LayoutItem::find($layout_item_id);
            if($layout_item)
            {
                $layout_items = $layout_section_category->layout_items;
                if($layout_items->find($layout_item_id))
                {
                    return $this->createMessageError("The LayoutItem #$layout_item_id can not added, is already in database", 409);
                }
                $layout_section_category->layout_items()->attach($layout_item_id, [
                    'default_quantity'  =>  $request->input('default_quantity'), 
                    'min_quantity'      =>  $request->input('min_quantity'),
                    'max_quantity'      =>  $request->input('max_quantity')]);
                return $this->createMessage("True", "200");
            }
            return $this->createMessageError('False - LayoutItem Not exist into DB', 400);
        }
        return $this->createMessageError('False - LayoutItem Not exist into DB', 400);
    }

    /**
     * Remove layout_item from layout_section_category.
     *
     * @param  $layout_section_category_id  $layout_item_id
     * @return \Illuminate\Http\Response
     */
    public function deleteLayoutItem($id, $layout_item_id)
    {
        $layout_section_category    = LayoutSectionCategory::find($id);
        if($layout_section_category)
        {
            $layout_item = LayoutItem::find($layout_item_id);
            if($layout_item)
            {
                $layout_items = $layout_section_category->layout_items;
                if($layout_items->find($layout_item_id))
                {
                    $layout_section_category->layout_items()->detach($layout_item_id);
                    return $this->createMessage("True", "200");
                }
            }
            return $this->createMessageError('False - LayoutItem Not exist into DB', 400);
        }
        return $this->createMessageError('False - LayoutItem Not exist into DB', 400);
    }
}
