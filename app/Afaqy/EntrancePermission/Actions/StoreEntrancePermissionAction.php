<?php

namespace Afaqy\EntrancePermission\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class StoreEntrancePermissionAction extends Action
{
    /** @var \Afaqy\EntrancePermission\DTO\EntrancePermissionData */
    private $data;

    /**
     * @param \Afaqy\EntrancePermission\DTO\EntrancePermissionData  $data
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
        return EntrancePermission::create($this->data->toArray());
    }
}
