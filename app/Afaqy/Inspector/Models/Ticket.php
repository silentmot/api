<?php

namespace Afaqy\Inspector\Models;

use Carbon\Carbon;
use ReflectionClass;
use Afaqy\User\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use EloquentFilter\Filterable;
use Afaqy\Contract\Models\Contract;
use Afaqy\District\Models\Neighborhood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Inspector\Models\Filters\TicketFilter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int user_id
 * @property int district_id
 * @property int neighborhood_id
 * @property int contract_id
 * @property string location
 * @property string details
 * @property string status  // 'PENDING', 'RESPONDED', 'ACCEPTED', 'APPROVED', 'REPORTED', 'PENALTY'
 */
class Ticket extends Model
{
    use Filterable;

    protected $table = 'mob_inspector_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'district_id',
        'neighborhood_id',
        'contractor_name',
        'contract_id',
        'location',
        'location_name',
        'details',
        'status',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->toIso8601String();
    }

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->toIso8601String();
    }

    /**
     * Returns ModelFilter class to be instantiated.
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(TicketFilter::class);
    }

    /**
     * Sort by the given column.
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function scopeSortBy(Builder $query, Request $request)
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

    /**
     * Ticket belongs to inspector
     *
     * @return BelongsTo
     */
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Ticket belongs to contract
     *
     * @return BelongsTo
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Ticket has zero or many Image
     * Get the ticket's images
     * @return BelongsTo
     */
    public function images(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'ticket_id');
    }

    /**
     * Ticket has zero or many responses
     * Get the ticket's responses
     * @return BelongsTo
     */
    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class, 'ticket_id');
    }

    /**
     * Ticket belongs to neighborhood
     *
     * @return BelongsTo
     */
    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    /**
     * The tickets that belong to contract.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithContract(Builder $query)
    {
        return $query->leftJoin('contracts', 'contracts.id', '=', 'mob_inspector_tickets.contract_id');
    }

    /**
     * The tickets that belong to district.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithSupervisor(Builder $query)
    {
        // join contracts with contacts
        return $query->leftJoin('contacts', 'contacts.contactable_id', '=', 'contracts.id')
            ->where('contacts.contactable_type', (new ReflectionClass(Contract::class))->name);
    }

    /**
     * The tickets that belong to district.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithDistrict(Builder $query)
    {
        return $query->leftJoin('districts', 'districts.id', '=', 'mob_inspector_tickets.district_id');
    }

    /**
     * The tickets that belong to neighborhood.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithNeighborhood(Builder $query)
    {
        return $query->leftJoin('neighborhoods', 'neighborhoods.id', '=', 'mob_inspector_tickets.neighborhood_id');
    }

    /**
     * The tickets that belong to inspector.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithInspector(Builder $query)
    {
        return $query->leftJoin('users', 'users.id', '=', 'mob_inspector_tickets.user_id');
    }

    /**
     * The tickets that has one or many images.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithImages(Builder $query)
    {
        return $query->leftJoin('mob_inspector_images', 'mob_inspector_images.ticket_id', '=', 'mob_inspector_tickets.id');
    }

    /**
     * The tickets that has one or many response.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithResponse(Builder $query)
    {
        return $query->leftJoin('mob_inspector_responses', 'mob_inspector_responses.ticket_id', '=', 'mob_inspector_tickets.id');
    }
}
