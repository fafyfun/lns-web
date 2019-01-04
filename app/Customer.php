<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use RecordsActivity;
    /**
     * Get the salesleads for the customer.
     * one-to-many
     */
    public function salesleads()
    {
        return $this->hasMany('App\Saleslead','customer_id');
    }
}
