<?php

namespace Afaqy\Permission\Http\Requests\Individual;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Permission\Rules\NationalIDFormat;
use Afaqy\Permission\Rules\CheckRfidDuplication;
use Afaqy\Permission\Rules\CheckQrCodeDuplication;
use Afaqy\Permission\Rules\CheckPlateNumberDuplication;
use Afaqy\Permission\Rules\DemolistionSerialValidation;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveContract;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveEntrancePermission;

class IndividualPermissionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'demolition_serial'    => ['nullable', new DemolistionSerialValidation],
            'permission_number'    => ['required', 'integer', Rule::unique('individual_damaged_permissions', 'permission_number')->where(function (Builder $query) {
                return $query->whereNull('deleted_at');
            })],
            'type'                 => ['required', 'string', 'in:construction,demolition,restoration,drilling_services,municipality_projects,charity_projects'],
            'permission_date'      => ['required', 'date_format:d-m-Y'],
            'district_id'          => ['required', 'integer'],
            'neighborhood_id'      => ['required', 'integer'],
            'street'               => ['string', 'nullable', 'min:1', 'max:50'],
            'owner_name'           => ['required', 'string'],
            'national_id'          => ['required', new NationalIDFormat, 'digits:10'],
            'owner_phone'          => ['required', 'numeric', 'digits_between:2,6'],
            'units'                => ['required', 'array'],
            'units.*'              => ['required', 'array'],
            'units.*.plate_number' => [
                'required',
                'string',
                'min:4',
                'max:8',
                new UnitPlateNumberNotRelatedToActiveContract,
                new UnitPlateNumberNotRelatedToActiveEntrancePermission,
                new CheckPlateNumberDuplication,
            ],
            'units.*.rfid'         => [
                'nullable',
                'integer',
                Rule::unique('permit_units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                new CheckRfidDuplication,
            ],
            'units.*.qr_code'      => [
                'required',
                'integer',
                Rule::unique('permit_units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                new CheckQrCodeDuplication,
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
            'demolition_serial'    => __('demolition serial'),
            'permission_number'    => __('permission number'),
            'permission_date'      => 'التاريخ ',
            'type'                 => 'النوع',
            'district_id'          => 'البلدية',
            'neighborhood_id'      => 'الحى',
            'street'               => 'الشارع',
            'owner_name'           => 'الاسم',
            'national_id'          => 'رقم الهويه',
            'owner_phone'          => 'رقم الناقل',
            'units.*'              => 'المركبات',
            'units.*.plate_number' => 'اسم المركبة',
            'units.*.rfid'         => 'RFID',
            'units.*.qr_code'      => 'QR Code',
        ];
    }
}
