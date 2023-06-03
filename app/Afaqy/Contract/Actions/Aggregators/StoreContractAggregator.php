<?php

namespace Afaqy\Contract\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Contact\Actions\StoreContactAction;
use Afaqy\Contract\Actions\StoreContractAction;
use Afaqy\Contract\Actions\StoreContractStationsAction;
use Afaqy\Contract\Actions\StoreContractDistrictsAction;

class StoreContractAggregator extends Aggregator
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
            $contract = (new StoreContractAction($this->data))->execute();

            (new StoreContactAction($this->data->contact, $contract))->execute();

            (new StoreContractDistrictsAction($this->data->districts, $contract))->execute();

            (new StoreContractStationsAction($this->data->stations, $contract))->execute();

            return $contract;
        });

        return $contract;
    }
}
