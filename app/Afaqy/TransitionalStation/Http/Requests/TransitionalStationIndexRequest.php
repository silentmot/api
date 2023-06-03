<?php

namespace Afaqy\TransitionalStation\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransitionalStationIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'     => ['sometimes', 'string', 'min:1'],
            'sort'        => ['sometimes', 'string', 'in:id,name,districts_count'],
            'direction'   => ['sometimes', 'string', 'in:desc,asc'],
            'per_page'    => ['sometimes', 'integer', 'min:10', 'max:200'],
            'all_pages'   => ['sometimes', 'nullable', 'boolean'],
            'districts'   => ['sometimes', 'required', 'array'],
            'districts.*' => [
                'sometimes',
                'integer',
                Rule::exists('districts', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at')->where('status', 1);
                }),
            ],
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
            'districts'   => __('districts'),
            'districts.*' => __('district'),
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
