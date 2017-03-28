<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelOrder extends Model
{
    protected $table = 'hotel_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'hotel_id', 'day', 'room_type_id', 'rooms', 'persons'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Hotel');
    }

    public function roomType()
    {
        return $this->belongsTo('App\RoomType');
    }

}
