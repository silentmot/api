<?php

namespace Afaqy\User\Http\Requests;

use Afaqy\User\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Afaqy\User\Rules\SaudiMobilFormat;
use Afaqy\User\Rules\PasswordComplexity;
use Afaqy\User\Rules\PasswordBelongToUser;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required_with:password', new PasswordBelongToUser(Auth::user())],
            'password'     => ['sometimes', 'required', 'confirmed', 'min:8',  new PasswordComplexity],
            'phone'        => [
                'sometimes',
                'bail',
                'required',
                'min:10',
                'max:10',
                new SaudiMobilFormat,
                Rule::unique('users', 'phone')->ignore(Auth::id()),
            ],
            'avatar'       => ['sometimes', 'nullable', 'image', 'mimes:jpeg,jpg,png', 'max:5000'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'old_password' => 'كلمة المرور القديم',

        ];
    }

    public function messages()
    {
        return [
            'phone.min'    => 'رقم الهاتف لابد الا يقل عن :min ارقام',
            'phone.max'    => 'رقم الهاتف لابد الا يزيد عن :max ارقام',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
