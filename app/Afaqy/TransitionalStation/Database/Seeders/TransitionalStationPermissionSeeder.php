<?php

namespace Afaqy\TransitionalStation\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class TransitionalStationPermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-transitional-station')->count()) {
            Permission::create([
                'name'         => 'read-transitional-station',
                'display_name' => 'عرض',
                'description'  => 'عرض تفاصيل المحطات الانتقالية',
                'module'       => 'transitional-station',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-transitional-station')->count()) {
            Permission::create([
                'name'         => 'create-transitional-station',
                'display_name' => 'إضافة',
                'description'  => 'إضافة محطة الانتقالية جديد',
                'module'       => 'transitional-station',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-transitional-station')->count()) {
            Permission::create([
                'name'         => 'update-transitional-station',
                'display_name' => 'تعديل',
                'description'  => 'تعديل المحطة الانتقالية',
                'module'       => 'transitional-station',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-transitional-station')->count()) {
            Permission::create([
                'name'         => 'delete-transitional-station',
                'display_name' => 'حذف',
                'description'  => 'حذف المحطة الانتقالية',
                'module'       => 'transitional-station',
            ]);
        }
    }
}
