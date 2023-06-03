<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Device\Models\Device;

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

$factory->define(Device::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->sentence(10),
        'serial'      => $faker->randomNumber(5),
        'type'        => $faker->randomElement(['lpr', 'rfid', 'qr code']),
        'ip'          => $faker->ipv4,
        'zone_id'     => $faker->numberBetween(1, 10),
        'path_order'  => $faker->randomDigit,
    ];
});
