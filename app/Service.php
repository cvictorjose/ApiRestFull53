<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'service_category_id', 'layout_item_id', 'product_id', 'subtitle', 'price', 'image', 'vat_rate', 'interactive'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function layoutItem()
    {
        return $this->belongsTo('App\LayoutItem');
    }

    /**
     *  Return all ServiceGroups associed with Service
     */
    public function serviceGroups(){
        return $this->belongsToMany(ServiceGroup::class);
    }


    public function category(){
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public static function create(array $attributes = array()){
        $p = Product::create(['type'=>'service']);
        $l = LayoutItem::create(['type'=>'service']);
        $attributes['product_id'] = $p->id;
        $attributes['layout_item_id'] = $l->id;
        parent::create($attributes);
    }

    public function delete(){
        $l = $this->layoutItem;
        $l->delete();
        $p = $this->product;
        $p->delete();
        return parent::delete();
    }

}
