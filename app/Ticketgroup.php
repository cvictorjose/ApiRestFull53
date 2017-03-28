<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TicketGroup extends Model
{
    use Notifiable;

    protected $table = 'ticket_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_sale_id','title','description'
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
     *  Return all tickets belong to a ticketsale
     */
    public function tickets(){
        return $this->belongsToMany(Ticket::class)->withPivot('default_quantity');
    }

    /**
     *  Return a ticket value
     */
    // public function ticket(){
    //     return $this->belongsTo(Ticket::class);
    // }

    /**
     *  Return a ticketsale value
     */
    public function ticketsales(){
        return $this->belongsToMany(TicketSale::class);
    }
}
