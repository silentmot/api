<?php

namespace Afaqy\UnitType\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\WasteType\Models\WasteType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Afaqy\UnitType\Models\Filters\UnitTypeFilter;

class UnitType extends Model
{
    use Filterable;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

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
        return $this->provideFilter(UnitTypeFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wasteTypes()
    {
        return $this->belongsToMany(WasteType::class);
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
     * The waste types ids that belong to unit types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithWasteTypeIds($query)
    {
        return $query->leftJoin('unit_type_waste_type', 'unit_types.id', '=', 'unit_type_waste_type.unit_type_id');
    }

    /**
     * The all Waste Type ids that belong to unit types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithWasteType($query)
    {
        return $query->withWasteTypeIds()
            ->leftJoin('waste_types', 'waste_types.id', '=', 'unit_type_waste_type.waste_type_id');
    }

    /**
     * The all units ids that belong to unit types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCommonUnits($query)
    {
        return $query->join('units', 'unit_types.id', '=', 'units.unit_type_id');
    }

    /**
     * The all units ids that belong to unit types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnits($query)
    {
        return $query->leftJoin('units', function ($query) {
            $query->on('unit_types.id', '=', 'units.unit_type_id')
                ->whereNull('units.deleted_at');
        });
    }
}
