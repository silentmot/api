<?php

namespace Afaqy\TransitionalStation\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\District\Models\District;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Afaqy\TransitionalStation\Models\Filters\TransitionalStationFilter;

class TransitionalStation extends Model
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
        return $this->provideFilter(TransitionalStationFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function districts()
    {
        return $this->belongsToMany(District::class, 'district_transitional_station');
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

        return $query->orderBy($this->getTable() . '.' .'id', 'desc');
    }

    /**
     * The all districts .
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDistrictsIds($query)
    {
        return $query->leftJoin('district_transitional_station', 'district_transitional_station.transitional_station_id', '=', 'transitional_stations.id');
    }

    /**
     * The all districts .
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDistricts($query)
    {
        return $query->withDistrictsIds()
            ->leftJoin('districts', 'district_transitional_station.district_id', '=', 'districts.id');
    }

    /**
     * The all contracts ids that own transitional stations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContractsIds($query)
    {
        return $query->leftJoin('contract_station', 'transitional_stations.id', '=', 'contract_station.station_id');
    }

    /**
     * The all contracts that own transitional stations.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContracts($query)
    {
        return $query->withContractsIds()
            ->leftJoin('contracts', 'contracts.id', '=', 'contract_station.contract_id');
    }

    /**
     * The all contracts that own transitional stations.
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
            $query->whereIn('transitional_stations.id', $ids);
        }

        return $query;
    }
}
