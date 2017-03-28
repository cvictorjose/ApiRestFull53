<?php

namespace App\Library;  

//use App\Library\soapwsdl; 
//use App\Library\RegulusAPI;

use Log;
use App\OrderElement;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SoapClient;
use SoapVar;

use Response;
use File;

class Regulus {

    private $auth_params;
    private $soap_vars; 
    private $soap_client;
    private $wsdl_url;
    
    //public $prepareRequest; 

    public   function __construct() {
        //TODO: Inserire questi valori nel file delle costanti
        if($_SERVER['HTTP_HOST'] == 'xxx.it'){ // development
            $this->auth_params = array(
                'cassa' =>  "cassa",
                'utente' =>  "utente",
                'password' => "password", 
                'wsdl' =>  ""
            ); /* ^^^ TEST ^^^ */
        }else{ // production
            $this->auth_params = array( // PROD
                'cassa' =>  "cassa",
                'utente' =>  "",
                'password' => "", 
                'wsdl' =>  ""
            );
        }

        $this->soap_vars    = array();
        $this->soap_vars[]  = new SoapVar($this->auth_params['cassa'], XSD_STRING, NULL, NULL, 'cassa');
        $this->soap_vars[]  = new SoapVar($this->auth_params['utente'], XSD_STRING, NULL, NULL, 'utente');
        $this->soap_vars[]  = new SoapVar($this->auth_params['password'], XSD_STRING, NULL, NULL, 'password');
        $this->set_client(); 
        
        //$this->prepareRequest["caricaListaEventi"] = new soapwsdl\CaricaListaEventiReq($this->auth_params["cassa"], $this->auth_params["utente"], $this->auth_params["password"] ) ;  
        //$this->prepareRequest["caricaListaTurniFissi"] = new soapwsdl\CaricaListaTurniFissiReq($this->auth_params["cassa"], $this->auth_params["utente"], $this->auth_params["password"] ) ;
        
    }

    public function confermaPagamento($id){

        $conferma_params = array();
        $conferma_params[] = new SoapVar($this->auth_params['cassa'], XSD_STRING, NULL, NULL, 'cassa');
        $conferma_params[] = new SoapVar($this->auth_params['utente'], XSD_STRING, NULL, NULL, 'utente');
        $conferma_params[] = new SoapVar($this->auth_params['password'], XSD_STRING, NULL, NULL, 'password');
        $conferma_params[] = new SoapVar(true, XSD_BOOLEAN, NULL, NULL, 'paga');
        $conferma_params[] = new SoapVar(false, XSD_BOOLEAN, NULL, NULL, 'compilaDatiFiscali');

        try {
            $result = DB::table('order_element')->where('order_id', $id)->orderby('operazione_id', 'DESC')->get();
            $result = json_decode($result, true);

            $i=0;
            $codiceTransazione=0;

            $operazioni = array();
            foreach ($result as $key => $value) {
                $type_product= Product::find($value["product_id"]);
                if ($type_product->type==="ticket") {
                    $operazione_id     = $value["operazione_id"];
                    $operazione        = array('idOperazione' => (int)$operazione_id);
                    $conferma_params[] = new SoapVar($operazione, SOAP_ENC_OBJECT, "ns1:DatiConfermaOperazioneBiglietteria", NULL, 'operazioni');
                    $i=1;
                }
            }
            //print_r($conferma_params);
            if ($i>0){

                try{
                    $req = new SoapVar($conferma_params, SOAP_ENC_OBJECT);
                    $conferma_prenotazione = $this->soap_client->confermaPrenotazione(array('req' => $req));
                }catch(\Exception $e){
                    throw new Exception('Regulus error - confermaPrenotazione: '.$e->getMessage());
                }

               /* if(
                    isset($conferma_prenotazione) &&
                    isset($conferma_prenotazione->confermaPrenotazioneResult) &&
                    isset($conferma_prenotazione->confermaPrenotazioneResult->transazioni) &&
                    is_object($conferma_prenotazione->confermaPrenotazioneResult->transazioni) &&
                    isset($conferma_prenotazione->confermaPrenotazioneResult->transazioni->codiceTransazione)
                ) {
                    $codiceTransazione=$conferma_prenotazione->confermaPrenotazioneResult->transazioni->codiceTransazione;
                    //print_r($conferma_prenotazione);
                    return $codiceTransazione;
                }*/


                if(is_array($conferma_prenotazione->confermaPrenotazioneResult->transazioni)){
                    $codiceTransazione=$conferma_prenotazione->confermaPrenotazioneResult->transazioni[0]->codiceTransazione;
                }else{
                    $codiceTransazione=$conferma_prenotazione->confermaPrenotazioneResult->transazioni->codiceTransazione;
                }
                return $codiceTransazione;
            }
            return $codiceTransazione;

        } catch(Exception $e) {
            echo $e->getMessage();
            //echo $this->soap_client->__getLastRequest();
            return false;
        }
    }

