<?php

namespace Afaqy\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class RolePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-role')->count()) {
            Permission::create([
                'name'         => 'read-role',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل الوظائف',
                'module'       => 'role',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-role')->count()) {
            Permission::create([
                'name'         => 'create-role',
                'display_name' => 'إضافة',
                'description'  => 'إضافة وظيفة جديد',
                'module'       => 'role',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-role')->count()) {
            Permission::create([
                'name'         => 'update-role',
                'display_name' => 'تعديل',
                'description'  => 'تعديل وظيفة',
                'module'       => 'role',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-role')->count()) {
            Permission::create([
                'name'         => 'delete-role',
                'display_name' => 'حذف',
                'description'  => 'حذف وظيفة',
                'module'       => 'role',
            ]);
        }
    }
}
