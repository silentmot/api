<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\District\Models\District;

$factory->define(District::class, function (Faker $faker) {
    return [
        'name' => $faker->state,
    ];
});
