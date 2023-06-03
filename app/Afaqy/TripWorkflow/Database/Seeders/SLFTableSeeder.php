<?php

namespace Afaqy\TripWorkflow\Database\Seeders;

use Laravel\Passport\Client;
use Illuminate\Database\Seeder;

class SLFTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::firstOrCreate([
            'id'                       => 10,
            'name'                     => 'slf',
            'secret'                   => 'nNzKrkakW1jwVQiITBOId4DoOfrvhXES6P8T4DE4',
            'redirect'                 => '',
            'personal_access_client'   => 0,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);
    }
}
