<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class PostTrip extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_trips';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
