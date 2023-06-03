<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class TripViolation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'violations_logs';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the trip that owns the violation.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
