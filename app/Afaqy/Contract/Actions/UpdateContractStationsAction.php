<?php

namespace Afaqy\Contract\Actions;

use Afaqy\Core\Actions\Action;

class UpdateContractStationsAction extends Action
{
    /**
     * @var \Afaqy\Contract\DTO\ContractStationData|null $data
     */
    private $data;

    /**
     * @var \Afaqy\Contract\Models\Contract $contract
     */
    private $contract;

    /**
     * @param \Afaqy\Contract\DTO\ContractStationData|null $data
     * @param \Afaqy\Contract\Models\Contract $contract
     * @return void
     */
    public function __construct($data = null, $contract)
    {
        $this->data     = $data;
        $this->contract = $contract;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $this->contract->stationUnits()->detach();

        if (is_null($this->data)) {
            return true;
        }

        foreach ($this->data as $key => $station) {
            $this->contract->stationUnits()->attach($station->units_ids, [
                'station_id' => $station->station_id,
            ]);
        }

        return true;
    }
}
