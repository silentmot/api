<?php

namespace Afaqy\District\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\District\Models\Neighborhood;
use Afaqy\District\Models\SubNeighborhood;

class SubNeighborhoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!SubNeighborhood::count()) {
            $neighborhoods = Neighborhood::all();

            SubNeighborhood::insert([
                [
                    'name'            => 'الأول',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'الثاني',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'الثالث',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'الرابع',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'الخامس',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'السادس',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'السابع',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'الثامن',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'التاسع',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'العاشر',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
                [
                    'name'            => 'الحادي عشر',
                    "neighborhood_id" => $neighborhoods->random()->id,
                ],
            ]);
        }
    }
}
