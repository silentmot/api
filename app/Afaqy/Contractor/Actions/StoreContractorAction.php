<?php

namespace Afaqy\Contractor\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\Contractor\Models\Contractor;

class StoreContractorAction extends Action
{
    /** @var \Afaqy\Contractor\DTO\ContactorData */
    private $data = [];

    /**
     * @param mixed $data
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
        return Contractor::create($this->data->toArray());
    }
}
