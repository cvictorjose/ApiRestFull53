<?php
namespace App\Http\Controllers;

use App;
use App\RoomType;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use Log;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new RoomType);

        //Get All RoomTypes
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=RoomType::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $roomtype = DB::table('room_type');
        if (isset($field_order)){
            $roomtype->orderBy($field_order);
        }

        $results= $roomtype->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_roomtype', new RoomType);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'         => 'required',
            'persons'       => 'required',
        ];

        try {

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(), "400");
            }
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $roomtype = RoomType::create($request_vars);
            return $this->createMessage("Added New RoomType","200");

        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
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
            $result = RoomType::where('id', $id)->firstOrFail();
            $this->authorize('read_roomtype', $result);
            return $this->createMessage($result,"200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
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
            'title'          => 'required',
            'persons'        => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $roomtype = RoomType::find($id);
            $this->authorize('update_roomtype', $roomtype);
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $roomtype->update($request_vars);
            return $this->createMessage("RoomType modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating RoomType: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
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
            $result= RoomType::where('id', $id)->firstOrFail();
            $this->authorize('delete_roomtype', $result);
            $result->delete();
            return $this->createMessage("RoomType deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting RoomType: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

}
