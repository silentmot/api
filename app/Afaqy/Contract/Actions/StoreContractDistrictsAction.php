<?php

namespace Afaqy\Contract\Actions;

use Afaqy\Core\Actions\Action;

class StoreContractDistrictsAction extends Action
{
    /**
     * @var \Afaqy\Contract\DTO\ContractDistrictData $data
     */
    private $data;

    /**
     * @var \Afaqy\Contract\Models\Contract $contract
     */
    private $contract;

    /**
     * @param \Afaqy\Contract\DTO\ContractDistrictData $data
     * @param \Afaqy\Contract\Models\Contract $contract
     * @return void
     */
    public function __construct($data, $contract)
    {
        $this->data     = $data;
        $this->contract = $contract;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        foreach ($this->data as $key => $district) {
            $this->contract->units()->attach($district->units_ids, [
                'district_id'     => $district->district_id,
                'neighborhood_id' => $district->neighborhood_id,
            ]);
        }

        return true;
    }
}
