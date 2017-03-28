<?php

namespace App\Http\Controllers;
use App;
use App\Identity;
use App\Library;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', new \App\Identity);

        //Get All Identity
        $input = $request->all();
        if (empty($input['page_s'])){
            $pagesize=Identity::all()->count();
        }else{
            $pagesize=$input['page_s'];
        }

        if (empty($input['sort'])){
            $field_order="id";
        }else{
            $field_order= $input['sort'];
        }

        $identity = DB::table('identity');
        //->join('identity_person', 'identity.id', '=', 'identity_person.identity_id');
        if (isset($field_order)){
            $identity->orderBy($field_order);
        }

        $results= $identity->paginate($pagesize,['*'],'page_n');
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
        $this->authorize('create_identity', new \App\Identity);

        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'name'    => 'required',
            'surname' => 'required',
            'email'   => 'required',
            'phone'   => 'required'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }

                $user=Identity::create(array(
                'name'      => Input::get('name'),
                'surname'   => Input::get('surname'),
                'email'     => Input::get('email'),
                'phone'     => Input::get('phone'),
            ));



            $lastInsertedId= $user->id; //get last inserted record's user id value

            $anagrafica_params = array(
                'cognome' => stripslashes($request->input('surname')),
                'nome' => stripslashes($request->input('name')),
                'cap' => stripslashes($request->input('postal_code')),
                'telCell' => stripslashes($request->input('phone')),
                'mail1' => stripslashes($request->input('email')),
                'azienda' => false,
                'sistemaOrigine' => 'GAG'
            );


            $regulus = new App\Library\Regulus();
            $id_user_regulus = $regulus->insertUser($anagrafica_params);

            $result= Identity::saveIdRegulus($id_user_regulus,$lastInsertedId);
             if (isset($result)){
                return $this->createMessage("Identity created","200");
              } else {
                return $this->createMessageError("Error saving user in Regulus","404");
              }

        } catch (Exception $e) {
            \Log::info('Error creating Identity: '.$e);
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
            $result = Identity::where('id', $id)->firstOrFail();
            $this->authorize('read_identity', $result);
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
            'name'    => 'required',
            'surname' => 'required',
            'email'   => 'required',
            'phone'   => 'required',
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $result = Identity::find($id);
            $this->authorize('update_identity', $result);
            $result->update($request->all());
            return $this->createMessage("Identity modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating Identity: '.$e);
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
            $result= Identity::where('id', $id)->firstOrFail();
            $this->authorize('delete_identity', $result);
            $result->delete();
            return $this->createMessage("Identity deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting Identity: '.$e);
            return $this->createMessageError($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), $e->getStatusCode());
        }
    }

}
