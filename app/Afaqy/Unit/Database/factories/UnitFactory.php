<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Afaqy\Unit\Models\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
    $plate_number = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 3) . ' ' . rand(100, 999);

    return [
        'code'          => $plate_number,
        'model'         => $faker->year,
        'plate_number'  => $plate_number,
        'vin_number'    => $faker->randomNumber(6),
        'unit_type_id'  => $faker->numberBetween(1, 4),
        'waste_type_id' => $faker->numberBetween(5, 24),
        'contractor_id' => $faker->numberBetween(1, 50),
        'net_weight'    => $faker->numberBetween(1000, 5000),
        'max_weight'    => $faker->numberBetween(100, 20000),
        'rfid'          => $faker->unique()->randomNumber(6),
        'qr_code'       => $faker->unique()->randomNumber(6),
        'active'        => $faker->numberBetween(0, 1),
    ];
});
