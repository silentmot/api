<?php

namespace Afaqy\Inspector\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class TicketPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->readPermission();
        $this->updatePermission();
    }

    public function readPermission()
    {
        if (!Permission::where('name', 'read-inspector')->count()) {
            Permission::create([
                'name'         => 'read-inspector',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل المخالفات',
                'module'       => 'inspector',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-inspector')->count()) {
            Permission::create([
                'name'         => 'update-inspector',
                'display_name' => 'تعديل',
                'description'  => 'تعديل مخالفه',
                'module'       => 'inspector',
            ]);
        }
    }
}
