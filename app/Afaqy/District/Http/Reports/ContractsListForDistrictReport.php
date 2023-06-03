<?php

namespace Afaqy\District\Http\Reports;

use Afaqy\Core\Http\Reports\Report;
use Afaqy\District\Models\District;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\District\Http\Transformers\DistrictContractsTransformer;

class ContractsListForDistrictReport extends Report
{
    use Generator;

    /**
     * @var int $request
     */
    private $id;

    /**
     * @param  int    $id
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
            new DistrictContractsTransformer
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return District::withContracts()
            ->distinct()
            ->select([
                'contracts.id',
                'contracts.contract_number',
            ])
            ->where('districts.id', $this->id)
            ->whereNotNull('contracts.id');
    }
}
