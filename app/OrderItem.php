<?php

namespace App;


class OrderItem extends BaseModel
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeTakeRandom($query, $size=1)
    {
        return $query->inRandomOrder()->take($size);
    }
}
