<?php

namespace Afaqy\District\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\District\Models\District;
use Afaqy\District\Models\Neighborhood;

class NeighborhoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Neighborhood::count()) {
            $districts = District::all();

            Neighborhood::insert([
                [
                    "name"        => "البندر",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الأمواج",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفردوس",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الصوارى",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "اللؤلؤ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الزمرد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الياقوت",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الشراع",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مخطط بلبيد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "99 ج م س",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الشاطي الزهبي",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المنارات",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفيروز",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "ذهبان الغربية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "ذهبان الشرقية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "طيبة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مشارف",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "خليج سلمان",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الصوالحة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الكنادرة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الجنوب الشرقي",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الجنوب الغربي",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الشمالية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "أبو زيد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الاسكان الخيري",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البحارة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السراحين",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حارة الأمير",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الروضة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السلامة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الخالدية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الشاطئ ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الزهراء",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "النعيم ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المحمدية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "النهضة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الشاطئ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "أبحر الجنوبية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المرجان ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البساتين",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي الشرفية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي الرويس",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي بني مالك  ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي الورود ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي النسيم ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي الأندلس ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي الحمراء ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي الرحاب ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي العزيزية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "حي مشرفة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الصفا",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المروة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفيصلية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البوادى ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الربوة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "النزهة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الثغر ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفيحاء",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السليمانية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الجامعة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الروابي ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البلد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "العمارية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الصحيفة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الكندرة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السبيل ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البغدادية الشرقية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البغدادية الغربية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المنتزهات",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "كيلو 14",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البورما ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "القحاطين ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الحرازات",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المحاميد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الواحة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "النخيل",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "وادى مريخ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الرغامة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "التيسير",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الكيلو 14",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفضل ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفاروق",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "العدل",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الامير فواز",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الأمير عبد المجيد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الجوهرة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السنابل",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الأجاويد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الهدى",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مخطط المعالي ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مخطط الالفية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مخطط الواحة ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مخطط الشفا",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مخطط الهدا",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السامر",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المنار",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الاجواد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الاجواد الشعبي",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "بريمان الشعبي",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الريان ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الكوثر ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "أم حبلين",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفلاح",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الرحمانية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الصالحية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الحمدانية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الفروسية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "البشاير",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "مدائن الفهد",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "النزلة الشرقية ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "النزلة اليمانية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "القريات ",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الثعالبة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "غليل",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "بترومين",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الجوهرة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الوزيرية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المحجر",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الصناعية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السرورية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الخمرة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "السروات",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "القرينية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الضاحية",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الوادي",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "الساحل",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المسرة",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "المليساء",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "القوزين",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
                [
                    "name"        => "عقد الكورنيش",
                    "population"  => rand(100000, 999999),
                    "district_id" => $districts->random()->id,
                ],
            ]);
        }
    }
}
