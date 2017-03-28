<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Rate extends Model
{
    use Notifiable;
    protected $table = 'rate';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'turno_id', 'description','rid_id','rid_code' ,'rid_description','prezzo'
     ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'created_at', 'updated_at',
     ];

    /*
     * name: ticket
     * params:
     * return:
     * desc: Rate belogn to many tickets
     */
    public function ticket(){
        return $this->hasMany(Ticket::class);
    }

    /*
     * name: getPrice
     * params:
     * return:
     * desc: getting value of the column prezzo
     */
    public function prezzo(){
        return $this->prezzo;
    }

     /*
     * name:    insertRates
     * params:  $data
     * return:
     * desc:    Insert All Rates get info from WSDL - Regulus
     */
    public static function insertRates($data)
    {
        $status = array('stat' => 'error', 'msg' => 'Something went wrong');
        $result = 0;

        $result = DB::table('rate')->insertGetId($data);
        if ($result > 0) {
            $status = array('data: [
                {
                "type": "rate",
                "id": "1",
                "attributes": {
                  "title": "Rate inserted successfully!",
                  "body": ""
                }
              }],');

        } else {
            $status = array('errors: [
                {
                  "status": "404",
                  "title":  "Rate inserted failed",
                  "detail": ""
                }
              ]');
        }
        return $status;
    }


    /*
     * name:    check_TurniLiberi
     * params:  $id= Id TurniLiberi
     * return:
     * desc:    check if Id TurniLiberi already exists
     */
    public static function check_TurniLiberi($id){
        $status=0;
        $result = DB::table('rate')->where('turno_id', $id )->select('turno_id')->take(1)->get();
        if(count($result)>0){
            //$status     = array('stat'=>'error', 'msg'=>'ID TurniLiberi already exists');
            $status=1;
        }
        return $status;
    }


    /*
     * name:    update_riduzioni_price
     * params:  array info, id_turnoliberi, id riduzione
     * return:
     * desc:    Update TurniLiberi + Riduzioni + Prezzo get info from WSDL - Regulus
     */
    public static function update_riduzioniPrice($data,$id_turniLiberi,$riduzione_id)
    {
       $result = 0;
       $result = DB::table('rate')->where([
            ['turno_id', '=', $id_turniLiberi],
            ['rid_id', '=', $riduzione_id],
        ])->update( $data );


        if ($result > 0) {
            $status = array('data: [
                {
                "type": "rate",
                "id": "1",
                "attributes": {
                  "title": "Riduzione price updated successfully!",
                  "body": ""
                }
              }],');

        } else {
            $status = array('errors: [
                {
                  "status": "404",
                  "title":  "Riduzione price updated failed",
                  "detail": ""
                }
              ]');
        }
        return $status;
    }
}
