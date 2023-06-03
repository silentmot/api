<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Permission\Models\DamagedProjectsPermission;

$factory->define(DamagedProjectsPermission::class, function (Faker $faker) {
    return [
        'demolition_serial'          => $faker->unique()->regexify('[0-9]{8}$'),
        'permission_number'          => $faker->unique()->regexify('[0-9]{5}'),
        'permission_date'            => $faker->date,
        'company_name'               => $faker->company,
        'company_commercial_number'  => $faker->regexify('[0-9]{10}'),
        'actual_weight'              => $faker->numberBetween(1000, 100000),
    ];
});
