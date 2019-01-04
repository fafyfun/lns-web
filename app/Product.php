<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use RecordsActivity;
    /**
     * Get the category that owns the product.
     * one-to-many(inverse)
     */
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    /**
     * Get the brand that owns the product.
     * one-to-many(inverse)
     */
    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }


}
