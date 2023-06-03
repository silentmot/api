<?php

namespace Afaqy\User\Http\Requests;

use Illuminate\Validation\Rule;
use Afaqy\User\Rules\NoWhiteSpace;
use Afaqy\User\Rules\SaudiMobilFormat;
use Afaqy\Contractor\Rules\EmailFormat;
use Afaqy\User\Rules\PasswordComplexity;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:50'],
            'last_name'  => ['required', 'string', 'min:3', 'max:50'],
            'username'   => [
                'required',
                'string',
                'min:3',
                'max:50',
                new NoWhiteSpace,
                Rule::unique('users', 'username')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'password'   => ['required', 'min:8', new PasswordComplexity],
            'email'      => [
                'required',
                new EmailFormat,
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
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
                }),
            ],
            'status'     => ['required', 'boolean'],
            'role'       => ['required', 'integer', 'exists:roles,id', 'gt:1'],
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
