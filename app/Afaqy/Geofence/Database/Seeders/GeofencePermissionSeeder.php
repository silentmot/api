<?php

namespace Afaqy\Geofence\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class GeofencePermissionSeeder extends Seeder
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
        if (!Permission::where('name', 'read-geofence')->count()) {
            Permission::create([
                'name'         => 'read-geofence',
                'display_name' => 'عرض',
                'description'  => 'عرض المناطق الجغرافية',
                'module'       => 'geofence',
            ]);
        }
    }

    public function createPermission()
    {
        if (!Permission::where('name', 'create-geofence')->count()) {
            Permission::create([
                'name'         => 'create-geofence',
                'display_name' => 'إضافة',
                'description'  => 'إضافة منطقة جغرافية جديد',
                'module'       => 'geofence',
            ]);
        }
    }

    public function updatePermission()
    {
        if (!Permission::where('name', 'update-geofence')->count()) {
            Permission::create([
                'name'         => 'update-geofence',
                'display_name' => 'تعديل',
                'description'  => 'تعديل منطقة جغرافية',
                'module'       => 'geofence',
            ]);
        }
    }

    public function deletePermission()
    {
        if (!Permission::where('name', 'delete-geofence')->count()) {
            Permission::create([
                'name'         => 'delete-geofence',
                'display_name' => 'حذف',
                'description'  => 'حذف منطقة جغرافية',
                'module'       => 'geofence',
            ]);
        }
    }
}
