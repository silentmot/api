<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Afaqy\User\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name'        => $faker->name,
        'last_name'         => $faker->name,
        'username'          => $faker->unique()->userName,
        'email'             => $faker->unique()->safeEmail,
        'phone'             => $faker->unique()->regexify('^(05)([0-9]{8})$'),
        'email_verified_at' => now(),
        'password'          => '$2y$10$WEmn63UO5qYcqVx96GJhzOHbqEVAI7HWeTefIquARtIRG3hVT8Vue', // 123456
        'remember_token'    => Str::random(10),
    ];
});
