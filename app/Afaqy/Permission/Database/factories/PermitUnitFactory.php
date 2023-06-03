<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Permission\Models\PermitUnit;

$factory->define(PermitUnit::class, function (Faker $faker) {
    $plate_number = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 3) . ' ' . rand(100, 999);

    return [
        'plate_number'  => $plate_number,
        'rfid'          => $faker->unique()->randomNumber(6),
        'qr_code'       => $faker->unique()->randomNumber(6),
    ];
});
