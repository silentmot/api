<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Contact\Models\Phone;

$factory->define(Phone::class, function (Faker $faker) {
    return [
        'phone' => '05' . $faker->randomNumber(8),
    ];
});
