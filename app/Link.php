<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'link';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'url', 'price', 'layout_item_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function layoutItem()
    {
        return $this->belongsTo('App\LayoutItem');
    }

    public static function create(array $attributes = array())
    {
        $l = LayoutItem::create(['type'=>'link']);
        $attributes['layout_item_id'] = $l->id;
        parent::create($attributes);
    }

    public function delete(){
        $l = $this->layoutItem;
        $l->delete();
        return parent::delete();
    }

}
