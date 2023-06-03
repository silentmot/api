<?php

namespace Afaqy\Role\Actions;

use Afaqy\Role\Models\Role;
use Afaqy\Core\Actions\Action;

class DeleteRolesAction extends Action
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
        if ($this->isOwner($ids)) {
            return 0;
        }

        if ($this->isHasRelatedUser($ids)) {
            return 0;
        }

        return Role::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        $role = Role::findOrFail($id);

        if ($this->isOwner($id)) {
            return 0;
        }

        if ($this->isHasRelatedUser($role->id)) {
            return 0;
        }

        return $role->delete();
    }

    /**
     * @param  $id
     * @return boolean
     */
    private function isOwner($ids): bool
    {
        return in_array(1, (array) $ids, true);
    }

    /**
     * @param  $id
     * @return boolean
     */
    private function isHasRelatedUser($ids): bool
    {
        $query = Role::withUsers()
            ->whereIn('role_user.role_id', (array) $ids)
            ->whereNull('users.deleted_at');

        if ($query->count()) {
            return true;
        }

        return false;
    }
}
