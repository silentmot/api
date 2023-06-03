<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Contractor\Models\Contractor;

$factory->define(Contractor::class, function (Faker $faker) {
    $faker_ar = \Faker\Factory::create('ar_SA');

    return [
        'name_ar'           => $faker_ar->unique()->firstName,
        'name_en'           => $faker->word,
        'commercial_number' => $faker->unique()->randomNumber(6),
        'address'           => $faker->address,
        'employees'         => $faker->numberBetween(10, 999),
    ];
});
