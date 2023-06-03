<?php

namespace Afaqy\Geofence\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Geofence\Models\Geofence;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Geofence\Http\Transformers\GeofenceTransformer;

class GeofenceShowReport extends Report
{
    use Generator;

    /**
     * @var int $id
     */
    private $id;

    /**
     * @param int $id
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->generateViewShow(
            $this->query(),
            new GeofenceTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Geofence::where('id', $this->id);
    }
}
