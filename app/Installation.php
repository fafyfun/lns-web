<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    public function job()
    {
        return $this->belongsTo('App\Quotationjob','quotationjob_id');
    }

    public function insatllaionlead()
    {
        return $this->belongsTo('App\User','installationlead_id');
    }
}
