<?php

namespace Afaqy\Contract\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Contact\Actions\UpdateContactAction;
use Afaqy\Contract\Actions\UpdateContractAction;
use Afaqy\Contract\Actions\UpdateContractStationsAction;
use Afaqy\Contract\Actions\UpdateContractDistrictsAction;

class UpdateContractAggregator extends Aggregator
{
    /**
     * @var \Afaqy\Contract\DTO\ContractData $data
     */
    private $data;

    /**
     * @param \Afaqy\Contract\DTO\ContractData $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        DB::transaction(function () use (&$contract) {
            $contract = (new UpdateContractAction($this->data))->execute();

            (new UpdateContactAction($this->data->contact, $contract))->execute();

            (new UpdateContractDistrictsAction($this->data->districts, $contract))->execute();

            (new UpdateContractStationsAction($this->data->stations, $contract))->execute();

            return $contract;
        });

        return $contract;
    }
}
