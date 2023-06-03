<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Afaqy\Gate\Models\Gate;
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

$factory->define(Gate::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->sentence(10),
        'serial'      => $faker->randomNumber(5),
        'direction'   => $faker->randomElement(['in', 'out']),
        'duration'    => $faker->randomNumber(5),
        'ip'          => $faker->ipv4,
        'zone_id'     => $faker->numberBetween(1, 10),
        'path_order'  => $faker->randomDigit,
    ];
});
