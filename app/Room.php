<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //use RecordsActivity;
    /**
     * Get the quotation that owns the room.
     * one-to-many(inverse)
     */
    public function quotation()
    {
        return $this->belongsTo('App\Quotation','quotation_id');
    }

    /**
     * Get the walls for the room.
     * one-to-many
     */
    public function walls()
    {
        return $this->hasMany('App\Wall','room_id');
    }
}
