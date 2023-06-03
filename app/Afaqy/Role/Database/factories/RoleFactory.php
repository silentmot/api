<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Afaqy\Role\Models\Role;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name'         => Str::kebab($faker->name),
        'display_name' => $faker->name,
        'description'  => $faker->sentence,
    ];
});
