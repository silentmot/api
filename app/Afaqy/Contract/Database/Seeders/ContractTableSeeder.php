<?php

namespace Afaqy\Contract\Database\Seeders;

use Afaqy\Unit\Models\Unit;
use Afaqy\Contact\Models\Phone;
use Illuminate\Database\Seeder;
use Afaqy\Contact\Models\Contact;
use Afaqy\Contract\Models\Contract;
use Afaqy\District\Models\District;
use Afaqy\District\Models\Neighborhood;

class ContractTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Contract::count()) {
            factory(Contract::class, 25)
                ->create()
                ->each(function ($contract) {
                    $district              = District::select('id')->get();
                    $district_first_group  = $district->random()->id;
                    $district_second_group = $district->random()->id;

                    $neighborhood_first_group = Neighborhood::select('id')
                        ->where('district_id', $district_first_group)
                        ->get()->random()->id;
                    $neighborhood_second_group = Neighborhood::select('id')
                        ->where('district_id', $district_second_group)
                        ->get()->random()->id;

                    $units_first_group = Unit::select('id')
                        ->where('contractor_id', $contract->contractor_id)
                        ->get()
                        ->random(3)
                        ->pluck('id')
                        ->toArray();

                    $units_second_group = Unit::select('id')
                        ->where('contractor_id', $contract->contractor_id)
                        ->whereNotIn('id', $units_first_group)
                        ->get()
                        ->random(4)
                        ->pluck('id')
                        ->toArray();

                    $units_third_group = Unit::select('id')
                        ->where('contractor_id', $contract->contractor_id)
                        ->whereNotIn('id', array_merge($units_first_group, $units_second_group))
                        ->get()
                        ->random(2)
                        ->pluck('id')
                        ->toArray();

                    $contract->units()->attach($units_first_group, [
                        'district_id'     => $district_first_group,
                        'neighborhood_id' => $neighborhood_first_group,
                    ]);

                    $contract->units()->attach($units_second_group, [
                        'district_id'     => $district_second_group,
                        'neighborhood_id' => $neighborhood_second_group,
                    ]);

                    $contract->stationUnits()->attach($units_third_group, [
                        'station_id'     => rand(1, 5),
                    ]);

                    $contact = $contract->contacts()->save(factory(Contact::class)->make([
                        'contactable_id' => $contract->id,
                    ]));

                    $contact->phones()->save(factory(Phone::class)->make([
                        'contact_id' => $contact->id,
                    ]));
                });
        }
    }
}
