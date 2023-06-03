<?php

namespace Afaqy\Contract\Http\Reports\Show;

use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Transformers\Show\ContractContractorTransformer;

class ContractContractorReport extends Report
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
        $result = $this->query()->first();

        if ($result->id) {
            return $this->fractalItem($result, new ContractContractorTransformer);
        }

        return (object) null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Contract::withContractors()
            ->select([
                'contractors.id',
                'contractors.name_ar',
            ])
            ->where('contracts.id', $this->id);
    }
}
