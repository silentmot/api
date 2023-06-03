<?php

namespace Afaqy\Contact\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'phone',
    ];

    /**
     * Get the contact that owns the phones.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
