<?php

namespace Afaqy\TripWorkflow\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\TripWorkflow\Actions\Scale\TakeExitCarWeightAction;
use Afaqy\TripWorkflow\Actions\Scale\TakeEntranceCarWeightAction;

class HandleTakeCarWeightAggregator extends Aggregator
{
    /**
     * @var \Afaqy\TripWorkflow\DTO\CarWeightData $data
     */
    private $data;

    /**
     * @param \Afaqy\TripWorkflow\DTO\CarWeightData $data
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
        if ($this->data->zone_type == 'entranceScale') {
            return (new TakeEntranceCarWeightAction($this->data))->execute();
        }

        return (new TakeExitCarWeightAction($this->data))->execute();
    }
}