    private function set_client() {
        //start soap client. call this only, if connection is needed
        if(empty($this->soap_client)) {
            $this->soap_client = new SoapClient( $this->auth_params["wsdl"]  , array(
                'local_cert' =>  __DIR__ . "/cinewws.pem"  ,
                'trace' => 1 
            ));
        }
        //return $this->soap_client; 
    }


    // public function __call($method, $soap_vars){
    //     $soap_vars = array_merge($this->soap_vars, $soap_vars);
    //     $req = new SoapVar($soap_vars, SOAP_ENC_OBJECT);
    //     return  $this->soap_client->$methodName(array('req' => $req ));
    // }

    public function getListaTurniLiberi(){
		$listaeventi_params = array();
                $listaeventi_params[] = new SoapVar($this->auth_params['cassa'], XSD_STRING, NULL, NULL, 'cassa');
                $listaeventi_params[] = new SoapVar($this->auth_params['utente'], XSD_STRING, NULL, NULL, 'utente');
                $listaeventi_params[] = new SoapVar($this->auth_params['password'], XSD_STRING, NULL, NULL, 'password');
                $req = new SoapVar($listaeventi_params, SOAP_ENC_OBJECT);
		return $this->soap_client->caricaListaTurniLiberi(array('req'=>$req));
    } 

    public function getDettaglioTurnoLibero($id){
        $params = array();
        $params[] = new SoapVar($this->auth_params['cassa'], XSD_STRING, NULL, NULL, 'cassa');
        $params[] = new SoapVar($this->auth_params['utente'], XSD_STRING, NULL, NULL, 'utente');
        $params[] = new SoapVar($this->auth_params['password'], XSD_STRING, NULL, NULL, 'password');
        $params[] = new SoapVar($id, XSD_STRING, NULL, NULL, 'idTurnoLibero');
        $req = new SoapVar($params, SOAP_ENC_OBJECT);
        return $this->soap_client->caricaDettaglioTurnoLibero(array('req'=>$req));
    }


    public function getScaricaPdf($code,$typeTicket){
        $params = array();
        $params[] = new SoapVar($this->auth_params['cassa'], XSD_STRING, NULL, NULL, 'cassa');
        $params[] = new SoapVar($this->auth_params['utente'], XSD_STRING, NULL, NULL, 'utente');
        $params[] = new SoapVar($this->auth_params['password'], XSD_STRING, NULL, NULL, 'password');

        //$operazione = array('idFattura' => (int)$id->id_fattura);
        //$params[] = new SoapVar($operazione, SOAP_ENC_OBJECT, "ns1:RigaRichiestaPdfFattura", NULL, 'righeRichiesta');

        switch($typeTicket){
            case '0':
                $operazione = array('idOperazione' => $code);
                $params[] = new SoapVar($operazione, SOAP_ENC_OBJECT, "ns1:RigaRichiestaPdfBiglietto", NULL, 'righeRichiesta');
                break;
            case '1':
                $operazione = array('codiceTransazione' => (string)$code);
                $params[] = new SoapVar($operazione, SOAP_ENC_OBJECT, "ns1:RigaRichiestaPdfRicevuta", NULL, 'righeRichiesta');
                break;
            default:
                throw new Exception(sprintf('The request regulus has an error', $typeTicket));
        }
        $req = new SoapVar($params, SOAP_ENC_OBJECT);
        //print_r($req);

        try {
            $pdf = $this->soap_client->scaricaPdf(array('req' => $req));
            if(
                isset($pdf) &&
                isset($pdf->scaricaPdfResult) &&
                isset($pdf->scaricaPdfResult->pdf)
            ) {
                return response($pdf->scaricaPdfResult->pdf, 200)
                    ->header('Content-Type', 'application/pdf');
            }
            return false;

        } catch(Exception $e) {
            return $this->createMessageError($e->getMessage(),$e->getStatusCode());
        }
    }

