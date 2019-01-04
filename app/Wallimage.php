<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallimage extends Model
{
    //use RecordsActivity;
    /**
     * Get the wall that owns the image.
     * one-to-many(inverse)
     */
    public function wall()
    {
        return $this->belongsTo('App\Wall','wall_id');
    }
}
