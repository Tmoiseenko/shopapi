<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'phone', 'quantity', 'amount'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
