<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\EntrancePermission\Models\EntrancePermission;

$factory->define(EntrancePermission::class, function (Faker $faker) {
    $plate_number = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 3) . ' ' . rand(100, 999);
    $faker_ar = \Faker\Factory::create('ar_SA');

    return [
        'type'          => $faker->randomElement(["employee", "visitor"]),
        'name'          => $faker_ar->unique()->firstName,
        'title'         => $faker_ar->title,
        'national_id'   => $faker->regexify('[0-9]{10}'),
        'phone'         => $faker->regexify('^(05)\d{8}$'),
        'company'       => $faker_ar->unique()->company,
        'plate_number'  => $plate_number,
        'start_date'    => $faker->date('Y-m-d'),
        'end_date'      => $faker->date('Y-m-d'),
        'rfid'          => $faker->unique()->randomNumber(6),
        'qr_code'       => $faker->unique()->randomNumber(6),
    ];
});
