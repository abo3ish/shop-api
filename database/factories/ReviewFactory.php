<?php

use App\Models\User;
use App\Model\Product;
use Faker\Generator as Faker;

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
        'text' => $faker->paragraph,
        'user_id' => function () {
            return User::all()->random();
        },
        'product_id' => function () {
            return Product::all()->random();
        },
        'stars' => $faker->numberBetween(0, 5),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
