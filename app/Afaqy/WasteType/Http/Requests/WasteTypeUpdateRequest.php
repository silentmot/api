<?php

namespace Afaqy\WasteType\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class WasteTypeUpdateRequest extends FormRequest
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
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('waste_types', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
                'not_regex:/(?=[\,\:])/',
            ],
            'zone_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return is_null(request('pit_id'));
                }),
                'exists:geofences,id',
            ],
            'pit_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return is_null(request('zone_id'));
                }),
                Rule::exists('geofences', 'id')->where(function ($query) {
                    $query->where('type', 'pit');
                }),
            ],
            'scale_zones'   => ['required', 'array'],
            'scale_zones.*' => [
                'required',
                'integer',
                Rule::exists('zones', 'id')->where(function ($query) {
                    $query->where('type', 'entranceScale');
                }),
            ],
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
            'name'    => __('name'),
            'zone_id' => __('zone id'),
            'pit_id'  => __('pit id'),
        ];
    }
}
