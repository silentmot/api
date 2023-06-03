<?php

namespace Afaqy\WasteType\Models;

use Afaqy\Zone\Models\Zone;
use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\UnitType\Models\UnitType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Afaqy\WasteType\Models\Filters\WasteTypeFilter;

class WasteType extends Model
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
        'zone_id',
        'pit_id',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unitTypes()
    {
        return $this->belongsToMany(UnitType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'waste_type_zone');
    }

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(WasteTypeFilter::class);
    }

    /**
     * The all units ids that belong to waste types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCommonUnits($query)
    {
        return $query->join('units', 'waste_types.id', '=', 'units.waste_type_id');
    }

    /**
     * The all units ids that belong to waste types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnits($query)
    {
        return $query->leftJoin('units', function ($query) {
            $query->on('waste_types.id', '=', 'units.waste_type_id')
                ->whereNull('units.deleted_at');
        });
    }

    /**
     * The all units ids that belong to waste types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutMardamWasteTypes($query)
    {
        return $query->whereNotIn('waste_types.id', [1, 2, 3, 4]);
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
     * The all zones .
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithZonesIds($query)
    {
        return $query->leftJoin('waste_type_zone', 'waste_type_zone.waste_type_id', '=', 'waste_types.id');
    }

    /**
     * The all zones .
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithZones($query)
    {
        return $query->withZonesIds()
            ->leftJoin('zones', 'waste_type_zone.zone_id', '=', 'zones.id');
    }
}
