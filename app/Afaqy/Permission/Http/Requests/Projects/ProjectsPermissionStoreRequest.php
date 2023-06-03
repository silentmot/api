<?php

namespace Afaqy\Permission\Http\Requests\Projects;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Permission\Rules\CheckRfidDuplication;
use Afaqy\Permission\Rules\CheckQrCodeDuplication;
use Afaqy\Contractor\Rules\TenDigitsNotStartedWithZero;
use Afaqy\Permission\Rules\CheckPlateNumberDuplication;
use Afaqy\Permission\Rules\DemolistionSerialValidation;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveContract;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveEntrancePermission;

class ProjectsPermissionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'demolition_serial'         => ['nullable', new DemolistionSerialValidation],
            'permission_number'         => ['required', 'integer', Rule::unique('damaged_projects_permissions', 'permission_number')->where(function (Builder $query) {
                return $query->whereNull('deleted_at');
            })],
            'permission_date'           => ['required', 'date_format:d-m-Y'],
            'company_name'              => ['required', 'string', 'min:3', 'max:50'],
            'company_commercial_number' => ['required', new TenDigitsNotStartedWithZero],
            'units'                     => ['required', 'array'],
            'units.*'                   => ['required', 'array'],
            'units.*.plate_number'      => [
                'required',
                'string',
                'min:4',
                'max:8',
                new UnitPlateNumberNotRelatedToActiveContract,
                new CheckPlateNumberDuplication,
                new UnitPlateNumberNotRelatedToActiveEntrancePermission,
            ],
            'units.*.rfid'              => [
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
            'units.*.qr_code'           => [
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
            'demolition_serial'         => __('demolition serial'),
            'permission_number'         => __('permission number'),
            'permission_date'           => 'التاريخ',
            'company_name'              => 'اسم الشركة',
            'company_commercial_number' => 'رقم السجل التجارى',
            'units.*'                   => 'المركبات',
            'units.*.plate_number'      => 'اسم المركبة',
            'units.*.rfid'              => 'RFID',
            'units.*.qr_code'           => 'QR Code',
        ];
    }
}
