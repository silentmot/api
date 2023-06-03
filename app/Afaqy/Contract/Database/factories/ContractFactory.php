<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Contract\Models\Contract;

$factory->define(Contract::class, function (Faker $faker) {
    return [
        'start_at'        => \Carbon\Carbon::today()->toDateString(),
        'end_at'          => \Carbon\Carbon::today()->addYear()->toDateString(),
        'contractor_id'   => $faker->unique()->numberBetween(1, 50),
        'contract_number' => $faker->numberBetween(1, 13),
    ];
});
