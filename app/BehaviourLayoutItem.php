<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BehaviourLayoutItem extends Model
{
    protected $table = 'behaviour_layout_item';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'behaviour_id', 'layout_item_id', 'use'
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
     *  Return behaviour
     */
    public function behaviour(){
        return $this->belongsTo(Behaviour::class);
    }

    /**
     *  Return layout_item
     */
    public function layout_item(){
        return $this->belongsTo(LayoutItem::class);
    } 

}
