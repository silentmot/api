<?php

namespace Afaqy\Contract\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class ContractPermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-contract')->count()) {
            Permission::create([
                'name'         => 'read-contract',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل العقود',
                'module'       => 'contract',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-contract')->count()) {
            Permission::create([
                'name'         => 'create-contract',
                'display_name' => 'إضافة',
                'description'  => 'إضافة عقد جديد',
                'module'       => 'contract',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-contract')->count()) {
            Permission::create([
                'name'         => 'update-contract',
                'display_name' => 'تعديل',
                'description'  => 'تعديل عقد',
                'module'       => 'contract',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-contract')->count()) {
            Permission::create([
                'name'         => 'delete-contract',
                'display_name' => 'حذف',
                'description'  => 'حذف عقد',
                'module'       => 'contract',
            ]);
        }
    }
}
