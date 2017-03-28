<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Identity extends Model
{
    protected $table = 'identity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identity','type','name','surname','email','phone','address','postal_code','city','region','country','company',
        'company_vat','picture', 'regulus_id', 'payback_card'

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
     * name:    Check Payback card validity (Luhn algorithm)
     * params:  $id_user_regulus, $lastInsertedId
     * return:
     * desc:    Update the field regulus_id with the $id_user_regulus variable
     */
    public static function isValidPaybackCard($number){
        settype($number, 'string');
        switch(strlen($number)){
            case 10:
                $number = '637152'.$number;
                break;
            case 16:
                break;
            default:
                return false;
                break;
        }
        switch(substr($number, 6, 1)){
            case '4':
            case '5':
            case '6':
            case '7':
                return Identity::isValidLuhn($number);
                break;
            case '8':
                if(substr($number, 7, 2)=='80' || substr($number, 7, 2)=='81'){
                    return Identity::isValidLuhn($number);
                }else{
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }

    public static function isValidLuhn($number) {
        settype($number, 'string');
        $sumTable = array(
        array(0,1,2,3,4,5,6,7,8,9),
        array(0,2,4,6,8,1,3,5,7,9));
        $sum = 0;
        $flip = 0;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
        $sum += $sumTable[$flip++ & 0x1][$number[$i]];
        }
        return $sum % 10 === 0;
    }


    /*
     * name:    Update ID regulus
     * params:  $id_user_regulus, $lastInsertedId
     * return:
     * desc:    Update the field regulus_id with the $id_user_regulus variable
     */
    public static function saveIdRegulus($id_user_regulus,$lastInsertedId)
    {
        $result = 0;
        $data_regulus= ['regulus_id' => $id_user_regulus];
        $result = DB::table('identity')
            ->where('id', $lastInsertedId)
            ->update($data_regulus);
        return $result;
    }

}
