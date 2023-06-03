<?php

namespace Afaqy\Unit\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'          => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('units', 'code')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'model'         => ['nullable', 'digits:4'],
            'plate_number'  => [
                'required',
                'string',
                'min:4',
                'max:8',
                Rule::unique('units', 'plate_number')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'vin_number'    => [
                'nullable',
                'string',
                'between:1,50',
                Rule::unique('units', 'vin_number')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'net_weight'    => ['required', 'numeric', 'min:501'],
            'max_weight'    => ['required', 'numeric', 'gt:net_weight'],
            'rfid'          => [
                'sometimes',
                'nullable',
                'integer',
                Rule::unique('units', 'rfid')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'rfid')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'unique:permit_units,rfid',
            ],
            'qr_code'       => [
                'nullable',
                'integer',
                Rule::unique('units', 'qr_code')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'qr_code')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'unique:permit_units,qr_code',
            ],
            'unit_type'     => [
                'required',
                Rule::exists('unit_types', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'waste_type'    => [
                'required',
                Rule::exists('waste_types', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'contractor_id' => [
                'required',
                'integer',
                Rule::exists('contractors', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'active'        => ['required', 'boolean'],
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
            'code'         => __('code'),
            'model'        => __('model'),
            'plate_number' => __('plate number'),
            'vin_number'   => __('vin number'),
            'net_weight'   => __('net weight'),
            'max_weight'   => __('max weight'),
            'unit_type'    => __('unit type'),
            'waste_type'   => __('waste type'),
            'contractor'   => __('contractor'),
            'active'       => __('active'),
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
            'model.digits'   => trans('unit::unit.year-format'),
            'net_weight.min' => trans('unit::unit.min-net-weight'),
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
