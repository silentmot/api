<?php

namespace Afaqy\EntrancePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class EntrancePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createEntrancePermissions();
    }

    public function createEntrancePermissions()
    {
        if (!EntrancePermission::count()) {
            $permissions =  factory(EntrancePermission::class, 100)->create();

            return $permissions;
        }
    }
}
