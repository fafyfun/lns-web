<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotationjob extends Model
{
    protected $table = 'quotationjobs';
    public function quotation()
    {
        return $this->belongsTo('App\Quotation','quotation_id');
    }

    public function installation()
    {
        return $this->hasOne('App\Installation','quotationjob_id');
    }
}
