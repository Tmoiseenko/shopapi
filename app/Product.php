<?php

namespace App;

class Product extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'category_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function featureValue()
    {
        return $this->hasMany(Value::class);
    }

    public function scopeTakeRandom($query, $size=1)
    {
        return $query->inRandomOrder()->take($size);
    }

}
