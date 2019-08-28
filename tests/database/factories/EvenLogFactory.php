<?php

use Faker\Generator as Faker;

$factory->define(\Vkovic\LaravelEventLog\EventLogModel::class, function (Faker $faker) {
    return [
        'event' => '',
        'message' => $faker->sentence,
        'data' => null,
        'related_type' => null,
        'related_id' => null,
    ];
});