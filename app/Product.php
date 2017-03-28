<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Product extends Model
{
    use Notifiable;
    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function ticket()
    {
        if($this->type == 'ticket'){
            return $this->hasOne(Ticket::class);
        }else{
            return null;
        }

    }

    public function service()
    {
        if($this->type == 'service'){
            return $this->hasOne(Service::class);
        }else{
            return null;
        }
    }

    /*
    * name: getPrice
    * params:
    * return:
    * desc: Return the price (of the connected rate)
    */
    public function getPrice(){
        if($this->type == 'ticket'){
            return $this->ticket()->getPrice();
        }elseif($this->type == 'service'){
            return $this->service()->getPrice();
        }else{
            return null;
        }
    }


    public function getIva(){
        if($this->type == 'ticket'){
            return $this->ticket;
        }elseif($this->type == 'service'){
            return $this->service;
        }else{
            return null;
        }
    }


    //Check type of product. Ticket or Service
    public function checkTypeProduct($product_id) {
        $type_product=Product::find($product_id);
        return $type_product->type;
    }


}
