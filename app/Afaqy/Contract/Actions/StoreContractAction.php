<?php

namespace Afaqy\Contract\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Contract\Models\Contract;

class StoreContractAction extends Action
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
        return Contract::create([
            'start_at'        => $this->data->start_at,
            'end_at'          => $this->data->end_at,
            'contractor_id'   => $this->data->contractor_id,
            'contract_number' => $this->data->contract_number,
            'status'          => $this->data->status,
        ]);
    }
}
