<?php

namespace Afaqy\Contract\Http\Requests;

use Illuminate\Validation\Rule;
use Afaqy\User\Rules\SaudiMobilFormat;
use Illuminate\Database\Query\Builder;
use Afaqy\Contractor\Rules\EmailFormat;
use Afaqy\Contract\Rules\ItemsNotDuplicate;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Contract\Rules\UnitBelongToContractor;
use Afaqy\Contract\Rules\StationBelongToDistricts;
use Afaqy\Contract\Rules\UnitNotDuplicatedInDistrict;
use Afaqy\Contract\Rules\NeighborhoodBelongToDistrict;
use Afaqy\Contract\Rules\UnitIdNotRelatedToActiveContract;
use Afaqy\Contract\Rules\UnitIdNotRelatedToActiveNormalPermission;
use Afaqy\Contract\Rules\UnitIdNotRelatedToActiveEntrancePermission;

class ContractUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contractor_id'               => [
                'required',
                'integer',
                Rule::exists('contractors', 'id')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'start_at'                    => ['required', 'date_format:Y-m-d', 'before:end_at'],
            'end_at'                      => ['required', 'date_format:Y-m-d', 'after:start_at'],
            'contract_number'             => ['sometimes', 'required', 'integer', 'between:1,100'],
            'status'                      => ['sometimes', 'required', 'boolean'],
            'contact.name'                => ['required', 'string', 'min:3', 'max:50'],
            'contact.title'               => ['sometimes', 'nullable', 'string'],
            'contact.email'               => ['sometimes', 'nullable', new EmailFormat],
            'contact.phone'               => ['required', 'digits:10', new SaudiMobilFormat],
            'districts'                   => ['required', 'array'],
            'districts.*.district_id'     => [
                'required',
                'integer',
                Rule::exists('districts', 'id')->where(function (Builder $query) {
                    return $query->where('status', 1)
                        ->whereNull('deleted_at');
                }),
            ],
            'districts.*.neighborhood_id' => [
                'required',
                'integer',
                Rule::exists('neighborhoods', 'id')->where(function (Builder $query) {
                    return $query->where('status', 1)
                        ->whereNull('deleted_at');
                }),
                new NeighborhoodBelongToDistrict,
            ],
            'districts.*.units_ids'       => ['required', 'array', new ItemsNotDuplicate],
            'districts.*.units_ids.*'     => [
                'bail',
                'required',
                'integer',
                Rule::exists('units', 'id')->where(function (Builder $query) {
                    return $query->where('active', 1)->whereNull('deleted_at');
                }),
                new UnitBelongToContractor,
                new UnitIdNotRelatedToActiveContract,
                new UnitIdNotRelatedToActiveEntrancePermission,
                new UnitIdNotRelatedToActiveNormalPermission,
            ],
            'stations'                    => ['sometimes', 'nullable', 'array'],
            'stations.*.station_id'       => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('transitional_stations', 'id')->where(function (Builder $query) {
                    return $query->where('status', 1)->whereNull('deleted_at');
                }),
                new StationBelongToDistricts,
            ],
            'stations.*.units_ids'        => ['required_unless:stations,null', 'array', new ItemsNotDuplicate],
            'stations.*.units_ids.*'      => [
                'sometimes',
                'bail',
                'required',
                'integer',
                Rule::exists('units', 'id')->where(function (Builder $query) {
                    return $query->where('active', 1)->whereNull('deleted_at');
                }),
                new UnitNotDuplicatedInDistrict,
                new UnitBelongToContractor,
                new UnitIdNotRelatedToActiveContract,
                new UnitIdNotRelatedToActiveEntrancePermission,
                new UnitIdNotRelatedToActiveNormalPermission,
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
            'start_at'                    => __('start at'),
            'end_at'                      => __('end at'),
            'contact.name'                => __('contact name'),
            'contact.title'               => __('contact title'),
            'contact.email'               => __('contact email'),
            'contact.phone'               => __('contact phone'),
            'districts.*.district_id'     => __('district id'),
            'districts.*.neighborhood_id' => __('neighborhood id'),
            'districts.*.units_ids'       => __('units ids'),
            'districts.*.units_ids.*'     => __('unit id'),
            'stations.*.station_id'       => __('station id'),
            'stations.*.units_ids'        => __('units ids'),
            'stations.*.units_ids.*'      => __('unit id'),
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
            'stations.*.units_ids.required_unless' => trans('contract::contract.unit-station-required'),
        ];
    }
}
