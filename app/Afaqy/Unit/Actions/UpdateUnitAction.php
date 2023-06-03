<?php

namespace Afaqy\Unit\Actions;

use Afaqy\Unit\Models\Unit;
use Afaqy\Core\Actions\Action;

class UpdateUnitAction extends Action
{
    /** @var \Afaqy\Unit\DTO\UnitData */
    private $data;

    /**
     * @param \Afaqy\Unit\DTO\UnitData  $data
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
        return Unit::findOrFail($this->data->id)->update($this->data->toArray());
    }
}
