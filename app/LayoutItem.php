<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ticket;
use App\Service;
use App\Link;
use App\LayoutCategory;

class LayoutItem extends Model
{
    protected $table = 'layout_item';
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

    /*
    * name: layoutCategories
    * params:
    * return:
    * desc: Layout items belong to many layout categories
    */
    public function layoutCategories(){
        $layout_section_categories = $this->belongsToMany(LayoutCategory::class, 'layout_section_category_item', 'layout_section_category_id');
    }

    public function title(){
        return $this->getChildAttr('title');
    }

    public function description(){
        return $this->getChildAttr('description');
    }

    public function getChildAttr($attr){
        try{
            switch($this->type){
                case 'ticket':
                    $obj = Ticket::where('layout_item_id', $this->id)->first();
                    break;
                case 'service':
                    $obj = Service::where('layout_item_id', $this->id)->first();
                    break;
                case 'link':
                    $obj = Link::where('layout_item_id', $this->id)->first();
                    break;
            }
            return $obj->$attr;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
