<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\District\Models\Neighborhood;

$factory->define(Neighborhood::class, function (Faker $faker) {
    return [
        'name'       => $faker->state,
        'population' => $faker->numberBetween(100000, 999999),
    ];
});
