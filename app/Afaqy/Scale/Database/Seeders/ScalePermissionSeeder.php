<?php

namespace Afaqy\Scale\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class ScalePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-scale')->count()) {
            Permission::create([
                'name'         => 'read-scale',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل الموازين',
                'module'       => 'scale',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-scale')->count()) {
            Permission::create([
                'name'         => 'create-scale',
                'display_name' => 'إضافة',
                'description'  => 'إضافة ميزان جديد',
                'module'       => 'scale',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-scale')->count()) {
            Permission::create([
                'name'         => 'update-scale',
                'display_name' => 'تعديل',
                'description'  => 'تعديل ميزان',
                'module'       => 'scale',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-scale')->count()) {
            Permission::create([
                'name'         => 'delete-scale',
                'display_name' => 'حذف',
                'description'  => 'حذف ميزان',
                'module'       => 'scale',
            ]);
        }
    }
}
