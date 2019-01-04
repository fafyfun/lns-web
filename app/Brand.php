<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use RecordsActivity;
    /**
     * Get the products for the brand.
     * one-to-many
     */
    public function products()
    {
        return $this->hasMany('App\Product','brand_id');
    }
}
