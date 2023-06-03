<?php

namespace Afaqy\TripWorkflow\Actions\UnitInformation;

use Afaqy\Unit\Models\Unit;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;

class GetContractUnitInformationAction extends Action
{
    /**
     * @var array
     */
    private $checker;

    /**
     * @var array
     */
    private $date;

    /**
     * @param array $checker
     * @param string $date
     * @return void
     */
    public function __construct(array $checker, string $date)
    {
        $this->checker = $checker;
        $this->date    = $date;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $district_unit = $this->getDistrictUnit($this->checker, $this->date);

        if ($district_unit) {
            return $this->format($district_unit);
        }

        $station_unit = $this->getStationUnit($this->checker, $this->date);

        if ($station_unit) {
            return $this->format($station_unit);
        }

        return [];
    }

    /**
     * @param  array  $checker
     * @param string $date
     * @return Model|null
     */
    private function getDistrictUnit(array $checker, string $date)
    {
        $query = Unit::withTypes()
            ->withContractors()
            ->withContracts()
            ->withDistricts()
            ->withNeighborhoods();

        return $query->select([
            'units.id',
            'units.code',
            'units.plate_number',
            'units.qr_code',
            'units.rfid',
            'units.net_weight',
            'units.max_weight',
            'unit_types.name as unit_type',
            'waste_types.name as waste_type',
            'contracts.id as contract_id',
            'contracts.contract_number as contract_number',
            DB::raw("'district' as contract_type"),
            'contractors.id as contractor_id',
            'contractors.name_ar as contractor_name',
            'contractors.avl_company',
            'districts.id as district_id',
            'districts.name as district_name',
            'neighborhoods.id as neighborhood_id',
            'neighborhoods.name as neighborhood_name',
        ])
            ->where('units.' . $checker['field'], $checker['value'])
            ->where('units.active', 1)
            ->where('contracts.status', 1)
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->whereNull('contracts.deleted_at')
            ->where('districts.status', 1)
            ->where('neighborhoods.status', 1)
            ->orderBy('contracts.id', 'desc')
            ->first();
    }

    /**
     * @param  array  $checker
     * @param string $date
     * @return Model|null
     */
    private function getStationUnit(array $checker, string $date)
    {
        $query = Unit::withTypes()
            ->withContractors()
            ->withStations();

        return $query->select([
            'units.id',
            'units.code',
            'units.plate_number',
            'units.qr_code',
            'units.rfid',
            'units.net_weight',
            'units.max_weight',
            'unit_types.name as unit_type',
            'waste_types.name as waste_type',
            'contracts.id as contract_id',
            'contracts.contract_number as contract_number',
            DB::raw("'station' as contract_type"),
            'contractors.id as contractor_id',
            'contractors.name_ar as contractor_name',
            'contractors.avl_company',
            'transitional_stations.id as station_id',
            'transitional_stations.name as station_name',
        ])
            ->where('units.' . $checker['field'], $checker['value'])
            ->where('units.active', 1)
            ->where('contracts.status', 1)
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->whereNull('contracts.deleted_at')
            ->where('transitional_stations.status', 1)
            ->orderBy('contracts.id', 'desc')
            ->first();
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $unit
     * @return array
     */
    private function format($data): array
    {
        $unit = [
            'id'           => $data->id,
            'unit_code'    => $data->code,
            'plate_number' => $data->plate_number,
            'qr_code'      => $data->qr_code,
            'rfid'         => $data->rfid,
            'net_weight'   => $data->net_weight,
            'max_weight'   => $data->max_weight,
            'type'         => $data->unit_type,
            'waste_type'   => $data->waste_type,
        ];

        $unit['contract'] = [
            'id'     => $data->contract_id,
            'number' => $data->contract_number,
            'type'   => $data->contract_type,
        ];

        $unit['contractor'] = [
            'id'          => $data->contractor_id,
            'name'        => $data->contractor_name,
            'avl_company' => $data->avl_company,
        ];

        if ($data->district_id ?? false) {
            $unit['district'] = [
                'id'           => $data->district_id,
                'name'         => $data->district_name,
                'neighborhood' => [
                    'id'   => $data->neighborhood_id,
                    'name' => $data->neighborhood_name,
                ],
            ];

            return $unit;
        }

        $unit['station'] = [
            'id'   => $data->station_id,
            'name' => $data->station_name,
        ];

        return $unit;
    }
}
