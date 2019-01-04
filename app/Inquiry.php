<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use RecordsActivity;
    /**
     * Get the saleslead that owns the inquiry.
     */

    public function saleslead()
    {
        return $this->belongsTo('App\Saleslead','saleslead_id');
    }

    /**
     * Get the agent that owns the inquiry.
     * one-to-many(inverse)
     */

    public function agent()
    {
        return $this->belongsTo('App\User','agent_id');
    }

    /**
     * Get the createduser that owns the inquiry.
     * one-to-many(inverse)
     */

    public function createdUser()
    {
        return $this->belongsTo('App\User','created_by');
    }

    /**
     * Get the quotations for the inquiry.
     * one-to-many
     */
    public function quotations()
    {
        return $this->hasMany('App\Quotation','inquiry_id');
    }
}
