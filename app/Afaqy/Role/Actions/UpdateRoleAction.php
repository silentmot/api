<?php

namespace Afaqy\Role\Actions;

use Afaqy\Role\Models\Role;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Afaqy\Role\Traits\GenerateRoleSlug;

class UpdateRoleAction extends Action
{
    use GenerateRoleSlug;

    /**
     * @var \Afaqy\Role\DTO\RoleData $data
     */
    private $data;

    /**
     * @param \Afaqy\Role\DTO\RoleData $data
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
        $role = Role::findOrFail($this->data->id);

        if ($this->isOwner($this->data->id)) {
            $role->notifications()->sync($this->data->notifications);

            return true;
        }

        DB::transaction(function () use ($role, &$result) {
            $slug = $this->generateSlug($this->data->role_name);

            $role->name         = $slug;
            $role->display_name = $this->data->role_name;

            $result = $role->update();

            $role->notifications()->sync($this->data->notifications);
            $role->syncPermissions($this->data->permissions);
        });

        return $result;
    }

    /**
     * @param int $id
     * @return boolean
     */
    private function isOwner($id): bool
    {
        return $id == 1;
    }
}
