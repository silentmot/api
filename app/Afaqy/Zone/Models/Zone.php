<?php

namespace Afaqy\Zone\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\WasteType\Models\WasteType;
use Illuminate\Database\Eloquent\Model;
use Afaqy\Zone\Models\Filters\ZoneFilter;
use Spatie\Activitylog\Traits\LogsActivity;

class Zone extends Model
{
    use Filterable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'reads'];

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
        return $this->provideFilter(ZoneFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wasteTypes()
    {
        return $this->belongsToMany(WasteType::class, 'waste_type_zone');
    }

    /**
     * The devices that belong to zone.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithDevices($query)
    {
        return $query->leftJoin('devices', 'zones.id', '=', 'devices.zone_id');
    }

    /**
     * The gates that belong to zone.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithGates($query)
    {
        return $query->leftJoin('gates', 'zones.id', '=', 'gates.zone_id');
    }

    /**
     * The scales that belong to zone.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithScales($query)
    {
        return $query->leftJoin('scales', 'zones.id', '=', 'scales.zone_id');
    }

    /**
     * All devices, gates and scales that belong to zone.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithMachines($query)
    {
        return $query->withDevices()->withScales();
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
}
