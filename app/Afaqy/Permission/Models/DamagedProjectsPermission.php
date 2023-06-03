<?php

namespace Afaqy\Permission\Models;

use EloquentFilter\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DamagedProjectsPermission extends Model
{
    use Filterable;

    public $table = "damaged_projects_permissions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "demolition_serial",
        "permission_number",
        "permission_date",
        "company_name",
        "company_commercial_number",
        "actual_weight",
    ];

    /**
     * Get all of the checkin unit.
     */
    public function checkinUnits()
    {
        return $this->morphMany(CheckinUnit::class, 'checkinable');
    }

    /**
     * The all checkin unit ids that belong to damaged projects permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCheckinUnitIds($query)
    {
        return $query->leftJoin('checkin_unit', function ($join) {
            $join->on('checkin_unit.checkinable_id', '=', 'damaged_projects_permissions.id')->where('checkin_unit.checkinable_type', '=', DamagedProjectsPermission::class);
        });
    }

    /**
     * The all permit unit ids that belong to damaged projects permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPermitUnit($query)
    {
        return $query->withCheckinUnitIds()->leftJoin('permit_units', 'permit_units.id', '=', 'checkin_unit.unit_id');
    }

    /**
     * The all permit unit ids that belong to damaged projects permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPermitUnitsWithWeight($query)
    {
        return $query->withPermitUnit()->leftJoin('dashboard', function ($join) {
            $join->on('dashboard.permission_id', '=', 'damaged_projects_permissions.id')
                ->where('dashboard.permission_type', '=', 'project')
                ->where('permit_units.id', '=', DB::raw('`dashboard`.`unit_id`'));
        });
    }
}
