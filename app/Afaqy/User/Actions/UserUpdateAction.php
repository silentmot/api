<?php

namespace Afaqy\User\Actions;

use Afaqy\User\Models\User;
use Afaqy\User\DTO\UserData;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserUpdateAction extends Action
{
    /** @var \Afaqy\User\DTO\UserData */
    private $data;

    /**
     * @param \Afaqy\User\DTO\UserData  $data
     * @return void
     */
    public function __construct(UserData $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if (
            $this->isOwnerUser($this->data->id) ||
            $this->isUserUpdateHimself($this->data->id, $this->data->profile)
        ) {
            return false;
        }

        $user = User::findOrFail($this->data->id);

        DB::transaction(function () use (&$user) {
            $user->fill($this->data->toArray());

            $user->update();

            if ($this->data->role != null && $user->id != 1) {
                $user->roles()->sync([$this->data->role]);
            }
        });

        return $user;
    }

    /**
     * @param  int  $id
     * @return boolean
     */
    private function isOwnerUser($id)
    {
        return $id == 1;
    }

    /**
     * @param  int  $id
     * @param  boolean  $is_profile
     * @return boolean
     */
    private function isUserUpdateHimself($id, $is_profile)
    {
        return $id == Auth::id() && !$is_profile;
    }
}
