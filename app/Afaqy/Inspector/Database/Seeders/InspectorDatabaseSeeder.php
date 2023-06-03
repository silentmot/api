<?php

namespace Afaqy\Inspector\Database\Seeders;

use Laravel\Passport\Client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class InspectorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Client::firstOrCreate([
            'id'                       => 11,
            'name'                     => 'Personal Token',
            'secret'                   => 'drIyOMRPUZBdBPX3tFhIbsRka6VPRTsxaoiJFgiJ',
            'redirect'                 => 'http://localhost',
            'personal_access_client'   => 1,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);
    }
}
