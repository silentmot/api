<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trips';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the pre-trip info for the trip.
     */
    public function pre()
    {
        return $this->hasOne(PreTrip::class, 'trip_id', 'id');
    }

    /**
     * Get the unit info for the trip.
     */
    public function information()
    {
        return $this->hasOne(TripUnitInformation::class, 'trip_id', 'id');
    }

    /**
     * Get the gates info for the trip.
     */
    public function gates()
    {
        return $this->hasMany(TripGate::class, 'trip_id', 'id');
    }

    /**
     * Get the violations for the trip.
     */
    public function violations()
    {
        return $this->hasMany(TripViolation::class, 'trip_id', 'id');
    }

    /**
     * The pre-trip info that belong to trip.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPreTripInformation($query)
    {
        return $query->leftJoin('pre_trips', 'trips.id', '=', 'pre_trips.trip_id');
    }

    /**
     * The post-trip info that belong to trip.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithPostTripInformation($query)
    {
        return $query->leftJoin('post_trips', 'trips.plate_number', '=', 'post_trips.plate_number');
        // What if car arrival be in the next day ??
    }

    /**
     * The gates info that belong to trip.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithTripGatesInformation($query)
    {
        return $query->leftJoin('trips_access_gates_info', 'trips.id', '=', 'trips_access_gates_info.trip_id');
    }

    /**
     * The unit info that belong to trip.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithUnitInformation($query)
    {
        return $query->leftJoin('trips_unit_info', 'trips.id', '=', 'trips_unit_info.trip_id');
    }
}
