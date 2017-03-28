<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $table = 'widget';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'code', 'coupon_code_id', 'image', 'document', 'width', 'height', 'embed_code'
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
     * Autogenerate HTML embed code, if empty
     * 
     */
    public function generateEmbedCode(){
        if(!$this->embed_code){
            $widget_width = (empty($this->width) ? '300' : $this->width);
            $widget_height = (empty($this->height) ? '250' : $this->height);
            $widget_host = (($_SERVER['HTTP_HOST'] == 'devel.ws.cinecittaworld.gag.it') ? 'http://devel.cinecittaworld.gag.it' : 'http://www.cinecittaworld.it');
            $this->embed_code = sprintf('<iframe width="%s" height="%s" src="%s/widget/?partner=%s"></iframe>', $widget_width, $widget_height, $widget_host, $this->code);
            $this->save();
            return true;
        }else{
            return false;
        }
    }

    /*
    * name: coupon
    * params:
    * return:
    * desc: CouponCode belongs to a Coupon
    */
    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

}
