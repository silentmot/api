<?php

namespace Afaqy\EntrancePermission\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class EntranceRolePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-entrance')->count()) {
            Permission::create([
                'name'         => 'read-entrance',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل تصاريح الدخول',
                'module'       => 'entrance',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-entrance')->count()) {
            Permission::create([
                'name'         => 'create-entrance',
                'display_name' => 'إضافة',
                'description'  => 'إضافة تصريح جديد',
                'module'       => 'entrance',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-entrance')->count()) {
            Permission::create([
                'name'         => 'update-entrance',
                'display_name' => 'تعديل',
                'description'  => 'تعديل تصريح',
                'module'       => 'entrance',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-entrance')->count()) {
            Permission::create([
                'name'         => 'delete-entrance',
                'display_name' => 'حذف',
                'description'  => 'حذف تصريح',
                'module'       => 'entrance',
            ]);
        }
    }
}
