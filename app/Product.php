<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function features()
    {
        return $this->hasMany(Features::class);
    }
}
