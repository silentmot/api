<?php

namespace Afaqy\Role\Database\Seeders;

use Afaqy\Role\Models\Role;
use Afaqy\User\Models\User;
use Illuminate\Database\Seeder;

class LaratrustTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner       = $this->owner();
        $admin       = $this->admin();

        $owner_user  = User::where('username', 'owner')->first();
        if ($owner_user != null) {
            $owner_user->attachRole($owner);
        }

        $users = User::where('username', '!=', 'owner')->get();
        foreach ($users as $user) {
            $user->syncRoles([$admin]);
        }
    }

    /**
     * Create owner role.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function owner()
    {
        $owner = Role::firstOrCreate([
            'name'          => 'owner',
            'display_name'  => 'مدير الموقع',
        ]);

        return $owner;
    }

    /**
     * Create owner role.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function admin()
    {
        $owner = Role::firstOrCreate([
            'name'          => 'admin',
            'display_name'  => 'مدير',
        ]);

        return $owner;
    }
}
