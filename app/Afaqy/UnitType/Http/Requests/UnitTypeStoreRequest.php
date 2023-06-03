<?php

namespace Afaqy\UnitType\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class UnitTypeStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('unit_types', 'name')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'waste_types'   => ['required', 'array'],
            'waste_types.*' => ['required', 'integer', 'exists:waste_types,id'],
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
            'waste_types.*' => ':attribute غير متواجد.',
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
            'waste_types'   => 'أنواع القمامة',
            'waste_types.*' => 'نوع القمامة',
        ];
    }
}
