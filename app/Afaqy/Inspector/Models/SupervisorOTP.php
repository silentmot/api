<?php

namespace Afaqy\Inspector\Models;

use Illuminate\Database\Eloquent\Model;

class SupervisorOTP extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mob_supervisor_otp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'otp_code',
        'expires_at',
    ];

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithContacts($query)
    {
        return $query->leftJoin('contacts', 'contacts.id', '=', 'mob_supervisor_otp.contact_id');
    }
}
