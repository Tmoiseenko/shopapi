<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $name = $faker->sentence(2, 3);
    return [
        'name' => $name,
        'slug' => \Illuminate\Support\Str::slug($name, '-'),
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(500, 10000),
    ];
});
