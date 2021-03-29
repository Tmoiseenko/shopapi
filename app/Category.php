<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Category extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'category_id'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }

    public function scopeTakeRandom($query, $size=1)
    {
        return $query->inRandomOrder()->take($size);
    }
}
