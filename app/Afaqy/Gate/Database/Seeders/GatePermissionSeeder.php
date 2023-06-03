<?php

namespace Afaqy\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class GatePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-gate')->count()) {
            Permission::create([
                'name'         => 'read-gate',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل البوابات',
                'module'       => 'gate',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-gate')->count()) {
            Permission::create([
                'name'         => 'create-gate',
                'display_name' => 'إضافة',
                'description'  => 'إضافة بوابة جديد',
                'module'       => 'gate',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-gate')->count()) {
            Permission::create([
                'name'         => 'update-gate',
                'display_name' => 'تعديل',
                'description'  => 'تعديل بوابة',
                'module'       => 'gate',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-gate')->count()) {
            Permission::create([
                'name'         => 'delete-gate',
                'display_name' => 'حذف',
                'description'  => 'حذف بوابة',
                'module'       => 'gate',
            ]);
        }
    }
}
