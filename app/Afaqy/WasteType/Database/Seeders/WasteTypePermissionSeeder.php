<?php

namespace Afaqy\WasteType\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class WasteTypePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-waste-type')->count()) {
            Permission::create([
                'name'         => 'read-waste-type',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل انواع القمامة',
                'module'       => 'waste-type',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-waste-type')->count()) {
            Permission::create([
                'name'         => 'create-waste-type',
                'display_name' => 'إضافة',
                'description'  => 'إضافة نوع قمامة جديد',
                'module'       => 'waste-type',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-waste-type')->count()) {
            Permission::create([
                'name'         => 'update-waste-type',
                'display_name' => 'تعديل',
                'description'  => 'تعديل نوع قمامة',
                'module'       => 'waste-type',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-waste-type')->count()) {
            Permission::create([
                'name'         => 'delete-waste-type',
                'display_name' => 'حذف',
                'description'  => 'حذف نوع قمامة',
                'module'       => 'waste-type',
            ]);
        }
    }
}
