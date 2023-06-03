<?php

namespace Afaqy\Role\Actions;

use Afaqy\Role\Models\Role;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Afaqy\Role\Traits\GenerateRoleSlug;

class CreateRoleAction extends Action
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
        DB::transaction(function () use (&$role) {
            $slug = $this->generateSlug($this->data->role_name);

            $role = Role::create([
                'name'         => $slug,
                'display_name' => $this->data->role_name,
            ]);

            $role->notifications()->attach($this->data->notifications);
            $role->attachPermissions($this->data->permissions);
        });

        return $role;
    }
}
