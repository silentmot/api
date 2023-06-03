<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Permission\Models\CheckinUnit;

$factory->define(CheckinUnit::class, function (Faker $faker) {
    return [
        'unit_id' => $faker->randomDigit,
    ];
});
