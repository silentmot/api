<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Factory;
use Afaqy\User\Models\User;
use Faker\Generator as Faker;
use Afaqy\Contact\Models\Contact;
use Afaqy\Inspector\Models\Ticket;
use Afaqy\Contract\Models\Contract;
use Afaqy\Contractor\Models\Contractor;
use Afaqy\District\Models\Neighborhood;

$arFaker = Factory::create('ar_SA');

$factory->define(Ticket::class, function (Faker $faker) use ($arFaker) {
    $contract   = Contract::inRandomOrder()->first();
    $contractor = Contractor::where('id', $contract->contractor_id)->inRandomOrder()->first();
    $districtId = $contract->districts()->inRandomOrder()->first()->id;

    return [
        'user_id'         => User::inRandomOrder()->first()->id,
        'contractor_name' => $contractor->name_ar,
        'contract_id'     => $contract,
        'district_id'     => $districtId,
        'neighborhood_id' => Neighborhood::inRandomOrder()->whereDistrictId($districtId)->first()->id,
        'location'        => rand(1, 100) . "," . rand(1, 100),
        'location_name'   => $arFaker->text(30),
        'details'         => $arFaker->realText(150),
        'status'          => $faker->randomElement(['PENDING', 'RESPONDED', 'ACCEPTED', 'REPORTED', 'PENALTY', 'APPROVED']),
    ];
});

$factory->afterCreating(Ticket::class, function ($ticket) use ($arFaker) {
    $ticket_id = $ticket->id;

    if ($ticket->status == "PENDING") {
        $inspector = User::find($ticket->user_id);

        // Adding inspector ticket's image
        $inspector->images()->create([
            'ticket_id' => $ticket_id,
            'url'       => public_path('jeddah.png'),
        ]);
    } elseif ($ticket->status == "RESPONDED") {
        $supervisor = Contact::where('contactable_id', $ticket->contract_id)
            ->where('contactable_type', Contract::class)
            ->first();

        if ($supervisor) {

            // Adding supervisor response
            $supervisor->responses()->create([
                'ticket_id' => $ticket_id,
                'details'   => $arFaker->text(150),
            ]);

            // Adding supervisor ticket's image
            $supervisor->images()->create([
                'ticket_id' => $ticket_id,
                'url'       => public_path('jeddah.png'),
            ]);
        }
    }
});
