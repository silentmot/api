<?php

namespace Afaqy\Integration\Database\Seeders;

use Laravel\Passport\Client;
use Illuminate\Database\Seeder;

class CapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::firstOrCreate([
            'id'                       => 8,
            'name'                     => 'CAP',
            'secret'                   => 'FA8QkYNFVMVj1f3KWCyrmT0dDJ3zpQTGG1ROMDqI',
            'redirect'                 => '',
            'personal_access_client'   => 0,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);
    }
}
