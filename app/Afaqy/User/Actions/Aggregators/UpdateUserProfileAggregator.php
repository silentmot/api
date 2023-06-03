<?php

namespace Afaqy\User\Actions\Aggregators;

use Afaqy\Core\Actions\Aggregator;
use Afaqy\User\Actions\UserUpdateAction;
use Afaqy\User\Actions\UserProfileUpdateAction;
use Afaqy\Core\Actions\Helpers\UploadFileAction;

class UpdateUserProfileAggregator extends Aggregator
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
        $this->data->avatar = (new UploadFileAction($this->data->avatar, 'users'))->execute();

        return ($this->data->profile)
            ? (new UserProfileUpdateAction($this->data))->execute()
            : (new UserUpdateAction($this->data))->execute();
    }
}
