<?php

namespace Afaqy\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermitUnit extends Model
{
    use SoftDeletes;
    use LogsActivity;

    public $table = "permit_units";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ["plate_number", "qr_code", "rfid"];

    /**
     * The attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * The permissions that belong to permit unit.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPermissionsIds($query)
    {
        return $query->leftJoin('checkin_unit', 'permit_units.id', '=', 'checkin_unit.unit_id');
    }

    /**
     * The permissions that belong to permit unit.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithCommonPermissionsIds($query)
    {
        return $query->join('checkin_unit', 'permit_units.id', '=', 'checkin_unit.unit_id');
    }
}
