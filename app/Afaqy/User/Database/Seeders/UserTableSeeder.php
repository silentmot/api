<?php

namespace Afaqy\User\Database\Seeders;

use Afaqy\User\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (in_array(config('app.env'), ['local', 'develop', 'test']) && !User::where('username', 'owner')->count()) {
            factory(User::class)->create([
                'first_name' => 'مدير',
                'last_name'  => 'أفاقي',
                'username'   => 'owner',
                'email'      => 'owner@afaqy.com',
                'password'   => bcrypt('P@ssword'),
                'use_mob'    => true,
            ]);

            factory(User::class)->create([
                'first_name' => 'dev',
                'last_name'  => 'team',
                'username'   => 'monitor',
                'email'      => 'monitor@afaqy.com',
                'password'   => bcrypt('Monitor123*#'),
                'use_mob'    => true,
            ]);
        }

        if (!User::where('username', 'mardam')->count()) {
            factory(User::class)->create([
                'first_name' => 'مدير',
                'last_name'  => 'مردم',
                'username'   => 'mardam',
                'email'      => 'user@mardam.com',
            ]);
        }

        if (!User::where('username', 'selim')->count()) {
            factory(User::class)->create([
                'first_name' => 'سليم',
                'last_name'  => 'سليم',
                'username'   => 'selim',
                'email'      => 'm.selim@afaqy.com',
            ]);
        }

        if (!User::where('username', 'nada')->count()) {
            factory(User::class)->create([
                'first_name' => 'ندي',
                'last_name'  => 'احمد',
                'username'   => 'nada',
                'email'      => 'nada.ahmed@afaqy.com',
                'use_mob'    => true,
            ]);
        }

        if (config('app.env') == 'uat') {
            if (!User::where('username', 'owner')->count()) {
                factory(User::class)->create([
                    'first_name' => 'مدير',
                    'last_name'  => 'أفاقي',
                    'username'   => 'owner',
                    'email'      => 'owner@afaqy.com',
                    'use_mob'    => true,
                ]);
            }
            if (!User::where('username', 'marwa')->count()) {
                factory(User::class)->create([
                    'first_name' => 'مروة',
                    'last_name'  => 'سعد',
                    'username'   => 'marwa',
                    'email'      => 'marwa.saad@afaqy.com',
                    'password'   => bcrypt('M@Saad75'),
                ]);
            }
        }

        if (config('app.env') == 'test') {
            if (!User::where('username', 'marwa')->count()) {
                factory(User::class)->create([
                    'first_name' => 'مروة',
                    'last_name'  => 'سعد',
                    'username'   => 'marwa',
                    'email'      => 'marwa.saad@afaqy.com',
                    'password'   => bcrypt('M@Saad75'),
                ]);
            }
        }
    }
}
