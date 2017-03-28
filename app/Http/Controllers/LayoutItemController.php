<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Service;
use App\Link;
use App\LayoutItem;
use Illuminate\Http\Request;
use DB;

class LayoutItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\LayoutItem);

        //Get All Layouts
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=LayoutItem::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $layout_item = DB::table('layout_item');
        if (isset($field_order)){
            $layout_item->orderBy($field_order);
        }
        $results= $layout_item->paginate($pagesize,['*'],'page_n');
        $results= $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));

        foreach($results as $r){
            try{
                $l = LayoutItem::find($r->id);
                $r->title = $l->title();
                $r->description = $l->description();
                switch($r->type){
                    case 'ticket':
                        $obj = Ticket::where('layout_item_id', $r->id)->first();
                        $r->ticket = $obj;
                        $r->ticket->rate = $obj->rate;
                        break;
                    case 'service':
                        $obj = Service::where('layout_item_id', $r->id)->first();
                        $r->service = $obj;
                        break;
                    case 'link':
                        $obj = Link::where('layout_item_id', $r->id)->first();
                        $r->link = $obj;
                        break;
                }
            }catch(\Exception $e){
                unset($r);
            }
        }

        return $results;
    }
}
