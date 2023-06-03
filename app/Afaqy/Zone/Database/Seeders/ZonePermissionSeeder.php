<?php

namespace Afaqy\Zone\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class ZonePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->readPermission();
        $this->createPermission();
        $this->updatePermission();
        $this->deletePermission();
    }

    public function readPermission()
    {
        if (!Permission::where('name', 'read-zone')->count()) {
            Permission::create([
                'name'         => 'read-zone',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل مناطق',
                'module'       => 'zone',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-zone')->count()) {
            Permission::create([
                'name'         => 'create-zone',
                'display_name' => 'إضافة',
                'description'  => 'إضافة منطقة جديد',
                'module'       => 'zone',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-zone')->count()) {
            Permission::create([
                'name'         => 'update-zone',
                'display_name' => 'تعديل',
                'description'  => 'تعديل منطقة',
                'module'       => 'zone',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-zone')->count()) {
            Permission::create([
                'name'         => 'delete-zone',
                'display_name' => 'حذف',
                'description'  => 'حذف منطقة',
                'module'       => 'zone',
            ]);
        }
    }
}
