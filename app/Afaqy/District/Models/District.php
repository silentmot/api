<?php

namespace Afaqy\District\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Afaqy\District\Models\Filters\DistrictsFilter;
use Afaqy\TransitionalStation\Models\TransitionalStation;

class District extends Model
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
        'name',
        'status',
        'points',
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
     * Set user filtration class.
     * @return string
     */
    public function modelFilter(): string
    {
        return $this->provideFilter(DistrictsFilter::class);
    }

    /**
     * The neighborhoods that belong to the district.
     */
    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'district_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transitionalStations()
    {
        return $this->belongsToMany(TransitionalStation::class, 'district_transitional_station');
    }

    /**
     * The neighborhoods ids that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithNeighborhoods($query)
    {
        return $query->leftJoin('neighborhoods', 'districts.id', '=', 'neighborhoods.district_id');
    }

    /**
     * The all neighborhoods ids (neighborhoods/sub neighborhoods) that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithAllNeighborhoods($query)
    {
        return $query->withNeighborhoods()
            ->leftJoin('sub_neighborhoods', 'neighborhoods.id', '=', 'sub_neighborhoods.neighborhood_id');
    }

    /**
     * The active neighborhoods that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithFilteredActiveNeighborhoods($query)
    {
        return $query->leftJoin('neighborhoods', function ($query) {
            return $query->on('districts.id', '=', 'neighborhoods.district_id')
                ->where('neighborhoods.status', '=', 1);
        });
    }

    /**
     * The all active neighborhoods (neighborhoods/sub neighborhoods) that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithFilteredActiveAllNeighborhoods($query)
    {
        return $query->withFilteredActiveNeighborhoods()
            ->leftJoin('sub_neighborhoods', 'neighborhoods.id', '=', 'sub_neighborhoods.neighborhood_id');
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
     * The contracts ids that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContractsIds($query)
    {
        return $query->leftJoin('contract_district', 'contract_district.district_id', '=', 'districts.id');
    }

    /**
     * The contracts that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContracts($query)
    {
        return $query->withContractsIds()
            ->leftJoin('contracts', 'contract_district.contract_id', '=', 'contracts.id');
    }

    /**
     * The active contracts that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithActiveContracts($query)
    {
        return $query->withContractsIds()
            ->leftJoin('contracts', 'contract_district.contract_id', '=', 'contracts.id')
            ->where(function ($query) {
                return $query->where('contracts.status', DB::raw(1))
                    ->where('contracts.end_at', '>=', Carbon::now()->toDateString());
            });
    }

    /**
     * The contracts that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCommonContractsIds($query)
    {
        return $query->join('contract_district', 'contract_district.district_id', '=', 'districts.id');
    }

    /**
     * The stations that belong to districts.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithStationsIds($query)
    {
        return $query->leftJoin('district_transitional_station', 'district_transitional_station.district_id', '=', 'districts.id');
    }

    /**
     * The common stations ids that belong to districts.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCommonStationsIds($query)
    {
        return $query->join('district_transitional_station', 'district_transitional_station.district_id', '=', 'districts.id');
    }

    /**
     * The contracts that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithStations($query)
    {
        return $query->withStationsIds()
            ->leftJoin('transitional_stations', 'district_transitional_station.transitional_station_id', '=', 'transitional_stations.id');
    }

    /**
     * The common stations that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCommonStations($query)
    {
        return $query->withCommonStationsIds()
            ->join('transitional_stations', 'district_transitional_station.transitional_station_id', '=', 'transitional_stations.id');
    }

    /**
     * The contracts that belong to districts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithUnits($query)
    {
        return $query->leftJoin('units', 'contract_district.unit_id', '=', 'units.id');
    }
}
