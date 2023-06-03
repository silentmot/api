<?php

namespace Afaqy\Scale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScaleIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'   => ['sometimes', 'string', 'min:1'],
            'sort'      => ['sometimes', 'string', 'in:name'],
            'direction' => ['sometimes', 'string', 'in:desc,asc'],
            'per_page'  => ['sometimes', 'integer', 'min:50', 'max:200'],
            'all_pages' => ['sometimes', 'nullable', 'boolean'],
            'type'      => ['sometimes', 'nullable', 'in:in,out'],
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
