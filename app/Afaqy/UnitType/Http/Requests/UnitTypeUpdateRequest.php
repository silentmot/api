<?php

namespace Afaqy\UnitType\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class UnitTypeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('unit_types', 'name')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'waste_types'   => [ 'sometimes', 'required', 'array'],
            'waste_types.*' => [ 'sometimes', 'required', 'integer', 'exists:waste_types,id'],
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'          => 'نوع المركبة',
            'waste_types'   => 'أنواع القمامة',
            'waste_types.*' => 'نوع القمامة',
        ];
    }
}
