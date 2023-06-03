<?php

namespace Afaqy\TransitionalStation\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\TransitionalStation\Models\TransitionalStation;
use Afaqy\TransitionalStation\Http\Transformers\TransitionalStationContractsTransformer;

class ContractsListForStationReport extends Report
{
    use Generator;

    /**
     * @var int $request
     */
    private $id;

    /**
     * @param int $request
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
        return $this->generateSelectList(
            $this->query(),
            new TransitionalStationContractsTransformer,
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return TransitionalStation::withContracts()
            ->distinct()
            ->select([
                'contracts.id',
                'contracts.contract_number',
            ])
            ->where('transitional_stations.id', $this->id)
            ->whereNotNull('contracts.id');
    }
}
