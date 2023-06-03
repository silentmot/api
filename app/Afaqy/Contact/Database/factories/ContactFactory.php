<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\Contact\Models\Contact;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'name'            => $faker->firstName,
        'title'           => $faker->word,
        'email'           => $faker->safeEmail,
        'default_contact' => 0,
    ];
});
