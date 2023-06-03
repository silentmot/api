<?php

namespace Afaqy\Inspector\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Inspector\Models\Ticket;

class TicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ticket::class, 20)->create();
    }
}
