<?php

namespace Afaqy\Permission\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SortingAreaPermission extends Model
{
    use LogsActivity;

    public $table = "sorting_area_permissions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "waste_type_id",
        "entity_name",
        "representative_name",
        "national_id",
        "allowed_weight",
    ];

    /**
     * The attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * Get all of the checkin unit.
     */
    public function checkinUnits()
    {
        return $this->morphMany(CheckinUnit::class, 'checkinable');
    }

    /**
     * The all checkin unit ids that belong to Sorting Area permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCheckinUnitIds($query)
    {
        return $query->leftJoin('checkin_unit', function ($join) {
            $join->on('checkin_unit.checkinable_id', '=', 'sorting_area_permissions.id')
                ->where('checkin_unit.checkinable_type', '=', SortingAreaPermission::class);
        });
    }

    /**
     * The all permit unit ids that belong to Sorting Area permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPermitUnit($query)
    {
        return $query->withCheckinUnitIds()->leftJoin('permit_units', 'permit_units.id', '=', 'checkin_unit.unit_id');
    }

    /**
     * The all permit unit ids that belong to  Sorting Area permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPermitUnitsWithWeight($query)
    {
        return $query->withPermitUnit()->leftJoin('dashboard', function ($join) {
            $join->on('dashboard.permission_id', '=', 'sorting_area_permissions.id')
                ->where('dashboard.permission_type', '=', 'sorting')
                ->where('permit_units.id', '=', DB::raw('`dashboard`.`unit_id`'));
        });
    }

    /**
     * The all permit unit ids that belong to Sorting Area permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithWasteType($query)
    {
        return $query->Join('waste_types', 'waste_types.id', '=', 'sorting_area_permissions.waste_type_id');
    }
}
