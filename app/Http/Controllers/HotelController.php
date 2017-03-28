<?php
namespace App\Http\Controllers;

use App;
use App\Hotel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use Log;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new Hotel);

        //Get All Hotels
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Hotel::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $hotel = DB::table('hotel');
        if (isset($field_order)){
            $hotel->orderBy($field_order);
        }

        $results= $hotel->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_hotel', new Hotel);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'title'          => 'required',
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
            $hotel = Hotel::create($request_vars);
            return $this->createMessage("Added New Hotel","200");

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
            $result = Hotel::where('id', $id)->firstOrFail();
            $this->authorize('read_hotel', $result);
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
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $hotel = Hotel::find($id);
            $this->authorize('update_hotel', $hotel);
            $request_vars = $request->all();
            foreach($request_vars as $k=>$v){
                $request_vars[$k] = stripslashes($v);
            }
            $hotel->update($request_vars);
            return $this->createMessage("Hotel modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Hotel: '.$e);
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
            $result= Hotel::where('id', $id)->firstOrFail();
            $this->authorize('delete_hotel', $result);
            $result->delete();
            return $this->createMessage("Hotel deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Hotel: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

}
