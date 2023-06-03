<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\UnitType\Models\UnitType;

$factory->define(UnitType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement(['ضاغط', 'سحاب', 'ثانكر', 'مكنسة']),
    ];
});
