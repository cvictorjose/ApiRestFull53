<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use App\ServiceGroup;

class ServiceGroupController extends Controller
{
    /**
     * Return all tickets belongto an tickegroup
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get All ServiceGroup
        return response()->json(['data'=>ServiceGroup::all()]);
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
            $servicegroup = ServiceGroup::where('id', $id)->firstOrFail();
            return $this->createMessage($servicegroup,"200");
            // return response()->json(['data'=>$ticket]);

        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
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
            $servicegroup = ServiceGroup::where('id', $id)->firstOrFail();
            $servicegroup->delete();
            return $this->createMessage("ServiceGroup deleted successfully","200");
        } catch (Exception $e) {
            \Log::info('Error deleting ServiceGroup: '.$e);
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

        $rules = ['ticket_sale_id' => 'required', 'title'  => 'required', 'description' => 'required'];
        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            $servicegroup = ServiceGroup::find($id);
            $servicegroup->update($request->all());
            return $this->createMessage("ServiceGroup modified successfully","200");

        } catch (Exception $e) {
            \Log::info('Error updating ServiceGroup: '.$e);
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
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = ['ticket_sale_id' => 'required', 'title'  => 'required', 'description' => 'required'];
        try {
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->createMessageError($validator->errors()->all(),"404");
            }
            ServiceGroup::create($request->all());
            return $this->createMessage("Added New ServiceGroup","200");
        } catch (Exception $e) {
            \Log::info('Error creating ServiceGroup: '.$e);
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }


    /**
     *  Return all services with category (id)
     *  Url:servicesgroups/{id}/services
     */
    public function getServices($id)
    {
        $servicegroup= ServiceGroup::find($id);
        $services = array();
        foreach($servicegroup->services as $service){
            $pivot                        = $service->pivot;
            $service->default_quantity    = $pivot->default_quantity;
            $services[]                   = $service;
        }
        if(!$servicegroup)
        {
            return $this->createMessageError("ServiceGroup not found","404");
        }
        return $this->createMessage($services,"200");
    }


    /**
     * Return the value the single service of a ServiceGroup
     *
     */
    public function getService($id,$service_id)
    {
        $ticketgroup= ServiceGroup::find($id);
        $tickets = $ticketgroup->services();
        $ticket=$tickets->find($service_id);
        if(!$ticket)
        {
            return $this->createMessageError("Service not found","404");
        }
        return $this->createMessage($ticket,"200");
    }


    /**
     * Add values to pivot table (servicegroup_service), the value:ServiceGroup_id and Service_id.
     *
     * @param  int  servicegroup_id, service_id
     * @return \Illuminate\Http\Response
     */
    public function addService(Request $request, $servicegroup_id, $service_id)
    {
        $servicegroup = ServiceGroup::find($servicegroup_id);
        if($servicegroup)
        {
            $ticket = Service::find($service_id);
            if($ticket)
            {
                $tickets = $servicegroup->services();
                if($tickets->find($service_id))
                {
                    return $this->createMessageError("The Service #$service_id can not added, is already in database",
                        409);
                }
                $servicegroup->services()->attach($service_id, ['default_quantity' => $request->input('default_quantity')]);
                return $this->createMessage("True","200");
            }
            return $this->createMessageError('False - Service Not exist into DB', 404);
        }
        return $this->createMessageError('False - ServiceGroup Not exist into DB', 404);
    }


    /**
     * Remove in the Pivot table (service_service_group), match servicegroup_id and service_id.
     *
     * @param  int  servicegroup_id, service_id
     * @return \Illuminate\Http\Response
     */
    public function deleteService($servicegroup_id, $service_id)
    {
        $servicegroup = ServiceGroup::find($servicegroup_id);
        if($servicegroup)
        {
            $service = Service::find($service_id);
            if($service)
            {
                $service = $servicegroup->services();
                if($service->find($service_id))
                {
                    $servicegroup->services()->detach($service_id);
                    return $this->createMessage("true","200");
                }
            }
            return $this->createMessageError('False - Service Not exist into DB', 404);
        }
        return $this->createMessageError('False - ServiceGroup Not exist into DB', 404);
    }

}
