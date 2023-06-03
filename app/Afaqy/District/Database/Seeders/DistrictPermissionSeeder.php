<?php

namespace Afaqy\District\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class DistrictPermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-district')->count()) {
            Permission::create([
                'name'         => 'read-district',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل البلديات',
                'module'       => 'district',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-district')->count()) {
            Permission::create([
                'name'         => 'create-district',
                'display_name' => 'إضافة',
                'description'  => 'إضافة بلدية جديد',
                'module'       => 'district',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-district')->count()) {
            Permission::create([
                'name'         => 'update-district',
                'display_name' => 'تعديل',
                'description'  => 'تعديل بلدية',
                'module'       => 'district',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-district')->count()) {
            Permission::create([
                'name'         => 'delete-district',
                'display_name' => 'حذف',
                'description'  => 'حذف بلدية',
                'module'       => 'district',
            ]);
        }
    }
}
