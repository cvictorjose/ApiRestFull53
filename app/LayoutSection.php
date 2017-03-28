<?php

namespace App;

use App\Layout;
use App\LayoutCategory;
use Illuminate\Database\Eloquent\Model;

class LayoutSection extends Model
{
    protected $table = 'layout_section';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'icon', 'layout_id'
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
     *  Return bound layout categories
     */
    public function layout_categories(){
        return $this->belongsToMany(LayoutCategory::class, 'layout_section_category')->withPivot('id');
    }

    /**
     *  Return intermediate layout section categories (pivot)
     */
    public function layout_section_categories(){
        return $this->hasMany(LayoutSectionCategory::class);
    }

    /**
     *  Return father layout
     */
    public function layout(){
        return $this->belongsTo(Layout::class);
    }
}
