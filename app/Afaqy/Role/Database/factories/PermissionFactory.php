<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Afaqy\Role\Models\Permission;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name'         => Str::kebab($faker->name),
        'display_name' => $faker->name,
        'description'  => $faker->sentence,
    ];
});
