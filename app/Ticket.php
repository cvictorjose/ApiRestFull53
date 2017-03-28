<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ticket extends Model
{
    use Notifiable;
    protected $table = 'ticket';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description','subscription','layout_item_id','product_id','rate_id','ticket_category_id','vat_rate','interactive','hidden','payback','educational'
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

    /*
    * name: rate
    * params:
    * return:
    * desc: Return the rate belonging to the ticket
    */
    public function rate(){
        return $this->belongsTo(Rate::class);
    }

    /*
    * name: getPrice
    * params:
    * return:
    * desc: Return the price (of the connected rate)
    */
    public function getPrice(){
        $r = $this->rate;
        if($r){
            return floatval($r->prezzo);
        }else{
            throw new \Exception(sprintf('Ticket "%s" has no Rate attached', $this->title));
        }
    }    

    /*
    * name: ticketgroups
    * params:
    * return:
    * desc: Ticket Belong to many TickeGroup
    */
    public function ticketgroups(){
        return $this->belongsToMany(Ticketgroup::class);
    }

    /*
    * name: ticketgroup
    * params:
    * return:
    * desc: Ticket Belong to one TickeGroup
    */
    // public function ticketgroup(){
    //     return $this->belongsTo(Ticketgroup::class);
    // }


    /*
    * name: ticketgroup
    * params:
    * return:
    * desc: Ticket Belong to one TickeGroup
    */
    public function category(){
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public static function create(array $attributes = array()){
        $p = Product::create(['type'=>'ticket']);
        $l = LayoutItem::create(['type'=>'ticket']);
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


    //Check type of product. Ticket or Abbonamento
    public function checkTypeTicket($product_id) {
        $result= Ticket::where('product_id',$product_id)->firstOrFail();
        return $result->subscription;
    }

}
