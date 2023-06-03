<?php

namespace Afaqy\Inspector\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'mob_inspector_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id',
        'url',
        'ticket_id',
        'imageable_id',
        'imageable_type',
    ];

    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
