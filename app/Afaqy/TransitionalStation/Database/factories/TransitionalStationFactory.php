<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\TransitionalStation\Models\TransitionalStation;

$factory->define(TransitionalStation::class, function (Faker $faker) {
    return [
        'name'    => $faker->unique()->word(),
        'status'  => 1,
    ];
});
