<?php

namespace Afaqy\Dashboard\Database\Seeders;

use Afaqy\Unit\Models\Unit;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Afaqy\District\Models\District;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\Permission\Models\PermitUnit;
use Illuminate\Database\Eloquent\Model;
use Afaqy\TripWorkflow\Models\TripUnitInformation;

class TripUnitTableSeeder extends Seeder
{
    public $contract_units;

    public $permission_units;

    public $districts;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (!TripUnitInformation::count()) {
            $logs = $this->logsGenerator();

            foreach ($logs->chunk(1000) as $chunk) {
                TripUnitInformation::insert($chunk->toArray());
            }
        }
    }

    public function logsGenerator()
    {
        $this->setLogComponents();

        $trips        = Trip::select(['id', 'plate_number', 'trip_unit_type'])->orderBy('id')->get();
        $logs         = [];
        $contract_key = 0;

        foreach ($trips as $trip) {
            if ($trip->trip_unit_type == 'permission') {
                $logs[] = $this->getPermissionUnitData($trip);

                continue;
            }

            $station = (++$contract_key % 50) ? false : true;

            $logs[] = $this->getContractUnitData($trip, $station);
        }

        // Storage::disk('local')->put('file.txt', var_export($logs, true));

        return collect($logs);
    }

    public function setLogComponents()
    {
        $this->contract_units = Unit::withTypes()->withContractors()->select([
            'units.id',
            'units.code',
            'units.plate_number',
            'units.rfid',
            'units.qr_code',
            'units.net_weight',
            'units.max_weight',
            'waste_types.name as waste_type',
            'unit_types.name as unit_type',
            'contractors.id as contractor_id',
            'contractors.name_ar as contractor_name',
            'contractors.avl_company as avl_company',
        ])
            ->where('units.active', 1)
            ->get();

        $this->permission_units = PermitUnit::select([
            'id',
            'plate_number',
            'rfid',
            'qr_code',
        ])
            ->get();

        $this->districts = District::withNeighborhoods()->select([
            'districts.id',
            'districts.name',
            'neighborhoods.id as neighborhood_id',
            'neighborhoods.name as neighborhood_name',
        ])
            ->get();
    }

    public function getPermissionUnitData($trip)
    {
        $unit       = $this->permission_units->where('plate_number', $trip->plate_number)->first();
        $waste_type = Arr::random([
            ['individual', 'دمارات أفراد'],
            ['project', 'دمارات مشاريع'],
            ['commercial', 'امر اتلاف تجارى'],
            ['governmental', 'امر اتلاف حكومى'],
            ['sorting', ['كتب', 'مخطوطات', 'زجاجات غازية', 'علب صفيح']],
        ]);

        return [
            'trip_id'           => $trip->id,
            'unit_id'           => $unit->id,
            'unit_code'         => null,
            'rfid'              => $unit->rfid,
            'qr_code'           => $unit->qr_code,
            'unit_type'         => null,
            'waste_type'        => ($waste_type[0] == 'sorting') ? Arr::random($waste_type[1]) : $waste_type[1],
            'net_weight'        => null,
            'max_weight'        => null,
            'permission_id'     => rand(1, 100),
            'permission_type'   => $waste_type[0],
            'permission_number' => rand(10000000, 99999999),
            'demolition_serial' => rand(10000000, 99999999),
            'contract_id'       => null,
            'contract_type'     => null,
            'contract_number'   => null,
            'contractor_id'     => null,
            'contractor_name'   => null,
            'avl_company'       => null,
            'district_id'       => null,
            'district_name'     => null,
            'neighborhood_id'   => null,
            'neighborhood_name' => null,
            'station_id'        => null,
            'station_name'      => null,
        ];
    }

    public function getContractUnitData($trip, $station = false)
    {
        $unit     = $this->contract_units->where('plate_number', $trip->plate_number)->first();
        $district = $this->districts->random();

        $data = [
            'trip_id'           => $trip->id,
            'unit_id'           => $unit->id,
            'unit_code'         => $unit->code,
            'rfid'              => $unit->rfid,
            'qr_code'           => $unit->qr_code,
            'unit_type'         => $unit->unit_type,
            'waste_type'        => $unit->waste_type,
            'net_weight'        => (int) $unit->net_weight,
            'max_weight'        => (int) $unit->max_weight,
            'permission_id'     => null,
            'permission_type'   => null,
            'permission_number' => null,
            'demolition_serial' => null,
            'contract_id'       => rand(1, 100),
            'contract_type'     => ($station) ? 'station' : 'district',
            'contract_number'   => rand(1, 100),
            'contractor_id'     => $unit->contractor_id,
            'contractor_name'   => $unit->contractor_name,
            'avl_company'       => $unit->avl_company,
            'district_id'       => $district->id,
            'district_name'     => $district->name,
            'neighborhood_id'   => $district->neighborhood_id,
            'neighborhood_name' => $district->neighborhood_name,
            'station_id'        => null,
            'station_name'      => null,
        ];

        if ($station) {
            $station_data         = ['Al-Murjan', 'Al-Basateen', 'Al-Mohamadiya', 'Ash-Shati', 'An-Nahda'];
            $data['station_id']   = rand(1, 5);
            $data['station_name'] = $station_data[$data['station_id'] - 1];
        }

        return $data;
    }
}
