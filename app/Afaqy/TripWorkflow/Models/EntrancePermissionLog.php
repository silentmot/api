<?php

namespace Afaqy\TripWorkflow\Models;

use Illuminate\Database\Eloquent\Model;

class EntrancePermissionLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entrance_permissions_logs';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
