<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Features;
use Faker\Generator as Faker;

$factory->define(Features::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});
