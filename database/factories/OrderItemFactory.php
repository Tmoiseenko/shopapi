<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(\App\OrderItem::class, function (Faker $faker) {
    return [
        'quantity' => rand(1, 8)
    ];
});
