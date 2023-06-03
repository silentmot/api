<?php

namespace Afaqy\EntrancePermission\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class UpdateEntrancePermissionAction extends Action
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
        return EntrancePermission::findOrFail($this->data->id)->update($this->data->toArray());
    }
}
