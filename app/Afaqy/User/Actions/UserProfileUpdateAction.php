<?php

namespace Afaqy\User\Actions;

use Afaqy\User\Models\User;
use Afaqy\User\DTO\UserData;
use Afaqy\Core\Actions\Action;

class UserProfileUpdateAction extends Action
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
        $user = User::findOrFail($this->data->id);

        $user->update([
            'phone'    => $this->data->phone,
            'avatar'   => $this->data->avatar,
            'password' => $this->data->password,
        ]);

        return $user;
    }
}
