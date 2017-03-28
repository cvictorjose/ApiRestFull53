<?php

namespace App\Http\Controllers;

use App\Link;
use DB;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new Link);

        //Get All links
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Link::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $link = DB::table('link');
        if (isset($field_order)){
            $link->orderBy($field_order);
        }
        $results= $link->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_link', new \App\Link);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'  => 'required',
            'url'    => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            Link::create($request->all());
            return $this->createMessage("Added New Link","200");

        } catch (Exception $e) {
            \Log::info('Error creating Link: '.$e);
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
            $link = Link::where('id', $id)->firstOrFail();
            $this->authorize('read_link', $link);
            return $this->createMessage($link,"200");
            // return response()->json(['data'=>$link]);

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
            'url'    => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $Link = Link::find($id);
            $this->authorize('update_link', $Link);
            $Link->update($request->all());
            return $this->createMessage("Link modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Link: '.$e);
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
            $link = Link::where('id', $id)->firstOrFail();
            $this->authorize('delete_link', $link);
            $link->delete();
            return $this->createMessage("Link deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Link: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }
}
