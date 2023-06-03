<?php

namespace Afaqy\Permission\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Afaqy\Permission\Models\Filters\PermissionFilter;

class CheckinUnit extends Model
{
    use Filterable;

    /**
     * @var string
     */
    public $table = 'checkin_unit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["checkinable_id", "checkinable_type", "unit_id"];

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(PermissionFilter::class);
    }

    /**
     * Get the owning checkinable model.
     */
    public function checkinable()
    {
        return $this->morphTo();
    }

    /**
     * The all checkin unit ids that belong to individual permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithIndividualDamaged($query)
    {
        return $query->leftJoin('individual_damaged_permissions', function ($join) {
            $join->on('individual_damaged_permissions.id', '=', 'checkin_unit.checkinable_id')->where('checkin_unit.checkinable_type', '=', IndividualDamagedPermission::class);
        });
    }

    /**
     * The all checkin unit ids that belong to damaged projects permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithDamagedProjects($query)
    {
        return $query->leftJoin('damaged_projects_permissions', function ($join) {
            $join->on('damaged_projects_permissions.id', '=', 'checkin_unit.checkinable_id')->where('checkin_unit.checkinable_type', '=', DamagedProjectsPermission::class);
        });
    }

    /**
     * The all checkin unit ids that belong to governmental permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithGovernmentalDamaged($query)
    {
        return $query->leftJoin('governmental_damaged_permissions', function ($join) {
            $join->on('governmental_damaged_permissions.id', '=', 'checkin_unit.checkinable_id')->where('checkin_unit.checkinable_type', '=', GovernmentalDamagedPermission::class);
        });
    }

    /**
     * The all checkin unit ids that belong to governmental permission.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCommercialDamaged($query)
    {
        return $query->leftJoin('commercial_damaged_permissions', function ($join) {
            $join->on('commercial_damaged_permissions.id', '=', 'checkin_unit.checkinable_id')->where('checkin_unit.checkinable_type', '=', CommercialDamagedPermission::class);
        });
    }
}
