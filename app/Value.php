<?php

namespace App;

class Value extends BaseModel
{
    protected $fillable = [
        'value', 'product_id', 'category_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function feature()
    {
        return $this->belongsTo(Features::class);
    }
}
