<?php

namespace Afaqy\User\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class PasswordBelongToUser implements Rule
{
    /**
     * @var \Afaqy\User\Models\User|null
     */
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @param \Afaqy\User\Models\User|null $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('user::users.fail-password-belong-user');
    }
}
