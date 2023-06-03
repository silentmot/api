<?php

namespace Afaqy\WasteType\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WasteTypeIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'         => ['sometimes', 'string', 'min:1'],
            'sort'            => ['sometimes', 'string', 'in:id,name,units_count'],
            'direction'       => ['sometimes', 'string', 'in:desc,asc'],
            'per_page'        => ['sometimes', 'integer', 'min:10', 'max:200'],
            'all_pages'       => ['sometimes', 'nullable', 'boolean'],
            'with_permisions' => ['sometimes', 'boolean'],
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
