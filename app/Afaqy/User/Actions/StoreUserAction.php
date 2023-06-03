<?php

namespace Afaqy\User\Actions;

use Afaqy\User\Models\User;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\DB;

class StoreUserAction extends Action
{
    /** @var \Afaqy\User\DTO\UserData */
    private $data;

    /**
     * @param \Afaqy\User\DTO\UserData  $data
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
        DB::transaction(function () use (&$user) {
            $user = User::create($this->data->toArray());

            $user->attachRole($this->data->role);
        });

        return $user;
    }
}
