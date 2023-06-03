<?php

namespace Afaqy\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class PermissionsRolePermissionSeeder extends Seeder
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
        $this->deletePermission();
    }

    public function readPermission()
    {
        if (!Permission::where('name', 'read-permission')->count()) {
            Permission::create([
                'name'         => 'read-permission',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل التصاريح',
                'module'       => 'permission',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-permission')->count()) {
            Permission::create([
                'name'         => 'create-permission',
                'display_name' => 'إضافة',
                'description'  => 'إضافة تصاريح جديد',
                'module'       => 'permission',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-permission')->count()) {
            Permission::create([
                'name'         => 'delete-permission',
                'display_name' => 'حذف',
                'description'  => 'حذف تصاريح',
                'module'       => 'permission',
            ]);
        }
    }
}
