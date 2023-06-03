<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Afaqy\WasteType\Models\WasteType;

$factory->define(WasteType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement([
            'منزلية',
            'دمار',
            'عضوية',
            'نفايات السائلة',
            'نفايات الصلبة',
            'نفايات الغازية',
            'نفايات الخطرة',
            'نفايات الحميدة',
            'مخلفات صناعية',
            'مخلفات حيوانية',
            'ورق paper',
            'مخلفات حربية',
            'CARTON كرتون من مصنع الفرز',
            'بلاستيك',
            'بترول',
            'غازات',
            'حديد وصلب',
            'جثث حيوانات',
            'سموم',
            'اخرى (نوع. .)',
        ]),
    ];
});
