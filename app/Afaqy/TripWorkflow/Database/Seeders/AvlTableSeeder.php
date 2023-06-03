<?php

namespace Afaqy\TripWorkflow\Database\Seeders;

use Laravel\Passport\Client;
use Illuminate\Database\Seeder;

class AvlTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::firstOrCreate([
            'id'                       => 3,
            'name'                     => 'Alqimma Co',
            'secret'                   => 'KB4N2MIFvuJDIyC1j0j8b0yMsCxI0ygBDklgmwcX',
            'redirect'                 => '',
            'personal_access_client'   => 0,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);

        Client::firstOrCreate([
            'id'                       => 4,
            'name'                     => 'External vision company',
            'secret'                   => 'I4jlKTknDvaHB3xwUWKG16d5cOMncDIHaBlYByTU',
            'redirect'                 => '',
            'personal_access_client'   => 0,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);

        Client::firstOrCreate([
            'id'                       => 5,
            'name'                     => 'Machines  Talk',
            'secret'                   => 'I1zemJF2KbutVa8UVS9YXqe3YxEAKkFixchJ1ARx',
            'redirect'                 => '',
            'personal_access_client'   => 0,
            'password_client'          => 0,
            'revoked'                  => 0,
        ]);
    }
}
