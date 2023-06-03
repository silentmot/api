<?php

namespace Afaqy\WasteType\Http\Reports;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\WasteType\Models\WasteType;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\WasteType\Http\Transformers\WasteTypeTransformer;

class WasteTypeListReport extends Report
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
        $options['include'] = ['unitsCount'];

        return $this->generateViewList(
            $this->query(),
            new WasteTypeTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = WasteType::withUnits();

        //@TODO: need to refactor
        if (!$this->request->with_permisions) {
            $query->withoutMardamWasteTypes();
        }

        $query->select([
            'waste_types.id',
            'waste_types.name',
            DB::raw('COUNT(units.waste_type_id) as units_count'),

        ])
            ->groupBy(['waste_types.id', 'waste_types.name'])
            ->sortBy($this->request);

        return $query;
    }
}
