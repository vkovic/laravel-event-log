<?php

use Faker\Generator as Faker;

$factory->define(\Vkovic\LaravelEventLog\Test\Support\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->words(rand(1, 4), true),
        'price' => rand(1, 9999),
        'quantity' => rand(0, 100),
    ];
});