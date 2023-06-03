<?php

namespace Afaqy\Unit\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class UnitPermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-unit')->count()) {
            Permission::create([
                'name'         => 'read-unit',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل المركبات',
                'module'       => 'unit',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-unit')->count()) {
            Permission::create([
                'name'         => 'create-unit',
                'display_name' => 'إضافة',
                'description'  => 'إضافة مركبة جديد',
                'module'       => 'unit',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-unit')->count()) {
            Permission::create([
                'name'         => 'update-unit',
                'display_name' => 'تعديل',
                'description'  => 'تعديل مركبة',
                'module'       => 'unit',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-unit')->count()) {
            Permission::create([
                'name'         => 'delete-unit',
                'display_name' => 'حذف',
                'description'  => 'حذف مركبة',
                'module'       => 'unit',
            ]);
        }
    }
}
