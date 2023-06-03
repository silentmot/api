<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Permission\Models\CommercialDamagedPermission;

$factory->define(CommercialDamagedPermission::class, function (Faker $faker) {
    return [
        'permission_number'          => $faker->regexify('[0-9]{5}'),
        'permission_date'            => $faker->date,
        'company_name'               => $faker->company,
        'representative_name'        => $faker->name,
        'company_commercial_number'  => $faker->regexify('[0-9]{10}'),
        'national_id'                => $faker->regexify('[0-9]{10}'),
        'allowed_weight'             => $faker->numberBetween(1000, 10000),
        'actual_weight'              => $faker->numberBetween(1000, 100000),
    ];
});
