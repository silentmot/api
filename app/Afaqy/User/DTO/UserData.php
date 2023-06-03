<?php

namespace Afaqy\User\DTO;

use Afaqy\User\Models\User;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;

class UserData extends FlexibleDataTransferObject
{
    /** @var int|null */
    public $id = null;

    /** @var string|null */
    public $first_name = null;

    /** @var string|null */
    public $last_name = null;

    /** @var string|null */
    public $username = null;

    /** @var string|null */
    public $email = null;

    /** @var mixed|null */
    public $avatar = null;

    /** @var string|null */
    public $phone = null;

    /** @var string|null */
    public $password = null;

    /** @var int|null */
    public $role = null;

    /** @var int */
    public $status;

    /** @var int|null */
    public $use_mob;

    /** @var boolean */
    public $profile = false;

    /**
     * Prepare data transfer object for the given request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null $id
     * @return self
     */
    public static function fromRequest(Request $request, ? int $id = null, $profile = false) : self
    {
        if ($id) {
            $user = User::findOrFail($id);
        }

        return new self([
            'id'         => $id ?? null,
            'first_name' => $request->first_name ?? $user->first_name,
            'last_name'  => $request->last_name ?? $user->last_name,
            'username'   => $request->username ?? $user->username,
            'email'      => $request->email ?? $user->email,
            'avatar'     => ($request->has('avatar')) ? $request->file('avatar') : $user->avatar ?? null,
            'phone'      => ($request->has('phone')) ? $request->phone : $user->phone ?? null,
            'password'   => $request->password ? bcrypt($request->password) : $user->password,
            'role'       => $request->role ?? $user->role,
            'status'     => $request->status ?? $user->status,
            'profile'    => $profile,
            'use_mob'    => $request->use_mob ?? $user->use_mob,
        ]);
    }
}
