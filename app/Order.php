<?php

namespace App;


class Order extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'phone', 'quantity', 'amount'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
