<?php

namespace Afaqy\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Role\Models\Notification;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Notification::count()) {
            Notification::insert([
                [
                    'name'         => 'UnitMaxWeightViolation',
                    'display_name' => 'الحمولة القصوي',
                ],
                [
                    'name'         => 'UnitUnloadedViolation',
                    'display_name' => 'عدم تفريغ الحمولة',
                ],
                [
                    'name'         => 'UnitHasNotEntranceWeightViolation',
                    'display_name' => 'عدم المرور علي بوابة الدخول',
                ],
                [
                    'name'         => 'UnendedTripViolation',
                    'display_name' => 'عدم المرور علي بوابة الخروج',
                ],
                [
                    'name'         => 'UnitExceedNetWeightViolation',
                    'display_name' => 'تجاوز اقصي حد للوزن الصافي',
                ],
            ]);
        }
    }
}
