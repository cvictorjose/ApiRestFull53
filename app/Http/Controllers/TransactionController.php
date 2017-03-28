<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use DB;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Transaction);

        //Get All Tickets
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Transaction::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $ticket = DB::table('transaction');
        if (isset($field_order)){
            $ticket->orderBy($field_order);
        }
        $results= $ticket->paginate($pagesize,['*'],'page_n');
        $results= $results->appends(array('sort' => $field_order, 'page_s' => $pagesize ));
        return $results;
    }
}
