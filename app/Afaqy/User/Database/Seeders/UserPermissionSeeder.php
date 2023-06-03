<?php

namespace Afaqy\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class UserPermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-user')->count()) {
            Permission::create([
                'name'         => 'read-user',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل المستخدمين',
                'module'       => 'user',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-user')->count()) {
            Permission::create([
                'name'         => 'create-user',
                'display_name' => 'إضافة',
                'description'  => 'إضافة مستخدم جديد',
                'module'       => 'user',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-user')->count()) {
            Permission::create([
                'name'         => 'update-user',
                'display_name' => 'تعديل',
                'description'  => 'تعديل مستخدم',
                'module'       => 'user',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-user')->count()) {
            Permission::create([
                'name'         => 'delete-user',
                'display_name' => 'حذف',
                'description'  => 'حذف مستخدم',
                'module'       => 'user',
            ]);
        }
    }
}
