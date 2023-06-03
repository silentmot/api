<?php

namespace Afaqy\Contract\Models;

use Carbon\Carbon;
use Afaqy\Unit\Models\Unit;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\Contact\Models\Contact;
use Illuminate\Support\Facades\DB;
use Afaqy\District\Models\District;
use Afaqy\Contractor\Models\Contractor;
use Afaqy\District\Models\Neighborhood;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Afaqy\Contract\Models\Filters\ContractFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Afaqy\TransitionalStation\Models\TransitionalStation;

/**
 * @TODO:
 *     [ ] need to refactor active contract filters and put them on one scope, for usability
 */
class Contract extends Model
{
    use Filterable;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['start_at', 'contract_number', 'end_at', 'status', 'contractor_id'];

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
        return $this->provideFilter(ContractFilter::class);
    }

    // user seed , use mob = true in owner

    /**
     *  Get active / valid contract
     * @param $query
     * @param null $date
     */
    public function scopeActiveContract($query, $date = null)
    {
        $date = $date ?? Carbon::now()->toDateString();

        $query->where('contracts.status', 1)
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->whereNull('contracts.deleted_at');
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
     * The districts that belong to the contract.
     */
    public function districts()
    {
        return $this->belongsToMany(District::class, 'contract_district', 'contract_id', 'district_id')
            ->withPivot('neighborhood_id', 'unit_id')
            ->withTimestamps();
    }

    /**
     * The districts that belong to the contract.
     */
    public function neighborhoods()
    {
        return $this->belongsToMany(Neighborhood::class, 'contract_district', 'contract_id', 'neighborhood_id')
            ->withPivot('district_id', 'unit_id')
            ->withTimestamps();
    }

    /**
     * The districts that belong to the contract.
     */
    public function units()
    {
        return $this->belongsToMany(Unit::class, 'contract_district', 'contract_id', 'unit_id')
            ->withPivot('district_id', 'neighborhood_id')
            ->withTimestamps();
    }

    /**
     * Get all of the contract contacts.
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * Contract belong to contractor
     * @return BelongsTo
     */
    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    /**
     * The districts that belong to the contract.
     */
    public function stations()
    {
        return $this->belongsToMany(TransitionalStation::class, 'contract_station', 'contract_id', 'station_id')
            ->withPivot('unit_id')
            ->withTimestamps();
    }

    /**
     * The districts that belong to the contract.
     */
    public function stationUnits()
    {
        return $this->belongsToMany(TransitionalStation::class, 'contract_station', 'contract_id', 'unit_id')
            ->withPivot('station_id')
            ->withTimestamps();
    }

    /**
     * The districts that belong to contracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDistrictsIds($query)
    {
        return $query->leftJoin('contract_district', 'contract_district.contract_id', '=', 'contracts.id');
    }

    /**
     * The contractors that belong to contracts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContractors($query)
    {
        return $query->leftJoin('contractors', 'contractors.id', '=', 'contracts.contractor_id');
    }

    /**
     * The contacts that belong to contract.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContacts($query)
    {
        return $query->leftJoin('contacts', function ($join) {
            $join->on('contacts.contactable_id', '=', 'contracts.id')
                ->where('contacts.contactable_type', '=', self::class);
        });
    }

    /**
     * The all contacts information that belong to contract.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContactsInformation($query)
    {
        return $query->withContacts()->leftJoin('phones', 'phones.contact_id', '=', 'contacts.id');
    }

    /**
     * Limit contact phone to one phone number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLimitOnePhoneNumber($query)
    {
        return $query->where('phones.id', function ($query) {
            $query->select(DB::raw('MIN(id) AS id'))
                ->from('phones')
                ->where('contact_id', DB::raw('contacts.id'))
                ->groupBy('contact_id');
        });
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContractInformation($query)
    {
        return $query->withDistrictsIds()
            ->withStationsIds()
            ->withContractors()
            ->withContactsInformation()
            ->withUnits()
            ->leftJoin(DB::raw('`units` as `station_unit`'), function ($query) { // to count contract station unit
                return $query->on('contract_station.unit_id', '=', 'station_unit.id')
                    ->whereNull('station_unit.deleted_at');
            });
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDistricts($query)
    {
        return $query->leftJoin('districts', 'contract_district.district_id', '=', 'districts.id');
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithNeighborhoods($query)
    {
        return $query->leftJoin('neighborhoods', 'contract_district.neighborhood_id', '=', 'neighborhoods.id');
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStationsIds($query)
    {
        return $query->leftJoin('contract_station', 'contract_station.contract_id', '=', 'contracts.id');
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStations($query)
    {
        return $query->withStationsIds()
            ->leftJoin('transitional_stations', 'contract_station.station_id', '=', 'transitional_stations.id');
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnits($query)
    {
        return $query->leftJoin('units', function ($query) {
            return $query->on('contract_district.unit_id', '=', 'units.id')
                ->whereNull('units.deleted_at');
        });
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStationUnits($query)
    {
        return $query->leftJoin('units', function ($query) {
            return $query->on('contract_station.unit_id', '=', 'units.id')
                ->whereNull('units.deleted_at');
        });
    }

    /**
     * The all contract information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContractDetailedInformation($query)
    {
        return $query->withDistrictsIds()
            ->withDistricts()
            ->withNeighborhoods()
            ->withUnits()
            ->withContractors()
            ->withContactsInformation();
    }
}
