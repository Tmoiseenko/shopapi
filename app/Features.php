<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Features extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function value()
    {
        return $this->hasMany(Value::class);
    }

    public function scopeTakeRandom($query, $size=1)
    {
        return $query->inRandomOrder()->take($size);
    }



}
