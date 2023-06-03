<?php

namespace Afaqy\Contact\Models;

use Afaqy\Inspector\Models\Image;
use Laravel\Passport\HasApiTokens;
use Afaqy\Contract\Models\Contract;
use Afaqy\Inspector\Models\Response;
use Illuminate\Database\Eloquent\Model;
use Afaqy\Contact\Traits\AuthenticatableOTP;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Contact extends Model implements Authenticatable
{
    use HasApiTokens;
    use AuthenticatableOTP;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'email',
        'default_contact',
        'contactable_id',
        'contactable_type',
    ];

    /**
     * Get the owning contactable model.
     */
    public function contactable()
    {
        return $this->morphTo();
    }

    /**
     * Ticket has zero or many Image
     * Get the ticket's images
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Ticket has zero or many Image
     * Get the ticket's images
     * @return morphMany
     */
    public function responses(): morphMany
    {
        return $this->morphMany(Response::class, 'responseable');
    }

    /**
     * Get the phones for the contact.
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Get the contact's phones.
     */
    public function scopeWithphones($query)
    {
        return $query->leftJoin('phones', 'phones.contact_id', '=', 'contacts.id');
    }

    /**
     * Get only contract supervisor's phones.
     */
    public function scopeOnlyContractsPhones($query)
    {
        return $query->withphones()
            ->where('contacts.contactable_type', Contract::class);
    }
}
