<?php

namespace Afaqy\Inspector\Http\Requests\Inspector;

use Illuminate\Validation\Rule;
use Afaqy\Inspector\Rules\ActiveContract;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Inspector\Rules\ContractRelatedToNeighborhood;

class StoreTicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contract_id'     => [
                'bail',
                'required',
                'integer',
                new ActiveContract,
                new ContractRelatedToNeighborhood($this->neighborhood_id),
            ],
            'district_id'     => [
                'required',
                'integer',
                Rule::exists('districts', 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'neighborhood_id' => [
                'required',
                'integer',
                Rule::exists('neighborhoods', 'id')->where(function ($query) {
                    $query->whereDistrictId($this->district_id)->whereNull('deleted_at');
                }),
            ],
            'location'        => ['required', 'string'],
            'location_name'   => ['required', 'string'],
            'details'         => ['nullable', 'string'],
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
            'contract_id'     => 'العقد',
            'contractor_name' => 'إسم المقاول',
            'district_id'     => 'البلدية',
            'neighborhood_id' => 'الحي',
            'location'        => 'الإحداثيات',
            'location_name'   => 'إسم الإحداثيات',
            'details'         => 'التفاصيل',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'neighborhood_id.exists' => 'الحي غير موجود او لا يتبع البلدية',
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
