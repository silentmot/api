<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Afaqy\Scale\Models\Scale;
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

$factory->define(Scale::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->sentence(10),
        'com_port'    => $faker->randomNumber(2),
        'baud_rate'   => $faker->randomNumber(2),
        'parity'      => $faker->randomNumber(2),
        'data_bits'   => $faker->randomNumber(2),
        'stop_bits'   => $faker->randomNumber(3),
        'start_read'  => $faker->randomNumber(3),
        'end_read'    => $faker->randomNumber(4),
        'service_url' => $faker->url,
        'ip'          => $faker->ipv4,
        'zone_id'     => $faker->numberBetween(1, 10),
        'path_order'  => $faker->randomDigit,
    ];
});
