<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saleslead extends Model
{
    /**
     * Get the customer that owns the saleslead.
     * one-to-many(inverse)
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    /**
     * Get the inquiry record associated with the saleslead.
     */

    public function inquiry()
    {
        return $this->hasOne('App\Inquiry','saleslead_id');
    }
}
