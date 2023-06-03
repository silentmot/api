<?php

namespace Afaqy\Dashboard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitsRerportsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from'              => ['required_with:to', 'date_format:Y-m-d', 'before_or_equal:to'],
            'to'                => ['required_with:from', 'date_format:Y-m-d', 'after_or_equal:from'],
            'contractor'        => ['sometimes', 'array'],
            'contractor.*'      => ['sometimes', 'string'],
            'contract'          => ['sometimes', 'array'],
            'contract.*'        => ['sometimes', 'integer'],
            'plate_number'      => ['sometimes', 'array'],
            'plate_number.*'    => ['sometimes', 'string'],
            'unit_type'         => ['sometimes', 'array'],
            'unit_type.*'       => ['sometimes', 'string'],
            'waste_type'        => ['sometimes', 'array'],
            'waste_type.*'      => ['sometimes', 'string'],
            'permission_type'   => ['sometimes', 'array'],
            'permission_type.*' => ['sometimes', 'string'],
            'entrance_scale'    => ['sometimes', 'array'],
            'entrance_scale.*'  => ['sometimes', 'integer'],
            'exit_scale'        => ['sometimes', 'array'],
            'exit_scale.*'      => ['sometimes', 'integer'],
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
            'from'              => __('from'),
            'to'                => __('to'),
            'type'              => __('type'),
            'contractor'        => __('contractors'),
            'contractor.*'      => __('contractor'),
            'contract'          => __('contracts'),
            'contract.*'        => __('contract'),
            'plate_number'      => __('plate numbers'),
            'plate_number.*'    => __('plate number'),
            'unit_type'         => __('units types'),
            'unit_type.*'       => __('unit type'),
            'waste_type'        => __('waste types'),
            'waste_type.*'      => __('waste type'),
            'permission_type'   => __('permissions types'),
            'permission_type.*' => __('permission type'),
            'entrance_scale'    => __('entrance scales'),
            'entrance_scale.*'  => __('entrance scale'),
            'exit_scale'        => __('exit scales'),
            'exit_scale.*'      => __('exit scale'),
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
            'from.date_format' => trans('dashboard::dashboard.date_format'),
            'to.date_format'   => trans('dashboard::dashboard.date_format'),
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
