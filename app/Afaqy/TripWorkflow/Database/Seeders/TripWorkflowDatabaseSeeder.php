<?php

namespace Afaqy\TripWorkflow\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TripWorkflowDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ZkTableSeeder::class);
        $this->call(AvlTableSeeder::class);
        $this->call(MasaderTableSeeder::class);
        $this->call(SLFTableSeeder::class);
    }
}
