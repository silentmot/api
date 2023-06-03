<?php

namespace Afaqy\Contractor\Models;

use Illuminate\Support\Str;
use EloquentFilter\Filterable;
use Afaqy\Contact\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Afaqy\Contractor\Models\Filters\ContractorFilter;

class Contractor extends Model
{
    use Filterable;
    use SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'commercial_number',
        'license_number',
        'address',
        'employees',
        'avl_company',
    ];

    /**
     * @var boolean
     */
    protected static $logOnlyDirty = true;

    /**
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected static $logAttributesToIgnore = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(ContractorFilter::class);
    }

    /**
     * Get all of the contractor's contacts.
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    /**
     * The all contacts ids that belong to contractors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContacts($query)
    {
        return $query->leftJoin('contacts', function ($join) {
            $join->on('contacts.contactable_id', '=', 'contractors.id')->where('contacts.contactable_type', '=', Contractor::class);
        });
    }

    /**
     * The all contacts ids that belong to contractors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithDefaultContact($query)
    {
        return $query->withContacts()->where('contacts.default_contact', 1);
    }

    /**
     * The all contacts ids that belong to contractors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContactsPhones($query)
    {
        return $query->withContacts()->leftJoin('phones', 'contacts.id', 'phones.contact_id');
    }

    /**
     * The all contracts  that belong to contractors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContracts($query)
    {
        return $query->leftJoin('contracts', 'contractors.id', 'contracts.contractor_id');
    }

    /**
     * The all units ids that belong to contractors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnits($query)
    {
        return $query->leftJoin('units', 'contractors.id', '=', 'units.contractor_id');
    }

    /**
     * Sort by the given column.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortBy($query, $request)
    {
        if ($request->has('sort')) {
            $column = Str::snake($request->input('sort'));

            if ($request->has('direction') && $request->input('direction') == 'asc') {
                return $query->orderBy($column, 'asc');
            }

            return $query->orderBy($column, 'desc');
        }

        return $query->orderBy($this->getTable() . '.' .'id', 'desc');
    }
}
