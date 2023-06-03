<?php

namespace Afaqy\UnitType\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class UnitTypePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-unit-type')->count()) {
            Permission::create([
                'name'         => 'read-unit-type',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل انواع المركبات',
                'module'       => 'unit-type',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-unit-type')->count()) {
            Permission::create([
                'name'         => 'create-unit-type',
                'display_name' => 'إضافة',
                'description'  => 'إضافة نوع مركبة جديد',
                'module'       => 'unit-type',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-unit-type')->count()) {
            Permission::create([
                'name'         => 'update-unit-type',
                'display_name' => 'تعديل',
                'description'  => 'تعديل نوع مركبة',
                'module'       => 'unit-type',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-unit-type')->count()) {
            Permission::create([
                'name'         => 'delete-unit-type',
                'display_name' => 'حذف',
                'description'  => 'حذف نوع مركبة',
                'module'       => 'unit-type',
            ]);
        }
    }
}
