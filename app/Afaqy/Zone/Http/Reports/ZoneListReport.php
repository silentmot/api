<?php

namespace Afaqy\Zone\Http\Reports;

use Afaqy\Zone\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Zone\Http\Transformers\ZoneTransformer;

class ZoneListReport extends Report
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
        $options['include'] = [
            'direction',
            'devicesNames',
            'scaleName',
        ];

        return $this->generateViewList(
            $this->query(),
            new ZoneTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Zone::withMachines();

        $query->select([
            'zones.id',
            'zones.name',
            DB::raw('scales.name as scale_name'),
            DB::raw('GROUP_CONCAT(DISTINCT devices.name SEPARATOR ",") as devices_names'),
            DB::raw('GROUP_CONCAT(DISTINCT devices.direction SEPARATOR ",") as direction'),
        ])
            ->groupBy(['zones.id', 'zones.name', 'scales.name'])
            ->sortBy($this->request);

        return $query;
    }
}
