<?php

namespace Afaqy\Contractor\Http\Reports;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Unit\Http\Transformers\UnitSelectListTransformer;

class ContractorUnitsListReport extends Report
{
    use Generator;

    /**
     * @var int
     */
    private $contractor_id;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @param int $contractor_id
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(int $contractor_id, Request $request)
    {
        $this->contractor_id = $contractor_id;
        $this->request       = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateSelectList(
            $this->query(),
            new UnitSelectListTransformer()
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $used_units = $this->getUsedUnitsList($this->contractor_id, $this->request->except_contract);

        return Unit::select([
            'units.id',
            'units.plate_number',
        ])
            ->where('active', 1)
            ->where('contractor_id', $this->contractor_id)
            ->whereNotIn('id', $used_units);
    }

    /**
     * Get all used/contracted units.
     *
     * @param  int $contractor_id
     * @param  int|null $except_contract
     * @return array
     */
    private function getUsedUnitsList(int $contractor_id, ? int $except_contract = null) : array
    {
        $districts_units            = $this->getUsedDistrictsUnits($contractor_id, $except_contract);
        $stations_units             = $this->getUsedStationsUnits($contractor_id, $except_contract);
        $entrance_permissions_units = $this->getUsedEntrancePermissionsUnits($contractor_id);
        $permissions_units          = $this->getUsedPermissionsUnits($contractor_id);

        return array_unique(
            array_merge($districts_units, $stations_units, $entrance_permissions_units, $permissions_units)
        );
    }

    /**
     * @param  int $contractor_id
     * @param  int|null $except_contract
     * @return array
     */
    private function getUsedDistrictsUnits(int $contractor_id, ? int $except_contract = null) : array
    {
        $query = Contract::distinct()->select('contract_district.unit_id')
            ->join('contract_district', 'contract_district.contract_id', '=', 'contracts.id')
            ->where('contracts.contractor_id', $contractor_id)
            ->where('contracts.status', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString());

        if ($except_contract) {
            $query->where('contracts.id', '!=', $except_contract);
        }

        return $query->get()->pluck('unit_id')->all();
    }

    /**
     * @param  int $contractor_id
     * @param  int|null $except_contract
     * @return array
     */
    private function getUsedStationsUnits(int $contractor_id, ? int $except_contract = null) : array
    {
        $query = Contract::distinct()->select('contract_station.unit_id')
            ->join('contract_station', 'contract_station.contract_id', '=', 'contracts.id')
            ->where('contracts.contractor_id', $contractor_id)
            ->where('contracts.status', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString());

        if ($except_contract) {
            $query->where('contracts.id', '!=', $except_contract);
        }

        return $query->get()->pluck('unit_id')->all();
    }

    /**
     * @param  int $contractor_id
     * @return array
     */
    private function getUsedEntrancePermissionsUnits(int $contractor_id): array
    {
        return Unit::distinct()->select('units.id')
            ->join('entrance_permissions', 'entrance_permissions.plate_number', '=', 'units.plate_number')
            ->where('entrance_permissions.end_date', '>=', Carbon::now()->toDateString())
            ->whereNull('entrance_permissions.deleted_at')
            ->where('units.contractor_id', $contractor_id)
            ->get()->pluck('id')->all();
    }

    /**
     * @param  int $contractor_id
     * @return array
     */
    private function getUsedPermissionsUnits(int $contractor_id): array
    {
        $permit_units = DB::table('permit_units')
            ->select(['permit_units.plate_number'])
            ->leftJoin('trips_unit_info', function ($query) {
                $query->on('permit_units.id', '=', 'trips_unit_info.unit_id')
                    ->whereNotNull('trips_unit_info.permission_id');
            })
            ->whereNull('trips_unit_info.unit_id');

        return Unit::distinct()->select('units.id')
            ->joinSub($permit_units, 'permit_units', 'permit_units.plate_number', '=', 'units.plate_number')
            ->where('units.contractor_id', $contractor_id)
            ->get()->pluck('id')->all();
    }
}
