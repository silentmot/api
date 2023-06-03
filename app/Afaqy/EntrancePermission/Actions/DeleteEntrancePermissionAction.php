<?php

namespace Afaqy\EntrancePermission\Actions;

use Afaqy\Core\Actions\Action;
use Afaqy\EntrancePermission\Models\EntrancePermission;

class DeleteEntrancePermissionAction extends Action
{
    /** @var mixed */
    private $id;

    /**
     * @param mixed  $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (is_array($this->id)) {
            return $this->deleteMany($this->id);
        }

        return $this->delete($this->id);
    }

    /**
     * @param  array  $ids
     * @return int
     */
    private function deleteMany(array $ids): int
    {
        return EntrancePermission::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $contractor = EntrancePermission::findOrFail($id);

        return $contractor->delete();
    }
}
