<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelAvailability extends Model
{
    protected $table = 'hotel_availability';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'room_type_id', 'day', 'rooms'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
