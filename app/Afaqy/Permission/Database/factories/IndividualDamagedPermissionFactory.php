<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use \Afaqy\District\Models\Neighborhood;
use  Afaqy\Permission\Models\IndividualDamagedPermission;

$factory->define(IndividualDamagedPermission::class, function (Faker $faker) {
    $neighborhood =  Neighborhood::where('district_id', 1)->pluck('id')->first();

    return [
        'demolition_serial'          => $faker->unique()->regexify('[0-9]{8}$'),
        'permission_number'          => $faker->unique()->regexify('[0-9]{5}'),
        'permission_date'            => $faker->date,
        'type'                       => $faker->randomElement(["construction", "demolition", "restoration", "drilling_services", "municipality_projects", "charity_projects"]),
        'district_id'                => 1,
        'neighborhood_id'            => $neighborhood,
        'street'                     => $faker->streetAddress,
        'owner_name'                 => $faker->name(),
        'national_id'                => $faker->regexify('^(1|2)([0-9]{9})$'),
        'owner_phone'                => $faker->regexify('[0-9]{6}'),
    ];
});
