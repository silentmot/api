<?php

namespace Afaqy\User\Actions;

use Afaqy\User\Models\User;
use Afaqy\Core\Actions\Action;
use Illuminate\Support\Facades\Auth;

class DeleteUserAction extends Action
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
        if ($this->isOwner($ids) || $this->isUserDeleteHimself($ids)) {
            return false;
        }

        return User::destroy($ids);
    }

    /**
     * @param  int  $id
     * @return int
     */
    private function delete(int $id): int
    {
        if ($this->isOwner($id) || $this->isUserDeleteHimself($id)) {
            return false;
        }

        $user = User::findOrFail($id);

        return $user->delete();
    }

    /**
     * @param  mixed  $ids
     * @return boolean
     */
    private function isOwner($ids)
    {
        return in_array(1, (array) $ids, true);
    }

    /**
     * @param  mixed  $ids
     * @return boolean
     */
    private function isUserDeleteHimself($ids)
    {
        return in_array(Auth::id(), (array) $ids, true);
    }
}
