<?php

namespace Afaqy\Geofence\Http\Reports;

use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Geofence\Models\Geofence;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Geofence\Http\Transformers\GeofenceTransformer;

class GeofenceListReport extends Report
{
    use Generator;

    /**
     * @var \Illuminate\Http\Request $request
     */
    private $request;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateViewList(
            $this->query(),
            new GeofenceTransformer,
            $this->request
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Geofence::select([
            'geofences.id',
            'geofences.name',
            'geofences.type',
            'geofences.geofence_id',
        ])->sortBy($this->request);
    }
}
