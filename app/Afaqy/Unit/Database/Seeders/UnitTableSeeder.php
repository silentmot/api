<?php

namespace Afaqy\Unit\Database\Seeders;

use Afaqy\Unit\Models\Unit;
use Illuminate\Database\Seeder;
use Afaqy\UnitType\Models\UnitType;
use Afaqy\WasteType\Models\WasteType;
use Afaqy\Contractor\Models\Contractor;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $waste_types = $this->createWasteType();
        $unit_types  = $this->createUnitType($waste_types);
        $this->createUnit($waste_types, $unit_types);
    }

    public function createWasteType()
    {
        if (!WasteType::count()) {
            WasteType::insert([
                ['name' => "دمارات أفراد"],
                ['name' => "دمارات مشاريع"],
                ['name' => "امر اتلاف حكومى"],
                ['name' => "امر اتلاف تجارى"],
            ]);

            return factory(WasteType::class, 20)->create();
        }
    }

    public function createUnitType($waste_types)
    {
        if (!UnitType::count()) {
            $unit_types = factory(UnitType::class, 4)->create();

            foreach ($unit_types as $type) {
                $type->wasteTypes()->sync($waste_types);
            }

            return $unit_types;
        }
    }

    public function createUnit($waste_types, $unit_types)
    {
        if (!Unit::count()) {
            $contractors = Contractor::select('id')->get();

            foreach ($contractors as $key => $contractor) {
                factory(Unit::class, 15)->create([
                    'contractor_id' => $contractor->id,
                ]);
            }
        }
    }

    public function generateRandomChars($length = 3)
    {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length);
    }
}
