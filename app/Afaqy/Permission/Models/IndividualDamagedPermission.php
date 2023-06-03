<?php

namespace Afaqy\Permission\Models;

use EloquentFilter\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class IndividualDamagedPermission extends Model
{
    use Filterable;
    use LogsActivity;

    public $table = "individual_damaged_permissions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "demolition_serial",
        "permission_number",
        "permission_date",
        "type",
        "district_id",
        "neighborhood_id",
        "street",
        "owner_name",
        "owner_phone",
        "national_id",
    ];

    /**
     * The attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * Get all of the contractor's contacts.
     */
    public function checkinUnits()
    {
        return $this->morphMany(CheckinUnit::class, 'checkinable');
    }

    /**
     * The all checkin unit ids that belong to individual permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCheckinUnitIds($query)
    {
        return $query->leftJoin('checkin_unit', function ($join) {
            $join->on('checkin_unit.checkinable_id', '=', 'individual_damaged_permissions.id')
                ->where('checkin_unit.checkinable_type', '=', IndividualDamagedPermission::class);
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
            $join->on('dashboard.permission_id', '=', 'individual_damaged_permissions.id')
                ->where('dashboard.permission_type', '=', 'individual')
                ->where('permit_units.id', '=', DB::raw('`dashboard`.`unit_id`'));
        });
    }

    /**
     * The neighborhood that belong to individual permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithNeighboorhood($query)
    {
        return $query->leftJoin('neighborhoods', 'neighborhoods.id', '=', 'individual_damaged_permissions.neighborhood_id');
    }

    /**
     * The district that belong to individual permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithDistrict($query)
    {
        return $query->leftJoin('districts', 'districts.id', '=', 'individual_damaged_permissions.district_id');
    }
}
