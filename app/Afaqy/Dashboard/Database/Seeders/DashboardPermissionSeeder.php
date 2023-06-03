<?php

namespace Afaqy\Dashboard\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Permission;

class DashboardPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Permission::where('name', 'read-dashboard')->count()) {
            Permission::create([
                'name'         => 'read-dashboard',
                'display_name' => 'عرض لوحة التحكم',
                'description'  => 'عرض تفاصيل لوحة التحكم',
                'module'       => 'dashboard',
            ]);
        }
    }
}
