<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\File;

use App;
use App\Http\Requests;
use App\Library;
use Dompdf\Dompdf;
use Storage;
use Response;
class RegulusController extends Controller
{
    /**
     * Connection soap test
     *
     * @return \Illuminate\Http\Response
     */
    public function turniliberi( Request $request )
    {
        $this->authorize('index', new \App\Rate);
        $regulus = new App\Library\Regulus();
        $result = $regulus->getListaTurniLiberi();
        return json_encode( $result );
    }

    public function turnolibero( $id )
    {
        $this->authorize('index', new \App\Rate);
        $regulus = new App\Library\Regulus() ;
        $result = $regulus->getDettaglioTurnoLibero( $id );
        return json_encode( $result  );
    }

    public function couponCheck( $idTurnoLibero, $couponCode ) // DEBUG method
    {
        $this->authorize('index', new \App\Rate);
        $regulus = new App\Library\Regulus() ;
        $result = $regulus->couponCheck( $idTurnoLibero, $couponCode );
        return print_r($result, true);
    }

    public function couponCheckRate( $idTurnoLibero, $couponCode, $ridCode ) // DEBUG method
    {
        $this->authorize('index', new \App\Rate);
        $regulus = new App\Library\Regulus() ;
        $result = $regulus->couponCheck( $idTurnoLibero, $couponCode );
        if($result){
            //$result = $regulus->getCouponVenduti($result);
            $result = $regulus->couponCheckRate( $result, $ridCode );
        }
        return json_encode( $result );
    }

    //Get info from WDSL and Insert or update the DB
    public function updateRates()
    {
        try {
            $this->authorize('index', new \App\Rate);
            $ticketstore = new App\Library\TicketStore();
            $result = $ticketstore->updateRates();
            return $this->createMessage(sprintf("Updated Rates Successfully: %s", print_r($result, true)), "200");
        } catch (Exception $e) {
            //return ['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
            return $this->createMessageError($e->getMessage(), '400');
        }
    }

    //Get info from WDSL and Insert or update the DB
    public function scaricaPdf($code,$typeTicket)
    {
        try {
            $regulus = new App\Library\Regulus();
            $result = $regulus->getScaricaPdf($code,$typeTicket);
            Storage::disk('local')->put($code.'.pdf', $result);
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }


    //Get info from WDSL and Insert or update the DB
    public function getPay($id)
    {
        try {
            $regulus = new App\Library\Regulus();
            $result = $regulus->confermaPagamento($id);
            if (empty($result)){return "ERRORE con confermapagamento";}
            return $result;
        } catch (Exception $e) {
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

//    //Get info from WDSL and Insert or update the DB
//    public function getIdOperazione($regulus_id,$turno_id,$riduzione_id)
//    {
//        try {
//            $regulus = new App\Library\Regulus();
//            $result = $regulus->getIdOperazione($regulus_id,$turno_id,$riduzione_id);
//            return $result;
//        } catch (Exception $e) {
//            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
//        }
//    }

}
