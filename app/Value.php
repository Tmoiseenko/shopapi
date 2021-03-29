<?php

namespace App;

class Value extends BaseModel
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function feature()
    {
        return $this->belongsTo(Features::class);
    }
}
