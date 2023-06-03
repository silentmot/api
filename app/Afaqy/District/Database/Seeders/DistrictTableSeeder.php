<?php

namespace Afaqy\District\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\District\Models\District;

class DistrictTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!District::count()) {
            District::insert([
                [
                    'name'   => 'ابحر الشمالية',
                    'points' => json_encode([
                        "lat"  => 21.589076396114503,
                        "lng"  => 39.14751267323918,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'ذهبان',
                    'points' => json_encode([
                        "lat"  => 21.584073882808145,
                        "lng"  => 39.20940022406377,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'ثول',
                    'points' => json_encode([
                        "lat"  => 21.617112336143418,
                        "lng"  => 39.17526128403858,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'ابحر',
                    'points' => json_encode([
                        "lat"  => 21.55310346488004,
                        "lng"  => 39.22226665874665,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'الشرفية',
                    'points' => json_encode([
                        "lat"  => 21.55597728727957,
                        "lng"  => 39.18589753670975,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'العزيزية',
                    'points' => json_encode([
                        "lat"  => 21.5649177039060971,
                        "lng"  => 39.12825590933047,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'الصفا',
                    'points' => json_encode([
                        "lat"  => 21.62019714847728,
                        "lng"  => 39.146230700993414,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'المطار',
                    'points' => json_encode([
                        "lat"  => 21.591289530673908,
                        "lng"  => 39.19014813137759,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'الجامعة',
                    'points' => json_encode([
                        "lat"  => 21.599429733957468,
                        "lng"  => 39.161670422612865,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'التاريخية',
                    'points' => json_encode([
                        "lat"  => 21.55888379387793,
                        "lng"  => 39.14752415161886,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'البلد',
                    'points' => json_encode([
                        "lat"  => 21.608134618576226,
                        "lng"  => 39.22128023208765,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'ام السلم',
                    'points' => json_encode([
                        "lat"  => 21.618827271767454,
                        "lng"  => 39.12452464327242,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'ابرق الرغامة',
                    'points' => json_encode([
                        "lat"  => 21.542205747408097,
                        "lng"  => 39.12040738417393,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'بريمان',
                    'points' => json_encode([
                        "lat"  => 21.602867797336962,
                        "lng"  => 39.283039118565426,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'افيردا',
                    'points' => json_encode([
                        "lat"  => 21.550827691426083,
                        "lng"  => 39.294018476161476,
                        "zoom" => 15,
                    ]),
                ],
                [
                    'name'   => 'المليساء',
                    'points' => json_encode([
                        "lat"  => 21.62233811977604,
                        "lng"  => 39.23225958968369,
                        "zoom" => 15,
                    ]),
                ],
            ]);
        }
    }
}
