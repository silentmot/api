<?php

namespace Afaqy\Role\Http\Requests;

use Illuminate\Validation\Rule;
use Afaqy\Role\Rules\GivenModulesAvailable;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Role\Rules\PermissionsBelongToModule;

class RoleStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_name'       => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('roles', 'display_name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'notifications'   => ['nullable', 'array'],
            'notifications.*' => ['nullable', 'integer', 'exists:notifications,id'],
            'permissions'     => ['required', 'array', new GivenModulesAvailable],
            'permissions.*'   => ['bail', 'array', 'nullable', new PermissionsBelongToModule],
            'permissions.*.*' => ['bail', 'integer', 'min:1'],
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
            'role_name'       => 'اسم الوظيفة',
            'permissions'     => 'الصلاحيات',
            'permissions.*'   => 'الموديول',
            'permissions.*.*' => 'رقم التصريح',
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
