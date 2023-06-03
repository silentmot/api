<?php

namespace Afaqy\Contract\Http\Reports\Show;

use Afaqy\Contract\Models\Contract;
use Afaqy\Core\Http\Reports\Report;
use Afaqy\Core\Http\Reports\Generator;
use Illuminate\Database\Eloquent\Builder;
use Afaqy\Contract\Http\Transformers\Show\ContractContactTransformer;

class ContractContactReport extends Report
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
            return $this->fractalItem($result, new ContractContactTransformer);
        }

        return (object) null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Contract::withContactsInformation()
            ->select([
                'contacts.id',
                'contacts.name',
                'contacts.email',
                'contacts.title',
                'phones.phone',
            ])
            ->where('contracts.id', $this->id);
    }
}
