<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class TripGeofence extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trip_geofences';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the trip that owns the gate.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
