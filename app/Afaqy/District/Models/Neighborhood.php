<?php

namespace Afaqy\District\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;

class Neighborhood extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'district_id' ,
        'population',
        'status',
        'points',
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
     * The neighborhoods that belong to the district.
     */
    public function subNeighborhoods()
    {
        return $this->hasMany(SubNeighborhood::class, 'neighborhood_id', 'id');
    }

    /**
     * The districts that belong to the neighborhood.
     */
    public function districts()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * The all neighborhoods ids (neighborhoods/sub neighborhoods) that belong to districts.
     *
     * @param  Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithDistrict($query)
    {
        return $query->leftJoin('districts', 'districts.id', '=', 'neighborhoods.district_id');
    }

    /**
     * The all neighborhoods ids (neighborhoods/sub neighborhoods) that belong to districts.
     *
     * @param Builder $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContractsIds(Builder $query)
    {
        return $query->leftJoin('contract_district', 'neighborhoods.id', '=', 'contract_district.neighborhood_id');
    }

    /**
     * The all neighborhoods ids (neighborhoods/sub neighborhoods) that belong to districts.
     *
     * @param  Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithContracts(Builder $query)
    {
        return $query->withContractsIds()
            ->leftJoin('contracts', 'contracts.id', '=', 'contract_district.contract_id');
    }

    /**
     * The all neighborhoods ids (neighborhoods/sub neighborhoods) that belong to districts.
     *
     * @param  Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWhereNeighborhoodsUnContracted($query, ? int $district_id = null)
    {
        if ($district_id) {
            $query->where('district_neighborhood.district_id', $district_id);
        }

        return $query->whereNotIn('neighborhoods.id', function ($query) {
            $query->distinct()->select('neighborhoods.id')
                ->from('neighborhoods')
                ->join('contract_district', 'neighborhoods.id', '=', 'contract_district.neighborhood_id')
                ->join('contracts', 'contracts.id', '=', 'contract_district.contract_id')
                ->where('contracts.status', 1)
                ->where('contracts.end_at', '>', Carbon::now()->toDateString());
        });
    }
}
