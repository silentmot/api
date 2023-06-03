<?php

namespace Afaqy\District\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SubNeighborhood extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'neighborhood_id',
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
     * The districts that belong to the neighborhood.
     */
    public function neighborhoods()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }
}
