<?php

namespace Afaqy\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleIndexRequst extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'      => ['sometimes', 'string', 'min:1'],
            'sort'         => ['sometimes', 'string', 'in:id,display_name,users_count'],
            'direction'    => ['sometimes', 'string', 'in:desc,asc'],
            'per_page'     => ['sometimes', 'integer', 'min:10', 'max:200'],
            'all_pages'    => ['sometimes', 'nullable', 'boolean'],
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
