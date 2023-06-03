<?php

namespace Afaqy\Contractor\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Illuminate\Support\Facades\DB;
use Afaqy\Contact\Actions\UpdateContactAction;
use Afaqy\Contractor\Actions\UpdateContractorAction;

class UpdateContractorAggregator extends Aggregator
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
        DB::transaction(function () use (&$contractor) {
            $contractor   = (new UpdateContractorAction($this->data->except('contacts')))->execute();

            (new UpdateContactAction($this->data->contacts, $contractor))->execute();
        });

        return $contractor;
    }
}
