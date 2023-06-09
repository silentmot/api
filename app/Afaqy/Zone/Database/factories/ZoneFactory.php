<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Afaqy\Zone\Models\Zone;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(Zone::class, function (Faker $faker) {
    return [
        'name'  => $faker->sentence(2),
        'reads' => $faker->randomNumber(3),
    ];
});
