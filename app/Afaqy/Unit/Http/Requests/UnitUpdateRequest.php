<?php

namespace Afaqy\Unit\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Unit\Rules\UnitIsRelatedToContract;

class UnitUpdateRequest extends FormRequest
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
                'sometimes',
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('units', 'code')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'model'         => ['nullable', 'digits:4'],
            'plate_number'  => [
                'sometimes',
                'required',
                'string',
                'min:4',
                'max:8',
                Rule::unique('units', 'plate_number')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'vin_number'    => [
                'nullable',
                'string',
                'between:1,50',
                Rule::unique('units', 'vin_number')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'net_weight'    => ['sometimes', 'required', 'numeric', 'min:501'],
            'max_weight'    => ['sometimes', 'required', 'numeric', 'gt:net_weight'],
            'rfid'          => [
                'sometimes',
                'nullable',
                'integer',
                Rule::unique('units', 'rfid')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
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
                })->ignore($this->route('id')),
                Rule::unique('entrance_permissions', 'qr_code')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                'unique:permit_units,qr_code',
            ],
            'unit_type'     => [
                'sometimes',
                'required',
                Rule::exists('unit_types', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'waste_type'    => [
                'sometimes',
                'required',
                Rule::exists('waste_types', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'contractor_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('contractors', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                new UnitIsRelatedToContract($this->route('id')),
            ],
            'active'        => ['sometimes', 'required', 'boolean'],
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
            'code'         => 'رمز المركبة',
            'model'        => 'موديل المركبة',
            'plate_number' => 'رقم اللوحة',
            'vin_number'   => 'رقم الشاسيه',
            'net_weight'   => 'الوزن الصافي',
            'max_weight'   => 'الحد الاقصي للوزن',
            'unit_type'    => 'نوع المركبة',
            'waste_type'   => 'نوع النفايات',
            'contractor'   => 'المقاول',
            'active'       => 'حقل التنشيط',
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
