<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //use RecordsActivity;
    /**
     * Get the rooms for the quotation.
     * one-to-many
     */
    public function rooms()
    {
        return $this->hasMany('App\Room','quotation_id');
    }

    /**
     * Get the inquiry that owns the quotation.
     * one-to-many(inverse)
     */
    public function inquiry()
    {
        return $this->belongsTo('App\Inquiry','inquiry_id');
    }

    public function job()
    {
        return $this->hasOne('App\Quoationjob','quotation_id');
    }
}
