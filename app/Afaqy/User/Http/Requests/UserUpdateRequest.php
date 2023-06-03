<?php

namespace Afaqy\User\Http\Requests;

use Illuminate\Validation\Rule;
use Afaqy\User\Rules\NoWhiteSpace;
use Afaqy\User\Rules\SaudiMobilFormat;
use Afaqy\Contractor\Rules\EmailFormat;
use Afaqy\User\Rules\PasswordComplexity;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['sometimes', 'required', 'string', 'min:3', 'max:50'],
            'last_name'  => ['sometimes', 'required', 'string', 'min:3', 'max:50'],
            'username'   => [
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:50',
                new NoWhiteSpace,
                Rule::unique('users', 'username')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'password'   => ['sometimes', 'required', 'min:8', 'max:10', new PasswordComplexity],
            'email'      => [
                'sometimes',
                'required',
                new EmailFormat,
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'phone'      => [
                'sometimes',
                'bail',
                'nullable',
                'min:6',
                'max:10',
                new SaudiMobilFormat,
                Rule::unique('users', 'phone')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'status'     => ['sometimes', 'required', 'boolean'],
            'role'       => ['sometimes', 'required', 'integer', 'exists:roles,id', 'gt:1'],
            'use_mob'    => ['sometimes', 'boolean'],
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
            'status' => 'الحالة',
            'role'   => 'الوظيفة',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.min' => 'رقم الهاتف لابد الا يقل عن :min ارقام',
            'phone.max' => 'رقم الهاتف لابد الا يزيد عن :max ارقام',
            'role.gt'   => 'لا يمكن اضافة وظيفة مدير الموقع للمستخدم',
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
