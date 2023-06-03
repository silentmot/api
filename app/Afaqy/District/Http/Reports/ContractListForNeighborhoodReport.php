<?php

namespace Afaqy\District\Http\Reports;

use Carbon\Carbon;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Afaqy\District\Models\Neighborhood;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\District\Http\Transformers\NeighborhoodContractsTransformer;

class ContractListForNeighborhoodReport extends Report
{
    use Generator;

    /**
     * @var int $request
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
        return $this->generateSelectList(
            $this->query(),
            new NeighborhoodContractsTransformer
        );
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        $date = Carbon::now()->toDateString();

        return Neighborhood::withContracts()
            ->distinct()
            ->select([
                'contracts.id',
                'contracts.contract_number',
            ])
            ->where('neighborhoods.id', $this->id)
            ->whereNotNull('contracts.id')
            ->where('contracts.status', 1)
            ->where('contracts.start_at', '<=', $date)
            ->where('contracts.end_at', '>=', $date)
            ->whereNull('contracts.deleted_at');
    }
}
