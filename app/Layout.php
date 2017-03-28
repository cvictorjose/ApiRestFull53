<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $table = 'layout';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'ticket_sale_id', 'message'
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
     *  Return bound layout sections
     */
    public function layout_sections(){
        return $this->hasMany(LayoutSection::class);
    }

    public function expand(){
        $lss = $this->layout_sections;
        foreach($lss as $ls){
            $lscs = $ls->layout_section_categories;
            foreach($lscs as $lsc){
                $lsc->layout_category = LayoutCategory::find($lsc->layout_category_id);
                $lscis = $lsc->layout_items;
                foreach($lscis as $lsci){
                    switch($lsci->type){
                        case "ticket":
                            $lsci->ticket = Ticket::where('layout_item_id', $lsci->id)->first();
                            $lsci->ticket->price = $lsci->ticket->getPrice();
                            break;
                        case "service":
                            $lsci->service = Service::where('layout_item_id', $lsci->id)->first();
                            break;
                        case "link":
                            $lsci->link = Link::where('layout_item_id', $lsci->id)->first();
                            break;
                    }
                }
            }
        }
        return $this;
    }
}
