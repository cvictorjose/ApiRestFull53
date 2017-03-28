<?php

namespace App;

use App\Behaviour;

class BehaviourChangeQuantity extends Behaviour
{
    protected $table = 'behaviour_change_quantity';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'ticket_sale_id','product_from_id','product_to_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
