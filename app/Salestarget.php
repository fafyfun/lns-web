<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salestarget extends Model
{
    /**
     * Get the agent that owns the salestarget.
     * one-to-many(inverse)
     */
    use RecordsActivity;

    public function agent()
    {
        return $this->belongsTo('App\User','agent_id');
    }
}
