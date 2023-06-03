<?php

namespace Afaqy\Dashboard\Models;

use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dashboard';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCommonViolations($query)
    {
        return $query->join('violations_logs', 'dashboard.id', '=', 'violations_logs.trip_id');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCommonViolationsTranslation($query)
    {
        return $query->withCommonViolations()
            ->join('notifications', 'notifications.name', '=', 'violations_logs.violation_type');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutSotringPermission($query)
    {
        return $query->where(function ($query) {
            return $query->where('permission_type', '!=', 'sorting')
                ->orWhereNull('permission_type');
        });
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTripCompleted($query)
    {
        return $query->whereNotNull('enterance_weight')
            ->whereNotNull('exit_weight')
            ->whereColumn('enterance_weight', '>', 'exit_weight');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereBetween('start_time', [
            Carbon::today()->startOfDay()->getTimestamp(),
            Carbon::today()->endOfDay()->getTimestamp(),
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeYesterday($query)
    {
        return $query->whereBetween('start_time', [
            Carbon::yesterday()->startOfDay()->getTimestamp(),
            Carbon::yesterday()->endOfDay()->getTimestamp(),
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('start_time', [
            Carbon::today()->subWeek()->getTimestamp(),
            Carbon::yesterday()->endOfDay()->getTimestamp(),
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $start
     * @param  string $end
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateBetween($query, $start, $end)
    {
        return $query->whereBetween('start_time', [
            Carbon::parse($start)->getTimestamp(),
            Carbon::parse($end)->getTimestamp(),
        ]);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnits($query)
    {
        return $query->join('units', 'units.id', '=', 'dashboard.unit_id');
    }
}