    public function couponCheck($idTurnoLibero, $barcode){ // barcode = coupon code?
        $coupon_params = $this->auth_params;
        $dati_chiusura_coupon = array('idTurnoLibero' => (int) $idTurnoLibero);
        $coupon_params['datiChiusuraCoupon'] = new SoapVar($dati_chiusura_coupon, SOAP_ENC_OBJECT, "ns1:DatiChiusuraCouponTurnoLibero", NULL, 'datiChiusuraCoupon');

        $coupon_params['barcode'] = $barcode;
        try {
            $coupon = $this->soap_client->caricaDatiCoupon(array('req' => $coupon_params));
            //return $coupon;
            //print_r($coupon);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
        if(isset($coupon->caricaDatiCouponResult) && isset($coupon->caricaDatiCouponResult->datiCoupon)) {
            $details = $coupon->caricaDatiCouponResult->datiCoupon->dettaglio;
            if(!is_array($details) && is_object($details)) {
                $details = array($details);
            }
            $ret = array(
                'riutilizzabile'=> $coupon->caricaDatiCouponResult->datiCoupon->riutilizzabile,
                'idGruppo'      => $coupon->caricaDatiCouponResult->datiCoupon->identificativo->idGruppo,
                'numero'        => $coupon->caricaDatiCouponResult->datiCoupon->identificativo->numero,
                'quantitaMin'   => $coupon->caricaDatiCouponResult->datiCoupon->quantitaMin,
                'quantitaMax'   => $coupon->caricaDatiCouponResult->datiCoupon->quantitaMax,
                'rates'         => array(),
                'details'       => $details,
                'barcode'       => $barcode
            );
            //return $ret;
            foreach($details as $detail) {
                $rate_code = $detail->codiceRiduzione;
                //$detail->codiceOrdinePosto;
                $rate = \App\Rate::where('rid_code', $rate_code)->first();
                if($rate){
                    $ret['rates'][] = array(
                        'quantitaMin' => $detail->quantitaMin,
                        'quantitaMax' => $detail->quantitaMax,
                        'ordineposto_id' => null,
                        'rid_id' => $rate->id,
                        'rid_code' => $rate->rid_code);
                }
            }
            if(empty($ret['rates'])) {
                return false; // coupon is not valid
            } else {
                return $ret; // coupon details if successful
            }
        } else {
            return false; // the coupon is not valid
        }
    }

    public function getCouponVenduti($coupon_details){ // only one possible
        $riga_coupon_venduti = array();
        $riga_coupon_venduti['progressivo'] = 1;
        $identificativo = array();
        $identificativo['idGruppo'] = (int) $coupon_details['idGruppo'];
        $identificativo['numero'] = (string) $coupon_details['numero'];
        //$identificativo['numero'] = (string) $coupon_details['barcode'];

        $riga_coupon_venduti['identificativo'] = new SoapVar($identificativo, SOAP_ENC_OBJECT, "ns1:IdentificativoCoupon");
        $couponVenduti = new SoapVar($riga_coupon_venduti, SOAP_ENC_OBJECT, "ns1:DatiCouponVenduto", NULL, 'couponVenduti');
        return $couponVenduti;
    }

    public function couponCheckRate($coupon_details, $rid_code){
        $rate_found = false;
        foreach($coupon_details['rates'] as $rate){
            if($rate['rid_code'] == $rid_code){
                Log::info('Rate found: '.$rid_code);
                $rate_found = true;
            }
        }
        return $rate_found;
    }


    public function getIdIngresso($idTurnoLibero){
        try{
            $params = array(
                'cassa' => $this->auth_params['cassa'],
                'utente' => $this->auth_params['utente'],
                'password' => $this->auth_params['password']);

            $params['idTurnoLibero'] = $idTurnoLibero;
            $dettaglio_turno_libero = $this->soap_client->caricaDettaglioTurnoLibero(array('req' => $params));
            $id_ingresso = $dettaglio_turno_libero->caricaDettaglioTurnoLiberoResult->dettaglioTurnoLibero->ingressi->id;
            return $id_ingresso;
        }catch(\Exception $e){
            throw new \Exception(sprintf('%s | File %s | Line %s', $e->getMessage(), $e->getFile(), $e->getLine()));
        }
    }



    public function insertUser($params){
        $anagrafica_params = array(
            'cassa' => $this->auth_params['cassa'],
            'utente' => $this->auth_params['utente'],
            'password' => $this->auth_params['password']);
        $anagrafica_params['consentiSalvataggioParziale'] = false;
        $anagrafica_params['anagrafiche'] = $params;
        $risposta_anagrafica = $this->soap_client->salvaAnagrafiche(array('req' => $anagrafica_params));
        //print_r($risposta_anagrafica) ;

        if(
            isset($risposta_anagrafica->salvaAnagraficheResult) &&
            isset($risposta_anagrafica->salvaAnagraficheResult->risultatiSalvataggio) &&
            $risposta_anagrafica->salvaAnagraficheResult->risultatiSalvataggio->salvata &&
            isset($risposta_anagrafica->salvaAnagraficheResult->risultatiSalvataggio->id) &&
            !empty($risposta_anagrafica->salvaAnagraficheResult->risultatiSalvataggio->id)
        ) {
            $id_user_regulus = $risposta_anagrafica->salvaAnagraficheResult->risultatiSalvataggio->id;
            return $id_user_regulus;
        }
    }


    //Chipaga=Intestario - Data= tutti gli elementi del carrello
    public function getIdOperazione_create_carrello($chipaga,$data){

        try{

            $carrello = array();
            //deve essere chiamato solo 1 volta, senno crea tanto carrelli come chiamate.
            $carrello[] = new SoapVar(($chipaga), XSD_INT, NULL, NULL, 'idAnagraficaCliente');
            $carrello[] = new SoapVar(false, XSD_BOOLEAN, NULL, NULL, 'cumulativo');
            //var_dump($data);

            //Aggiungo al carrello appena creato, tutti gli elementi (es:Adulto, Ridotto, Abbonamento)
            foreach($data as $t){
                $riga_carrello = array(
                    'ivaAssolta' => false,
                    'idAnagraficaTitolare' => $t['regulus_id'],
                    'quantita'      => 1,
                    'idIngresso'    => $this->getIdIngresso($t['turno_id']),
                    'idRiduzione'   => $t['riduzione_id'],
                    'prevendita'    => false
                );
                //var_dump($riga_carrello);

                // coupon start
                //Log::info(sprintf("Coupon code: %s - Rate code: %s", $coupon_code, $rid_code));
                $coupon_details = $this->couponCheck(934, $t['coupon_code']);
                if($coupon_details && $this->couponCheckRate($coupon_details, $t['rid_code'])){
                    $carrello[] = $this->getCouponVenduti($coupon_details);
                    $riga_carrello['listaProgressiviCoupon'] = 1;
                }
                // coupon end

                $carrello[] = new SoapVar($riga_carrello, SOAP_ENC_OBJECT, "ns1:RigaCarrelloTurnoLibero", NULL, 'righeCarrello');
            }

            $params = array(
                'cassa' => $this->auth_params['cassa'],
                'utente' => $this->auth_params['utente'],
                'password' => $this->auth_params['password']);

            $params['carrello'] = new SoapVar($carrello, SOAP_ENC_OBJECT);

            $minutes=20;
            $params['scadenza'] = date('c', strtotime("+".$minutes." minute"));
            //Log::info('RegulusPrenota SOAP structure: '.print_r($params, true));

            $prenotazione = $this->soap_client->prenota(array('req' => $params));

            //Log::info('RegulusPrenota XML request: '.$this->soap_client->__getLastRequest());
            //Log::info('RegulusPrenota response: '.print_r($prenotazione, true));

            $operazioni['codiceTransazione'] = $prenotazione->prenotaResult->transazione->codiceTransazione;

            if(is_array($prenotazione->prenotaResult->transazione->operazioni)){
                foreach($prenotazione->prenotaResult->transazione->operazioni as $operazione) {
                    $operazioni['order_elements'][] = array(
                        'operazione_id' => $operazione->id,
                        'total' => $operazione->importo,
                        'identity_id' => $operazione->idAnagraficaTitolare
                    );
                }
            }else{
                $operazioni['order_elements'][] = array(
                    'operazione_id' => $prenotazione->prenotaResult->transazione->operazioni->id,
                    'total'         => $prenotazione->prenotaResult->transazione->operazioni->importo,
                    'identity_id' => $prenotazione->prenotaResult->transazione->operazioni->idAnagraficaTitolare
                );
            }
            //print_r($prenotazione);
            //Log::info('RegulusPrenota response: '.print_r($operazioni, true));
            return $operazioni;

        } catch(\Exception $e) {

            throw new \Exception(sprintf('%s | File %s | Line %s', $e->getMessage(), $e->getFile(), $e->getLine()));

        }
    }

}

/*
        $lista_turni_fissi = $this->soap_client->caricaListaTurniLiberi(array('req' => $params));
        $test=$lista_turni_fissi->caricaListaTurniLiberiResult->turniLiberi;

         $year=2017; $month=01;
        $listaeventi_params = array();
        $listaeventi_params[] = new SoapVar($this->auth_params['cassa'], XSD_STRING, NULL, NULL, 'cassa');
        $listaeventi_params[] = new SoapVar($this->auth_params['utente'], XSD_STRING, NULL, NULL, 'utente');
        $listaeventi_params[] = new SoapVar($this->auth_params['password'], XSD_STRING, NULL, NULL, 'password');
        $maxdays = date('t', strtotime($year.'-'.$month.'-01'));
        $filtri = array();
        $filtri[] = new SoapVar(date('c', strtotime($year.'-'.$month.'-01 00:00:01')), XSD_DATETIME, NULL, NULL, 'min');
        $filtri[] = new SoapVar(date('c', strtotime($year.'-'.$month.'-'.$maxdays.' 23:59:59')), XSD_DATETIME, NULL, NULL, 'max');
        $listaeventi_params[] = new SoapVar($filtri, SOAP_ENC_OBJECT, "ns1:FiltroEventoInizio", NULL, 'filtri');
        $req = new SoapVar($listaeventi_params, SOAP_ENC_OBJECT);
        $lista_eventi = $this->soap_client->caricaListaEventi(array('req' => $req));


        $params = array(
            'cassa' => $this->auth_params['cassa'],
            'utente' => $this->auth_params['utente'],
            'password' => $this->auth_params['password']);
        $params['idEvento'] = $lista_eventi->caricaListaEventiResult->eventi->id;
        $dettaglio_evento = $this->soap_client->caricaDettaglioEvento(array('req' => $params));
        $id_ingresso=$dettaglio_evento->caricaDettaglioEventoResult->dettaglioEvento->fasce->ingressi->id;*/



