<?php

namespace Afaqy\Contractor\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Contact\Actions\StoreContactAction;
use Afaqy\Contractor\Actions\StoreContractorAction;

class StoreContractorAggregator extends Aggregator
{
    /** @var \Afaqy\Contractor\DTO\ContractorData */
    private $data;

    /**
     * @param \Afaqy\Contractor\DTO\ContractorData $data
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
        $exception =  DB::transaction(function () use (&$contactable) {
            $contactable   = (new StoreContractorAction($this->data->except('contacts')))->execute();

            (new StoreContactAction($this->data->contacts, $contactable))->execute();
        });

        return $contactable;
    }
}
