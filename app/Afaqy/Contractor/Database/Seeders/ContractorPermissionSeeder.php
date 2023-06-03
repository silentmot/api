<?php

namespace Afaqy\Contractor\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class ContractorPermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-contractor')->count()) {
            Permission::create([
                'name'         => 'read-contractor',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل المقاولين',
                'module'       => 'contractor',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-contractor')->count()) {
            Permission::create([
                'name'         => 'create-contractor',
                'display_name' => 'إضافة',
                'description'  => 'إضافة مقاول جديد',
                'module'       => 'contractor',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-contractor')->count()) {
            Permission::create([
                'name'         => 'update-contractor',
                'display_name' => 'تعديل',
                'description'  => 'تعديل مقاول',
                'module'       => 'contractor',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-contractor')->count()) {
            Permission::create([
                'name'         => 'delete-contractor',
                'display_name' => 'حذف',
                'description'  => 'حذف مقاول',
                'module'       => 'contractor',
            ]);
        }
    }
}
