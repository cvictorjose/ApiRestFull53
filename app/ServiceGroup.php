<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceGroup extends Model
{
    protected $table = 'service_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'ticket_sale_id'
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
     * Return all Service associed with ServiceGroups
     * Url:servicesgroups/{id}/services
     */
    public function services(){
        return $this->belongsToMany(Service::class)->withPivot('default_quantity');
    }

    /**
     *  Return ticketsales connected
     */
    public function ticketsales(){
        return $this->belongsToMany(TicketSale::class);
    }
}
