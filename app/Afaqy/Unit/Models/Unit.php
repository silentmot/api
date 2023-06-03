<?php

namespace Afaqy\Unit\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Afaqy\Unit\Models\Filters\UnitFilter;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use Filterable;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'model',
        'plate_number',
        'vin_number',
        'unit_type_id',
        'waste_type_id',
        'contractor_id',
        'net_weight',
        'max_weight',
        'rfid',
        'qr_code',
        'active',
    ];

    /**
     * @var boolean
     */
    protected static $logOnlyDirty = true;

    /**
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected static $logAttributesToIgnore = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(UnitFilter::class);
    }

    /**
     * Sort by the given column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortBy($query, $request)
    {
        if ($request->has('sort')) {
            $column = Str::snake($request->input('sort'));

            if ($request->has('direction') && $request->input('direction') == 'asc') {
                return $query->orderBy($column, 'asc');
            }

            return $query->orderBy($column, 'desc');
        }

        return $query->orderBy($this->getTable() . '.' . 'id', 'desc');
    }

    /**
     * The waste types that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithWasteTypes($query)
    {
        return $query->leftJoin('waste_types', 'units.waste_type_id', '=', 'waste_types.id');
    }

    /**
     * The unit types that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnitTypes($query)
    {
        return $query->leftJoin('unit_types', 'units.unit_type_id', '=', 'unit_types.id');
    }

    /**
     * all types that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTypes($query)
    {
        return $query->withUnitTypes()->withWasteTypes();
    }

    /**
     * The unit types that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContractors($query)
    {
        return $query->leftJoin('contractors', 'units.contractor_id', '=', 'contractors.id');
    }

    /**
     * The all contracts ids that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContractsIds($query)
    {
        return $query->leftJoin('contract_district', 'units.id', '=', 'contract_district.unit_id');
    }

    /**
     * The all contracts that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContracts($query)
    {
        return $query->withContractsIds()
            ->leftJoin('contracts', 'contracts.id', '=', 'contract_district.contract_id');
    }

    /**
     * The all contracts that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $ids
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWhereContractsActive($query, array $ids = [])
    {
        $query = $query->withContracts()
            ->whereNull('contracts.deleted_at')
            ->where('contracts.status', '=', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString());

        if ($ids) {
            $query->whereIn('units.id', $ids);
        }

        return $query;
    }

    /**
     * The all contracts ids that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithDistricts($query)
    {
        return $query->leftJoin('districts', 'districts.id', '=', 'contract_district.district_id');
    }

    /**
     * The all contracts ids that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithNeighborhoods($query)
    {
        return $query->leftJoin('neighborhoods', 'neighborhoods.id', '=', 'contract_district.neighborhood_id');
    }

    /**
     * The all contracts ids that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithStationContractsIds($query)
    {
        return $query->leftJoin('contract_station', 'units.id', '=', 'contract_station.unit_id');
    }

    /**
     * The all contracts that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithStationContracts($query)
    {
        return $query->withStationContractsIds()
            ->leftJoin('contracts', 'contracts.id', '=', 'contract_station.contract_id');
    }

    /**
     * The all contracts that own units.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithStations($query)
    {
        return $query->withStationContracts()
            ->leftJoin('transitional_stations', 'transitional_stations.id', '=', 'contract_station.station_id');
    }

    /**
     * return all stations that belong to active contract.
     *
     * @param  array  $ids
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWhereStationContractsActive($query, array $ids = [])
    {
        $query = $query->WithStationContracts()
            ->whereNull('contracts.deleted_at')
            ->where('contracts.status', '=', 1)
            ->where('contracts.end_at', '>=', Carbon::now()->toDateString());

        if ($ids) {
            $query->whereIn('units.id', $ids);
        }

        return $query;
    }
}
