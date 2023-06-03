<?php

namespace Afaqy\TransitionalStation\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\District\Models\District;
use Afaqy\TransitionalStation\Models\TransitionalStation;

class TransitionalStationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!TransitionalStation::count()) {
            $this->createStations();

            $stations = TransitionalStation::select('id')->get();

            foreach ($stations as $station) {
                $district             = District::select('id')->get();
                $district_first_group = $district->random()->id;

                $station->districts()->attach([
                    'district_id' => $district_first_group,
                    'station_id'  => $station->id,
                ]);
            }
        }
    }

    /**
     * create stations.
     *
     * @return void
     */
    public function createStations()
    {
        $data = [
            [
                'name'   => 'Al-Murjan',
                'status' => 1,
            ],
            [
                'name'   => 'Al-Basateen',
                'status' => 1,
            ],
            [
                'name'   => 'Al-Mohamadiya',
                'status' => 1,
            ],
            [
                'name'   => 'Ash-Shati',
                'status' => 1,
            ],
            [
                'name'   => 'An-Nahda',
                'status' => 1,
            ],
        ];

        TransitionalStation::insert($data);
    }
}
