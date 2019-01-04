<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wall extends Model
{
    //use RecordsActivity;
    /**
     * Get the room that owns the wall.
     * one-to-many(inverse)
     */
    public function room()
    {
        return $this->belongsTo('App\Room','room_id');
    }

    /**
     * Get the wallimages for the wall.
     * one-to-many
     */
    public function wallimages()
    {
        return $this->hasMany('App\Wallimage','wall_id');
    }

    /**
     * Get the product that owns the wall.
     * one-to-many(inverse)
     */
    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }
}
