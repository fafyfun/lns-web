<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use RecordsActivity;
    /**
     * Get the products for the category.
     * one-to-many
     */
    public function products()
    {
        return $this->hasMany('App\Product','category_id');
    }
}
