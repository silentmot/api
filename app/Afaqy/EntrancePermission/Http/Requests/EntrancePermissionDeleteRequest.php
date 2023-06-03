<?php

namespace Afaqy\EntrancePermission\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EntrancePermissionDeleteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['required',
                Rule::exists('entrance_permissions', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }), ],
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

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'ids.*' => ':attribute غير متواجد.',
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
            'ids'   => 'المقاولين',
            'ids.*' => 'المقاول',
        ];
    }
}
