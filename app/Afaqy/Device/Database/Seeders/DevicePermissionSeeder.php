<?php

namespace Afaqy\Device\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class DevicePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-device')->count()) {
            Permission::create([
                'name'         => 'read-device',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل الأجهزة',
                'module'       => 'device',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-device')->count()) {
            Permission::create([
                'name'         => 'create-device',
                'display_name' => 'إضافة',
                'description'  => 'إضافة جهاز جديد',
                'module'       => 'device',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-device')->count()) {
            Permission::create([
                'name'         => 'update-device',
                'display_name' => 'تعديل',
                'description'  => 'تعديل جهاز',
                'module'       => 'device',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-device')->count()) {
            Permission::create([
                'name'         => 'delete-device',
                'display_name' => 'حذف',
                'description'  => 'حذف جهاز',
                'module'       => 'device',
            ]);
        }
    }
}
