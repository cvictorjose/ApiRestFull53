<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Behaviour extends Model
{
    protected $table = 'behaviour';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'ticket_sale_id', 'type', 'attribute', 'ratio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     *  Return bound behaviour_layout_items
     */
    public function behaviour_layout_items(){
        return $this->hasMany(BehaviourLayoutItem::class);
    }

}
