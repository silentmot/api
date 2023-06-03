<?php

namespace Afaqy\Contract\Http\Reports\Show;

use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Transformers\Show\ContractShowTransformer;

class ContractReport extends Report
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
        $result = $this->query()->firstOrFail();

        return $this->fractalItem($result, new ContractShowTransformer);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Contract::select([
            'contracts.id',
            'contracts.start_at',
            'contracts.end_at',
            'contracts.contract_number',
            'contracts.status',
        ])
            ->where('id', $this->id);
    }
}
