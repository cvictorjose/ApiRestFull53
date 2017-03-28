<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = 'service_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'icon'
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
     *  Return all Service associed with ServiceGroups
     */
    public function service(){
        return $this->belongsTo(Service::class);
    }



    /**
     *  Return all Services with category (id)
     *  Url:category/id/services
     */
    public function services(){
        return $this->hasMany(Service::class);
    }



}
