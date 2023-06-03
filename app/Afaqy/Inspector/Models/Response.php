<?php

namespace Afaqy\Inspector\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'mob_inspector_responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id',
        'details',
        'responseable_id',
        'responseable_type',
    ];

    /**
     * Get the owning responsable model.
     */
    public function responsable()
    {
        return $this->morphTo();
    }
}