    /*public function getIdOperazione($chipaga,$regulus_id, $turno_id, $riduzione_id, $coupon_code=null,
                                    $rid_code=null){
        //Ogni volta che si fa send si autoincrementa idoperazione in automatico
        $carrello = array();
        $carrello[] = new SoapVar(($chipaga), XSD_INT, NULL, NULL, 'idAnagraficaCliente');

        $carrello[] = new SoapVar(false, XSD_BOOLEAN, NULL, NULL, 'cumulativo');
        $riga_carrello = array(
            'ivaAssolta' => false,
            'idAnagraficaTitolare' => $regulus_id, //7056 o 7021 regulus_id
            'quantita'      => 1,
            'idIngresso'    => $this->getIdIngresso($turno_id), // 894 turno_id - rate table
            'idRiduzione'   => $riduzione_id, // 1008 rid_id - rate table
            'prevendita'    => false
        );
        // coupon start
        Log::info(sprintf("Coupon code: %s - Rate code: %s", $coupon_code, $rid_code));
        $coupon_details = $this->couponCheck(934, $coupon_code);
        if($coupon_details && $this->couponCheckRate($coupon_details, $rid_code)){
            $carrello[] = $this->getCouponVenduti($coupon_details);
            $riga_carrello['listaProgressiviCoupon'] = 1;
        }
        // coupon end

        $carrello[] = new SoapVar($riga_carrello, SOAP_ENC_OBJECT, "ns1:RigaCarrelloTurnoLibero", NULL, 'righeCarrello');

        $params = array(
            'cassa' => $this->auth_params['cassa'],
            'utente' => $this->auth_params['utente'],
            'password' => $this->auth_params['password']);

        $params['carrello'] = new SoapVar($carrello, SOAP_ENC_OBJECT);
        //$params['scadenza']="2017-03-08T15:16:58+00:00";
        $minutes=20;
        $params['scadenza'] = date('c', strtotime("+".$minutes." minute"));
        Log::info('RegulusPrenota SOAP structure: '.print_r($params, true));

        $prenotazione = $this->soap_client->prenota(array('req' => $params));

        Log::info('RegulusPrenota XML request: '.$this->soap_client->__getLastRequest());
        Log::info('RegulusPrenota response: '.print_r($prenotazione, true));

        //print_r($prenotazione);

        $operazioni['codiceTransazione'] = $prenotazione->prenotaResult->transazione->codiceTransazione;

        if(is_array($prenotazione->prenotaResult->transazione->operazioni)){
            foreach($prenotazione->prenotaResult->transazione->operazioni as $operazione) {
                $operazioni['order_elements'][] = array(
                    'operazione_id' => $operazione->id,
                    'total' => $operazione->importo
                );
            }
        }else{
            $operazioni['order_elements'][] = array(
                'operazione_id' => $prenotazione->prenotaResult->transazione->operazioni->id,
                'total'         => $prenotazione->prenotaResult->transazione->operazioni->importo
            );
        }
        // print_r($operazioni);
        return $operazioni;
    }*/

