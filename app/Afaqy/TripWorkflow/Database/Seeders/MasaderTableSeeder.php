<?php

namespace Afaqy\TripWorkflow\Database\Seeders;

use Laravel\Passport\Client;
use Illuminate\Database\Seeder;

class MasaderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::firstOrCreate([
            'id'                       => 7,
            'name'                     => 'Al-Masader',
            'secret'                   => '04zHGxyH8gGlconlGJp4TAaxEJqY63MQEhppbcyc',
            'redirect'                 => '',
            'personal_access_client'   => 0,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);
    }
}
