<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LayoutCategory extends Model
{
    protected $table = 'layout_category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'icon', 'type'
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
     *  Return all layout items belonging to the layout category
     */
    // public function layoutItems(){
    //     return $this->belongsToMany(LayoutItem::class)->withPivot('default_quantity');
    // }

}
