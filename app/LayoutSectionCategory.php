<?php

namespace App;

use App\LayoutItem;
use Illuminate\Database\Eloquent\Model;

class LayoutSectionCategory extends Model
{
    protected $table = 'layout_section_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'layout_section_id', 'layout_category_id'
    ];

    public $timestamps = false;

    /**
     *  Return bound layout_items
     */
    public function layout_items(){
        return $this->belongsToMany(LayoutItem::class, 'layout_section_category_item')->withPivot('default_quantity', 'min_quantity', 'max_quantity');
    }
}
