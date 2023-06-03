<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class TripZone extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trips_additional_zones';

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
