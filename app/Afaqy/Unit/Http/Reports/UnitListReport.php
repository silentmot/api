<?php

namespace Afaqy\Unit\Http\Reports;

use Afaqy\Unit\Models\Unit;
use Illuminate\Http\Request;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Unit\Http\Transformers\UnitTransformer;

class UnitListReport extends Report
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
        $options['include'] = ['unitTypeName', 'wasteTypeName', 'contractorName'];

        return $this->generateViewList(
            $this->query(),
            new UnitTransformer,
            $this->request,
            $options
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        $query = Unit::withTypes()->withContractors();

        $query->select([
            'units.id',
            'units.code',
            'units.model',
            'units.plate_number',
            'unit_types.name as unit_type_name',
            'waste_types.name as waste_type_name',
            'units.net_weight',
            'contractors.name_ar as contractor_name',
            'units.active',
        ])
            ->sortBy($this->request);

        return $query;
    }
}
