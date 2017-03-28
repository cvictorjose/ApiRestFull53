<?php

namespace App\Library;
use Illuminate\Database\Eloquent\Model;
use App;
use App\Rate;

class TicketStore
{
    /*
     * name:    updateTickets
     * params:  none
     * return:
     * desc:    Insert or update rates - TurniLiberi/TurnoLibero=Riduzioni
     */
    public function updateRates(){
        try {
            $regulus = new App\Library\Regulus();
            $result = $regulus->getListaTurniLiberi();
            $status="";

            $turni_liberi = (array) $result->caricaListaTurniLiberiResult->turniLiberi;

            foreach($turni_liberi as $turno_libero)
            {
                $id_turniLiberi     =   $turno_libero->id;
                $descrizione        =   $turno_libero->descrizione;
                print $id_turniLiberi."; ";

                //Check if an IdTurniLiberi exist
                $check_TurniLiberi = Rate::check_TurniLiberi($id_turniLiberi);

                //Call Function regulus dettaglio Turno libero
                $result_DettaglioTurnoLibero = $regulus->getDettaglioTurnoLibero($id_turniLiberi);
                //print_r($result_DettaglioTurnoLibero);

                //Root Riduzioni, can be an object or array
                try{
                    $root_riduzioni     =   $result_DettaglioTurnoLibero->caricaDettaglioTurnoLiberoResult->dettaglioTurnoLibero->riduzioni;
                } catch(\Exception $e) {
                    $root_riduzioni     =   array();
                }

                if( is_object($root_riduzioni) )
                {
                    $riduzione_id=$root_riduzioni->id;
                    $riduzione_codice=$root_riduzioni->codice;
                    $riduzione_description=$root_riduzioni->descrizione;
                    $riduzione_riservataCoupon=$root_riduzioni->riservataCoupon;

                    /*echo "id_TLiberi".$id_turniLiberi. " -- Riduzione ".$riduzione_id ." -- ".$riduzione_description
                        ." -- Cod ".$riduzione_codice ."<br>";*/

                    $items_rate = array(
                        'turno_id'            => $id_turniLiberi,
                        'description'         => $descrizione,
                        'rid_id'              => $riduzione_id,
                        'rid_code'            => $riduzione_codice,
                        'rid_description'     => $riduzione_description,
                        'rid_riservataCoupon' => $riduzione_riservataCoupon,
                    );

                    if ($check_TurniLiberi>0){
                        $status = Rate::update_riduzioniPrice($items_rate,$id_turniLiberi,$riduzione_id);
                    }else{
                        $status = Rate::insertRates($items_rate);
                    }
                 }
                else
                {
                    foreach($root_riduzioni as $rid_values)
                    {
                        $riduzione_id=$rid_values->id;
                        $riduzione_codice=$rid_values->codice;
                        $riduzione_description=$rid_values->descrizione;
                        $riduzione_riservataCoupon=$rid_values->riservataCoupon;

                        if ($check_TurniLiberi>0){
                            $items_rate = array(
                                'rid_id'              => $riduzione_id,
                                'rid_code'            => $riduzione_codice,
                                'rid_description'     => $riduzione_description,
                                'rid_riservataCoupon' => $riduzione_riservataCoupon,
                            );
                            //print_r($items_rate);
                            $status = Rate::update_riduzioniPrice($items_rate,$id_turniLiberi,$riduzione_id);

                            /*echo "
                            UPDATE:->
                            id_TLiberi".$id_turniLiberi. "
                            Riduzione ".$values->id ."
                            Des:".$values->descrizione." -- Codice ".$values->codice ."<br>";*/

                        }else{

                            $items_rate = array(
                                'turno_id'            => $id_turniLiberi,
                                'description'         => $descrizione,
                                'rid_id'              => $riduzione_id,
                                'rid_code'            => $riduzione_codice,
                                'rid_description'     => $riduzione_description,
                                'rid_riservataCoupon' => $riduzione_riservataCoupon,
                            );
                            $status = Rate::insertRates($items_rate);
                        }
                    }
                }

                //Check riduzione exist
                if (!empty($root_riduzioni)){

                    //Root tabellaPrezzi, can be an object or array
                    $root_tabellaPrezzi=$result_DettaglioTurnoLibero->caricaDettaglioTurnoLiberoResult
                            ->dettaglioTurnoLibero->tabellaPrezzi->prezzi;

                    if( is_object($root_tabellaPrezzi) )
                    {
                       $riduzione_id=$root_tabellaPrezzi->idRiduzione;
                       $idOrdinePosto=$root_tabellaPrezzi->idOrdinePosto;
                       $prezzo=$root_tabellaPrezzi->prezzo;
                       $prevendita=$root_tabellaPrezzi->prevendita;

                        $items_price = array(
                            'prezzo'         => $prezzo,
                            'prevendita'     => $prevendita,
                        );
                        /*echo "id_TLiberi".$id_turniLiberi;
                        echo " idRiduzione".$riduzione_id=$root_tabellaPrezzi->idRiduzione;
                        echo " prezzo".$prezzo=$root_tabellaPrezzi->prezzo;
                        echo "COD".$riduzione_codice;
                        echo "<br><br>";*/

                        $status = Rate::update_riduzioniPrice($items_price,$id_turniLiberi,$riduzione_id);
                    }
                    else
                    {
                         foreach($root_tabellaPrezzi as $tp_values)
                         {
                             $riduzione_id=$tp_values->idRiduzione;
                             $idOrdinePosto=$tp_values->idOrdinePosto;
                             $prezzo=$tp_values->prezzo;
                             $prevendita=$tp_values->prevendita;

                             $items_price = array(
                                 'prezzo'         => $prezzo,
                                 'prevendita'     => $prevendita,
                             );
                             $status = Rate::update_riduzioniPrice($items_price,$id_turniLiberi,$riduzione_id);

                            /* echo "id_TLiberi".$id_turniLiberi;
                             echo " idRiduzione".$riduzione_id=$values->idRiduzione;
                             echo " prezzo".$prezzo=$values->prezzo;
                             echo " COD".$riduzione_codice;
                             echo "<br><br>";*/
                        }
                    }
                }//End Check Riduzioni exist
                //Clean last value
                $check_TurniLiberi=0;

            }//EndForeach
            return $status;
        } catch (\Exception $e) {
            return $e->getMessage(); //['error'=>'not_found','error_message'=>'Please check the SOAP connection'];
        }
    }//End updateTickets
}