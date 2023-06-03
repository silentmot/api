<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class RequestChecker extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slf_requests_checker';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
